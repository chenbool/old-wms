<?php
namespace Home\Model;
use Think\Model;

class RecordModel extends Model {
    
    // 新增数据的时候允许写入name和email字段
    protected $insertFields = 'nickname,username,password,tel,email,role_id';
    // 编辑数据的时候只允许写入email字段    
    protected $updateFields = 'nickname,username,password,tel,email,role_id'; 
    
    //验证规则
    // 第四个参数： 0：存在字段就验证（默认） 1：必须验证 2：值不为空的时候验证    
    // 第六个参数： 规则什么时候生效： 1：添加时生效 2：修改时生效 3：所有情况都生效
    protected $_validate = array(
        array('nickname','require','姓名不能为空',1),
    );    
    
    //插入之前
    protected function _before_insert(&$data, $option){
    }
    
    //插入之后
    protected function _after_insert($data, $option){
        
    }    

    //更新之前
    protected function _before_update(&$data, $option){
        
    }        
    
    //更新之后
    protected function _after_update($data, $option){
        
    }    
    
    
    //实现 搜索 分页 
    public function search(){
        $where=array();
        
        //接受搜索的关键字 
        I('get.name') && $where['a.name']=array( 'like','%'.I('get.name').'%' )  ;
        I('get.category') && $where['c.id']=array( 'eq',I('get.category'))  ;
        I('get.create_time') && $where['create_time']=array( 'gt',  strtotime( I('get.create_time') ) )  ;
        
        // 查询满足要求的总记录数
        $count = $this->alias('a')               
                ->join('LEFT JOIN __GOODS_CATEGORY__ as b on a.goods_id=b.goods_id')
                ->join('LEFT JOIN __CATEGORY__ as c on b.category_id=c.id')
                ->where($where)
                ->count();
        
        $Page  = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数

        //设置
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');    
        $Page->setConfig('next','下一页');
        $Page->setConfig('prev','上一页');
        
        $page  = $Page->show();// 分页显示输出    
        $limit=$Page->firstRow.','.$Page->listRows;
        
        //查询之后的结果
        $res=$this->alias('a')
                ->field('a.*,c.name as category_name')
                ->join('LEFT JOIN __GOODS_CATEGORY__ as b on a.goods_id=b.goods_id')
                ->join('LEFT JOIN __CATEGORY__ as c on b.category_id=c.id')
                ->where($where)
                ->order('create_time asc')
                ->limit($limit)
                ->select();

        return array(
            'page'  =>  $page,
            'res'   =>  $res
        );
    }
    
    
    // 删除之后
    protected function _after_delete($option){

    }        

    
}
