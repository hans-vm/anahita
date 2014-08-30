<?php

/** 
 * LICENSE: ##LICENSE##
 * 
 * @category   Anahita
 * @package    Com_Hashtags
 * @subpackage Domain_Entity
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @copyright  2008 - 2014 rmdStudio Inc.
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @link       http://www.GetAnahita.com
 */

/**
 * Component object
 *
 * @category   Anahita
 * @package    Com_Hashtags
 * @subpackage Domain_Entity
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @link       http://www.GetAnahita.com
 */

class ComHashtagsDomainEntityComponent extends ComComponentsDomainEntityComponent
{
	/**
	 * On Dashboard event
	 *
	 * @param  KEvent $event The event parameter
	 *
	 * @return void
	 */
	public function onDashboardDisplay(KEvent $event)
	{
		$actor = $event->actor;
		$gadgets = $event->gadgets;
		$composers = $event->composers;
		$this->_setGadgets($actor, $gadgets, 'dashboard');		
	}	
	
	/**
	 * @{inheritdoc}
	 */
	protected function _setGadgets($actor, $gadgets, $mode)
	{
		if($mode == 'dashboard')
		{
			$gadgets->insert('hashtags-trending', array(
				'title' => JText::_('COM-HASHTAGS-GADGET-TRENDING'),
				'url'   => 'option=com_hashtags&view=hashtags&layout=list&limit=10'
			));
		}
	}
}
