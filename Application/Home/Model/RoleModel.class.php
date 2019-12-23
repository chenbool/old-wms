<?php
namespace Home\Model;
use Think\Model;

class RoleModel extends Model {
    
    // 新增数据的时候允许写入name和email字段
    protected $insertFields = 'role_name,id,privliege_id,role_id';
    // 编辑数据的时候只允许写入email字段    
    protected $updateFields = 'role_name,id,privliege_id,role_id,name,parent_id,controller,module,action';
    
    //验证规则
    // 第四个参数： 0：存在字段就验证（默认） 1：必须验证 2：值不为空的时候验证    
    // 第六个参数： 规则什么时候生效： 1：添加时生效 2：修改时生效 3：所有情况都生效
    protected $_validate = array(
        array('role_name','require','角色名称不能为空',1),
        array('role_name', '', '角色名称已经存在！', 1, 'unique', 1),
        array('role_name', '1,20', '角色名称的值最长不能超过 20 个字符！', 1, 'length', 3),
    );    
    
    //插入之前
    protected function _before_insert(&$data, $option){
        
    }
    
    //插入之后
    protected function _after_insert($data, $option){
        $res['role_id']=$data['id'];
        
       if( is_array( I('post.privliege_id/a') )   ) {
           //遍历插入
           foreach (I('post.privliege_id/a') as $v) {
               $res['privliege_id']=$v;
               M('role_privilege')->add($res);
           }
       }
    }
    
    //更新之后
    protected function _after_update($data, $option){
        $id=$data['id'];    //用户id
        $res['role_id']=$id;
        
        
        //执行更新
        if( is_array( I('post.privliege_id/a') )   ) {
            
            //先删除原来的内容
            M('role_privilege')->where($res)->delete();
            
            //遍历插入
            foreach (I('post.privliege_id/a') as $v) {
               $res['privliege_id']=$v;
               M('role_privilege')->add($res);
            }
        }
        
    }    
    
    //实现 分页 
    public function role(){
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
                ->field('a.*,GROUP_CONCAT(c.name) as names')
                ->alias('a')
                ->join('LEFT JOIN __ROLE_PRIVILEGE__ as b on a.id=b.role_id')
                ->join('LEFT JOIN __PRIVILEGE__ as c on b.privliege_id=c.id')
                ->where($where)
                ->group('a.id')
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
        
	if($option['where']['id'] == 1){
                    
            $this->error = '超级管理员无法删除！';
            return FALSE;
	}

    }    
    
        
    // 删除之后
    protected function _after_delete($option){
        $id=$option['id'];
        $map['role_id']=$id;
        $id && M('role_privilege')->where($map)->delete();
    }    
    
    
}
