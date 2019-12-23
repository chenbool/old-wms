<?php
namespace Home\Controller;
use Think\Controller;

class RoleController extends PublicController {
    
    public function index(){

        $res=D('Role')->role();
//        dump($res);
        //分配
        $this->assign(array(
            'res'   =>  $res,
            'empty' =>  '<tr><td colspan="8"><span class="empty">没有找到匹配的数据...</span></td></tr>'
            )
        );
        $this->display('list');
    }
    
    //添加用户
    public function add(){
        //获取权限列表
        $privilege=D('Privilege');
        $res=$privilege->field('id,name')->select();
        $this->assign('res',$res);
        
        if( I('post.') ){
            $data=I('post./a') ;

            //检测是否是ajax
            ajax();
            
            $model=D('Role');
            //检验是否是有效数据
            if($model->create($data,1)){
                //添加
                if( $model->add($data) ){
                    $this->success('添加成功！',U('Role/index')) && exit();
                }
                
            }else{
                $this->error( $model->getError() );
            }
        }
        
        $this->display('add');
    }
    
    
    //编辑 修改
    public function edit(){
        //获取权限列表
        $privilege=D('Privilege');
        $res=$privilege->field('id,name')->select();
        $this->assign('res',$res);
        
        //获取信息
        if( I('get.id/d') ){
            $id=I('get.id/d');
            $res=D('Role')->role();
            $this->assign('info',$res['res'][0] );
            
        }
        
        //数据提交
        if( I('post.') ){
            $data=I('post.');

            //判断是否是ajax提交
            ajax();
            
            $model=D('Role');
            //检验是否是有效数据
            if($model->create($data,2)){
                //修改
                if( $model->save($data) ){
                    $this->success('修改成功！',U('Role/index')) && exit();
                }
                
            }else{
                $this->error( $model->getError() );
                exit;
            }
            
            //乐观锁  返回json数据
            $this->ajaxReturn( array('status'=>1,'info'=>'修改成功！') );      
        }
        
        $this->display();
    }
    
    public function delete(){
        //判断是否传入了id
        if( I('get.id/d') ){
            $id=I('get.id/d'); 
            //判断是否是ajax提交
            ajax(); 
            $model=D('Role');
            if( $model->delete($id) ){
                $this->success('删除成功!',U('Role/index'));
            }else{
                $this->error( $model->getError() );
            }
            
        }
        
    }
    
}
