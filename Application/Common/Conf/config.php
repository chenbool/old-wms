<?php
return array(
	//'配置项'=>'配置值'
    'SHOW_PAGE_TRACE'=>1,    //显示调试信息

    //数据库配置信息
   'DB_TYPE'   => 'mysql', // 数据库类型
   'DB_HOST'   => 'localhost', // 服务器地址
   'DB_NAME'   => 'wms', // 数据库名
   'DB_USER'   => 'root', // 用户名
   'DB_PWD'    => '', // 密码
   'DB_PORT'   => 3306, // 端口
   'DB_PARAMS' =>  array(), // 数据库连接参数
   'DB_PREFIX' => 'wms_', // 数据库表前缀 
   'DB_CHARSET'=> 'utf8', // 字符集
   'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    
    //memcache配置
    // 'DATA_CACHE_TYPE' => 'Memcache',
    // 'MEMCACHED_HOST' => array('127.0.0.1','127.0.0.1'),
    // 'MEMCACHED_PORT' => array('11211','11212'),
    // 'DATA_CACHE_KEY'=>'think',
    // 'SESSION_EXPIRE' => 60*60, //Memcache的session信息有效时间
    // 'PERSISTENTID'=>'tp',//可选
    // 'MEMECACHED_WEIGHT' => array(33,67),//可选    
    
    
    
);
