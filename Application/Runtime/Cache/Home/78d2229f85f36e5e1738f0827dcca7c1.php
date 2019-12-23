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
                
                <div class="text_info clearfix"><span>编号：</span></div>
                <div class="input_info">
                    <input type="text" class="width200" name='sn' value='<?php echo ($info["sn"]); ?>' disabled/>
                    <span class="required">*</span>
                    <div class="validate_msg_medium">不能为空，且为20长度的字母、数字和汉字的组合</div>
                </div> 
                
                <div class="text_info clearfix"><span>商品名称：</span></div>
                <div class="input_info">
                    <input type="text" class="width200" name='name' value='<?php echo ($info["name"]); ?>' disabled/>
                    <span class="required">*</span>
                    <div class="validate_msg_medium">不能为空，且为20长度的字母、数字和汉字的组合</div>
                </div> 
                
                    <div class="text_info clearfix"><span>所属门店：</span></div>
                    <div class="input_info">
                        <select name="store_id" disabled>
                            <!--分类-->
                            <?php if(is_array($store)): $i = 0; $__LIST__ = $store;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" 
                            <?php if($info['store_id']==$vo['id']){ echo 'selected'; } ?>        
                                
                                ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            
                        </select>  
<!--                        <input type="button" value="增加" class="btn_add" onclick="location.href='<?php echo U('Brand/add');?>';" />-->
                    </div>     
                    
                    
                <div class="text_info clearfix"><span>单价：</span></div>
                <div class="input_info">
                    <input type="text" class="width110" name='price' value='<?php echo ($info["price"]); ?>' disabled/>
                    <span class="required">元</span>
                    <div class="validate_msg_medium">不能为空，且为20长度的字母、数字和汉字的组合</div>
                </div>                 

                <div class="text_info clearfix"><span>库存：</span></div>
                <div class="input_info">
                    <input type="text" class="width110" name='stock' value="<?php echo array_sum( explode(',',$info['count']) ); ;?>" disabled/>
                    <span class="required">*</span>
                    <div class="validate_msg_medium">不能为空，且为20长度的字母、数字和汉字的组合</div>
                </div>   
                
                <div class="text_info clearfix"><span>购入时间：</span></div>
                <div class="input_info">
                    <input type="text" class="width130" name='stock' value="<?php echo date('Y-m-d H:i:s',$info['time']) ;?>" disabled/>
                    <span class="required">*</span>
                    <div class="validate_msg_medium">不能为空，且为20长度的字母、数字和汉字的组合</div>
                </div>                   
                
                <?php $arr=array_unique( explode(',', $info['attrbute_value'] ) ); $count=explode(',', $info['count'] ); ?>
                <div class="input_info">
                    <table id="datalist">
                        
                      <tr>  
                        <th>属性</th>
<?php if(is_array($arr)): $i = 0; $__LIST__ = $arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td><?php echo ($vo); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                      </tr>

                       
                      
                      <tr>  
                        <th>数量</th>  
<?php if(is_array($count)): $i = 0; $__LIST__ = $count;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td><?php echo ($vo); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                      </tr>                      
                      
                    </table>
                </div>    
   
                <div class="text_info clearfix"><span></span></div>
                
                    <div class="text_info clearfix"><span>商品品牌：</span></div>
                    <div class="input_info">
                        <select name="brand_id" disabled>
                            <!--品牌分类-->
                            <?php if(is_array($brand)): $i = 0; $__LIST__ = $brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" 
                            <?php if($info['brand_id']==$vo['id']){ echo 'selected'; } ?>        
                                ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            
                        </select>  
                    </div>                
                

                                    
                <div class="text_info clearfix"><span>商品类型：</span></div>
                <div class="input_info" id="as">
  
                        <select name="category_id" id="category_id" onchange="get_attr(this)" disabled> 
<!--遍历类型-->                            
<?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" 
                              <?php if($info['category_id']==$vo['id']){ echo 'selected'; } ?>            
                            ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?> 
                        </select>  
                    <span class="required">
                    </span>
                    <div class="validate_msg_tiny">至少选择一个类型</div>
                </div>     
                
        </div>
        <!--主要区域结束-->
   
        

<script type="text/javascript">
    $(function(){
        //点击之后的图标
        $('.buy_off').addClass('buy_on').removeClass('buy_off');
    });  
</script>



<script type="text/javascript">
 $(function(){
     $('#category_id').change();
     
 }); 
  
  
  
 function get_attr(obj){
    //判断选中的类型
    var isa=jQuery("#category_id  option:selected").val();
    var attrbute_id="<?php echo ($info["attrbute_id"]); ?>".split(",");
//    var attrbute_value="<?php echo ($info["attrbute_value"]); ?>".split(",");
    
    //删除原来的
    $('.afters').remove();

    $.get('/wms/index.php/Buy/get_attr/id/'+isa, function(data){
//              console.log(data);
        
        //第一层遍历      
        $.each( data, function(index, value)
          { 
            content = (value.content).split(",");
//            console.log(value.id);
     
            //下拉框
            var option='';
            $.each( content, function(k, v)
            { 
                v=$.trim(v);
 
                 if( value.type=='select' ){

                    option+="<option value='"+v+"' >"+v+"</option>"
                            
                 }
                
            });
            
            //下拉框结束
            if( value.type == 'select' ){
                var str="<div class='text_info clearfix afters'><span>"+value.name+"：</span></div><div class='input_info afters'>  <select name='attrbute_id["+value.id+"]' class='get_content_"+value.id+"' disabled>"+ option +"</select>  <span class='required'></span><div class='validate_msg_tiny'>至少选择一个</div></div>    ";
                $('#as').after(str);      
                attr('select');

            }else if(value.type == 'text'){
                var str="<div class='text_info clearfix afters'><span>"+value.name+"：</span></div><div class='input_info afters'>  <input type='text' class='get_contents_"+value.id+" '  name='attrbute_id["+value.id+"]'  disabled/>  <span class='required'></span><div class='validate_msg_tiny'>至少选择一个类型</div></div>    ";
                $('#as').after(str);
                attr('text');
            }else if(value.type == 'date'){
                var str="<div class='text_info clearfix afters'><span>"+value.name+"：</span></div><div class='input_info afters'>  <input type='date' class='get_contents_"+value.id+" ' name='attrbute_id["+value.id+"]'  disabled/>  <span class='required'></span><div class='validate_msg_tiny'>请填写</div></div>    ";
                $('#as').after(str);   
                attr('date');
            }       
            
        });
        

        
        
    });     
//     layer.msg(isa);
 }
 

</script>

<?php $attrbute_id= array_values( array_filter( explode(",",$info['attrbute_id']) ) ); $attrbute_value= explode(",",$info['val']) ; echo "<script type='text/javascript'> function attr(obj){ if(obj=='select'){  "; foreach($attrbute_id as $k=>$v){ printf(" \$(\".get_content_%u  option[value='%s'] \").prop(\"selected\",true); \r\n",trim($v),trim($attrbute_value[$k]) ); } echo " }else{ "; foreach($attrbute_id as $k=>$v){ printf(" \$(\".get_contents_%u\").val(\"%s\"); ",trim($v),trim($attrbute_value[$k]) ); } echo " } }</script>"; ?>

        


        <div id="footer">
            <p>[ 源自技昂，专注WMS，TMS，POD的解决方案 ]</p>
            <p>版权所有(C)苏州技昂信息技术有限公司 </p>
        </div>
    </body>
</html>