<?php
namespace Packfire\Web\Admin;

use Packfire\Application\Pack\View;
use Packfire\Web\MenuView;

/**
 * ChangePasswordView class
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2012, Sam-Mauris Yong / mauris@hotmail.sg
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Packfire\Web\Admin
 * @since 1.0
 */
class ChangePasswordView extends View {
    
    protected function create(){
        $menu = new MenuView();
        $menu->copyBucket($this);
        $this->define('menu', $menu);
        
        $rootUrl = $this->route('home');
        $this->define('rootUrl', $rootUrl);
        
        $identity = $this->service('security')->identity();
        $this->define('username', $identity['name']);
        $this->define('timeOfTheDay', $this->state->get('timeOfDay'));
        
        $this->define('contentTypes', $this->state->get('types'));
        
        if($this->state->get('fail')){
            $this->define('failMessage', $this->state->get('fail'));
        }
        if($this->state->get('success')){
            $this->define('successMessage', $this->state->get('success'));
        }
    }
    
}