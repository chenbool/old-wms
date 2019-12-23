<?php
namespace Home\Controller;
use Think\Controller;

class AdminController extends PublicController {
    
    public function index(){
        //获取角色列表
        $Role=D('Role');
        $info=$Role->field('id,role_name')->select();
        $this->assign('role',$info);    
        
        //查询数据
        $res=D('Admin')->search();
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
            $model=D('Admin');
            
            //检测是否是ajax
            ajax();
            
            //检验是否是有效数据
            if($model->create($data,1)){
                //添加
                if( $model->add($data) ){
                    $this->success('添加成功！',U('Admin/index')) && exit();
                }
                
            }else{
                $this->error( $model->getError() );
            }
            
        }
        
        //获取角色列表
        $Role=D('Role');
        $res=$Role->field('id,role_name')->select();
        $this->assign('role',$res);        
        
        $this->display('add');
    }
    
    
    //编辑 修改
    public function edit(){
        //获取信息
        $info=D('Admin')->search();
        
        //获取角色列表
        $Role=D('Role');
        $res=$Role->field('id,role_name')->select();

        $this->assign(array(
                'role'  =>  $res,
                'info'  =>  $info['res'][0]
            ) 
        );     
        
        //修改
        if(I('post.')){
            $data=I('post./a'); //接受数据

            //检测是否是ajax
            ajax();
            
            $model=D('Admin');
            //检验是否是有效数据
            if($model->create($data,2)){
                //修改
                if( $model->save($data) ){
                    $this->success('修改成功！',U('Admin/index')) && exit();
                }
                
            }else{
                $this->error( $model->getError() );
            }
            
            //乐观锁  返回json数据
            $this->ajaxReturn( array('status'=>1,'info'=>'修改成功！') );    
            
        }        
        
        $this->display();
    }

    
    //删除用户
    public function delete(){
        
        //如果get id存在
        if( I('get.id/d')  ){
            $id=I('get.id/d');
            $model=D('Admin');
            
            //判断是否删除成功
            if( $model->delete($id) ){
                $this->success('删除成功!',U('Admin/index'));
            }else{
                $this->error( $model->getError() );
            }
            
        }
        
    }        
    
    
}

