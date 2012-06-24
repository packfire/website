<?php
pload('app.AppView');

/**
 * AdminIndexView View
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2012, Sam-Mauris Yong / mauris@hotmail.sg
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package app.view
 * @since 1.0
 */
class AdminIndexView extends AppView {
    
    protected function create(){
        $menu = new MenuView();
        $menu->copyBucket($this);
        $this->define('menu', $menu);
        
        $rootUrl = $this->route('home');
        $this->define('rootUrl', $rootUrl);
        
        $identity = $this->service('security')->identity();
        $this->define('username', $identity['Name']);
        $this->define('timeOfTheDay', $this->renderTimeOfDay($identity));
        
        $this->define('contentTypes', $this->state->get('types'));
        
        if($this->state->get('fail')){
            $this->define('failMessage', $this->state->get('fail'));
        }
    }
    
    private function renderTimeOfDay($user){
        $now = pDateTime::now();
        $now->timezone($user['Timezone']); // convert to user's timezone
        $hour = $now->time()->hour();
        $result = 'night';
        if($hour > 3 && $hour < 12){
            $result = 'morning';
        }elseif($hour < 17){
            $result = 'afternoon';
        }elseif($hour < 22){
            $result = 'evening';
        }
        return $result;
    }
    
}