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

            <form action="/wms/index.php/Sell/item/id/1" method="post" class="main_form">
                
 <input type="hidden" name="id" value='<?php echo ($info["id"]); ?>' />
                <div class="text_info clearfix"><span>编号：</span></div>
                <div class="input_info">
                    <input type="text" class="width200" name='sn' value='<?php echo ($info["sn"]); ?>'/>
                    <span class="required">*</span>
                    <div class="validate_msg_medium">不能为空，且为20长度的字母、数字和汉字的组合</div>
                </div> 
                
                <div class="text_info clearfix"><span>商品名称：</span></div>
                <div class="input_info">
                    <input type="text" class="width200" name='name' value='<?php echo ($info["name"]); ?>'/>
                    <span class="required">*</span>
                    <div class="validate_msg_medium">不能为空，且为20长度的字母、数字和汉字的组合</div>
                </div> 
                
                    <div class="text_info clearfix"><span>商品品牌：</span></div>
                    <div class="input_info">
                        <select name="brand_id">
                            <!--品牌分类-->
                            <?php if(is_array($brand)): $i = 0; $__LIST__ = $brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" 
                            <?php if($info['brand_id']==$vo['id']){ echo 'selected'; } ?>        
                                ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            
                        </select>  
<!--                        <input type="button" value="增加" class="btn_add" onclick="location.href='<?php echo U('Brand/add');?>';" />-->
                    </div>                
                

                                    
                <div class="text_info clearfix"><span>商品类型：</span></div>
                <div class="input_info" id="as">
  
                        <select name="category_id" id="category_id" onchange="get_attr(this)" > 
<!--遍历类型-->                            
<?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" 
                              <?php if($info['category_id']==$vo['id']){ echo 'selected'; } ?>            
                            ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?> 
                        </select>  
                    <span class="required">
<!--<input type="button" value="增加" class="btn_add" onclick="location.href='<?php echo U('Category/add');?>';" />-->
                    </span>
                    <div class="validate_msg_tiny">至少选择一个类型</div>
                </div>   
                         


<div class="button_info clearfix">
    <?php echo W('Menu/goods');?> 
</div>


                <div class="button_info clearfix">
                    <input type="button" value="下单" class="btn_save" onclick="send()" />
                    <input type="button" value="取消" class="btn_save" />
                </div>
            </form>
        </div>
        <!--主要区域结束-->
     
        
        
<style type="text/css">
    .l-text{
        width: 80px;
    }
    .li_width label input{
        position: relative;
        top:10px;
    }
</style>
<script type="text/javascript">
    $(function(){
        //点击之后的图标
         $('.sell_off').addClass('sell_on').removeClass('sell_off');

    });  
    
</script>

<script type="text/javascript">
    function send(){
        layer.confirm('你确定真的要下单吗？', {icon: 3, title:'提示'}, function(index){
        if(index){    
        
    
                $.ajax({
                    url: '/wms/index.php/Sell/item/id/1',
                    type: 'post',
                    dataType:'json',
                    data: $(".main_form").serializeArray(),
                    success: function(data) {
    //                    console.log(data);
                        //判断是否添加成功！
                        if(data.status==0){
                            layer.msg(data.info,{icon: 5});
                        }else{
                            layer.msg(data.info,{icon: 6});

                            //延迟跳转
                            setTimeout(function () {
                                location.href = "<?php echo U('Sell/index');?>";
                            }, <?php echo C('AJAX_TIME');?>);

                        }

                    }
                });
                
                
        }  
          layer.close(index);
        });                 
            
    }
</script>

<script type="text/javascript">
 $(function(){
     $('#category_id').change();
 }); 
  
  
 function get_attr(obj){

    var isa=jQuery("#category_id  option:selected").val();
    
    $('.afters').remove();
    $('.div_contentlist').html(''); 
    
    $.get('/wms/index.php/Sell/get_attr/id/'+isa, function(data){
//              console.log(data);
        
        //第一层遍历      
        $.each( data, function(index, value)
          { 
            content = (value.content).split(",");
            //console.log(value.id);
     
            //下拉框
            var option='';
            $.each( content, function(k, v)
            { 
                 if( value.type=='select' ){
                    option+="<option value='"+v+"' >"+v+"</option>"
                 }
                
            });
            
            var checkedstrat='<ul class="Father_Title"><li>'+value.name+'</li></ul> <ul class="Father_Item'+index+'">';
            var checked_end='</ul><br/><br/><br/><br/>';                     
            var check='';
            $.each( content, function(k, v)
            { 
                 if( value.type=='checkbox' ){
//                      console.log(value.name);
                    check+=' <li class="li_width"><label><input id="Checkbox'+value.id+k+'" type="checkbox" class="chcBox_Width" value="'+v+'"  />'+v+'<span class="li_empty"  ></span></label></li> ';
                    
                 }
                
            });    
           
            
            
            //下拉框结束
        if( value.type == 'select' ){
            var str="<div class='text_info clearfix afters'><span>"+value.name+"：</span></div><div class='input_info afters'>  <select name='attrbute_id["+value.id+"]' class='get_contents_"+value.id+" ' >"+ option +"</select>  <span class='required'></span><div class='validate_msg_tiny'>至少选择一个</div></div>    ";
            $('#as').after(str);   
            attr('select');
        }else if(value.type == 'text'){
            var str="<div class='text_info clearfix afters'><span>"+value.name+"：</span></div><div class='input_info afters'>  <input type='text' name='attrbute_id["+value.id+"]' class='get_contents_"+value.id+" ' />  <span class='required'></span><div class='validate_msg_tiny'>至少选择一个类型</div></div>    ";
            $('#as').after(str);  
            attr('text');
        }else if(value.type == 'date'){
            var str="<div class='text_info clearfix afters'><span>"+value.name+"：</span></div><div class='input_info afters'>  <input type='date' name='attrbute_id["+value.id+"]' class='get_contents_"+value.id+" ' />  <span class='required'></span><div class='validate_msg_tiny'>请填写</div></div>    ";
            $('#as').after(str);     
            attr('date');
        }else if(value.type == 'checkbox'){
            var str=checkedstrat+check+checked_end;
            $('.div_contentlist').append(str);    
            attr('checkbox');
            
            $(".div_contentlist label").bind("change", function () {
                step.Creat_Table();
            });
            
            
     var step = {
        //SKU信息组合
        Creat_Table: function () {
            step.hebingFunction();
            var SKUObj = $(".Father_Title");
            //var skuCount = SKUObj.length;//
            var arrayTile = new Array();//标题组数
            var arrayInfor = new Array();//盛放每组选中的CheckBox值的对象
            var arrayColumn = new Array();//指定列，用来合并哪些列
            var bCheck = true;//是否全选
            var columnIndex = 0;
            $.each(SKUObj, function (i, item){
                arrayColumn.push(columnIndex);
                columnIndex++;
                arrayTile.push(SKUObj.find("li").eq(i).html().replace("：", ""));
                var itemName = "Father_Item" + i;
                //选中的CHeckBox取值
                var order = new Array();
                $("." + itemName + " input[type=checkbox]:checked").each(function (){
                    order.push($(this).val());
                });
                arrayInfor.push(order);
                if (order.join() == ""){
                    bCheck = false;
                }
                //var skuValue = SKUObj.find("li").eq(index).html();
            });
            //开始创建Table表
            if (bCheck == true) {
                var RowsCount = 0;
                $("#createTable").html("");
                var table = $("<table id=\"process\" border=\"1\" cellpadding=\"1\" cellspacing=\"0\" style=\"width:100%;padding:1px;\"></table>");
                table.appendTo($("#createTable"));
                var thead = $("<thead></thead>");
                thead.appendTo(table);
                var trHead = $("<tr></tr>");
                trHead.appendTo(thead);
                //创建表头
                $.each(arrayTile, function (index, item) {
                    var td = $("<th>" + item + "</th>");
                    td.appendTo(trHead);
                });
                var itemColumHead = $("<th  style=\"width:70px;\">价格</th><th style=\"width:70px;\">库存</th><th style=\"width:70px;\">数量</th> ");
                itemColumHead.appendTo(trHead);
                var tbody = $("<tbody></tbody>");
                tbody.appendTo(table);
                ////生成组合
                var zuheDate = step.doExchange(arrayInfor);
                if (zuheDate.length > 0) {
                    //创建行
                    $.each(zuheDate, function (index, item) {
                        var td_array = item.split(",");
                        var tr = $("<tr></tr>");
                        
                        tr.appendTo(tbody);
                        $.each(td_array, function (i, values) {
                            var td = $("<td>" + values + "</td>");
                            td.appendTo(tr);
//                            console.log( values );
                        });
                        
                        //把php字符串赋值给js,并js转为数组
                        var counts="<?php echo ($info["count"]); ?>";
                        counts = counts.split(',').sort();
                        
                        //把php字符串赋值给js,并js转为数组
                        var prices="<?php echo ($info["prices"]); ?>";
                        prices = prices.split(',').sort();
                        
                        //console.log(index);   
                        console.log(counts);   

                        //判断库存是否为空
                        if(counts[index]==0){
                            
                            var td1 = $("<td><input class=\"l-text\" type=\"text\" value=\" "+prices[index]+" \" readonly></td>" );
                            td1.appendTo(tr);
                            var td2 = $("<td> <input class=\"l-text\" type=\"text\" value=\" "+counts[index]+"\" readonly></td>");
                            td2.appendTo(tr);
                            
                            var td3 = $("<td> <input class=\"l-text\" type=\"text\" value=\"暂无\" disabled></td>");
                            td3.appendTo(tr);
                            
                        }else{
                            var td1 = $("<td> <input name=\"spec_item[]\" class=\"l-text\" type=\"hidden\" value=\""+item+" \" >  <input name=\"price[]\" class=\"l-text\" type=\"text\" value=\" "+prices[index]+" \" ></td>" );
                            td1.appendTo(tr);
                            var td2 = $("<td> <input name=\"count[]\" class=\"l-text\" type=\"text\" value=\" "+counts[index]+"\" readonly></td>");
                            td2.appendTo(tr);
                            var td3 = $("<td> <input name=\"num[]\" class=\"l-text\" type=\"number\" value=\"\"></td>");
                            td3.appendTo(tr);
                      }  

                    });
                }
                //结束创建Table表
                arrayColumn.pop();//删除数组中最后一项
                //合并单元格
                $(table).mergeCell({
                    // 目前只有cols这么一个配置项, 用数组表示列的索引,从0开始
                    cols: arrayColumn
                });
            } else{
                //未全选中,清除表格
                document.getElementById('createTable').innerHTML="";
            }
        },//合并行
        hebingFunction: function () {
            $.fn.mergeCell = function (options) {
                return this.each(function () {
                    var cols = options.cols;
                    for (var i = cols.length - 1; cols[i] != undefined; i--) {
                        // fixbug console调试
                        // console.debug(cols[i]);
                        mergeCell($(this), cols[i]);
                    }
                    dispose($(this));
                });
            };
            function mergeCell($table, colIndex) {
                $table.data('col-content', ''); // 存放单元格内容
                $table.data('col-rowspan', 1); // 存放计算的rowspan值 默认为1
                $table.data('col-td', $()); // 存放发现的第一个与前一行比较结果不同td(jQuery封装过的), 默认一个"空"的jquery对象
                $table.data('trNum', $('tbody tr', $table).length); // 要处理表格的总行数, 用于最后一行做特殊处理时进行判断之用
                // 进行"扫面"处理 关键是定位col-td, 和其对应的rowspan
                $('tbody tr', $table).each(function (index) {
                    // td:eq中的colIndex即列索引
                    var $td = $('td:eq(' + colIndex + ')', this);
                    // 取出单元格的当前内容
                    var currentContent = $td.html();
                    // 第一次时走此分支
                    if ($table.data('col-content') == '') {
                        $table.data('col-content', currentContent);
                        $table.data('col-td', $td);
                    } else {
                        // 上一行与当前行内容相同
                        if ($table.data('col-content') == currentContent) {
                            // 上一行与当前行内容相同则col-rowspan累加, 保存新值
                            var rowspan = $table.data('col-rowspan') + 1;
                            $table.data('col-rowspan', rowspan);
                            // 值得注意的是 如果用了$td.remove()就会对其他列的处理造成影响
                            $td.hide();
                            // 最后一行的情况比较特殊一点
                            // 比如最后2行 td中的内容是一样的, 那么到最后一行就应该把此时的col-td里保存的td设置rowspan
                            if (++index == $table.data('trNum'))
                                $table.data('col-td').attr('rowspan', $table.data('col-rowspan'));
                        } else { // 上一行与当前行内容不同
                            // col-rowspan默认为1, 如果统计出的col-rowspan没有变化, 不处理
                            if ($table.data('col-rowspan') != 1) {
                                $table.data('col-td').attr('rowspan', $table.data('col-rowspan'));
                            }
                            // 保存第一次出现不同内容的td, 和其内容, 重置col-rowspan
                            $table.data('col-td', $td);
                            $table.data('col-content', $td.html());
                            $table.data('col-rowspan', 1);
                        }
                    }
                });
            }
            // 同样是个private函数 清理内存之用
            function dispose($table) {
                $table.removeData();
            }
        },
        //组合数组
        doExchange: function (doubleArrays) {
            var len = doubleArrays.length;
            if (len >= 2) {
                var arr1 = doubleArrays[0];
                var arr2 = doubleArrays[1];
                var len1 = doubleArrays[0].length;
                var len2 = doubleArrays[1].length;
                var newlen = len1 * len2;
                var temp = new Array(newlen);
                var index = 0;
                for (var i = 0; i < len1; i++) {
                    for (var j = 0; j < len2; j++) {
                        temp[index] = arr1[i] + "," + arr2[j];
                        index++;
                    }
                }
                var newArray = new Array(len - 1);
                newArray[0] = temp;
                if (len > 2) {
                    var _count = 1;
                    for (var i = 2; i < len; i++) {
                        newArray[_count] = doubleArrays[i];
                        _count++;
                    }
                }
                //console.log(newArray);
                return step.doExchange(newArray);
            }
            else {
                return doubleArrays[0];
            }
        }
    }
    return step;           
            /*******************************************************************/
        }       

              


        });
        
    });     
//     layer.msg(isa);
 }
</script>



<?php  $attrbute_value=explode(":",$info['attrbute_value']); $attrbute_value=array_filter( array_unique( $attrbute_value )) ; $attrbute_id= array_values( array_filter( explode(",",$info['attrbute_id']) ) ); $attrbute_val= explode(",",$info['val']) ; $arr=array(); foreach($attrbute_value as $v){ $arr[]=explode(",",$v); } foreach($arr as $v){ foreach($v as $val){ $arrs.=$val.','; } } $attrbute_value=array_values( array_filter( explode(",",$arrs) ) ); echo "<script type='text/javascript'> function attr(obj){ if(obj=='checkbox'){  \r\n "; echo "\$(\"input\").each(function(){ \r\n"; foreach($attrbute_value as $k=>$v){ printf("  if( \$(this).val()=='%s' ) { $(this).prop(\"checked\",true); }  \r\n",trim($attrbute_value[$k]) ); } echo"}); \r\n"; echo " }else if(obj=='select'){   \r\n"; foreach($attrbute_id as $k=>$v){ printf(" \$(\".get_content_%u option[value='%s'] \").prop(\"selected\",true); \r\n",trim($v),trim($attrbute_val[$k]) ); } echo " }else{  \r\n "; foreach($attrbute_id as $k=>$v){ printf(" \$(\".get_contents_%u\").val(\"%s\"); \r\n",trim($v),trim($attrbute_val[$k]) ); } echo " } }</script>"; ?>
<script type="text/javascript">
    $(function(){
        
        setTimeout(function () {

            //设置保留选中的选择框
            $(".chcBox_Width:not(checked)").each(function(){ 
                if( $(this).prop('checked')) { 
                    //$(this).prop("checked",false); 
                }else{
                    $(this).parent().remove();
                }  
              
            });
            
            
        }, 500);
       
    });
</script>
<script type="text/javascript">
    $(function(){
        //延迟加载属性
        setTimeout(function () {
            $(".div_contentlist label").change();
        }, 200);
    });
</script>        


        <div id="footer">
            <p>[ 源自技昂，专注WMS，TMS，POD的解决方案 ]</p>
            <p>版权所有(C)苏州技昂信息技术有限公司 </p>
        </div>
    </body>
</html>