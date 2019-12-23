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
            <form action="/wms/index.php/Account/index.html" method="get" id="search">
                
                <!--查询-->
                <div class="search_add">                        
                    <div>员工编号：<input type="text" class="text_search width110" value="<?php echo I('get.no');?>" name='no'/></div>                            
                    <div>姓名：<input type="text" class="width70 text_search" value="<?php echo I('get.nickname');?>" name='nickname'/></div>
                    <div>账号：<input type="text" class="width70 text_search" value="<?php echo I('get.username');?>" name='username'/></div>
                    
                    <div>
                        状态：
                        <select class="select_search" name='status' id='status'>
                            <option value="">全部</option>
                            <option value="0" <?php if( I('status')=='0' ){echo 'selected';} ?>>正常</option>
                            <option value="1" <?php if( I('status')=='1' ){echo 'selected';} ?>>禁止</option>
                        </select>
                    </div>

                    <div>
                        职位：
                        <select class="select_search" name='position_name' id='position'>
                            <option value="">全部</option>
<?php if(is_array($position)): $i = 0; $__LIST__ = $position;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["name"]); ?>" <?php if( I('position_name')==$vo['name'] ){echo 'selected';} ?>
                            ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>  
                    
                    
                    <div>
                        <input type="button" value="搜索" class="btn_search" id="btn_search" onclick="search()"/>
                    </div>
                    
                    <input type="button" value="增加" class="btn_add" onclick="location.href='/wms/index.php/Account/add';" />
<!--第二行-->
<div style='margin:5px 0;'>

    <div>
                        门店：
                        <select class="select_search" name='store_name' >
                            <option value="">全部</option>
<?php if(is_array($store)): $i = 0; $__LIST__ = $store;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["name"]); ?>" <?php if( I('store_name')==$vo['name'] ){echo 'selected';} ?>
                            ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
    </div>                 
  
    <div>
                        排序：
                        <select class="select_search" name='order'>
                            <option value="a.id asc" <?php if( I('get.order')=='a.id asc' ){ echo 'selected';} ?> >  ↑ 默认 </option>                        
                            <option value="a.id desc" <?php if( I('get.order')=='a.id desc' ){ echo 'selected';} ?> > ↓ 主键从高到低 </option>
                            <option value="create_time asc" <?php if( I('get.order')=='create_time asc' ){ echo 'selected';} ?> >   ↑ 日期从低到高 </option>                        
                            <option value="create_time desc" <?php if( I('get.order')=='create_time desc' ){ echo 'selected';} ?> >  ↓ 日期从高到低 </option> 
                        </select>
    </div>    
    
</div>                    
 <!--第二行结束-->                   
                    
                </div>  
 
            </form>    

                
                <!--数据区域：用表格展示数据 表格列表-->     
                <div id="data">            
                    <table id="datalist">
                        
                    <tr>
                        <th>账号ID</th>
                        <th>姓名</th>
                        <th>员工编号</th>
                        <th>账号</th>
                        <th>状态</th>
                        <th>职位</th>  
                        <th>门店</th>  
                        <th>创建日期</th>
                        <th class="width200">操作</th>
                    </tr>
<!--开始遍历数据--> 
<?php if(is_array($res['res'])): $i = 0; $__LIST__ = $res['res'];if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                        <td><?php echo ($vo["id"]); ?></td>
                        <td><a href="/wms/index.php/Account/detail/id/<?php echo ($vo["id"]); ?>"><?php echo ($vo["nickname"]); ?></a></td>
                        <td><?php echo ($vo["no"]); ?></td>
                        <td><?php echo ($vo["username"]); ?></td>
                        <td>
                    <?php if($vo['status']==0){ echo '正常'; }else if($vo['status']==1){ echo '禁止'; }else if($vo['status']==2){ echo '删除'; } ?>
                        </td>

                        <td>
                            <a href="/wms/index.php/Account/index/position_name/<?php echo ($vo["position_name"]); ?>/"> <?php echo ($vo["position_name"]); ?> </a>
                        </td>   
                        <td><?php echo ($vo["store_name"]); ?></td>
                        <td><?php echo date('Y-m-d',$vo['create_time']);?></td>
                        <td class="td_modi">
<?php if($vo['status'] != 2): if($vo['status'] == 0): ?><input type="button" value="禁止"  class="btn_pause" onclick="set_status( '/wms/index.php/Account/status/id/<?php echo ($vo["id"]); ?>/status/1' );" />
<?php else: ?>
    <input type="button" value="正常"  class="btn_start" onclick="set_status( '/wms/index.php/Account/status/id/<?php echo ($vo["id"]); ?>/status/0' );" /><?php endif; ?>                                   
                                   
                            <input type="button" value="修改" class="btn_modify" onclick=" location.href='/wms/index.php/Account/edit/id/<?php echo ($vo["id"]); ?>'; " />
                            <input type="button" value="删除" class="btn_delete" onclick=" deletes( '/wms/index.php/Account/delete/id/<?php echo ($vo["id"]); ?>' ); " />
<?php else: endif; ?>                       
                        </td>
                    </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>   
<!--遍历结束-->                    
                  
                </table>
                <p>操作说明：<br />
                1、创建则开通，记载创建时间；<br />
                2、禁止后，则无法登陆；<br />
                3、重新开通后，则可以正常使用；<br />
                4、删除后，标示为删除，不能再开通、修改、删除；<br />
                </div> 
                
                <!--分页-->
                <div id="pages">
                    <?php echo ($res['page']); ?>
                </div>                    
            
        </div>
        <!--主要区域结束-->


<script type="text/javascript">
    function search(){
        layer.load(2); //加载
        setTimeout(function(){
            $('#search').submit();
        },<?php echo C('SEARCH_TIME');?>);
        
    }
    
    //状态
    $(function(){
        $('#status').change(function(){
            $('#search').submit();
        });
    });
    
    //职位
    $(function(){
        $('#position').change(function(){
            $('#search').submit();
        });
    });
        
     $(function(){
        $('select').change(function(){
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
    
    
    
    //禁止 开通
    function set_status(obj){
    
        layer.confirm('你确定真的要修改用户状态吗？', {icon: 0, title:'提示'}, function(index){
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
                                    location.href = "<?php echo U('Account/index');?>";
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
                    location.href = "<?php echo U('Account/index');?>";
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
         $('.emp_off').addClass('emp_on').removeClass('emp_off');
    });  
</script>        


        <div id="footer">
            <p>[ 源自技昂，专注WMS，TMS，POD的解决方案 ]</p>
            <p>版权所有(C)苏州技昂信息技术有限公司 </p>
        </div>
    </body>
</html>