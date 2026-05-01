<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>权限不足 - WMS-仓储管理系统</title>
    <link type="text/css" rel="stylesheet" media="all" href="/Public/styles/global.css" />
    <link type="text/css" rel="stylesheet" media="all" href="/Public/styles/global_color.css" />
    <style type="text/css">
        body {
            background: url('/Public/images/login_bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Tahoma, Geneva, sans-serif;
            font-size: 12px;
        }
        .jump_box {
            width: 500px;
            margin: 150px auto 0;
            background: #fff;
            border: 1px solid #ccc;
            padding: 30px;
            text-align: center;
        }
        .jump_box h1 {
            color: #f0ad4e;
            font-size: 48px;
            margin-bottom: 20px;
            font-weight: normal;
        }
        .jump_msg {
            color: #333;
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .jump_action {
            margin-bottom: 15px;
        }
        .jump_action a {
            color: #0063a0;
            text-decoration: underline;
            font-size: 12px;
        }
        .jump_action a:hover {
            color: #004d7a;
        }
        .jump_wait {
            color: #666;
            font-size: 12px;
        }
        .jump_wait span {
            color: #f0ad4e;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="jump_box">
        <h1>!</h1>
        <p class="jump_msg">您无权访问此页面</p>
        <p class="jump_action">
            <a href="<?php echo U('Index/index');?>">立即返回</a>
        </p>
        <p class="jump_wait">
            页面将在 <span id="wait">3</span> 秒后自动跳转
        </p>
    </div>
    <script type="text/javascript">
        (function(){
            var wait = document.getElementById('wait');
            var href = "<?php echo U('Index/index');?>";
            var interval = setInterval(function(){
                var time = --wait.innerHTML;
                if(time <= 0) {
                    location.href = href;
                    clearInterval(interval);
                }
            }, 1000);
        })();
    </script>
</body>
</html>