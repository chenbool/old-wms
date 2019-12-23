<?php
namespace Home\Model;
use Think\Model;

class PrivilegeModel extends Model {
    
    // 新增数据的时候允许写入name和email字段
    protected $insertFields = 'name,parent_id,controller,module,action';
    // 编辑数据的时候只允许写入email字段    
    protected $updateFields = 'name,parent_id,controller,module,action,id';
    
    //验证规则
    // 第四个参数： 0：存在字段就验证（默认） 1：必须验证 2：值不为空的时候验证    
    // 第六个参数： 规则什么时候生效： 1：添加时生效 2：修改时生效 3：所有情况都生效
    protected $_validate = array(
        array('name','require','角色名称不能为空',1),
        array('controller','require','控制器不能为空',1),
        array('module','require','模块不能为空',1,'',1),
        array('name', '', '角色名称已经存在！', 1, 'unique', 1),
        array('name', '1,20', '用户名的值最长不能超过 20 个字符！', 1, 'length', 3),
    );    
    
    //插入之前
    protected function _before_insert(&$data, $option){
  
       //判断方法是否选择了多个 
       if( is_array( $data['action'] ) ) {
           $data['action']=implode(',', $data['action']);
       }
        
    }
    
    
    //插入之后
    protected function _after_insert($data, $option){

    }
    
    
    //更新之前
    protected function _before_update(&$data, $option){
        
       //判断方法是否选择了多个,把数组拆分为字符串
       if( is_array( $data['action'] ) ) {
           $data['action']=implode(',', $data['action']);
       }
       
    }    
    
    
    //实现 分页 
    public function privilege(){
        $where=array();
        
        //编辑信息页面获取到的id
        I('get.id') &&  $where=array('id' =>array('eq',I('get.id/d') ) );
        
        $count = $this->where($where)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数

        //设置
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');    
        $Page->setConfig('next','下一页');
        $Page->setConfig('prev','上一页');
        
        $page  = $Page->show();// 分页显示输出    
        $limit=$Page->firstRow.','.$Page->listRows;
        
        $res=$this->where($where)
                ->order('id asc')
                ->limit($limit)
                ->select();

        return array(
            'page'  =>  $page,
            'res'   =>  $res
        );
    }
    

	// 删除之前
	protected function _before_delete($option)
	{
		if($option['where']['id'] == 1){
                    
                    $this->error = '超级管理员无法删除！';
                    return FALSE;
		}

	}       

    // 删除之后
	protected function _after_delete($option){
            $id=$option['id'];
        }    
    
    
}
