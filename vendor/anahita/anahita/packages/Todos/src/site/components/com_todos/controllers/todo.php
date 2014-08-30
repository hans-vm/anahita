<?php

/** 
 * LICENSE: ##LICENSE##
 * 
 * @category   Anahita
 * @package	   Com_Todos
 * @subpackage Controller
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @copyright  2008 - 2010 rmdStudio Inc./Peerglobe Technology Inc
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @version    SVN: $Id$
 * @link       http://www.anahitapolis.com
 */

/**
 * Todo Controller
 * 
 * @category   Anahita
 * @package	   Com_Todos
 * @subpackage Controller
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @link       http://www.anahitapolis.com
 */
class ComTodosControllerTodo extends ComMediumControllerDefault
{	

    /**
     * Constructor.
     *
     * @param KConfig $config An optional KConfig object with configuration options.
     *
     * @return void
     */
    public function __construct(KConfig $config)
    {
        parent::__construct($config);

        $this->registerCallback(array('before.enable','before.disable'), array($this,'setLastChanger'));
        $this->registerCallback(array('after.enable','after.disable'), array($this,'createStoryCallback'));
    }
    
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
            'request' => array('pid'=>null),
        	'behaviors' => array(
                'parentable',
        		'enablable'
        	)
        ));   

        parent::_initialize($config);
    }
        
    /**
	 * Sets the value of lastChanger to the last person who opened or closed a todo
	 * 
	 * @param KCommandContext $context
     * 
	 * @return void
	 */
	public function setLastChanger($context)
	{		
		$this->getItem()->setLastChanger(get_viewer());
	}
        
	/**
	 * Browse Todos
	 * 
	 * @param  KCommandContext $context
	 * @return void
	 */
	protected function _actionBrowse($context)
	{		
		$todos = parent::_actionBrowse($context);

		if($this->getRequest()->get('layout') == 'gadget')
			$todos->where('open', '=', 1);
		else 
			$todos->order('open', 'DESC');
		
		if($this->filter == 'leaders')
			$todos->order('creationTime', 'DESC');
		else
			$todos->order('priority', 'DESC');
			
		return $todos;
	}

    protected function _actionAdd($context)
    {       
        $data           = $context->data;
        $file           = KRequest::get('files.portrait', 'raw');
        $content        = @file_get_contents($file['tmp_name']);
        $filesize       = strlen($content);
        $uploadlimit    =  2 * 1024 * 1024;

        $exif = (function_exists('exif_read_data')) ? @exif_read_data($file['tmp_name']) : array();

        if ($filesize == 0) {
            throw new LibBaseControllerExceptionBadRequest('File is missing');
        }

        if ($filesize > $uploadlimit) {
            throw new LibBaseControllerExceptionBadRequest('Exceed maximum size');
        }

        $orientation = 0;

        if (!empty($exif) && isset($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
        }

        $data['portrait']  = array(
            'data' => $content,
            'rotation' => $orientation,
            'mimetype' => isset($file['type']) ? $file['type'] : null
        );
        $todo = $this->actor->todos->addNew($data);
        $todo->setExifData($exif);
        $todo->save();
        $this->setItem($todo);
        $this->getResponse()->status = KHttpResponse::CREATED;
        if ($todo->body && preg_match('/\S/',$todo->body)) {
            $context->append(array(
                'story' => array(
                    'body' => $todo->body
                )
            ));
        }

        return $todo;
    }

    protected function _actionEdit($context)
    {
        $data = $context->data;
        $todo = parent::_actionEdit($context);

        $file           = KRequest::get('files.portrait', 'raw');
        $content        = @file_get_contents($file['tmp_name']);
        $filesize       = strlen($content);
        $uploadlimit    =  2 * 1024 * 1024; 

        $exif = (function_exists('exif_read_data')) ? @exif_read_data($file['tmp_name']) : array();

        if ($filesize == 0) {
            throw new LibBaseControllerExceptionBadRequest('File is missing');
        }
        
        if ($filesize > $uploadlimit) {
            throw new LibBaseControllerExceptionBadRequest('Exceed maximum size');
        }

        $orientation = 0;

        if (!empty($exif) && isset($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
        }

        $data['portrait']  = array(
            'data' => $content,
            'rotation' => $orientation,
            'mimetype' => isset($file['type']) ? $file['type'] : null
        );
        $todo->setPortrait($data['portrait']);
        $todo->save();

        $this->getResponse()->status = KHttpResponse::RESET_CONTENT;

        return $todo;
    }
}