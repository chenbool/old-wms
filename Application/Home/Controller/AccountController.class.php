<?php
namespace Home\Controller;
use Think\Controller;

class AccountController extends PublicController {
    
    public function index(){
        //职位列表
        $position=M('position')->field('id,name')->select();  
        
        //门店列表
        $store=M('store')->field('id,name')->select();
        
        //实现 分页 搜索
        $res=D('User')->search();

        $this->assign(array(
            'res'   =>  $res,
            'empty' =>  '<tr><td colspan="9"><span class="empty">没有找到匹配的数据...</span></td></tr>',
            'position'  =>  $position,
            'store'     =>  $store,
            )
        );
        $this->display('list');
    }
    
    
    //添加用户
    public function add(){
        
        if(I('post.')){
            $data=I('post./a');

            $model=D('User');
            //检测是否是ajax
            ajax();
            
            //检验是否是有效数据
            if($model->create($data,1)){
                //添加
                if( $model->add($data) ){
                    $this->success('添加成功！',U('Account/index')) && exit();
                }
                
            }else{
                $this->error( $model->getError() );
            }
            
        }
        
        //职位列表
        $position=M('position')->field('id,name')->select();

        //门店列表
        $store=M('store')->field('id,name')->select();
//        dump($store);
        
        $this->assign(array(
                'position'  =>  $position,
                'store'     =>  $store
            )     
        );
        
        $this->display('add');
    }
    
    
    //编辑 修改 
    public function edit(){
        
        //获取用户信息
        $res=D('User')->search();

        //职位列表
        $position=M('position')->field('id,name')->select();

        //门店列表
        $store=M('store')->field('id,name')->select();
        
        $this->assign(array(
                'position'  =>  $position,
                'store'     =>  $store,
                'info'      =>  $res['res'][0]
            )     
        );
        
        
        //执行修改
        if(I('post.')){
            $data=I('post./a');

            $model=D('User');
            
            //判断是否是ajax提交
            ajax();
            
            //检验是否是有效数据
            if($model->create($data,2)){
                //修改
                if( $model->save($data) ){
                    $this->success('修改成功！',U('Account/index')) && exit();
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
    
    //修改用户状态
    public function status(){
        
        //如果get id存在
        if( I('get.id/d') ){
            $id=I('get.id/d');
            $data['status']=I('get.status/d');
            
            //判断是否是ajax提交
            ajax();
            
            //判断是否修改成功
            if( M('user')->where(array('id'=>$id))->save($data) ){
                //返回json数据
                $this->ajaxReturn( array('status'=>1,'info'=>'修改成功！') );      
            }else{
                
                $this->ajaxReturn( array('status'=>0,'info'=>'修改失败！') );     
            }
            
        }
        
        
    }
    
    //删除用户
    public function delete(){
        
        //如果get id存在
        if( I('get.id/d')  ){
            $id=I('get.id/d');
            $model=D('user');
            
            //判断是否删除成功
            if( $model->delete($id) ){
                $this->success('删除成功!',U('Account/index'));
            }else{
                $this->error( $model->getError() );
            }
            
        }
        
    }
    
   
    //信息展示
    public function detail(){
        //获取信息
        if( I('get.id/d') ){
            $res=D('User')->search();
            $this->assign('info',$res['res'][0]);
        }
        
        $this->display();
    }
       
    
    
}
