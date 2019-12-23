<?php
namespace Home\Controller;
use Think\Controller;

class BuyController extends PublicController {
    
    public function index(){
        //获取所有的品牌
        $brand=M('brand')->field('id,name')->select();

        //获取所有的类型
        $category=M('category')->field('id,name')->select();
        
        //获取所有的属性
//        $attribute=M('attribute')->field('id,name')->select();
//        dump($attribute);
        
        //商品列表信息
        $res=D('Goods')->goods();
//        dump($res);
        
        //分配
        $this->assign(array(
            'res'       =>  $res,
            'empty'     =>  '<tr><td colspan="10"><span class="empty">没有找到匹配的数据...</span></td></tr>',
            'brand'     =>  $brand,
            'category'  =>  $category,
//            'attribute'=>  $attribute
            )
        );
        $this->display('list');
    }
     
    
    //编辑 修改
    public function add(){
        //分类列表
        $category=D('Category');
        $res=$category->field('id,name')->select();
        
        //品牌列表
        $brand=D('Brand');
        $brand=$brand->field('id,name')->select();     
    
        //获取所有的门店
        $store=M('store')->field('id,name')->select();
           
        $this->assign(array(
            'category'  =>  $res,
            'brand'     =>  $brand,
            'store'     =>  $store
        ));
               
        
        if( I('post.') ){
            $data=I('post./a') ;
//            dump($data);
//            die();
            //检测是否是ajax
            ajax();
            
            $model=D('Goods');
            //检验是否是有效数据
            if($model->create($data,1)){
                //添加
                if( $model->add($data) ){
                    $this->success('添加成功！',U('Goods/index')) && exit();
                }
                
            }else{
                $this->error( $model->getError() );
                exit();
            }
            
            //乐观锁  返回json数据
            $this->ajaxReturn( array('status'=>1,'info'=>'修改成功！') );  
            
        }
        
        
        $this->display();
    }
    
    
    //编辑 修改
    public function edit(){
        //分类列表
        $category=D('Category');
        $res=$category->field('id,name')->select();
        
        //品牌列表
        $brand=D('Brand');
        $brand=$brand->field('id,name')->select();     
    
        //获取所有的门店
        $store=M('store')->field('id,name')->select();
           
        $this->assign(array(
            'category'  =>  $res,
            'brand'     =>  $brand,
            'store'     =>  $store
        ));
           
        
        //获取信息
        if( I('get.id/d') ){
            $id=I('get.id/d');
            $res=D('Goods')->goods();
            
//            dump($res['res'][0]);
            
            $this->assign('info',$res['res'][0] );
        }
        
        //数据提交
        if( I('post.') ){
            $data=I('post.');
//            dump($data);die;
            //判断是否是ajax提交
            ajax();
            
            $model=D('Goods');
            //检验是否是有效数据
            if($model->create($data,2)){
                //修改
                if( $model->save($data) ){
                   // $this->success('修改成功！',U('Goods/index')) && exit();
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
    
    //删除
    public function delete(){
        //判断是否传入了id
        if( I('get.id/d') ){
            $id=I('get.id/d'); 
            
            //判断是否是ajax提交
            ajax(); 
            
            $model=D('Goods');
            if( $model->delete($id) ){
                $this->success('删除成功!',U('Goods/index'));
            }else{
                $this->error( $model->getError() );
            }
            
        }
        
    } 
    
    
    //ajax获取属性列表
    public function get_attr(){
        $model=D('Goods');
        $res=$model->get_attr( I('get.id/d') );
        $this->ajaxReturn($res);
    }
      
    //信息
    public function detail(){
        //分类列表
        $category=D('Category');
        $res=$category->field('id,name')->select();
        
        //品牌列表
        $brand=D('Brand');
        $brand=$brand->field('id,name')->select();     
    
        //获取所有的门店
        $store=M('store')->field('id,name')->select();
           
        $this->assign(array(
            'category'  =>  $res,
            'brand'     =>  $brand,
            'store'     =>  $store
        ));
             
        
        //获取信息
        if( I('get.id/d') ){
            $id=I('get.id/d');
            $res=D('Goods')->goods();
//            dump($res);
            $this->assign('info',$res['res'][0] );
        }
     
        $this->display();
    }   
    
    
}

