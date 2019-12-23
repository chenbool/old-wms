<?php
namespace Home\Model;
use Think\Model;

class StoreModel extends Model {
    
    // 新增数据的时候允许写入name和email字段
    protected $insertFields = 'name,leader,tel,create_time,address,desc';
    // 编辑数据的时候只允许写入email字段    
    protected $updateFields = 'name,leader,tel,create_time,address,desc';
    
    //验证规则
    // 第四个参数： 0：存在字段就验证（默认） 1：必须验证 2：值不为空的时候验证    
    // 第六个参数： 规则什么时候生效： 1：添加时生效 2：修改时生效 3：所有情况都生效
    protected $_validate = array(
        array('name','require','门店名称不能为空',1),
        array('leader','require','管理者不能为空',1),
        array('tel','require','电话不能为空',1),
        array('create_time','require','时间不能为空',1),
        array('address','require','地址不能为空',1),
        array('name', '', '门店名称已经存在！', 1, 'unique', 1),
        array('name', '1,20', '门店名称最长不能超过 20 个字符！', 1, 'length', 3),
        array('desc', '1,100', '描述最长不能超过 100 个字符！', 1, 'length', 3),
    );    
    
    //插入之前
    protected function _before_insert(&$data, $option){
        
    }
    
    //插入之后
    protected function _after_insert($data, $option){
        $id=$data['id'];
        
    }
    
    //更新之后
    protected function _after_update($data, $option){
        $id=$data['id'];    //用户id
        
    }    
    
    //实现 分页 
    public function store(){
        $where=array();
        //编辑信息页面获取到的id
        I('get.id') &&  $where=array('a.id' =>array('eq',I('get.id/d') ) );

        
        $count = $this->alias('a')->where($where)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count,7);// 实例化分页类 传入总记录数和每页显示的记录数

        //设置
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');    
        $Page->setConfig('next','下一页');
        $Page->setConfig('prev','上一页');
        
        $page  = $Page->show();// 分页显示输出    
        $limit=$Page->firstRow.','.$Page->listRows;
        
        $res=$this
                ->alias('a')
                ->where($where)
                ->order('a.id asc')
                ->limit($limit)
                ->select();

        return array(
            'page'  =>  $page,
            'res'   =>  $res
        );
    }
    
    
    // 删除之前
    protected function _before_delete($option){
        
	$id=$option['where']['id'];
    }    
    
        
    // 删除之后
    protected function _after_delete($option){
        $id=$option['id'];
    }    
    
    
}
