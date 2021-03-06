<?php
namespace Packfire\Web\Page;

use Packfire\Application\Pack\Controller as CoreController;
use Packfire\IO\File\Path;
use Packfire\DateTime\DateTime;

/**
 * Controller class
 * 
 * Handles interaction for pages
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2010-2012, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Packfire\Web\Page
 */
class Controller extends CoreController {
    
    public function index(){
        $this->state['features'] = array(
            array(
                'title' => 'Truly Object-Oriented',
                'text' => 'Packfire is a full OO framework that helps you to design your application to be clear and highly reusable. If you are a C#, Java or any OO language developer, you will love PHP using Packfire. '
            ),
            array(
                'title' => 'MVC Designed',
                'text' => 'Designed with the well-proven Model-View-Controller (MVC) architecture, Packfire allows you develop with Separation of Concerns (SoC) for ease of testing and writing code.'
            ),
            array(
                'title' => 'Easily Extensible',
                'text' => 'Due to Packfire\'s OO nature, you can easily extend and re-implement any part of the framework for your application without modifying the framework source code directly.'
            ),
            array(
                'title' => 'Secured and Hardened',
                'text' => 'When set for production, the framework is automatically hardened to the highest security. Input validation, injection prevention measures and sniffing deterrence give hackers no chance of entry.'
            ),
            array(
                'title' => 'Test and Debug',
                'text' => 'Packfire provides a toolbox full of testing support and debugging utilities. You can write your code knowing that they are are well tested and bug-free.'
            ),
            array(
                'title' => 'Modern technologies',
                'text' => 'Emerging server-side technologies and concepts such as JSON, YAML, Mustache, LINQ and IoC are incorporated into Packfire for great development efficiency with gentle learning curve.'
            )
        );
        $this->render();
    }
    
    public function downloadFile($id){
        $screencasts = $this->ioc['database']->from('contents')
                ->where('ContentId = :contentId')->select('ContentId', 'Title', 'Content', 'Created')
                ->orderByDesc('Created')
                ->param('contentId', $id)
                ->map(function($x){
                    return array(
                            'id' => $x[0],
                            'title' => $x[1],
                            'url' => $x[2],
                            'filename' => Path::baseName($x[2]),
                            'date' => DateTime::fromString($x[3])->format('h:i:sa, j M Y')
                        );
                })->fetch();
        if($screencasts->count() > 0){
            $this->state = $screencasts[0];
        }else{
            $this->state = false;
        }
        $this->render();
    }
    
    public function postDownloads($download){
        $this->redirect($this->route('downloadFile', array('id' => $download)));
    }
    
    public function downloads(){
        $screencasts = $this->ioc['database']->from('contents')
                ->where('ContentType = 2')->select('ContentId', 'Title', 'Content', 'Created')
                ->orderByDesc('Created')
                ->map(function($x){
                    return array(
                            'id' => $x[0],
                            'title' => $x[1],
                            'url' => $x[2],
                            'filename' => Path::baseName($x[2]),
                            'date' => DateTime::fromString($x[3])->format('h:i:sa, j M Y')
                        );
                })->fetch();
        if($screencasts->count() > 0){
            $this->state = $screencasts;
        }else{
            $this->state = false;
        }
        $this->render();
    }
    
    public function screencasts(){
        $screencasts = $this->ioc['database']->from('contents')
                ->where('ContentType = 1')->select('ContentId', 'Title', 'Content')
                ->orderByDesc('Created')
                ->map(function($x){
                    return array(
                            'id' => $x[0],
                            'title' => $x[1],
                            'videoId' => $x[2]
                        );
                })->fetch();
        if($screencasts->count() > 0){
            $this->state = $screencasts;
        }else{
            $this->state = null;
        }
        $this->render();
    }
    
}