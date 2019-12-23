<?php
namespace Home\Controller;
use Think\Controller;

class PublicController extends Controller {
    
    //初始化
    function _initialize(){
        //判断session id是否存在
        if( session('uid') ){
           //判断是否是普通用户
            if( session('user_type')=='admin' ){
                //查询用户信息
                $info= M('admin')
                    ->field('a.*,a.id as user_id,GROUP_CONCAT(DISTINCT c.role_name) as role_name,e.*,e.id as privliege_id,GROUP_CONCAT(DISTINCT e.controller) as authority')
                    ->alias('a')
                    ->group('b.admin_id')
                    ->join('LEFT JOIN __ADMIN_ROLE__ as b on a.id=b.admin_id')
                    ->join('LEFT JOIN __ROLE__ as c on c.id=b.role_id')
                    ->join('LEFT JOIN __ROLE_PRIVILEGE__ as d on c.id=d.role_id')
                    ->join('LEFT JOIN __PRIVILEGE__ as e on d.privliege_id=e.id')
                    ->where(array('a.id'=>session('uid')))
                    ->find();                
            }else{
                $info= M('user')
                    ->field('a.*,a.id as user_id,b.*,c.id as position_id,c.name as position_name,d.name as store_name,d.id as store_id')
                    ->alias('a')
                    ->join('LEFT JOIN __USERINFO__ as b on a.id=b.id')
                    ->join('LEFT JOIN __POSITION__ as c on b.position=c.id')
                    ->join('LEFT JOIN __STORE__ as d on b.store_id=d.id')
                    ->where(array('a.id'=>session('uid')) )
                    ->find();
            }

           $this->assign('infos',$info); //分配用户信息
           //dump($info);
           //dump($info['authority']);
           
        }else{
            $this->redirect('Login/index'); //跳转到登陆页面
        }
    }
    

    public function nopower(){
        $this->display();
    }
    
    
    
    
}

