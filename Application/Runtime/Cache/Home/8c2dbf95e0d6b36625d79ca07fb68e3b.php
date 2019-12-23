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
            //排序按钮的点击事件
            function sort(btnObj) {
                if (btnObj.className == "sort_desc")
                    btnObj.className = "sort_asc";
                else
                    btnObj.className = "sort_desc";
            }

        </script>        

        <!--主要区域开始-->
        <div id="main">
            <form action="" method="">
                <!--排序-->
                <div class="search_add">
                    <div>
<!--                        <input type="button" value="时间" class="sort_asc" onclick="sort(this);" />-->
<!--                        <input type="button" value="基费" class="sort_asc" onclick="sort(this);" />
                        <input type="button" value="时长" class="sort_asc" onclick="sort(this);" />-->
                    </div>
                    <input type="button" value="增加" class="btn_add" onclick="location.href='add';" />
                </div> 

                <!--数据区域：用表格展示数据-->     
                <div id="data">            
                    <table id="datalist">
                        <tr>
                            <th>ID</th>
                            <th class="width150">名称</th>
                            <th>管理者</th>
                            <th>电话</th>
                            <th>地址</th>
                            <th>创建时间</th>
                            <th class="width50">状态</th>
                            <th class="width200"></th>
                        </tr>  
                        
<?php if(is_array($res['res'])): $i = 0; $__LIST__ = $res['res'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo ($vo["id"]); ?></td>
                            <td><a href="/wms/index.php/Store/detail/id/<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></a></td>
                            <td><?php echo ($vo["leader"]); ?></td>
                            <td><?php echo ($vo["tel"]); ?></td>
                            <td><?php echo ($vo["address"]); ?></td>
                            <td><?php echo ($vo["create_time"]); ?></td>
                            <td>
<?php if($vo['status'] == 0 ): ?>正常
<?php else: ?>
   暂停<?php endif; ?> 
                            </td>
                            <td>  
<?php if($vo['status'] == 0 ): ?><input type="button" value="暂停"  class="btn_pause" onclick="set_status( '/wms/index.php/Store/status/id/<?php echo ($vo["id"]); ?>/status/1' );" />
<?php else: ?>
    <input type="button" value="启用"  class="btn_start" onclick="set_status( '/wms/index.php/Store/status/id/<?php echo ($vo["id"]); ?>/status/0' );" /><?php endif; ?>   
                                <input type="button" value="修改" class="btn_modify" onclick="location.href='/wms/index.php/Store/edit/id/<?php echo ($vo["id"]); ?>';" />
                                <input type="button" value="删除" class="btn_delete" onclick="deletes('/wms/index.php/Store/delete/id/<?php echo ($vo["id"]); ?>');" />
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?> 
                        
                    </table>
                    <p>业务说明：<br />
                    1、创建资费时，状态为暂停，记载创建时间；<br />
                    2、暂停状态下，可修改，可删除；<br />
                    3、开通后，记载开通时间，且开通后不能修改、不能再停用、也不能删除；<br />
                    4、业务账号修改资费时，在下月底统一触发，修改其关联的资费ID（此触发动作由程序处理）
                    </p>
                </div>
                <!--分页-->
                <div id="pages">
                    <?php echo ($res['page']); ?>   
                </div>
            </form>
        </div>
        <!--主要区域结束-->

<script type="text/javascript">
    $(function(){
        //点击之后的图标
        $('.store_off').addClass('store_on').removeClass('store_off');
    });  
</script>

<script type="text/javascript">
    //禁止 开通
    function set_status(obj){
    
        layer.confirm('你确定真的要修改用户状态吗？', {icon: 3, title:'提示'}, function(index){
        if(index){
        
                $.ajax({
                   type: "GET",
                   url: obj,
                   success: function(data){

                            //判断修改加成功！
                            if(data.status==0){
                                layer.msg(data.info,{icon: 5});
                            }else{
                                layer.msg(data.info,{icon: 6});

                                //延迟跳转
                                setTimeout(function () {
                                    location.href = "<?php echo U('Store/index');?>";
                                }, <?php echo C('AJAX_TIME');?>);

                            }

                   }
                });      
        
//        layer.msg(obj);

    }  
      layer.close(index);
    });

    }
    
    
    //删除
    function deletes(obj){
      
    layer.confirm('你确定真的要删除此分店？', {icon: 3, title:'提示'}, function(index){
    if(index){    
        
        $.get(obj, function(data){
            
            //判断是否删除成功！
            if(data.status==0){
                layer.msg(data.info,{icon: 5});
            }else{
                layer.msg(data.info,{icon: 6});

                //延迟跳转
                setTimeout(function () {
                    location.href = "<?php echo U('Store/index');?>";
                }, <?php echo C('AJAX_TIME');?>);

            }
            
        });
        
        
    }  
      layer.close(index);
    });    
        
    }
    
    
</script>        


        <div id="footer">
            <p>[ 源自技昂，专注WMS，TMS，POD的解决方案 ]</p>
            <p>版权所有(C)苏州技昂信息技术有限公司 </p>
        </div>
    </body>
</html>