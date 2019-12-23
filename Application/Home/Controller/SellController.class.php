<?php
namespace Home\Controller;
use Think\Controller;

class SellController extends PublicController {
    
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
            'empty'     =>  '<tr><td colspan="8"><span class="empty">没有找到匹配的数据...</span></td></tr>',
            'brand'     =>  $brand,
            'category'  =>  $category,
//            'attribute'=>  $attribute
            )
        );
        $this->display();
    }
     
    
    //编辑 修改
    public function item(){
        //分类列表
        $category=D('Category');
        $res=$category->field('id,name')->select();
        $this->assign('category',$res);
        
        //品牌列表
        $brand=D('Brand');
        $brand=$brand->field('id,name')->select();
        $this->assign('brand',$brand);     
        
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
            
            //判断是否是ajax提交
//            ajax();
            
            $model=D('Goods');
            //检验是否是有效数据
            if($model->reduce_stock()){
                //修改
                $this->success('下单成功！',U('Sell/index')) && exit();
                
            }else{
                $this->error( '下单失败!'.$model->getError() );
                exit;
            }
            
            //乐观锁  返回json数据
            $this->ajaxReturn( array('status'=>1,'info'=>'修改成功！') );      
        }
        
        $this->display();
    }
    
    
    //ajax获取属性列表
    public function get_attr(){
        $model=D('Goods');
        $res=$model->get_attr( I('get.id/d') );
        $this->ajaxReturn($res);
    }
    
  
    //销售记录
    public function record(){
        //获取销售信息
        $res=D('record')->search();
        
        //获取所有的类型
        $category=M('category')->field('id,name')->select();
        
        //dump($res);
        $this->assign(array(
            'res'   =>  $res,
            'empty' =>  '<tr><td colspan="9"><span class="empty">没有找到匹配的数据...</span></td></tr>',
            'category'=>$category
        ));
        
        $this->display();
    }
    

}

