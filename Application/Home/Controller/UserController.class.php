<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends PublicController {
    
    //用户信息
    public function info(){

        //判断用户
        if( session('user_type')=='admin' ){
            
            if( I('post./a')  ){
               $data=I('post./a');
               
               if( M('admin')->where( array('id'=>$data['id']) )->save($data)  ){
                    //乐观锁  返回json数据
                    $this->ajaxReturn( array('status'=>1,'info'=>'修改成功！') ); 
                    exit();
               }else{
                    //乐观锁  返回json数据
                    $this->ajaxReturn( array('status'=>0,'info'=>'修改失败！') );
                    exit();
                   
               }
            }            
            
        }else{
                if( I('post./a')  ){
                $data=I('post./a');
               if( M('user')->where( array('id'=>$data['id']) )->save($data)  ){
                    //乐观锁  返回json数据
                    $this->ajaxReturn( array('status'=>1,'info'=>'修改成功！') ); 
                    exit();
               }else{
                    //乐观锁  返回json数据
                    $this->ajaxReturn( array('status'=>0,'info'=>'修改失败！') );
                    exit();
               }
            }         
        }        


        $this->display();
    }
    
    //密码修改
    public function pwd(){

        //判断是否是普通用户
        if( session('user_type')=='admin' ){

            //获取密码
            $info= M('admin')
                ->field('a.*,GROUP_CONCAT(c.role_name) as role_name')
                ->alias('a')
                ->group('b.admin_id')
                ->join('LEFT JOIN __ADMIN_ROLE__ as b on a.id=b.admin_id')
                ->join('LEFT JOIN __ROLE__ as c on c.id=b.role_id')
                ->where(array('a.id'=>session('uid')))
                ->find();

            //接受数据    
            $data=I('post./a');

            if( I('post./a')  ){

                //判断旧密码是否正确
                if( $info['password'] == md5( $data['old_password'] )  ){

                    //判断两次密码是否一样
                    if($data['password'] == $data['confirm_password']){
                            $data['password'] =md5($data['password'] );
                            if( M('admin')->where( array('id'=>$data['id']) )->save($data)  ){
                                //乐观锁  返回json数据
                                $this->ajaxReturn( array('status'=>1,'info'=>'修改成功！') );  
                                 session('uid',null);
                                 session('user_type',null);
                                 exit();
                            }else{
                                //乐观锁  返回json数据
                                $this->ajaxReturn( array('status'=>0,'info'=>'修改失败！') ); 
                                exit();
                            }
                    }

                }else{
                    $this->ajaxReturn( array('status'=>0,'info'=>'旧密码错误！') );
                }            

            }        
            
        }else{

            //获取密码
            $info=M('user')->field('id,username,password')->where( array('id'=>session('uid')) )->find();

            //接受数据    
            $data=I('post./a');

            if( I('post./a')  ){

                //判断旧密码是否正确
                if( $info['password'] == md5( $data['old_password'] )  ){

                    //判断两次密码是否一样
                    if($data['password'] == $data['confirm_password']){
                            $data['password'] =md5($data['password'] );
                            if( M('user')->where( array('id'=>$data['id']) )->save($data)  ){
                                //乐观锁  返回json数据
                                $this->ajaxReturn( array('status'=>1,'info'=>'修改成功！') );  
                                 session('uid',null);
                                 session('user_type',null);
                                 exit();
                            }else{
                                //乐观锁  返回json数据
                                $this->ajaxReturn( array('status'=>0,'info'=>'修改失败！') ); 
                                exit();
                            }
                    }

                }else{
                    $this->ajaxReturn( array('status'=>0,'info'=>'旧密码错误！') );
                }            

            }            
            
        }        


        
        
        $this->display();
    }
    
    
    
    
    
    
}

