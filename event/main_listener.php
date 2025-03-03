<?php
/**
 *
 * Hide on Index. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, Joshua Sayles, https://www.josh18657.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace josh18657\hideonindex\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Hide on Index Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return [
			'core.display_forums_modify_sql'			=> 'display_forums_modify_sql',
			'core.acp_manage_forums_request_data'		=> 'acp_manage_forums_request_data',
			'core.acp_manage_forums_display_form'		=> 'acp_manage_forums_display_form',
			
			//'core.user_setup'							=> 'load_language_on_setup',
			//'core.display_forums_modify_template_vars'	=> 'display_forums_modify_template_vars',
		];
	}

	/* @var \phpbb\language\language */
	protected $language;
	
	/* @var \phpbb\user */
	protected $user;
	
	/* @var \phpbb\request\request_interface */
	protected $request;

	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language	$language	Language object
	 * @param \phpbb\user	$user	User object
	 * @param \phpbb\request\request_interface     $request               Request object
	*/
	public function __construct(\phpbb\language\language $language, \phpbb\user $user, \phpbb\request\request_interface $request )
	{
		$this->language = $language;
		$this->user = $user;
		$this->request = $request;
		
		
		
	}
	
	
	/**
	 * Modify display forum sql if needed
	 *
	 * @param \phpbb\event\data	$event	Event object
	*/
	public function display_forums_modify_sql($event) {
		
		if ( $this->user->page['page_name'] == 'index.php' ) {
			
			$sql_ary = $event['sql_ary'];
			
			if ( !empty( $sql_ary['WHERE'] ) ) {
				$sql_ary['WHERE'] .= ' AND forum_hide_on_index = 0';
			}
			else {
				$sql_ary['WHERE'] = 'forum_hide_on_index = 0';
			}
			
			$event['sql_ary'] = $sql_ary;
			
		}
		
	}
	
	
	/**
	 * Option in forums acp module
	 *
	 * @param \phpbb\event\data	$event	Event object
	*/
	public function acp_manage_forums_request_data($event) {
		$forum_data = $event['forum_data'];
		$forum_data['forum_hide_on_index'] = $this->request->variable('forum_hide_on_index', 0);
		$event['forum_data'] = $forum_data;
	}
	
	/**
	 * Option in forums acp module
	 *
	 * @param \phpbb\event\data	$event	Event object
	*/
	public function acp_manage_forums_display_form($event) {
		$template_data = $event['template_data'];
		$forum_data = $event['forum_data'];
		$template_data['S_HIDE_FORUM_ON_INDEX'] = ($forum_data['forum_hide_on_index']) ? true : false;
		$event['template_data'] = $template_data;
	}
	
	
	
	
	
	
	
	
	
	
	

	/**
	 * Load common language files during user setup
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'josh18657/hideonindex',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * A sample PHP event
	 * Modifies the names of the forums on index
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function display_forums_modify_template_vars($event)
	{
		$forum_row = $event['forum_row'];
		$forum_row['FORUM_NAME'] .= $this->language->lang('HIDEONINDEX_EVENT');
		$event['forum_row'] = $forum_row;
	}
}
