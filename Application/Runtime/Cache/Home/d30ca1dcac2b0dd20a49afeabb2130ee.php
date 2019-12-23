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
            function deleteRole() {
                var r = window.confirm("确定要删除此角色吗？");
                document.getElementById("operate_result_info").style.display = "block";
            }
        </script>

        
        <!--主要区域开始-->
        <div id="main">
            <form action="" method="">
                <!--查询-->
                <div class="search_add">
                    <input type="button" value="增加" class="btn_add" onclick="location.href='<?php echo U('Privilege/add');?>';" />
                </div>  
                
                
                <!--数据区域：用表格展示数据-->     
                <div id="data">                      
                    <table id="datalist">
                        <tr>                            
                            <th>权限 ID</th>
                            <th>权限名称</th>
                            <th>控制器</th>
                            <th>模块</th>
                            <th>方法</th>
                            <th class="td_modi"></th>
                        </tr>    
<!--遍历数据 start-->                                                    
<?php if(is_array($res['res'])): $k = 0; $__LIST__ = $res['res'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr>
                            <td><?php echo ($vo["id"]); ?></td>
                            <td><?php echo ($vo["name"]); ?></td>
                            <td><?php echo ($vo["controller"]); ?></td>
                            <td><?php echo ($vo["module"]); ?></td>
                            <td><?php echo ($vo["action"]); ?></td>
<?php if($vo['id'] == 1): ?><td> --- </td>
    <?php else: ?> 
                            <td>
                                <input type="button" value="修改" class="btn_modify" onclick="location.href='/wms/index.php/Privilege/edit/id/<?php echo ($vo["id"]); ?>';"/>
                                <input type="button" value="删除" class="btn_delete" onclick="deletes('/wms/index.php/Privilege/delete/id/<?php echo ($vo["id"]); ?>');" />
                            </td><?php endif; ?>

                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>    
<!--遍历数据 end-->

                    </table>
                </div> 
                <!--分页-->
                <div id="pages">
                       <?php echo ($res['page']); ?>
                </div>
            </form>
        </div>
        <!--主要区域结束-->
 
<script type="text/javascript">
//删除
function deletes(obj){
      
    layer.confirm('你确定真的要删除此权限？', {icon: 3, title:'提示'}, function(index){
        if(index){    

            $.get(obj, function(data){

                //判断是否删除成功！
                if(data.status==0){
                    layer.msg(data.info,{icon: 5});
                }else{
                    layer.msg(data.info,{icon: 6});

                    //延迟跳转
                    setTimeout(function () {
                        location.href = "<?php echo U('Privilege/index');?>";
                    }, <?php echo C('AJAX_TIME');?>);

                }

            });


        }  
      layer.close(index);
    });    
        
}            
</script>        
        
<script type="text/javascript">
    $(function(){
        //点击之后的图标
        $('.role_off').addClass('role_on').removeClass('role_off');
    });  
</script>
<style type="text/css">
    .empty{
        font-weight:bold;
    }
</style>
        


        <div id="footer">
            <p>[ 源自技昂，专注WMS，TMS，POD的解决方案 ]</p>
            <p>版权所有(C)苏州技昂信息技术有限公司 </p>
        </div>
    </body>
</html>