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
 * Hashtag association   
 * 
 * @category   Anahita
 * @package    Com_Hashtags
 * @subpackage Domain_Entity
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @link       http://www.GetAnahita.com
 */
final class ComHashtagsDomainEntityTag extends ComTagsDomainEntityTag
{
    /**
    * Initializes the default configuration for the object
    *
    * Called from {@link __construct()} as a first step of object instantiation.
    *
    * @param KConfig $config An optional KConfig object with configuration options.
    *
    * @return void
    */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
        	'relationships' => array(
				'hashtag' => array('parent'=>'com:hashtags.domain.entity.hashtag')
			),
        	'aliases' => array(
                'hashtag' => 'nodeA'
            )
        ));
        
        parent::_initialize($config);           
    }
    
    /**
     * After entity insert reset stats
     *
     * KCommandContext $context Context
     * 
     * @return void
     */
    protected function _afterEntityInsert(KCommandContext $context)
    {
    	$this->resetStats();
    }
    
    /**
     * After entity delete reset stats
     *
     * KCommandContext $context Context
     * 
     * @return void
     */
    protected function _afterEntityDelete(KCommandContext $context)
    {       
		$this->resetStats();
    }
    
    /**
     * Resets the hashtag
     *
     * KCommandContext $context Context
     * 
     * @return void
     */
    private function resetStats()
    {
    	$this->hashtag->resetStats(array($this->hashtag));
    	
    	if(count($this->hashtag->tagables) === 0)
			$this->hashtag->delete();
    }
}