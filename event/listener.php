<?php
/**
 *
 * Team Security Measures extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbb\teamsecurity\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $phpbb_root_path;

	/** @var string phpEx */
	protected $phpEx;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config $config Config object
	 * @param \phpbb\log\log $log The phpBB log system
	 * @param \phpbb\user $user User object
	 * @param string $phpbb_root_path phpBB root path
	 * @param string $phpEx phpEx
	 * @return \phpbb\teamsecurity\event\listener
	 * @access public
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\log\log $log, \phpbb\user $user, $phpbb_root_path, $phpEx)
	{
		$this->config = $config;
		$this->log = $log;
		$this->user = $user;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $phpEx;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_users_overview_before'	=> 'set_team_password_configs',
			'core.ucp_display_module_before'	=> 'set_team_password_configs',
			'core.login_box_failed'				=> 'log_failed_login_attempts',
			'core.login_box_redirect'			=> 'acp_login_notification',
			'core.user_setup'					=> 'load_language_on_setup',
		);
	}

	/**
	 * Load common language files during user setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'phpbb/teamsecurity',
			'lang_set' => 'info_acp_teamsecurity',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Set stronger password requirements for members of specific groups
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function set_team_password_configs($event)
	{
		if (!$this->config['sec_strong_pass'])
		{
			return;
		}

		// reg_details = UCP Account Settings // overview = ACP User Overview
		if ($event['mode'] == 'reg_details' || $event['mode'] == 'overview')
		{
			// The user the new password settings apply to
			$user_id = (isset($event['user_row']['user_id'])) ? $event['user_row']['user_id'] : $this->user->data['user_id'];

			if ($this->in_watch_group($user_id))
			{
				$this->config['pass_complex'] = 'PASS_TYPE_SYMBOL';
				$this->config['min_pass_chars'] = ($this->config['min_pass_chars'] > $this->config['sec_min_pass_chars']) ? $this->config['min_pass_chars'] : $this->config['sec_min_pass_chars'];
			}
		}
	}

	/**
	 * Log failed login attempts for members of specific groups
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function log_failed_login_attempts($event)
	{
		if (!$this->config['sec_login_attempts'])
		{
			return;
		}

		if ($this->in_watch_group($event['result']['user_row']['user_id']))
		{
			$this->log->add('user', $event['result']['user_row']['user_id'], $this->user->ip, 'LOG_TEAM_AUTH_FAIL', time(), array('reportee_id' => $event['result']['user_row']['user_id']));
		}
	}

	/**
	 * Send an email notification when a user logs into the ACP
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function acp_login_notification($event)
	{
		if (!$this->config['sec_login_email'])
		{
			return;
		}

		if ($event['admin'])
		{
			if (!class_exists('messenger'))
			{
				include($this->phpbb_root_path . 'includes/functions_messenger.' . $this->php_ext);
			}

			$messenger = new \messenger(false);
			$messenger->set_template_ext('phpbb/teamsecurity', 'acp_login', 'en');
			$messenger->to((!empty($this->config['sec_contact'])) ? $this->config['sec_contact'] : $this->config['board_contact'], $this->config['board_contact_name']);
			$messenger->assign_vars(array(
				'USERNAME'		=> $this->user->data['username'],
				'IP_ADDRESS'	=> $this->user->ip,
				'LOGIN_TIME'	=> date('l jS \of F Y \a\t h:i:s A', time()),
			));
			$messenger->send();
		}
	}

	/**
	 * Is user in a specified watch group
	 *
	 * @param int $user_id User identifier
	 * @return bool True if in group, false otherwise
	 * @access protected
	 */
	protected function in_watch_group($user_id)
	{
		$group_id_ary = (!$this->config['sec_usergroups']) ? array() : unserialize(trim($this->config['sec_usergroups']));

		if (empty($group_id_ary))
		{
			return false;
		}

		if (!function_exists('group_memberships'))
		{
			include($this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext);
		}

		return group_memberships($group_id_ary, $user_id, true);
	}
}
