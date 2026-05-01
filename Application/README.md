# 仓库管理系统（WMS）

基于 ThinkPHP 框架开发的企业级仓库管理系统（进销存），2016年老项目。

## 联系方式

- QQ：30024167
- QQ群：785794314
- Email：30024167@qq.com / sloan1993@163.com

## 技术栈

| 分类 | 技术 |
|------|------|
| 框架 | ThinkPHP |
| 数据库 | MySQL |
| 前端 | HTML + jQuery + Ajax |
| 缓存 | Memcache |
| 表格 | Bootstrap Table |

## 项目结构

```
old-wms/
├── Application/               # 应用目录
│   ├── Common/               # 公共模块
│   │   ├── Common/          # 公共函数
│   │   └── Conf/           # 配置文件
│   ├── Home/                # 前台模块
│   │   ├── Controller/     # 控制器
│   │   ├── Model/          # 模型
│   │   ├── View/           # 视图
│   │   └── Widget/         # 组件
│   └── Runtime/            # 运行时目录
├── Public/                    # 静态资源
│   └── Classes/            # 第三方类库
│       └── PHPExcel/       # Excel 处理
├── LICENSE                    # 许可证
└── README.md
```

## 功能模块

| 模块 | 说明 |
|------|------|
| 账户管理 | 账户信息维护 |
| 管理员 | 管理员账号管理 |
| 属性管理 | 商品属性配置 |
| 品牌管理 | 商品品牌管理 |
| 购货管理 | 采购订单管理 |
| 分类管理 | 商品分类管理 |
| 商品管理 | 商品信息管理 |
| 职位管理 | 职位管理 |
| 权限管理 | 权限节点管理 |
| 角色管理 | 角色权限管理 |
| 销售管理 | 销售订单管理 |
| 门店管理 | 门店信息管理 |
| 人员管理 | 员工信息管理 |
| 个人信息 | 个人信息维护 |

## 核心控制器

| 控制器 | 说明 |
|--------|------|
| `AccountController` | 账户管理 |
| `AdminController` | 管理员管理 |
| `AttributeController` | 属性管理 |
| `BrandController` | 品牌管理 |
| `BuyController` | 购货管理 |
| `CategoryController` | 分类管理 |
| `GoodsController` | 商品管理 |
| `IndexController` | 首页控制 |
| `LoginController` | 登录控制 |
| `PositionController` | 职位管理 |
| `PrivilegeController` | 权限管理 |
| `RoleController` | 角色管理 |
| `SellController` | 销售管理 |
| `StoreController` | 门店管理 |
| `UserController` | 人员管理 |

## 系统特点

- 基于 ThinkPHP 框架开发
- 页面静态化处理
- 使用 Memcache 缓存不常变更的数据
- 全面采用 Ajax 实现交互
- 包含表单验证、添加、搜索、提示等功能

## 快速开始

### 1. 环境要求

- PHP >= 5.3
- MySQL >= 5.5
- Apache/Nginx
- Memcache 扩展

### 2. 配置数据库

修改 `Application/Common/Conf/config.php` 中的数据库连接信息

### 3. 导入数据库

创建数据库并导入 SQL 文件

### 4. 访问系统

访问地址：`http://localhost/wms/`

### 测试账号

| 用户名 | 密码 |
|--------|------|
| bool | bool |
| admin | admin |

## 目录说明

| 目录 | 说明 |
|------|------|
| `Application/Common/` | 公共模块 |
| `Application/Home/` | 前台业务模块 |
| `Application/Runtime/` | 运行时文件（缓存、日志） |
| `Public/` | 静态资源文件 |

## 注意事项

- 本代码仅供学习，请勿用于商业用途
- 尊重原创，转载需注明出处

## 相关链接

- [ThinkPHP 官网](https://www.thinkphp.cn/)
- [ThinkPHP 代码仓库](https://www.thinkphp.cn/code/2220.html)
