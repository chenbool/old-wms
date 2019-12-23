<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
 


<?php jumps($infos['authority'],CONTROLLER_NAME); ?>

        <script language="javascript" type="text/javascript">

            //显示选填的信息项
            function showOptionalInfo(imgObj) {
                var div = document.getElementById("optionalInfo");
                if (div.className == "hide") {
                    div.className = "show";
                    imgObj.src = "/wms/Public/images/hide.png";
                }
                else {
                    div.className = "hide";
                    imgObj.src = "/wms/Public/images/show.png";
                }
            }
        </script>

        
        <!--主要区域开始-->
        <div id="main">       
            
            <form action="/wms/index.php/Account/add" method="post" class="main_form" id="formTest">
                
                <!--必填项-->
                <div class="text_info clearfix"><span>姓名：</span></div>
                <div class="input_info">
                    <input type="text" value="" maxlength="20" name="nickname"/>
                    <span class="required">*</span>
                    <div class="validate_msg_long">20长度以内的汉字、字母和数字的组合</div>
                </div>
                
                <div class="text_info clearfix"><span>职员编号：</span></div>
                <div class="input_info">
                    <input type="text" value="" maxlength="25" name="no"/>
                    <span class="required">*</span>
                    <div class="validate_msg_long">正确的职员编号格式</div>
                </div>
                
                <div class="text_info clearfix"><span>所属门店：</span></div>
                    <div class="input_info">
                        <select name="store_id">
                            <?php if(is_array($store)): $i = 0; $__LIST__ = $store;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>  
                        
                        <input type="button" value="增加" class="btn_add" onclick="location.href='<?php echo U('Store/add');?>';" />
                        
                </div>                
                
                <div class="text_info clearfix"><span>登录账号：</span></div>
                <div class="input_info">
                    <input type="text" value=""  maxlength="30" name="username"/>
                    <span class="required">*</span>
                    <div class="validate_msg_long">16长度以内的字母、数字和下划线的组合</div>
                </div>
                <div class="text_info clearfix"><span>密码：</span></div>
                <div class="input_info">
                    <input type="password"  maxlength="30" name="password"/>
                    <span class="required">*</span>
                    <div class="validate_msg_long">16长度以内的字母、数字和下划线的组合</div>
                </div>
                
                <div class="text_info clearfix"><span>重复密码：</span></div>
                <div class="input_info">
                    <input type="password"  maxlength="30" name="confirm_password"/>
                    <span class="required">*</span>
                    <div class="validate_msg_long">两次密码必须相同</div>
                </div>               
                
                <!--可选项-->
                <div class="text_info clearfix"><span>可选项：</span></div>
                <div class="input_info">
                    <img src="/wms/Public/images/show.png" alt="展开" onclick="showOptionalInfo(this);" />
                </div>
                <div id="optionalInfo" class="hide">

                    <div class="text_info clearfix"><span>Email：</span></div>
                    <div class="input_info">
                        <input type="text" class="width350" name="email"/>
                        <div class="validate_msg_tiny">50长度以内，合法的 Email 格式</div>
                    </div> 
                    
                    <div class="text_info clearfix"><span>职业：</span></div>
                    <div class="input_info">
                        <select name="position">
                            <?php if(is_array($position)): $i = 0; $__LIST__ = $position;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>  
                        
                        <input type="button" value="增加" class="btn_add" onclick="location.href='<?php echo U('Position/add');?>';" />
                        
                    </div>
                    
                <div class="text_info clearfix"><span>电话：</span></div>
                <div class="input_info">
                    <input type="text" class="width200" maxlength="20" name="tel"/>
                    <span class="required">*</span>
                    <div class="validate_msg_medium">正确的电话号码格式：手机或固话</div>
                </div>                      
                    
                    
                    <div class="text_info clearfix"><span>性别：</span></div>
                    <div class="input_info fee_type">
                        <input type="radio" name="sex" id="male" value="男" checked="checked"/>
                        <label for="male">男</label>
                        <input type="radio" name="sex" id="female" value="女"/>
                        <label for="female">女</label>
                    </div> 
                    <div class="text_info clearfix"><span>通信地址：</span></div>
                    <div class="input_info">
                        <input type="text" class="width350" name="address"/>
                        <div class="validate_msg_tiny">50长度以内</div>
                    </div> 
                    <div class="text_info clearfix"><span>邮编：</span></div>
                    <div class="input_info">
                        <input type="text" name="post"/>
                        <div class="validate_msg_long">6位数字</div>
                    </div> 
                    <div class="text_info clearfix"><span>QQ：</span></div>
                    <div class="input_info">
                        <input type="text" name="qq"/>
                        <div class="validate_msg_long">5到11位数字</div>
                    </div>                
                </div>
                
                <!--操作按钮-->
                <div class="button_info clearfix">
                    <input type="button" value="保存" class="btn_save" onclick="send(this)" />
                    <input type="reset" value="取消" class="btn_save" />
                </div>
                
            </form>  
        </div>
        <!--主要区域结束-->
        

<script>

//ajax提交
function send(obj){

            $.ajax({
                url: '/wms/index.php/Account/add',
                type: 'post',
                dataType:'json',
                data: $("#formTest").serializeArray(),
                success: function(data) {
//                    console.log(data);
                    //判断是否添加成功！
                    if(data.status==0){
                        layer.msg(data.info,{icon: 5});
                    }else{
                        layer.msg(data.info,{icon: 6});
                        
                        //延迟跳转
                        setTimeout(function () {
                            location.href = "<?php echo U('Account/index');?>";
                        }, <?php echo C('AJAX_TIME');?>);
                        
                        
                    }
                    
                }
            });
            

}

</script>        
<script type="text/javascript">
    $(function(){
        //点击之后的图标
        $('.emp_off').addClass('emp_on').removeClass('emp_off');
    });  
</script>        


        <div id="footer">
            <p>[ 源自技昂，专注WMS，TMS，POD的解决方案 ]</p>
            <p>版权所有(C)苏州技昂信息技术有限公司 </p>
        </div>
    </body>
</html>