<?php
namespace Home\Controller;
use Think\Controller;

class PositionController extends PublicController {
    
    public function index(){
        $model=D('Position');
        $res=$model->position();

        $this->assign('res',$res);
        
        $this->display('list');
    }
    
    
    //添加
    public function add(){
        if(I('post.')){
            $data=I('post./a'); //接受数据
            
            //检测是否是ajax
//            ajax();
            
            $model=D('Position');
            
            //检验是否是有效数据
            if($model->create($data,1)){
                //添加
                if( $model->add($data) ){
                    $this->success('添加成功！',U('Position/index')) && exit();
                }
                
            }else{
                $this->error( $model->getError() );
            }
            
        }
        
        $this->display();
    }
    
    
    //编辑 修改
    public function edit(){
        
        //获取信息
        if( I('get.id/d') ){
            $res=D('Position')->position();
            $this->assign('info',$res['res'][0] );
        }
        
        if(I('post.id/d')){
            $data=I('post./a'); //接受数据
            
            //检测是否是ajax
            ajax();
            
            $model=D('Position');
            
            //检验是否是有效数据
            if($model->create($data,2)){
                //添加
                if( $model->save($data) ){
                    $this->success('修改成功！',U('Store/index')) && exit();
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
            $model=D('Position');
            
            //判断是否删除成功
            if( $model->delete($id) ){
                $this->success('删除成功!',U('Store/index'));
            }else{
                $this->error( $model->getError() );
            }
            
        }
            
    }    
    
    
    
}
