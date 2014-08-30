<?php 

/**
 * LICENSE: ##LICENSE##
 *
 * @category   Anahita
 * @package    Plg_Contentfilter
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @version    SVN: $Id$
 * @link       http://www.anahitapolis.com
 */

/**
 * Creates a hyperlink from the URLs
 *
 * @category   Anahita
 * @package    Plg_Contentfilter
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @link       http://www.anahitapolis.com
 */
class PlgContentfilterLink extends PlgContentfilterAbstract
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
            'priority'   => KCommand::PRIORITY_NORMAL,
        ));

        parent::_initialize($config);
    }
    	
	/**
	 * Filter a value. 
	 * The code is extracted from the ignite framework auto_link 
	 * 
	 * @param string The text to filter
	 * 
	 * @return string
	 */	
	public function filter($text)
	{
		$this->_stripTags($text);
		
		$text = trim($text);
    		    
    	$text = strip_tags($text, "<b><i><u>");
    	$text = preg_replace("/(?<!http:\/\/)www\./","http://www.", $text);
    	$text = preg_replace( "/((http|ftp)+(s)?:\/\/[^<>\s]+)/i", "<a href=\"\\0\" target=\"_blank\">\\0</a>", $text);

		$this->_replaceTags($text);
		
		return $text;	
	}
}