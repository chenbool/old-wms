<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>WMS-仓储管理系统</title>
        <link type="text/css" rel="stylesheet" media="all" href="/wms/Public/styles/global.css" />
        <link type="text/css" rel="stylesheet" media="all" href="/wms/Public/styles/global_color.css" /> 
        <script src="/wms/Public/js/jquery-1.9.1.min.js"></script>
        <script src="/wms/Public/layer/layer.js"></script>
        <script src="/wms/Public/js/user.js"></script>
    </head>
    <body>
        <!--Logo区域开始-->
        <div id="header">
            <img src="/wms/Public/images/logo.png" alt="logo" class="left"/>
            <span style="font-weight:bold;">Hi!</span>  
            <span style="color:white;font-weight:bold;"><?php echo ($infos["nickname"]); ?></span> 
            <a href="<?php echo U('Login/loginout');?>" >[退出]</a>            
        </div>
        <!--Logo区域结束-->
        
        <!--导航区域开始-->
        <div id="navi">                        
            <ul id="menu">
                <li><a href="<?php echo U('Index/index');?>" class="index_off"></a></li>
                <li><a href="<?php echo U('Role/index');?>" class="role_off"></a></li>
                <li><a href="<?php echo U('Admin/index');?>" class="admin_off"></a></li>
                <li><a href="<?php echo U('Store/index');?>" class="store_off"></a></li>
                <li><a href="<?php echo U('Account/index');?>" class="emp_off"></a></li>
                <li><a href="<?php echo U('Buy/index');?>" class="buy_off"></a></li>               
                <li><a href="<?php echo U('Sell/index');?>" class="sell_off"></a></li>
                <li><a href="<?php echo U('Goods/index');?>" class="warehouse_off"></a></li>
                <li><a href="<?php echo U('User/info');?>" class="information_off"></a></li>
                <li><a href="<?php echo U('User/pwd');?>" class="password_off"></a></li>
            </ul>            
        </div>
        <!--导航区域结束-->
 

<?php echo jumps($infos['authority'],CONTROLLER_NAME);?>

        <!--主要区域开始-->
        <div id="main">            

            <form action="/wms/index.php/Admin/edit/id/1" method="post" class="main_form">
                    <input type="hidden" name="id" value='<?php echo ($info["id"]); ?>'/>
                    <div class="text_info clearfix"><span>姓名：</span></div>
                    <div class="input_info">
                        <input type="text" value="<?php echo ($info['nickname']); ?>" name='nickname'/>
                        <span class="required">*</span>
                        <div class="validate_msg_long ">20长度以内的汉字、字母、数字的组合</div>
                    </div>
                    <div class="text_info clearfix"><span>账号：</span></div>
                    <div class="input_info"><input type="text" readonly="readonly" class="readonly" value="<?php echo ($info["username"]); ?>"  name='username'/></div>


                    <div class="text_info clearfix"><span>密码：</span></div>
                    <div class="input_info">
                        <input type="password" class="width200" value="<?php echo ($info["password"]); ?>" name='password'/>
                        <span class="required">*</span>
                        <div class="validate_msg_medium ">20长度以内的汉字、字母、数字的组合</div>
                    </div>
                    
                    <div class="text_info clearfix"><span>电话：</span></div>
                    <div class="input_info">
                        <input type="text" value="<?php echo ($info["tel"]); ?>"  name='tel'/>
                        <span class="required">*</span>
                        <div class="validate_msg_long ">正确的电话号码格式：手机或固话</div>
                    </div>
                    
                    <div class="text_info clearfix"><span>Email：</span></div>
                    <div class="input_info">
                        <input type="text" class="width200" value="<?php echo ($info["email"]); ?>" name='email'/>
                        <span class="required">*</span>
                        <div class="validate_msg_medium ">50长度以内，正确的 email 格式</div>
                    </div>
                    
                    <div class="text_info clearfix"><span>角色：</span></div>
                    <div class="input_info_high">
                        <div class="input_info_scroll">
                            <ul>
<!--遍历权限-->
<?php if(is_array($role)): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><input type="checkbox" value='<?php echo ($vo["id"]); ?>' name='role_id[]'
                        <?php if( strstr ($info['role_name'],$vo['role_name']) ){ echo 'checked'; } ?>          
                        /><?php echo ($vo["role_name"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>  
                            </ul>
                        </div>
                        <span class="required">*</span>
                        <div class="validate_msg_tiny ">至少选择一个</div>
                    </div>
                    <div class="button_info clearfix">
                        <input type="button" value="保存" class="btn_save" onclick="send()" />
                        <input type="button" value="取消" class="btn_save" />
                    </div>
                </form>  
        </div>
        <!--主要区域结束-->

<script type="text/javascript">
    $(function(){
        //点击之后的图标
        $('.admin_off').addClass('admin_on').removeClass('admin_off');
    });  
</script>

<script type="text/javascript">
function send(){

                $.ajax({
                    url: '/wms/index.php/Admin/edit/id/1',
                    type: 'post',
                    dataType:'json',
                    data: $(".main_form").serializeArray(),
                    success: function(data) {

                        //判断是否修改成功！
                        if(data.status==0){
                            layer.msg(data.info,{icon: 5});
                        }else{
                            layer.msg(data.info,{icon: 6});

                            //延迟跳转
                            setTimeout(function () {
                                location.href = "<?php echo U('Admin/index');?>";
                            }, <?php echo C('AJAX_TIME');?>);


                        }

                    }
                });

            
}
</script>        


        <div id="footer">
            <p>[ 源自技昂，专注WMS，TMS，POD的解决方案 ]</p>
            <p>版权所有(C)苏州技昂信息技术有限公司 </p>
        </div>
    </body>
</html>