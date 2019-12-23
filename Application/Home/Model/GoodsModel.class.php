<?php
namespace Home\Model;
use Think\Model;

class GoodsModel extends Model {
    
    // 新增数据的时候允许写入name和email字段
    protected $insertFields = 'name,brand_id,category_id,price,stock,attrbute_id,spec_item,sn,store_id';
    // 编辑数据的时候只允许写入email字段    
    protected $updateFields = 'name,brand_id,category_id,price,stock,id,attrbute_id,spec_item,sn,store_id';
    
    //验证规则
    // 第四个参数： 0：存在字段就验证（默认） 1：必须验证 2：值不为空的时候验证    
    // 第六个参数： 规则什么时候生效： 1：添加时生效 2：修改时生效 3：所有情况都生效
    protected $_validate = array(
        array('name','require','名称不能为空',1),
        array('name', '', '名称已经存在！', 1, 'unique', 1),
        array('sn', '', '编号已经存在！', 1, 'unique', 1),
        array('name', '1,20', '名称最长不能超过 20 个字符！', 1, 'length', 3),
        array('brand_id','require','品牌不能为空',1),
    );    
    
    //插入之前
    protected function _before_insert(&$data, $option){
        $data['time']=  time();
        $price=I('post.price');
        $data['price']= $price[0];

        //购入总数量
        $count=I('post.count');
        $data['sum']= array_sum($count);
        
        //购入总价
        $data['total']= $data['price']*$data['sum'];
    
        
    }
    
    
    
    //获取属性的***************************************************************
    public function info($data,$price,$count){
    
        static $res=array();
        foreach ( $data as $k=>$v) {
            $res[]=$v.','.$price[$k].','.$count[$k];  
        }   
        return $res;
    }
    
    
    
    
    //插入之后*******************************************************************
    protected function _after_insert($data, $option){
        $res['goods_id']=$data['id'];
        
//        判断category_id是否是数组
        if(is_array( I('post.category_id/a') ) ){
            
//            遍历赋值，并添加
            foreach ( I('post.category_id/a') as $v) {
                $res['category_id']=$v;
                $res && M('goods_category')->add($res);
            }
            
        }
        
        //属性id
        $res1['goods_id']=$data['id'];
        
        $attrbute_id=I('post.attrbute_id/a');   //获取参数

        //判断是否 为数组 添加到val
        if(is_array($attrbute_id) ){
            
            //遍历插入数据库
            foreach ($attrbute_id as $key => $value) {
                $res1['attrbute_id']=$key;
                $res1['val']=$value;
                $res1 && M('goods_attrbute')->add($res1);  
            }
               
        }        
        
        
        //判断属性列表是否是数组
        if(is_array( I('post.spec_item/a') )){
            
            //获取参数
            $price=I('post.price/a');   //价格
            $count=I('post.count/a');   //库存
            
            //获取商品属性
           $arr= self::info(I('post.spec_item/a'),$price,$count);

           //把字符串转为数组
           foreach ($arr as $key => $value) {
               $attr[]=explode(",",$value);
           }
           
           //遍历赋值，并添加
            foreach ($attr as $value) {
                $res['attrbute_id']='';
                $res['attrbute_value']=$value[0].':'.$value[1];
                $res['price']=$value[2];
                $res['count']=$value[3];
                $res && M('goods_attrbute')->add($res);  
            }
            
        }
        
    }
    
    //更新之前*******************************************************************
    protected function _before_update(&$data, $option){
        $price=I('post.price');
        $data['price']= $price[0];

        //购入总数量
        $count=I('post.count');
        $data['sum']= array_sum($count);
//        dump($data);
        
        //购入总价
        $data['total']= $data['price']*$data['sum'];        
        
        //id
        //$res['goods_id']=$option['where']['id'];
  
    }    
    
    
    //更新之后*******************************************************************
    protected function _after_update($data, $option){
        $res=I('post.');  

        //id
        $res['goods_id']=$data['id'];
        
//        判断category_id是否是数组
        if(is_array( I('post.category_id/a') ) ){
            //先删除
            M('goods_category')->where( array('goods_id'=>$data['id']) )->delete();
            
//            遍历赋值，并添加
            foreach ( I('post.category_id/a') as $v) {
                $res['category_id']=$v;
                $res && M('goods_category')->add($res);
            }
            
        }    

        //判断属性列表是否是数组***********************************************
        if(is_array( I('post.spec_item/a') )){

                //获取参数
                $price=I('post.price/a');   //价格
                $count=I('post.count/a');   //库存
                
                //先删除
                M('goods_attrbute')->where(array( 'goods_id'=>$data['id']) )->delete();
                
                //获取商品属性
               $arr= self::info(I('post.spec_item/a'),$price,$count);

               //把字符串转为数组
               foreach ($arr as $key => $value) {
                   $attr[]=explode(",",$value);
               }

               //遍历赋值，并添加
                foreach ($attr as $value) {
                    $res['attrbute_id']='';
                    $res['attrbute_value']=$value[0].':'.$value[1];
                    $res['price']=$value[2];
                    $res['count']=$value[3];
                    $res && M('goods_attrbute')->add($res);  
                }

        }
        
        
        //属性id
        $res1['goods_id']=$data['id'];

        $attrbute_id=I('post.attrbute_id/a');   //获取参数

            //判断是否 为数组 添加到val
            if(is_array($attrbute_id) ){
                
                //遍历插入数据库
                foreach ($attrbute_id as $key => $value) {
                    $res1['attrbute_id']=$key;
                    $res1['val']=$value;
                    $res1 && M('goods_attrbute')->add($res1);  
                }

            }            
        
        
    }      
    
    
    
    //实现 搜索 分页 
    public function goods(){
        $where=array();
        
        //接受搜索的关键字 
        I('get.sn') && $where['sn']=array( 'eq',I('get.sn')) ;  //货号
        I('get.name') && $where['a.name']=array( 'like','%'.I('get.name').'%' )  ;
        I('get.username') && $where['username']=array( 'eq',I('get.username'))  ;
        I('get.brand') && $where['brand_id']=array( 'eq',I('get.brand'))  ; //品牌
        I('get.category') && $where['category_id']=array( 'eq',I('get.category'))  ; //类型
        
        //编辑信息页面获取到的id
        I('get.id') &&  $where=array('a.id' =>array('eq',I('get.id/d') ) );        
        
//        dump($where);
        
        //排序
        $order='a.id asc';    //默认从低到高
        I('get.order') &&  $order= str_replace('+',' ',I('get.order/s') ); //查找替换+
//        dump($order);
        
        /*************************区间查询开始 start *****************************/
        
        /*价格区间***************************************************************/
        if( I('get.start_price') ){
            $where['a.price']=array('egt',I('get.start_price'));
        }
        
        //起始价格 开始-结束
        if( I('get.start_price') && I('get.end_price') ){
            $where['a.price']=array("between",array( I('get.start_price'), I('get.end_price') ));
        }
        
        //小于结束 价格
        if( I('get.end_price') ){
            $where['a.price']=array('elt',I('get.end_price'));
        }    
        
        
        /*库存区间***************************************************************/
        if( I('get.start_stock') && !I('get.end_stock') ){
            $where['count']=array('egt',I('get.start_stock'));
        }

        //起始库存 开始-结束
        if( I('get.start_stock') && I('get.end_stock') ){
            $where['count']=array("between",array( I('get.start_stock'), I('get.end_stock') ));
        }
        
        //小于结束 库存
        if( !I('get.start_stock') && I('get.end_stock') ){
            $where['count']=array('elt',I('get.end_stock'));
        }            
        
        
        /*时间区间***************************************************************/
        //strtotime()
        if( I('get.start_time') && !I('get.end_time') ){
            $where['a.time']=array('egt',strtotime( I('get.start_time') )  );
        }        
        
        //起始时间 开始-结束
        if( I('get.start_time') && I('get.end_time') ){
            $where['a.time']=array("between",array( strtotime( I('get.start_time') ), strtotime( I('get.end_time') )  ));
            
        }
        
        //小于结束 时间
        if( !I('get.start_time') && I('get.end_time') ){
            $where['a.time']=array('elt',strtotime( I('get.end_time') ) );
        }        
        
       /************************区间查询结束 end *********************************/ 
        
        
        $count = $this->alias('a')
//                ->join('LEFT JOIN __BRAND__ as b on a.brand_id=b.id')
//                ->join('LEFT JOIN __GOODS_CATEGORY__ as c on a.id=c.goods_id')
//                ->join('LEFT JOIN __CATEGORY__ as d on c.category_id=d.id')
//                ->join('LEFT JOIN __GOODS_ATTRBUTE__ as e on a.id=e.goods_id')
//                ->join('LEFT JOIN __ATTRIBUTE__ as f on e.attrbute_id=f.id')
//                ->group('e.goods_id')
                ->where($where)
                ->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count,7);// 实例化分页类 传入总记录数和每页显示的记录数

        //设置
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');    
        $Page->setConfig('next','下一页');
        $Page->setConfig('prev','上一页');
        
        $page  = $Page->show();// 分页显示输出    
        $limit=$Page->firstRow.','.$Page->listRows;
        
        $res=$this
                ->field('a.*,b.name as brand_name,d.id as category_id,d.name as category_name,GROUP_CONCAT(e.attrbute_id) as attrbute_id,GROUP_CONCAT(e.attrbute_value) as attrbute_value,GROUP_CONCAT(e.val) as val,GROUP_CONCAT(e.count) as count,GROUP_CONCAT(e.price) as prices,GROUP_CONCAT(f.name) as attrbute_name')
                ->alias('a')
                ->join('LEFT JOIN __BRAND__ as b on a.brand_id=b.id')
                ->join('LEFT JOIN __GOODS_CATEGORY__ as c on a.id=c.goods_id')
                ->join('LEFT JOIN __CATEGORY__ as d on c.category_id=d.id')
                ->join('LEFT JOIN __GOODS_ATTRBUTE__ as e on a.id=e.goods_id')
                ->join('LEFT JOIN __ATTRIBUTE__ as f on e.attrbute_id=f.id')
                ->group('e.goods_id')
                ->where($where)
                ->order($order)
                ->limit($limit)
                ->select();
        
        //缓存        
//        $res=S('res') ? S('res') : S('res',$res);
//        $page=S('$page') ? S('$page') : S('$page',$page);

        return array(
            'page'  =>  $page,
            'res'   =>  $res
        );
    }
    
    //通过id获取属性值
    public function get_attr($id=1){
       //[category_id]= array('eq',$id);
        
        return M('category_attribute')
                ->field('b.id,b.name,b.type,b.content')
                ->alias('a')
                ->join('LEFT JOIN __ATTRIBUTE__ as b on a.attribute_id=b.id')
                ->where( array('a.category_id'=>$id,'b.status'=>0) )
                ->group('a.attribute_id')    
                ->select();
    }
    

    //通过id获取属性值
    public function get_attrs($id=1){
       $map['a.category_id']= array('eq',$id);
       $map['b.status']= array('eq',0);
       $map['c.count']= array('gt',0);
       
        return M('category_attribute')
                ->field('b.id,b.name,b.type,b.content')
                ->alias('a')
                ->join('LEFT JOIN __ATTRIBUTE__ as b on a.attribute_id=b.id')
                ->where( $map )
                ->group('a.attribute_id')    
                ->select();
    }    
    
    //减库存
    public function reduce_stock(){
        
        //!empty($arr) || exit();

        //判断属性列表是否是数组***********************************************
        if(is_array( I('post.spec_item/a') )){
               //接受参数
               $price=I('post.price/a');   //价格
               $count=I('post.count/a');   //库存     
                       
                //获取商品属性
               $arr= self::info(I('post.spec_item/a'),$price,$count);

               //把字符串转为数组
               foreach ($arr as $key => $value) {
                   $attr[]=explode(",",$value);
               }

               //用户下单的数量 
               $num=I('post.num/a');

               //遍历赋值，并修改库存
                foreach ($attr as $key=>$value) {
                    $res['attrbute_id']='';
                    $res['attrbute_value']=$value[0].':'.$value[1];
                    //$res['price']=$value[2];
                    
                    //判断下单数量是否大于库存
                    if( $num[$key]>$value[3] ){
                       $this->error='&nbsp;商品&nbsp;<lable style="color:blue;font-weight:bold;">'.$res['attrbute_value'].'</lable>&nbsp;商品库存不足';
                       return false;
                       exit();
                    }else{
                        if($value[3]!==0 ){
                            $data['value']=$value[0].','.$value[1];
                            $res['count']=$value[3]-$num[$key]; //减去库存
                            //修改数据库的库存信息
                            $res && $result=M('goods_attrbute')->where( array('attrbute_value'=>$res['attrbute_value']) )->save($res);                         
                        }
                        
                        
                        //取出用户信息
                        if( session('user_type')=='admin' ){
                            $userinfo= M('admin')->where(array('id'=>session('uid')))->find();  
                        }else{
                            $userinfo= M('user')->alias('a')
                                ->join('LEFT JOIN __USERINFO__ as b on a.id=b.id')
                                ->where(array('a.id'=>session('uid')))->find(); 
                        }                     
                       
                        //取出商品信息
                        $goods_info=$this->where(array('goods_id'=>$result))->find();
                        
                        //判断库存是否修改成功
                        $data['goods_id']=$result;
                        $data['no']=$userinfo['no'];
                        $data['name']=$userinfo['username'];
                        $data['create_time']=time();
                        
                        $data['sn']=$goods_info['sn'];
                        $data['goods_name']=$goods_info['name'];
                        $data['price']=$goods_info['price'];
                        $result && M('record')->add($data);
                    }
    
                }
                
                return $result;

        }
        
    }
    
    // 删除之后执行
    protected function _after_delete($option){
        $id['goods_id']=$option['id'];
        //删除类型
        $id && M('goods_category')->where($id)->delete();
        //删除属性
        $id && M('goods_attrbute')->where($id)->delete($id);
    }    
    
}
