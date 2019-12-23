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

        <script language="javascript" type="text/javascript">
            //显示角色详细信息
            function showDetail(flag, a) {
                var detailDiv = a.parentNode.getElementsByTagName("div")[0];
                if (flag) {
                    detailDiv.style.display = "block";
                }
                else
                    detailDiv.style.display = "none";
            }

            //删除
            function deleteAdmin() {
                var r = window.confirm("确定要删除此管理员吗？");
                document.getElementById("operate_result_info").style.display = "block";
            }
            //全选
            function selectAdmins(inputObj) {
                var inputArray = document.getElementById("datalist").getElementsByTagName("input");
                for (var i = 1; i < inputArray.length; i++) {
                    if (inputArray[i].type == "checkbox") {
                        inputArray[i].checked = inputObj.checked;
                    }
                }
            }
        </script>       
 
        <!--主要区域开始-->
        <div id="main">
            <form action="/wms/index.php/Admin/index.html" method="get" id="search">
                <!--查询-->
                <div class="search_add">
                    <div>
                        角色：
                        <select id="selModules" class="select_search" name='role_name'>
                            <option value=''>全部</option>
<!--遍历角色-->
<?php if(is_array($role)): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo["role_name"]); ?>'
<?php if(I('get.role_name') == $vo['role_name'] ): ?>selected
    <?php else: endif; ?>               
               ><?php echo ($vo["role_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>                            

                        </select>
                    </div>
                    
                    <div>手机：<input type="text" class="text_search width100" name='tel' value="<?php echo I('get.tel');?>"/></div>
                    
                    <div>姓名：<input type="text" class="text_search width70" name='nickname' value="<?php echo I('get.nickname');?>"/></div>
                    
                    <div>用户名：<input type="text" class="text_search width70" name='username' value="<?php echo I('get.username');?>"/></div>
                    <div>邮箱：<input type="text" class="text_search width80" name='email' value="<?php echo I('get.email');?>"/></div>
                    
                    <div><input type="button" value="搜索" class="btn_search" id="btn_search" onclick="search()"/></div>
                    
<!--                    <input type="button" value="密码重置" class="btn_add" onclick="resetPwd();" />-->
                    <input type="button" value="增加" class="btn_add" onclick="location.href='add.html';" />
                </div>
            </form>
            
            
                <!--数据区域：用表格展示数据-->     
                <div id="data">            
                    <table id="datalist">
                        <tr>
<!--                            <th class="th_select_all">
                                <input type="checkbox" onclick="selectAdmins(this);" />
                                <span>全选</span>
                            </th>-->
                            <th>管理员ID</th>
                            <th>姓名</th>
                            <th>登录名</th>
                            <th>电话</th>
                            <th>电子邮件</th>
                            <th>授权日期</th>
                            <th class="width100">拥有角色</th>
                            <th></th>
                        </tr>   
                        
                     
<?php if(is_array($res['res'])): $i = 0; $__LIST__ = $res['res'];if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
<!--                            <td><input type="checkbox" /></td>-->
                            <td><?php echo ($vo["id"]); ?></td>
                            <td><?php echo ($vo["nickname"]); ?></td>
                            <td><?php echo ($vo["username"]); ?></td>
                            <td><?php echo ($vo["tel"]); ?></td>
                            <td><?php echo ($vo["email"]); ?></td>
                            <td><?php echo date('Y-m-d',$vo['create_time']);?></td>
                            <td>
                                <a class="summary"  onmouseover="showDetail(true,this);" onmouseout="showDetail(false,this);">
                                    <?php echo mb_substr($vo['role_name'],0,4,'utf-8');?>...
                                </a>
                                
                                <!--浮动的详细信息-->
                                <div class="detail_info">
                                    <?php echo ($vo["role_name"]); ?>
                                </div>
                            </td>
                            <td class="td_modi">
                                <input type="button" value="修改" class="btn_modify" onclick=" location.href='/wms/index.php/Admin/edit/id/<?php echo ($vo["id"]); ?>' " />
                                <input type="button" value="删除" class="btn_delete" onclick="deletes('/wms/index.php/Admin/delete/id/<?php echo ($vo["id"]); ?>');" />
                            </td>
                        </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                        

                    </table>
                </div>
                
                <!--分页-->
                <div id="pages">
                    <?php echo ($res['page']); ?>
                </div>  
                
            
        </div>
        <!--主要区域结束-->

<script type="text/javascript">
    //搜索效果
    function search(){
        layer.load(2); //加载
        setTimeout(function(){
            $('#search').submit();
        },<?php echo C('SEARCH_TIME');?>);
        
    }
    
    //下拉框提交
    $(function(){
        $('#selModules').change(function(){
            $('#search').submit();
        });
    });

    //键盘事件    
    $(document).keydown(function(event){ 
        if(event.keyCode == 13){
//            alert(event.keyCode); 
            search();
        }            
                    
    });     

    
    //删除
    function deletes(obj){
      
    layer.confirm('你确定真的要删除此用户？', {icon: 3, title:'提示'}, function(index){
    if(index){    
        
        $.get(obj, function(data){
            
            //判断是否删除成功！
            if(data.status==0){
                layer.msg(data.info,{icon: 5});
            }else{
                layer.msg(data.info,{icon: 6});

                //延迟跳转
                setTimeout(function () {
                    location.href = "<?php echo U('Admin/index');?>";
                }, <?php echo C('AJAX_TIME');?>);

            }
            
        });
        
        
    }  
      layer.close(index);
    });    
        
    }    
    
</script> 

<style type="text/css">
    .empty{
        font-weight:bold;
    }
</style>
<script type="text/javascript">
    $(function(){
        //点击之后的图标
        $('.admin_off').addClass('admin_on').removeClass('admin_off');
    });  
</script>        


        <div id="footer">
            <p>[ 源自技昂，专注WMS，TMS，POD的解决方案 ]</p>
            <p>版权所有(C)苏州技昂信息技术有限公司 </p>
        </div>
    </body>
</html>