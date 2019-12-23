<?php

function ajax(){
    IS_AJAX || die('无效的方式的提交方式');
}

//excel处理
function excel(){
    //引入核心 class  
    require_once('./Public/Classes/PHPExcel.php');  
    require_once('./Public/Classes/PHPExcel/Writer/Excel2007.php');  
    $objPHPExcel = new PHPExcel();   
    
    //Set properties 设置文件属性  
    //创建人
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
    //最后修改人
    $objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
    //标题
    $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
    //题目
    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
    //描述
    $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
    //关键字
    $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
    //种类
    $objPHPExcel->getProperties()->setCategory("Test result file"); 
    
    //设置当前的sheet
    $objPHPExcel->setActiveSheetIndex(0);
    //设置sheet的name
    $objPHPExcel->getActiveSheet()->setTitle('Simple');
    //设置单元格的值
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'String');
    $objPHPExcel->getActiveSheet()->setCellValue('A2', 12);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', true);
    $objPHPExcel->getActiveSheet()->setCellValue('C5', '=SUM(C2:C4)');
    $objPHPExcel->getActiveSheet()->setCellValue('B8', '=MIN(B2:C5)');    
    
    //在默认sheet后，创建一个worksheet
    echo date('H:i:s') . " Create new Worksheet object\n";
    $objPHPExcel->createSheet();
    $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
    $objWriter-save('php://output');    
}

//验证码校验
function check_verify($code, $id = ''){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

//验证权限 并跳转
function jumps($infos,$name){
    if( !strstr( $infos,$name )  &&  !strstr( $infos,'---' ) ){
//        dump(strstr( $infos,$name ) );
//        dump(strstr( $infos,'---' ));
//        die;
        $url= 'http://'.$_SERVER['HTTP_HOST'].PHP_FILE.'/Public/nopower';
        echo "<script language='javascript' type='text/javascript'>";  
        echo "location.href='".$url."'";  
        echo "</script>";          
        exit;
    }    
}