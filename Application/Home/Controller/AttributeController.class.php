<?php
namespace Home\Controller;
use Think\Controller;

class AttributeController extends PublicController {
    
    public function index(){
        $model=D('Attribute');
        $res=$model->category();
        $this->assign('res',$res);
        
        $this->display('list');
    }
    
    
    //添加
    public function add(){
        if(I('post.')){
            $data=I('post./a'); //接受数据
            
            //检测是否是ajax
            ajax();

            $model=D('Attribute');
            
            //检验是否是有效数据
            if($model->create($data,1)){
                //添加
                if( $model->add($data) ){
                    $this->success('添加成功！',U('Attribute/index')) && exit();
                }
                
            }else{
                $this->error( $model->getError() );
            }
            
        }
        
        //分类列表
        $category=D('Category');
        $res=$category->field('id,name')->select();
        $this->assign('category',$res);        
        
        $this->display();
    }
    
    
    //编辑 修改
    public function edit(){
        
        //获取信息
        if( I('get.id/d') ){
            $res=D('Attribute')->category();
            $this->assign('info',$res['res'][0] );
        }
        
        if(I('post.id/d')){
            $data=I('post./a'); //接受数据
            
            //检测是否是ajax
            ajax();
            
            $model=D('Attribute');
            
            //检验是否是有效数据
            if($model->create($data,2)){
                //添加
                if( $model->save($data) ){
                    $this->success('修改成功！',U('Attribute/index')) && exit();
                }
                
            }else{
                $this->error( $model->getError() );
            }
            
            //乐观锁  返回json数据
            $this->ajaxReturn( array('status'=>1,'info'=>'修改成功！') );      
        }  
        
        //分类列表
        $category=D('Category');
        $res=$category->field('id,name')->select();
        $this->assign('category',$res);          
        
        $this->display();
    }
    

    //删除用户
    public function delete(){
        
        //如果get id存在
        if( I('get.id/d')  ){
            $id=I('get.id/d');
            $model=D('Attribute');
            
            //判断是否删除成功
            if( $model->delete($id) ){
                $this->success('删除成功!',U('Attribute/index'));
            }else{
                $this->error( $model->getError() );
            }
            
        }
            
    }    

    
    
}
