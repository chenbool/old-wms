<?php
namespace Home\Model;
use Think\Model;

class AdminModel extends Model {
    
    // 新增数据的时候允许写入name和email字段
    protected $insertFields = 'nickname,username,password,tel,email,role_id,code';
    // 编辑数据的时候只允许写入email字段    
    protected $updateFields = 'nickname,username,password,tel,email,role_id'; 
    
    //验证规则
    // 第四个参数： 0：存在字段就验证（默认） 1：必须验证 2：值不为空的时候验证    
    // 第六个参数： 规则什么时候生效： 1：添加时生效 2：修改时生效 3：所有情况都生效
    protected $_validate = array(
        array('nickname','require','姓名不能为空',1),
        array('username','require','账号不能为空',1),
        array('password','require','密码不能为空',1),
        array('tel','require','手机号码不能为空',1),
        array('email','require','邮箱不能为空',1),
        array('username', '1,20', '账号的值最长不能超过 20 个字符！', 1, 'length', 3),
        array('email','email','邮箱格式不正确',2),
    );    
    
    /*************登陆验证*******************************************************/
    
    // 为登录的表单定义一个验证规则 
    public $_login_validate = array(
	array('username', 'require', '用户名不能为空！', 1),
	array('password', 'require', '密码不能为空！', 1),
	array('code', 'require', '验证码不能为空！', 1),
	array('code', 'check_verify', '验证码不正确！', 1, 'callback'),
    );    
    
    // 验证验证码是否正确
    function check_verify($code, $id = ''){
	$verify = new \Think\Verify();
	return $verify->check($code, $id);
    }  
    
    //登陆
    public function login(){
	// 从模型中获取用户名和密码
	$username = $this->username;
	$password = $this->password;
        
	// 先查询这个用户名是否存在
	$user = $this->where(array('username' => array('eq', $username),))->find();
        if($user){
			if($user['password'] == md5($password)){
                            //保存到session
                            session('uid',$user['id']);
                            session('user_type','admin');
                            return TRUE;
			}else{
                            $this->error = '密码不正确！';
                            return FALSE;
			}
        }else {
			$this->error = '用户名不存在！';
			return FALSE;
        }
    }    
    
    //插入之前*******************************************************************
    protected function _before_insert(&$data, $option){
        $data['create_time']=  time();
        $data['password']=  md5( I('post.password') );
        $data['status']=0;
    }
    
    
    //插入之后
    protected function _after_insert($data, $option){
        $res=I('post.');    //接受的数据
        $res['admin_id']=$data['id'];   //管理员id
        $role_id=I('post.role_id/a');   //角色id
        
        if( is_array($role_id ) ){
            //遍历插入
            foreach ($role_id as $v) {
                $res['role_id']=$v; 
                M('admin_role')->add($res);
            }            
        }

        
    }    
    
    
    //更新之前
    protected function _before_update(&$data, $option){

        //判断是否修改密码
        if( $data['password'] ){
            $data['password'] = md5($data['password']);
        }  else {
            unset($data['password']);
        }
        
        
    }        
    
    //更新之后
    protected function _after_update($data, $option){
        $id=$data['id'];
        $res['admin_id']=$id;   //用户id
        $role_id=I('post.role_id/a');
        
        if( is_array($role_id ) ){
            //先删除
            M('admin_role')->where($res)->delete();
            
            //遍历插入
            foreach ($role_id as $v) {
                $res['role_id']=$v; 
                M('admin_role')->add($res);
            }            
        }
        
    }    
    
    
    //实现 搜索 分页 
    public function search(){
        $where=array();
        
        //接受搜索的关键字 
        I('get.nickname') && $where['nickname']=array( 'like','%'.I('get.nickname').'%' )  ;
        I('get.username') && $where['username']=array( 'eq',I('get.username'))  ;
        I('get.role_name') && $where['role_name']=array( 'like','%'.I('get.role_name').'%' )  ;
        I('get.tel') && $where['tel']=array( 'like','%'.I('get.tel').'%' )  ;
        I('get.email') && $where['email']=array( 'like','%'.I('get.email').'%' )  ;
        
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
        
        //查询之后的结果
        $res=$this->field('a.*,GROUP_CONCAT(c.role_name) as role_name')
                ->alias('a')
                ->group('b.admin_id')
                ->join('LEFT JOIN __ADMIN_ROLE__ as b on a.id=b.admin_id')
                ->join('LEFT JOIN __ROLE__ as c on c.id=b.role_id')
//                ->join('LEFT JOIN __ROLE_PRIVILEGE__ as d on c.id=d.role_id')
//                ->join('LEFT JOIN __PRIVILEGE__ as e on d.privliege_id=e.id')
                ->where($where)
                ->order('a.id asc')
                ->limit($limit)
                ->select();

        return array(
            'page'  =>  $page,
            'res'   =>  $res
        );
    }
    
    
    // 删除之后
    protected function _after_delete($option){
        $id=$option['id'];
        $map['admin_id']=$id;
        $id && M('admin_role')->where($map)->delete();
    }        

    
}
