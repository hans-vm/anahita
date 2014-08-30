<?php

/** 
 * LICENSE: ##LICENSE##
 * 
 * @package    Com_Anahita
 * @subpackage Schema_Migration
 */

/**
 * Schema Migration
 *
 * @package    Com_Anahita
 * @subpackage Schema_Migration
 */
class ComAnahitaSchemaMigration6 extends ComMigratorMigrationVersion
{
   /**
    * Called when migrating up
    */
    public function up()
    {    
        //delete a legacy record	
        dbexec('DELETE FROM #__components WHERE `option` = \'com_content\' ');
    	
    	//add the mention tag contentfilter
        dbexec('INSERT INTO #__plugins (`name`,`element`,`folder`,`iscore`,`published`) VALUES (\'Mention\', \'mention\',\'contentfilter\',1,1)');
        
        //changing the hashtag class name to tag
        dbexec('UPDATE #__anahita_edges SET `type` = REPLACE(`type`, \'ComHashtagsDomainEntityAssociation,com:hashtags.domain.entity.association\', \'ComTagsDomainEntityTag,ComHashtagsDomainEntityTag,com:hashtags.domain.entity.tag\') WHERE type LIKE \'%com:hashtags.domain.entity%\' ');
    }

   /**
    * Called when rolling back a migration
    */        
    public function down()
    {
        //add your migration here        
    }
}