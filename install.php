<?php
/**
 * ============================================================================
 * WMS 仓库管理系统 - 安装程序
 * ============================================================================
 * 
 * 功能说明：
 * 1. 自动创建数据库并导入初始数据
 * 2. 自动配置数据库连接信息
 * 
 * 使用方式：
 * 在浏览器中访问此文件，填写数据库连接信息后点击安装
 * 
 * 安全提示：
 * - 安装完成后请立即删除此文件
 * ============================================================================
 */

// 定义项目常量
define('INSTALL_PATH', str_replace('\\', '/', __DIR__));
define('PUBLIC_PATH', INSTALL_PATH . '/Public');
define('APP_PATH', INSTALL_PATH . '/Application');
define('CONFIG_PATH', APP_PATH . '/Common/Conf');

// 防止重复安装的检查
if (file_exists(APP_PATH . '/install.lock')) {
    exit('<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>系统已安装 - WMS</title>
    <link type="text/css" rel="stylesheet" media="all" href="./Public/styles/global.css" />
    <link type="text/css" rel="stylesheet" media="all" href="./Public/styles/global_color.css" />
    <style>
        body.index { background-image: url(./Public/images/login_bg.jpg); background-size: cover; }
        .install_box { 
            width: 400px; 
            margin: 100px auto; 
            background: rgba(255,255,255,0.95); 
            border-radius: 6px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            padding: 30px;
            text-align: center;
        }
        .install_box h1 { color: #0063a0; margin-bottom: 15px; font-size: 20px; }
        .install_box p { color: #666; margin: 10px 0; line-height: 1.6; font-size: 13px; }
        .install_box .btn { 
            display: inline-block; 
            padding: 8px 25px; 
            background: #0063a0; 
            color: #fff; 
            text-decoration: none; 
            border-radius: 3px; 
            margin-top: 15px;
            font-size: 13px;
        }
        .install_box .btn:hover { background: #004d7a; }
    </style>
</head>
<body class="index">
    <div class="install_box">
        <h1>系统已安装</h1>
        <p>检测到系统已经安装完成</p>
        <p>如需重新安装，请先删除<br><strong>Application/install.lock</strong> 文件</p>
        <a href="./index.php" class="btn">立即访问系统</a>
    </div>
</body>
</html>');
}

// ==================== 处理安装表单提交 ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['host'])) {
    
    // 接收并清理表单数据
    $dbHost     = trim($_POST['host']);
    $dbUsername = trim($_POST['username']);
    $dbPassword = $_POST['password'];
    $dbName     = trim($_POST['db']);
    
    $errors = [];
    
    // -------------------- 1. 连接数据库 --------------------
    $mysqli = @new mysqli($dbHost, $dbUsername, $dbPassword);
    
    if ($mysqli->connect_errno) {
        $errors[] = '连接数据库失败：' . $mysqli->connect_error;
    } else {
        // -------------------- 2. 创建数据库 --------------------
        $createDbSql = "CREATE DATABASE IF NOT EXISTS `{$dbName}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
        if (!$mysqli->query($createDbSql)) {
            $errors[] = '创建数据库失败：' . $mysqli->error;
        } else {
            // 切换到新创建的数据库
            $mysqli->select_db($dbName);
            
            // -------------------- 3. 导入 SQL 文件 --------------------
            $sqlFilePath = INSTALL_PATH . '/wms.sql';
            if (!file_exists($sqlFilePath)) {
                $errors[] = 'SQL 文件不存在，请确保 wms.sql 文件存在于项目根目录';
            } else {
                // 设置执行时间不限制
                set_time_limit(0);
                
                $sqlContent = file_get_contents($sqlFilePath);
                
                // 移除 SQL 注释 (/* */ 和 -- )
                $sqlContent = preg_replace('/\/\*.*?\*\//s', '', $sqlContent);
                $sqlContent = preg_replace('/--[^\n]*\n/', "\n", $sqlContent);
                
                // 按分号分割 SQL 语句
                $sqlStatements = explode(';', $sqlContent);
                $errorCount = 0;
                $successCount = 0;
                
                foreach ($sqlStatements as $sql) {
                    $sql = trim($sql);
                    // 跳过空语句和特定的 SQL 命令
                    if (!empty($sql) && !preg_match('/^(SET|DROP\s+TABLE\s+IF\s+EXISTS)/i', $sql)) {
                        if ($mysqli->query($sql)) {
                            $successCount++;
                        } else {
                            // 忽略某些非致命错误
                            $errorMsg = $mysqli->error;
                            if (strpos($errorMsg, 'Duplicate') === false && 
                                strpos($errorMsg, 'already exists') === false) {
                                error_log('SQL Error: ' . $errorMsg . ' | SQL: ' . substr($sql, 0, 100));
                                $errorCount++;
                            }
                        }
                    }
                }
                
                // -------------------- 4. 配置数据库连接 --------------------
                $configFile = CONFIG_PATH . '/config.php';
                if (file_exists($configFile)) {
                    $configContent = file_get_contents($configFile);
                    
                    // 替换数据库配置
                    $configContent = preg_replace("/'DB_HOST'\s*=>\s*'.*?'/", "'DB_HOST'   => '{$dbHost}'", $configContent);
                    $configContent = preg_replace("/'DB_NAME'\s*=>\s*'.*?'/", "'DB_NAME'   => '{$dbName}'", $configContent);
                    $configContent = preg_replace("/'DB_USER'\s*=>\s*'.*?'/", "'DB_USER'   => '{$dbUsername}'", $configContent);
                    $configContent = preg_replace("/'DB_PWD'\s*=>\s*'.*?'/", "'DB_PWD'    => '{$dbPassword}'", $configContent);
                    
                    file_put_contents($configFile, $configContent);
                }
                
                // -------------------- 5. 创建安装锁定文件 --------------------
                file_put_contents(APP_PATH . '/install.lock', date('Y-m-d H:i:s'));
                
                // 关闭数据库连接
                $mysqli->close();
                
                // -------------------- 6. 显示安装成功页面 --------------------
                showSuccessPage();
                exit;
            }
        }
    }
    
    if (!empty($errors)) {
        $mysqli->close();
    }
}

/**
 * 显示安装成功页面
 */
function showSuccessPage() {
    echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>安装成功 - WMS 仓库管理系统</title>
    <link type="text/css" rel="stylesheet" media="all" href="./Public/styles/global.css" />
    <link type="text/css" rel="stylesheet" media="all" href="./Public/styles/global_color.css" />
    <style>
        body.index { 
            background-image: url(./Public/images/login_bg.jpg); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .success_box { 
            width: 400px; 
            margin: 80px auto; 
            background: rgba(255,255,255,0.98); 
            border-radius: 6px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
            padding: 35px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .success_box .icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            background: url(./Public/images/ok.png) no-repeat center;
            background-size: contain;
        }
        .success_box h1 { 
            color: #0063a0; 
            margin-bottom: 12px; 
            font-size: 22px;
            font-weight: bold;
        }
        .success_box p { 
            color: #666; 
            margin: 8px 0; 
            line-height: 1.6;
            font-size: 13px;
        }
        .success_box .info {
            background: #f0f7fc;
            border-left: 3px solid #0063a0;
            padding: 12px 15px;
            margin: 18px 0;
            text-align: left;
            border-radius: 0 3px 3px 0;
            font-size: 12px;
        }
        .success_box .info strong {
            color: #0063a0;
        }
        .success_box .btn { 
            display: inline-block; 
            padding: 10px 30px; 
            background: #0063a0; 
            color: #fff; 
            text-decoration: none; 
            border-radius: 3px; 
            margin-top: 15px;
            font-size: 14px;
            transition: all 0.2s;
        }
        .success_box .btn:hover { 
            background: #004d7a; 
        }
        .success_box .warning {
            color: #d9534f;
            margin-top: 18px;
            padding: 10px;
            background: #fff5f5;
            border-radius: 3px;
            font-size: 12px;
        }
        .success_box .warning::before {
            content: "⚠ ";
        }
    </style>
</head>
<body class="index">
    <div class="success_box">
        <div class="icon"></div>
        <h1>安装成功！</h1>
        <p>WMS 仓库管理系统已成功安装并配置完成</p>
        <div class="info">
            <p><strong>默认管理员账号：</strong>bool / bool</p>
            <p><strong>默认测试账号：</strong>admin / admin</p>
        </div>
        <a href="./index.php" class="btn">立即访问系统</a>
        <p class="warning">重要提示：请立即删除 install.php 文件以保障安全！</p>
    </div>
</body>
</html>';
}

// 如果有错误，显示错误信息
$errorHtml = '';
if (!empty($errors)) {
    $errorHtml = '<div class="error_msg"><ul>';
    foreach ($errors as $error) {
        $errorHtml .= '<li>' . htmlspecialchars($error) . '</li>';
        // 检测 MySQL 8.0+ 字符集错误
        if (strpos($error, 'charset unknown') !== false || strpos($error, 'utf8mb4') !== false) {
            $errorHtml .= '</ul><div style="margin-top:10px;padding:8px;background:#fff3cd;border:1px solid #ffeaa7;border-radius:3px;color:#856404;font-size:11px;">
                <strong>⚠ 兼容性提示：</strong>当前 MySQL 版本过高，本项目<strong>不支持 MySQL 8.0+</strong><br>
                请使用 <strong>MySQL 5.6</strong> 或 <strong>MySQL 5.7</strong> 版本
            </div>';
        }
    }
    $errorHtml .= '</ul></div>';
}

// 默认表单值
$defaultHost = isset($_POST['host']) ? htmlspecialchars($_POST['host']) : 'localhost';
$defaultUser = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : 'root';
$defaultDb   = isset($_POST['db']) ? htmlspecialchars($_POST['db']) : 'wms';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>系统安装 - WMS 仓库管理系统</title>
    <link type="text/css" rel="stylesheet" media="all" href="./Public/styles/global.css" />
    <link type="text/css" rel="stylesheet" media="all" href="./Public/styles/global_color.css" />
    <script src="./Public/js/jquery-1.9.1.min.js"></script>
    <style>
        /* 安装页面自定义样式 - 紧凑布局 */
        body.index { 
            background-image: url(./Public/images/login_bg.jpg); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .install_container {
            width: 480px;
            margin: 40px auto;
            background: rgba(255,255,255,0.98);
            border-radius: 6px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.3);
        }
        
        /* 头部 */
        .install_header {
            background: #0063a0;
            padding: 15px 20px;
            text-align: center;
            border-bottom: 2px solid #004d7a;
        }
        
        .install_header img {
            height: 36px;
            margin-bottom: 6px;
        }
        
        .install_header h1 {
            color: #fff;
            font-size: 18px;
            margin: 0;
            font-weight: bold;
        }
        
        .install_header p {
            color: rgba(255,255,255,0.8);
            margin: 4px 0 0;
            font-size: 12px;
        }
        
        /* 步骤指示器 */
        .steps {
            display: flex;
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }
        
        .step {
            flex: 1;
            padding: 10px;
            text-align: center;
            color: #999;
            font-size: 12px;
            position: relative;
        }
        
        .step.active {
            color: #0063a0;
            background: #fff;
            font-weight: bold;
        }
        
        .step.active::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background: #0063a0;
        }
        
        /* 表单区域 */
        .install_body {
            padding: 20px 25px;
        }
        
        .error_msg {
            background: #fff5f5;
            border: 1px solid #ffcaca;
            border-radius: 3px;
            padding: 10px 15px;
            margin-bottom: 15px;
        }
        
        .error_msg ul {
            margin: 0;
            padding-left: 18px;
            color: #d9534f;
            font-size: 12px;
        }
        
        .error_msg li {
            margin: 3px 0;
        }
        
        /* 表单样式 */
        .form_table {
            width: 100%;
        }
        
        .form_table td {
            padding: 6px 3px;
            vertical-align: middle;
        }
        
        .form_table .label {
            width: 100px;
            text-align: right;
            color: #333;
            font-weight: bold;
            font-size: 12px;
            white-space: nowrap;
        }
        
        .form_table .label .required {
            color: #d9534f;
            margin-right: 2px;
        }
        
        .form_table input[type="text"],
        .form_table input[type="password"] {
            width: 220px;
            height: 30px;
            line-height: 30px;
            padding: 0 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 12px;
            transition: all 0.2s;
        }
        
        .form_table input[type="text"]:focus,
        .form_table input[type="password"]:focus {
            border-color: #0063a0;
            box-shadow: 0 0 0 2px rgba(0,99,160,0.1);
            outline: none;
        }
        
        .form_table .hint {
            color: #999;
            font-size: 11px;
            margin-left: 6px;
        }
        
        /* 按钮 */
        .btn_install {
            width: 100%;
            height: 36px;
            background: #0063a0;
            color: #fff;
            border: none;
            border-radius: 3px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
        }
        
        .btn_install:hover {
            background: #004d7a;
        }
        
        .btn_install:disabled {
            background: #999;
            cursor: not-allowed;
        }
        
        /* 底部提示 */
        .install_footer {
            background: #f9f9f9;
            padding: 12px 20px;
            border-top: 1px solid #eee;
            text-align: center;
        }
        
        .install_footer p {
            margin: 3px 0;
            color: #666;
            font-size: 11px;
        }
        
        .install_footer .warning {
            color: #d9534f;
            font-weight: bold;
        }
        
        /* 输入框图标 */
        .input_wrapper {
            position: relative;
            display: inline-block;
        }
        
        .input_wrapper input {
            padding-left: 28px !important;
        }
        
        .input_icon {
            position: absolute;
            left: 8px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 12px;
        }
    </style>
</head>
<body class="index">
    <div class="install_container">
        <!-- 头部 -->
        <div class="install_header">
            <h1>WMS 仓库管理系统</h1>
            <p>请填写数据库连接信息以完成系统安装</p>
        </div>
        
        <!-- 步骤指示器 -->
        <div class="steps">
            <div class="step active">① 配置数据库</div>
            <div class="step">② 完成安装</div>
        </div>
        
        <!-- 表单主体 -->
        <div class="install_body">
            <?php echo $errorHtml; ?>
            
            <form method="post" action="" id="install_form">
                <table class="form_table">
                    <tr>
                        <td class="label"><span class="required">*</span>数据库主机：</td>
                        <td>
                            <div class="input_wrapper">
                                <span class="input_icon">🖥</span>
                                <input type="text" name="host" value="<?php echo $defaultHost; ?>" placeholder="localhost" required />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><span class="required">*</span>数据库账号：</td>
                        <td>
                            <div class="input_wrapper">
                                <span class="input_icon">👤</span>
                                <input type="text" name="username" value="<?php echo $defaultUser; ?>" placeholder="root" required />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">数据库密码：</td>
                        <td>
                            <div class="input_wrapper">
                                <span class="input_icon">🔒</span>
                                <input type="password" name="password" placeholder="密码（可为空）" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><span class="required">*</span>数据库名称：</td>
                        <td>
                            <div class="input_wrapper">
                                <span class="input_icon">🗄</span>
                                <input type="text" name="db" value="<?php echo $defaultDb; ?>" placeholder="wms" required />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn_install">开始安装</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        
        <!-- 底部提示 -->
        <div class="install_footer">
            <p>请确保 MySQL 服务已启动</p>
            <p class="warning">安装完成后请删除 install.php</p>
        </div>
    </div>
    
    <script>
        // 表单验证
        $(function() {
            $('#install_form').on('submit', function() {
                var host = $('input[name="host"]').val().trim();
                var username = $('input[name="username"]').val().trim();
                var db = $('input[name="db"]').val().trim();
                
                if (!host) {
                    alert('请输入数据库主机地址');
                    $('input[name="host"]').focus();
                    return false;
                }
                if (!username) {
                    alert('请输入数据库账号');
                    $('input[name="username"]').focus();
                    return false;
                }
                if (!db) {
                    alert('请输入数据库名称');
                    $('input[name="db"]').focus();
                    return false;
                }
                
                // 禁用按钮防止重复提交
                $('.btn_install').prop('disabled', true).text('安装中，请稍候...');
                
                return true;
            });
        });
    </script>
</body>
</html>
