<?php
namespace Home\Model;
use Think\Model;

class UserModel extends Model {
    
    // 新增数据的时候允许写入name和email字段
    protected $insertFields = 'nickname,no,username,password,confirm_password,tel,position,sex,address,post,qq,store_id,code';
    // 编辑数据的时候只允许写入email字段    
    protected $updateFields = 'nickname,no,username,password,confirm_password,tel,position,sex,address,post,qq,store_id'; 
    
    //验证规则
    // 第四个参数： 0：存在字段就验证（默认） 1：必须验证 2：值不为空的时候验证    
    // 第六个参数： 规则什么时候生效： 1：添加时生效 2：修改时生效 3：所有情况都生效
    protected $_validate = array(
        array('nickname','require','昵称不能为空',1),
        array('username','require','用户名不能为空',1),
        array('password','require','密码不能为空',1,'',1),
        array('confirm_password', 'password', '两次密码输入不一致！', 2, 'confirm', 3),
        array('username', '', '用户名已经存在！', 1, 'unique', 1),
        array('username', '1,20', '用户名的值最长不能超过 20 个字符！', 1, 'length', 3),
        array('email','email','邮箱格式不正确',2),
    );    
    
    //插入之前
    protected function _before_insert(&$data, $option){
        $data['create_time']=  time();
        $data['password']=  md5( I('post.password') );
        $data['status']=0;
    }
    
    //插入之后
    protected function _after_insert($data, $option){
        $res=I('post.');
        $res['id']=$data['id'];
        $res && M('userinfo')->add($res);
    }
    
    //更新之前
    protected function _before_update(&$data, $option){
        $res=I('post.');
        
        //判断是否修改密码
        if( $data['password'] ){
            $data['password'] = md5($data['password']);
        }  else {
            unset($data['password']);
        }
        //id
        $map['id']=$option['where']['id'];
        $res && M('userinfo')->where($map)->save($res);
        
    }    
    
    //实现 搜索 分页 
    public function search(){
        $where=array();
        
        //接受搜索的关键字 
        I('get.no') && $where['no']=array( 'eq',I('get.no')) ;
        I('get.nickname') && $where['nickname']=array( 'like','%'.I('get.nickname').'%' )  ;
        I('get.username') && $where['username']=array( 'eq',I('get.username'))  ;
        I('get.status') && $where['a.status']=array( 'eq',I('get.status'))  ;
        I('get.position_name') && $where['c.name']=array( 'eq',I('get.position_name'))  ;
        I('get.store_name') && $where['d.name']=array( 'eq',I('get.store_name'))  ;
        
        //编辑信息页面获取到的id
        I('get.id') &&  $where=array('a.id' =>array('eq',I('get.id/d') ) );        
        
        //排序
        $order="a.id asc";    //默认从低到高
        I('get.order') &&  $order=I('get.order');

//        $count = $this->alias('a')->where($where)->count();// 查询满足要求的总记录数
        // 查询满足要求的总记录数
        $count=$this->field('a.*,b.*,c.id as position_id,c.name as position_name,d.name as store_name,d.id as store_id')
                ->alias('a')
                ->join('LEFT JOIN __USERINFO__ as b on a.id=b.id')
                ->join('LEFT JOIN __POSITION__ as c on b.position=c.id')
                ->join('LEFT JOIN __STORE__ as d on b.store_id=d.id')
                ->where($where)
                ->limit($limit)
                ->count();
        
        $Page  = new \Think\Page($count,7);// 实例化分页类 传入总记录数和每页显示的记录数

        //设置
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');    
        $Page->setConfig('next','下一页');
        $Page->setConfig('prev','上一页');
        
        $page  = $Page->show();// 分页显示输出    
        $limit=$Page->firstRow.','.$Page->listRows;
        
        $res=$this
                ->field('a.*,b.*,c.id as position_id,c.name as position_name,d.name as store_name,d.id as store_id')
                ->alias('a')
                ->join('LEFT JOIN __USERINFO__ as b on a.id=b.id')
                ->join('LEFT JOIN __POSITION__ as c on b.position=c.id')
                ->join('LEFT JOIN __STORE__ as d on b.store_id=d.id')
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
    
    
    // 删除之后
    protected function _after_delete($option){
        $id=$option['id'];
        $id && M('userinfo')->delete($id);
    }    
    

    /***************验证登陆*****************************************************/
    
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
                            session('user_type','user');
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
        
        
        
        
        
}
