<?php
namespace Home\Controller;
use Think\Controller;

class PrivilegeController extends PublicController {
    
    public function index(){

        $res=D('Privilege')->privilege();
        
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
        
        if(I('post.')){
            $data=I('post./a'); //接受数据
            $model=D('Privilege');
            
            //判断是否是ajax提交
            ajax();  
            
            //检验是否是有效数据
            if($model->create($data)){
                //添加
                if( $model->add($data) ){
                    $this->success('添加成功！',U('Privilege/index')) && exit();
                }
                
            }else{
                $this->error( $model->getError() );
            }
            
        }
        
        $this->display('add');
    }
    
    
    //编辑 修改
    public function edit(){
        //信息
        $res=D('Privilege')->privilege();
        $this->assign( 'res',$res['res'][0] );
        
        if( I('post.id/d') ){
            $id=I('post.id/d');
            $data=I('post.');
            
            //检测是否是ajax
            ajax();
            
            $model=D('Privilege');
            
            //检验是否是有效数据
            if($model->create($data,2)){
                //添加
                if( $model->save($data) ){
                    $this->success('修改成功！',U('Privilege/index')) && exit();
                }
                
            }else{
                $this->error( $model->getError() );
            }
            
            //乐观锁  返回json数据
            $this->ajaxReturn( array('status'=>1,'info'=>'修改成功！') );                
        }
        
        $this->display();
    }
    
    
    //删除
    public function delete(){
        
        //检测是否 是ajax
        ajax();
        
        if( I('get.id/d') ){
            $id=I('get.id/d');
            $model=D('Privilege');
            //判断是否删除成功
            if( $model->delete($id) ){
                $this->success('删除成功',U('Privilege/index'));
            }else{
                $this->error( $model->getError() );
            }
            
        }
        
    }
    
}
