<?php
namespace Home\Widget;
use Think\Controller;

class MenuWidget extends Controller {
    //菜单
    public function menu(){
        return $this->fetch('Widget:menu');
    }
    
    //商品
    public function goods(){
        return $this->fetch('Widget:goods');
    }    
    
}

