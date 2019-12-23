/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : wms

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-08-07 09:54:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `wms_access`
-- ----------------------------
DROP TABLE IF EXISTS `wms_access`;
CREATE TABLE `wms_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主id',
  `role_id` smallint(6) unsigned NOT NULL COMMENT '角色id',
  `node_id` smallint(6) unsigned NOT NULL COMMENT '节点id',
  `level` tinyint(1) NOT NULL COMMENT '级别',
  `pid` smallint(6) DEFAULT NULL COMMENT '父id',
  `module` varchar(50) DEFAULT NULL COMMENT '模块',
  PRIMARY KEY (`id`),
  KEY `idx_role_id` (`role_id`),
  KEY `idx_node_id` (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限分配';

-- ----------------------------
-- Records of wms_access
-- ----------------------------

-- ----------------------------
-- Table structure for `wms_ad`
-- ----------------------------
DROP TABLE IF EXISTS `wms_ad`;
CREATE TABLE `wms_ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主id',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '广告位名称',
  `mark` varchar(30) NOT NULL DEFAULT '' COMMENT '广告位标识',
  `platform` tinyint(1) NOT NULL DEFAULT '0' COMMENT '设备平台[见配置文件]',
  `ad_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=代码2=文字3=图片',
  `time_limit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1=永不过期2=时间限制',
  `start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `normal_content` text NOT NULL COMMENT '正常显示内容',
  `overdue_content` text NOT NULL COMMENT '过期显示内容',
  `status` tinyint(1) DEFAULT '1' COMMENT '1为可用 2为禁用',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=正常 2=删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_time_limit` (`time_limit`),
  KEY `idx_mark` (`mark`),
  KEY `idx_start_time` (`start_time`),
  KEY `idx_end_time` (`end_time`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告';

-- ----------------------------
-- Records of wms_ad
-- ----------------------------

-- ----------------------------
-- Table structure for `wms_admin`
-- ----------------------------
DROP TABLE IF EXISTS `wms_admin`;
CREATE TABLE `wms_admin` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `nickname` varchar(16) DEFAULT NULL COMMENT '昵称',
  `username` varchar(16) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `tel` varchar(15) DEFAULT NULL,
  `email` varchar(15) DEFAULT NULL,
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `nickname` (`nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of wms_admin
-- ----------------------------
INSERT INTO `wms_admin` VALUES ('1', '布尔', 'bool', 'c506ff134babdd6e68ab3e6350e95305', '18101565685', '30024167@qq.com', '1475662263');
INSERT INTO `wms_admin` VALUES ('32', 'test', 'test', '098f6bcd4621d373cade4e832627b4f6', '222000', '200@qq.com', '1461049869');
INSERT INTO `wms_admin` VALUES ('33', 'admin', 'admin', 'd9b1d7db4cd6e70935368a1efb10e377', '11', '111@qq.com', '1461204870');

-- ----------------------------
-- Table structure for `wms_admin_role`
-- ----------------------------
DROP TABLE IF EXISTS `wms_admin_role`;
CREATE TABLE `wms_admin_role` (
  `role_id` mediumint(12) unsigned NOT NULL COMMENT '角色id',
  `admin_id` mediumint(12) unsigned NOT NULL COMMENT '用户id',
  KEY `role_id` (`role_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wms_admin_role
-- ----------------------------
INSERT INTO `wms_admin_role` VALUES ('1', '33');
INSERT INTO `wms_admin_role` VALUES ('7', '33');
INSERT INTO `wms_admin_role` VALUES ('1', '1');
INSERT INTO `wms_admin_role` VALUES ('7', '32');
INSERT INTO `wms_admin_role` VALUES ('10', '32');

-- ----------------------------
-- Table structure for `wms_attribute`
-- ----------------------------
DROP TABLE IF EXISTS `wms_attribute`;
CREATE TABLE `wms_attribute` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `type` enum('range','number','radio','file','checkbox','button','week','time','date','password','text','email','url','month','tel','search','select','color') DEFAULT 'text',
  `content` varchar(200) DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wms_attribute
-- ----------------------------
INSERT INTO `wms_attribute` VALUES ('28', '号码', 'checkbox', '34,35,36,37,38,39,40,41,42,43,44,45,46', '鞋子号码', '1461557423', '0');
INSERT INTO `wms_attribute` VALUES ('29', '颜色', 'checkbox', '白色,黑色,蓝色,绿色,紫色,红色,天蓝色', '鞋子颜色', '1461557664', '0');
INSERT INTO `wms_attribute` VALUES ('31', '出厂日期', 'date', '', '出厂日期', '1461571851', '0');
INSERT INTO `wms_attribute` VALUES ('32', '号码', 'checkbox', 'XS,S,M,L,XL,XXL,XXXL', '衣服尺寸', '1461808173', '0');
INSERT INTO `wms_attribute` VALUES ('33', '颜色', 'checkbox', '白色,黑色,蓝色,绿色,紫色,红色,天蓝色', '衣服', '1461831605', '0');
INSERT INTO `wms_attribute` VALUES ('34', '季节', 'select', '春秋,夏季,冬季', '鞋子季节', '1461831862', '0');
INSERT INTO `wms_attribute` VALUES ('35', '材质', 'text', '', '鞋子的材质', '1461831994', '0');
INSERT INTO `wms_attribute` VALUES ('36', '款式', 'select', '商务,休闲,运动,韩版,英伦', '鞋子款式', '1461832335', '0');
INSERT INTO `wms_attribute` VALUES ('37', '适用对象', 'select', '儿童(6-18),青年(18-25周岁),中年(26-40),中老年(40-50),老年(50以上)', '鞋子适用对象', '1461832510', '1');
INSERT INTO `wms_attribute` VALUES ('38', '闭合方式', 'select', '系带,拉链', '鞋子闭合方式', '1461832716', '1');
INSERT INTO `wms_attribute` VALUES ('39', '鞋跟', 'select', '平底,中跟,高跟,内增高', '鞋子鞋跟样式', '1461832801', '0');

-- ----------------------------
-- Table structure for `wms_brand`
-- ----------------------------
DROP TABLE IF EXISTS `wms_brand`;
CREATE TABLE `wms_brand` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='品牌表';

-- ----------------------------
-- Records of wms_brand
-- ----------------------------
INSERT INTO `wms_brand` VALUES ('1', 'XTEP/特步', '1461312069');
INSERT INTO `wms_brand` VALUES ('2', '耐克NIKE', '1461312183');
INSERT INTO `wms_brand` VALUES ('3', 'ANTA/安踏', '1461312192');
INSERT INTO `wms_brand` VALUES ('4', '贵人鸟', '1461312200');
INSERT INTO `wms_brand` VALUES ('5', '李宁', '1461312246');
INSERT INTO `wms_brand` VALUES ('6', '乔丹', '1461312252');
INSERT INTO `wms_brand` VALUES ('7', 'erke/鸿星尔克', '1461312267');
INSERT INTO `wms_brand` VALUES ('8', '阿迪达斯', '1461312279');
INSERT INTO `wms_brand` VALUES ('9', '361°', '1461312279');

-- ----------------------------
-- Table structure for `wms_category`
-- ----------------------------
DROP TABLE IF EXISTS `wms_category`;
CREATE TABLE `wms_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='商品分类';

-- ----------------------------
-- Records of wms_category
-- ----------------------------
INSERT INTO `wms_category` VALUES ('1', '鞋子', '1461307800');
INSERT INTO `wms_category` VALUES ('2', '衣服', '1461307877');
INSERT INTO `wms_category` VALUES ('3', '袜子', '1461207877');
INSERT INTO `wms_category` VALUES ('4', '男鞋', '1461310483');
INSERT INTO `wms_category` VALUES ('5', '女鞋', '1461310492');
INSERT INTO `wms_category` VALUES ('6', '运动鞋', '1461310561');
INSERT INTO `wms_category` VALUES ('7', '休闲鞋', '1461310572');
INSERT INTO `wms_category` VALUES ('8', '帆布鞋', '1461310686');
INSERT INTO `wms_category` VALUES ('9', '皮鞋', '1461310759');

-- ----------------------------
-- Table structure for `wms_category_attribute`
-- ----------------------------
DROP TABLE IF EXISTS `wms_category_attribute`;
CREATE TABLE `wms_category_attribute` (
  `category_id` mediumint(12) unsigned NOT NULL COMMENT '鍟嗗搧id',
  `attribute_id` mediumint(12) unsigned NOT NULL COMMENT '灞炴€d'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wms_category_attribute
-- ----------------------------
INSERT INTO `wms_category_attribute` VALUES ('1', '28');
INSERT INTO `wms_category_attribute` VALUES ('1', '29');
INSERT INTO `wms_category_attribute` VALUES ('4', '30');
INSERT INTO `wms_category_attribute` VALUES ('1', '31');
INSERT INTO `wms_category_attribute` VALUES ('2', '32');
INSERT INTO `wms_category_attribute` VALUES ('2', '33');
INSERT INTO `wms_category_attribute` VALUES ('1', '34');
INSERT INTO `wms_category_attribute` VALUES ('1', '35');
INSERT INTO `wms_category_attribute` VALUES ('1', '36');
INSERT INTO `wms_category_attribute` VALUES ('1', '37');
INSERT INTO `wms_category_attribute` VALUES ('1', '38');
INSERT INTO `wms_category_attribute` VALUES ('1', '39');

-- ----------------------------
-- Table structure for `wms_config`
-- ----------------------------
DROP TABLE IF EXISTS `wms_config`;
CREATE TABLE `wms_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键递增',
  `field_name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名称',
  `field_value` varchar(150) NOT NULL DEFAULT '' COMMENT '字段内容',
  `field_desc` varchar(30) NOT NULL DEFAULT '' COMMENT '字段描述',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型',
  `atta_type` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1=有附件2=无',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_filed_name` (`field_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站配置';

-- ----------------------------
-- Records of wms_config
-- ----------------------------

-- ----------------------------
-- Table structure for `wms_depot`
-- ----------------------------
DROP TABLE IF EXISTS `wms_depot`;
CREATE TABLE `wms_depot` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(60) NOT NULL COMMENT '仓库名称',
  `time` int(11) unsigned NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='仓库表';

-- ----------------------------
-- Records of wms_depot
-- ----------------------------

-- ----------------------------
-- Table structure for `wms_depot_store`
-- ----------------------------
DROP TABLE IF EXISTS `wms_depot_store`;
CREATE TABLE `wms_depot_store` (
  `depot_id` mediumint(12) unsigned NOT NULL COMMENT '仓库id',
  `store_id` mediumint(12) unsigned NOT NULL COMMENT '门店id',
  KEY `depot_id` (`depot_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='仓库';

-- ----------------------------
-- Records of wms_depot_store
-- ----------------------------

-- ----------------------------
-- Table structure for `wms_goods`
-- ----------------------------
DROP TABLE IF EXISTS `wms_goods`;
CREATE TABLE `wms_goods` (
  `id` mediumint(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sn` varchar(60) NOT NULL COMMENT 'sn',
  `name` varchar(60) NOT NULL COMMENT '名称',
  `brand_id` mediumint(9) unsigned NOT NULL COMMENT '品牌id',
  `time` int(11) unsigned DEFAULT NULL COMMENT '时间',
  `price` decimal(10,2) DEFAULT NULL,
  `sum` mediumint(12) unsigned DEFAULT NULL,
  `total` decimal(12,2) unsigned DEFAULT NULL,
  `store_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sn` (`sn`) USING BTREE,
  KEY `brand_id` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wms_goods
-- ----------------------------
INSERT INTO `wms_goods` VALUES ('1', '001', '特步01', '3', '1461576497', '20.00', '190', '3800.00', '1');
INSERT INTO `wms_goods` VALUES ('2', '002', '特步02', '1', '1461576854', '60.00', '20', '1200.00', null);
INSERT INTO `wms_goods` VALUES ('3', '003', '衣服', '1', '1461810099', '99.00', '11', '1089.00', '3');
INSERT INTO `wms_goods` VALUES ('4', '004', '贵人鸟鞋子', '4', '1462258269', '120.00', '30', '3600.00', null);
INSERT INTO `wms_goods` VALUES ('6', '005', '特步衣服', '1', '1462258724', '80.00', '50', '4000.00', null);
INSERT INTO `wms_goods` VALUES ('7', '006', '李宁', '5', '1462335589', '30.00', '80', '2400.00', null);
INSERT INTO `wms_goods` VALUES ('8', '007', '贵人鸟衣服', '4', '1462335911', '20.00', '50', '1000.00', null);
INSERT INTO `wms_goods` VALUES ('9', '008', 'bool', '1', '1462351559', '50.00', '50', '2500.00', null);
INSERT INTO `wms_goods` VALUES ('10', '009', '111', '1', '1462353852', '20.00', '100', '2000.00', null);
INSERT INTO `wms_goods` VALUES ('11', '0010', 'slaon', '7', '1462354174', '60.00', '50', '3000.00', null);
INSERT INTO `wms_goods` VALUES ('12', '0011', '测试', '1', '1462409831', '100.00', '140', '14000.00', null);
INSERT INTO `wms_goods` VALUES ('13', '0012', 'is_test', '1', '1462412320', '100.00', '40', '4000.00', null);
INSERT INTO `wms_goods` VALUES ('14', '0013', 'is bool', '1', '1462412576', '150.00', '180', '27000.00', null);
INSERT INTO `wms_goods` VALUES ('15', '0014', '搜索', '1', '1462412825', '160.00', '50', '8000.00', null);
INSERT INTO `wms_goods` VALUES ('16', '0015', '测试数据', '1', '1462413110', '39.00', '77', '3003.00', '2');
INSERT INTO `wms_goods` VALUES ('17', '0016', 'Haley', '1', '1462424710', '30.00', '158', '4740.00', null);
INSERT INTO `wms_goods` VALUES ('18', '0071', '1111二个', '4', '1462516379', '30.00', '10', '300.00', '2');

-- ----------------------------
-- Table structure for `wms_goods_attrbute`
-- ----------------------------
DROP TABLE IF EXISTS `wms_goods_attrbute`;
CREATE TABLE `wms_goods_attrbute` (
  `goods_id` mediumint(9) unsigned DEFAULT NULL,
  `attrbute_id` mediumint(9) unsigned DEFAULT NULL,
  `attrbute_value` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) unsigned DEFAULT NULL,
  `count` mediumint(12) unsigned DEFAULT NULL,
  `val` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wms_goods_attrbute
-- ----------------------------
INSERT INTO `wms_goods_attrbute` VALUES ('11', '0', 'XS:白色 ', '60.00', '9', null);
INSERT INTO `wms_goods_attrbute` VALUES ('11', '0', 'M:白色 ', '60.00', '30', null);
INSERT INTO `wms_goods_attrbute` VALUES ('2', '39', null, null, null, '中跟');
INSERT INTO `wms_goods_attrbute` VALUES ('2', '36', null, null, null, '韩版');
INSERT INTO `wms_goods_attrbute` VALUES ('2', '35', null, null, null, '棉布');
INSERT INTO `wms_goods_attrbute` VALUES ('2', '34', null, null, null, '春秋');
INSERT INTO `wms_goods_attrbute` VALUES ('2', '31', null, null, null, '2016-05-02');
INSERT INTO `wms_goods_attrbute` VALUES ('2', '0', '40:白色 ', '60.00', '19', null);
INSERT INTO `wms_goods_attrbute` VALUES ('4', '0', '40:白色 ', '120.00', '19', null);
INSERT INTO `wms_goods_attrbute` VALUES ('4', '0', '40:蓝色 ', '120.00', '10', null);
INSERT INTO `wms_goods_attrbute` VALUES ('4', '39', null, null, null, '平底');
INSERT INTO `wms_goods_attrbute` VALUES ('4', '36', null, null, null, '商务');
INSERT INTO `wms_goods_attrbute` VALUES ('4', '35', null, null, null, '皮革');
INSERT INTO `wms_goods_attrbute` VALUES ('4', '34', null, null, null, '春秋');
INSERT INTO `wms_goods_attrbute` VALUES ('4', '31', null, null, null, '2016-05-05');
INSERT INTO `wms_goods_attrbute` VALUES ('6', '0', 'M:白色 ', '80.00', '30', null);
INSERT INTO `wms_goods_attrbute` VALUES ('6', '0', 'M:黑色 ', '60.00', '20', null);
INSERT INTO `wms_goods_attrbute` VALUES ('8', '0', 'M:蓝色 ', '20.00', '19', null);
INSERT INTO `wms_goods_attrbute` VALUES ('8', '0', 'L:蓝色 ', '30.00', '19', null);
INSERT INTO `wms_goods_attrbute` VALUES ('7', '0', '40:白色 ', '30.00', '19', null);
INSERT INTO `wms_goods_attrbute` VALUES ('7', '0', '41:白色 ', '30.00', '30', null);
INSERT INTO `wms_goods_attrbute` VALUES ('7', '0', '42:白色 ', '30.00', '38', null);
INSERT INTO `wms_goods_attrbute` VALUES ('7', '39', null, null, null, '平底');
INSERT INTO `wms_goods_attrbute` VALUES ('7', '36', null, null, null, '商务');
INSERT INTO `wms_goods_attrbute` VALUES ('7', '35', null, null, null, '皮革');
INSERT INTO `wms_goods_attrbute` VALUES ('7', '34', null, null, null, '夏季');
INSERT INTO `wms_goods_attrbute` VALUES ('7', '31', null, null, null, '2016-05-03');
INSERT INTO `wms_goods_attrbute` VALUES ('15', '0', '40:白色 ', '160.00', '19', null);
INSERT INTO `wms_goods_attrbute` VALUES ('15', '0', '41:白色 ', '160.00', '30', null);
INSERT INTO `wms_goods_attrbute` VALUES ('15', '39', null, null, null, '平底');
INSERT INTO `wms_goods_attrbute` VALUES ('15', '36', null, null, null, '商务');
INSERT INTO `wms_goods_attrbute` VALUES ('15', '35', null, null, null, '漆皮PU');
INSERT INTO `wms_goods_attrbute` VALUES ('15', '34', null, null, null, '春秋');
INSERT INTO `wms_goods_attrbute` VALUES ('15', '31', null, null, null, '2016-05-06');
INSERT INTO `wms_goods_attrbute` VALUES ('14', '0', '34:白色 ', '34.00', '20', null);
INSERT INTO `wms_goods_attrbute` VALUES ('14', '0', '34:黑色 ', '34.00', '30', null);
INSERT INTO `wms_goods_attrbute` VALUES ('14', '0', '34:蓝色 ', '34.00', '34', null);
INSERT INTO `wms_goods_attrbute` VALUES ('14', '0', '35:白色 ', '35.00', '40', null);
INSERT INTO `wms_goods_attrbute` VALUES ('14', '0', '35:黑色 ', '35.00', '48', null);
INSERT INTO `wms_goods_attrbute` VALUES ('14', '0', '35:蓝色 ', '35.00', '35', null);
INSERT INTO `wms_goods_attrbute` VALUES ('14', '0', '36:白色 ', '36.00', '36', null);
INSERT INTO `wms_goods_attrbute` VALUES ('14', '0', '36:黑色 ', '36.00', '36', null);
INSERT INTO `wms_goods_attrbute` VALUES ('14', '0', '36:蓝色 ', '36.00', '36', null);
INSERT INTO `wms_goods_attrbute` VALUES ('14', '39', null, null, null, '平底');
INSERT INTO `wms_goods_attrbute` VALUES ('14', '36', null, null, null, '商务');
INSERT INTO `wms_goods_attrbute` VALUES ('14', '35', null, null, null, 'PU');
INSERT INTO `wms_goods_attrbute` VALUES ('14', '34', null, null, null, '春秋');
INSERT INTO `wms_goods_attrbute` VALUES ('14', '31', null, null, null, '2016-05-05');
INSERT INTO `wms_goods_attrbute` VALUES ('13', '0', '34:白色 ', '100.00', '20', null);
INSERT INTO `wms_goods_attrbute` VALUES ('13', '0', '34:黑色 ', '100.00', '30', null);
INSERT INTO `wms_goods_attrbute` VALUES ('13', '39', null, null, null, '平底');
INSERT INTO `wms_goods_attrbute` VALUES ('13', '36', null, null, null, '商务');
INSERT INTO `wms_goods_attrbute` VALUES ('13', '35', null, null, null, '帆布');
INSERT INTO `wms_goods_attrbute` VALUES ('13', '34', null, null, null, '春秋');
INSERT INTO `wms_goods_attrbute` VALUES ('13', '31', null, null, null, '2016-05-06');
INSERT INTO `wms_goods_attrbute` VALUES ('12', '0', '34:白色 ', '100.00', '20', null);
INSERT INTO `wms_goods_attrbute` VALUES ('12', '0', '34:黑色 ', '100.00', '30', null);
INSERT INTO `wms_goods_attrbute` VALUES ('12', '0', '35:白色 ', '100.00', '40', null);
INSERT INTO `wms_goods_attrbute` VALUES ('12', '0', '35:黑色 ', '100.00', '48', null);
INSERT INTO `wms_goods_attrbute` VALUES ('12', '39', null, null, null, '平底');
INSERT INTO `wms_goods_attrbute` VALUES ('12', '36', null, null, null, '商务');
INSERT INTO `wms_goods_attrbute` VALUES ('12', '35', null, null, null, '橡胶');
INSERT INTO `wms_goods_attrbute` VALUES ('12', '34', null, null, null, '夏季');
INSERT INTO `wms_goods_attrbute` VALUES ('12', '31', null, null, null, '2016-05-03');
INSERT INTO `wms_goods_attrbute` VALUES ('9', '0', '34:白色 ', '50.00', '20', null);
INSERT INTO `wms_goods_attrbute` VALUES ('9', '0', '34:黑色 ', '50.00', '30', null);
INSERT INTO `wms_goods_attrbute` VALUES ('9', '39', null, null, null, '平底');
INSERT INTO `wms_goods_attrbute` VALUES ('9', '36', null, null, null, '商务');
INSERT INTO `wms_goods_attrbute` VALUES ('9', '35', null, null, null, 'PVC');
INSERT INTO `wms_goods_attrbute` VALUES ('9', '34', null, null, null, '春秋');
INSERT INTO `wms_goods_attrbute` VALUES ('9', '31', null, null, null, '2016-05-04');
INSERT INTO `wms_goods_attrbute` VALUES ('10', '0', '34:白色 ', '20.00', '20', null);
INSERT INTO `wms_goods_attrbute` VALUES ('10', '0', '34:黑色 ', '20.00', '30', null);
INSERT INTO `wms_goods_attrbute` VALUES ('10', '0', '35:白色 ', '20.00', '40', null);
INSERT INTO `wms_goods_attrbute` VALUES ('10', '0', '35:黑色 ', '20.00', '48', null);
INSERT INTO `wms_goods_attrbute` VALUES ('10', '39', null, null, null, '平底');
INSERT INTO `wms_goods_attrbute` VALUES ('10', '36', null, null, null, '商务');
INSERT INTO `wms_goods_attrbute` VALUES ('10', '35', null, null, null, '网布');
INSERT INTO `wms_goods_attrbute` VALUES ('10', '34', null, null, null, '春秋');
INSERT INTO `wms_goods_attrbute` VALUES ('10', '31', null, null, null, '2016-05-01');
INSERT INTO `wms_goods_attrbute` VALUES ('17', '0', '39:白色 ', '30.00', '39', null);
INSERT INTO `wms_goods_attrbute` VALUES ('17', '0', '39:黑色 ', '30.00', '39', null);
INSERT INTO `wms_goods_attrbute` VALUES ('17', '0', '40:白色 ', '30.00', '19', null);
INSERT INTO `wms_goods_attrbute` VALUES ('17', '0', '40:黑色 ', '30.00', '40', null);
INSERT INTO `wms_goods_attrbute` VALUES ('17', '39', null, null, null, '平底');
INSERT INTO `wms_goods_attrbute` VALUES ('17', '36', null, null, null, '商务');
INSERT INTO `wms_goods_attrbute` VALUES ('17', '35', null, null, null, '皮革');
INSERT INTO `wms_goods_attrbute` VALUES ('17', '34', null, null, null, '春秋');
INSERT INTO `wms_goods_attrbute` VALUES ('17', '31', null, null, null, '2016-05-04');
INSERT INTO `wms_goods_attrbute` VALUES ('1', '0', '41:白色 ', '20.00', '30', null);
INSERT INTO `wms_goods_attrbute` VALUES ('1', '0', '41:黑色 ', '20.00', '29', null);
INSERT INTO `wms_goods_attrbute` VALUES ('1', '0', '42:白色 ', '20.00', '38', null);
INSERT INTO `wms_goods_attrbute` VALUES ('1', '0', '42:黑色 ', '20.00', '78', null);
INSERT INTO `wms_goods_attrbute` VALUES ('1', '39', null, null, null, '平底');
INSERT INTO `wms_goods_attrbute` VALUES ('1', '36', null, null, null, '商务');
INSERT INTO `wms_goods_attrbute` VALUES ('1', '35', null, null, null, '皮革');
INSERT INTO `wms_goods_attrbute` VALUES ('1', '34', null, null, null, '冬季');
INSERT INTO `wms_goods_attrbute` VALUES ('1', '31', null, null, null, '2016-04-30');
INSERT INTO `wms_goods_attrbute` VALUES ('3', '0', 'M:白色 ', '99.00', '1', null);
INSERT INTO `wms_goods_attrbute` VALUES ('3', '0', 'L:白色 ', '99.00', '10', null);
INSERT INTO `wms_goods_attrbute` VALUES ('16', '0', '38:蓝色 ', '39.00', '39', null);
INSERT INTO `wms_goods_attrbute` VALUES ('16', '0', '39:蓝色 ', '38.00', '38', null);
INSERT INTO `wms_goods_attrbute` VALUES ('16', '39', null, null, null, '平底');
INSERT INTO `wms_goods_attrbute` VALUES ('16', '36', null, null, null, '商务');
INSERT INTO `wms_goods_attrbute` VALUES ('16', '35', null, null, null, 'PU');
INSERT INTO `wms_goods_attrbute` VALUES ('16', '34', null, null, null, '夏季');
INSERT INTO `wms_goods_attrbute` VALUES ('16', '31', null, null, null, '2016-05-03');
INSERT INTO `wms_goods_attrbute` VALUES ('18', '0', 'XS:白色 ', '30.00', '9', null);

-- ----------------------------
-- Table structure for `wms_goods_category`
-- ----------------------------
DROP TABLE IF EXISTS `wms_goods_category`;
CREATE TABLE `wms_goods_category` (
  `goods_id` mediumint(9) unsigned NOT NULL,
  `category_id` mediumint(9) unsigned NOT NULL,
  KEY `category_id` (`category_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wms_goods_category
-- ----------------------------
INSERT INTO `wms_goods_category` VALUES ('11', '2');
INSERT INTO `wms_goods_category` VALUES ('2', '1');
INSERT INTO `wms_goods_category` VALUES ('4', '1');
INSERT INTO `wms_goods_category` VALUES ('6', '2');
INSERT INTO `wms_goods_category` VALUES ('8', '2');
INSERT INTO `wms_goods_category` VALUES ('7', '1');
INSERT INTO `wms_goods_category` VALUES ('15', '1');
INSERT INTO `wms_goods_category` VALUES ('14', '1');
INSERT INTO `wms_goods_category` VALUES ('13', '1');
INSERT INTO `wms_goods_category` VALUES ('12', '1');
INSERT INTO `wms_goods_category` VALUES ('9', '1');
INSERT INTO `wms_goods_category` VALUES ('10', '1');
INSERT INTO `wms_goods_category` VALUES ('17', '1');
INSERT INTO `wms_goods_category` VALUES ('1', '1');
INSERT INTO `wms_goods_category` VALUES ('3', '2');
INSERT INTO `wms_goods_category` VALUES ('16', '1');
INSERT INTO `wms_goods_category` VALUES ('18', '2');

-- ----------------------------
-- Table structure for `wms_goods_extend`
-- ----------------------------
DROP TABLE IF EXISTS `wms_goods_extend`;
CREATE TABLE `wms_goods_extend` (
  `goods_id` mediumint(9) unsigned DEFAULT NULL,
  `val` varchar(20) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `count` mediumint(12) unsigned DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wms_goods_extend
-- ----------------------------

-- ----------------------------
-- Table structure for `wms_link`
-- ----------------------------
DROP TABLE IF EXISTS `wms_link`;
CREATE TABLE `wms_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键递增',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '标题',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=友情链接 2=合作伙伴',
  `icon` varchar(60) NOT NULL DEFAULT '' COMMENT '图片',
  `url` varchar(60) NOT NULL DEFAULT '' COMMENT '链接地址',
  `order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=启用 2=禁用',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=正常 2=删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='友情链接';

-- ----------------------------
-- Records of wms_link
-- ----------------------------

-- ----------------------------
-- Table structure for `wms_news`
-- ----------------------------
DROP TABLE IF EXISTS `wms_news`;
CREATE TABLE `wms_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键递增',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '标题',
  `category_id` int(10) NOT NULL DEFAULT '0' COMMENT '类别ID',
  `content` text NOT NULL COMMENT '内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=启用 2=禁用',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=正常 2=删除',
  `publish_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='最新公告';

-- ----------------------------
-- Records of wms_news
-- ----------------------------

-- ----------------------------
-- Table structure for `wms_news_category`
-- ----------------------------
DROP TABLE IF EXISTS `wms_news_category`;
CREATE TABLE `wms_news_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '分类名称',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=正常 2=删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='资讯类别';

-- ----------------------------
-- Records of wms_news_category
-- ----------------------------

-- ----------------------------
-- Table structure for `wms_node`
-- ----------------------------
DROP TABLE IF EXISTS `wms_node`;
CREATE TABLE `wms_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '主id',
  `name` varchar(20) NOT NULL COMMENT '名字',
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `sort` smallint(6) unsigned DEFAULT NULL COMMENT '排序',
  `pid` smallint(6) unsigned NOT NULL COMMENT '父id',
  `level` tinyint(1) unsigned NOT NULL COMMENT '级别',
  PRIMARY KEY (`id`),
  KEY `idx_level` (`level`),
  KEY `idx_pid` (`pid`),
  KEY `idx_status` (`status`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COMMENT='权限节点';

-- ----------------------------
-- Records of wms_node
-- ----------------------------
INSERT INTO `wms_node` VALUES ('1', 'Admin', '后台管理', '1', 'WMS后台管理系统', '0', '0', '1');
INSERT INTO `wms_node` VALUES ('2', 'News', '资讯管理', '1', '', '0', '1', '2');
INSERT INTO `wms_node` VALUES ('3', 'index', '资讯列表', '1', '', '0', '2', '3');
INSERT INTO `wms_node` VALUES ('4', 'add', '添加', '1', '', '0', '2', '3');
INSERT INTO `wms_node` VALUES ('5', 'edit', '编辑', '1', '', '0', '2', '3');
INSERT INTO `wms_node` VALUES ('6', 'status', '启用/禁用', '1', '', '0', '2', '3');
INSERT INTO `wms_node` VALUES ('7', 'del', '删除', '1', '', '0', '2', '3');
INSERT INTO `wms_node` VALUES ('8', 'category', '资讯分类', '1', '', '0', '2', '3');
INSERT INTO `wms_node` VALUES ('9', 'Link', '链接管理', '1', '', '0', '1', '2');
INSERT INTO `wms_node` VALUES ('10', 'index', '链接列表', '1', '', '0', '9', '3');
INSERT INTO `wms_node` VALUES ('11', 'add', '添加', '1', '', '0', '9', '3');
INSERT INTO `wms_node` VALUES ('12', 'edit', '编辑', '1', '', '0', '9', '3');
INSERT INTO `wms_node` VALUES ('13', 'status', '启用/禁用', '1', '', '0', '9', '3');
INSERT INTO `wms_node` VALUES ('14', 'del', '删除', '1', '', '0', '9', '3');
INSERT INTO `wms_node` VALUES ('15', 'details', '详情', '1', '', '0', '9', '3');
INSERT INTO `wms_node` VALUES ('16', 'Ad', '广告管理', '1', '', '0', '1', '2');
INSERT INTO `wms_node` VALUES ('17', 'index', '广告列表', '1', '', '0', '16', '3');
INSERT INTO `wms_node` VALUES ('18', 'add', '添加', '1', '', '0', '16', '3');
INSERT INTO `wms_node` VALUES ('19', 'edit', '编辑', '1', '', '0', '16', '3');
INSERT INTO `wms_node` VALUES ('20', 'status', '启用/禁用', '1', '', '0', '16', '3');
INSERT INTO `wms_node` VALUES ('21', 'del', '删除', '1', '', '0', '16', '3');
INSERT INTO `wms_node` VALUES ('22', 'details', '详情', '1', '', '0', '16', '3');
INSERT INTO `wms_node` VALUES ('23', 'User', '用户管理', '1', '', '0', '1', '2');
INSERT INTO `wms_node` VALUES ('24', 'index', '用户列表', '1', '', '0', '23', '3');
INSERT INTO `wms_node` VALUES ('26', 'del', '删除', '1', '', '0', '23', '3');
INSERT INTO `wms_node` VALUES ('27', 'details', '详情', '1', '', '0', '23', '3');
INSERT INTO `wms_node` VALUES ('28', 'Admin', '管理员管理', '1', '', '0', '1', '2');
INSERT INTO `wms_node` VALUES ('29', 'index', '管理员列表', '1', '', '0', '28', '3');
INSERT INTO `wms_node` VALUES ('30', 'add', '添加', '1', '', '0', '28', '3');
INSERT INTO `wms_node` VALUES ('31', 'edit', '编辑', '1', '', '0', '28', '3');
INSERT INTO `wms_node` VALUES ('32', 'status', '启用/禁用', '1', '', '0', '28', '3');
INSERT INTO `wms_node` VALUES ('33', 'del', '删除', '1', '', '0', '28', '3');
INSERT INTO `wms_node` VALUES ('34', 'details', '详情', '1', '', '0', '28', '3');
INSERT INTO `wms_node` VALUES ('35', 'Config', '配置管理', '1', '', '0', '1', '2');
INSERT INTO `wms_node` VALUES ('36', 'index', '列表+编辑', '1', '', '0', '35', '3');
INSERT INTO `wms_node` VALUES ('37', 'add', '添加', '1', '', '0', '35', '3');
INSERT INTO `wms_node` VALUES ('38', 'Access', '权限管理', '1', '', '0', '1', '2');
INSERT INTO `wms_node` VALUES ('39', 'index', '节点列表', '1', '', '0', '38', '3');
INSERT INTO `wms_node` VALUES ('40', 'addNode', '添加节点', '1', '', '0', '38', '3');
INSERT INTO `wms_node` VALUES ('41', 'editNode', '编辑节点', '1', '', '0', '38', '3');
INSERT INTO `wms_node` VALUES ('42', 'opSort', '节点排序', '1', '', '0', '38', '3');
INSERT INTO `wms_node` VALUES ('43', 'opNodeStatus', '启用/禁用(节点)', '1', '', '0', '38', '3');
INSERT INTO `wms_node` VALUES ('44', 'delNode', '删除节点', '1', '', '0', '38', '3');
INSERT INTO `wms_node` VALUES ('45', 'roleList', '角色列表', '1', '', '0', '38', '3');
INSERT INTO `wms_node` VALUES ('46', 'addRole', '添加角色', '1', '', '0', '38', '3');
INSERT INTO `wms_node` VALUES ('47', 'editRole', '编辑角色', '1', '', '0', '38', '3');
INSERT INTO `wms_node` VALUES ('48', 'opRoleStatus', '启用/禁用(角色)', '1', '', '0', '38', '3');
INSERT INTO `wms_node` VALUES ('49', 'changeRole', '分配权限', '1', '', '0', '38', '3');
INSERT INTO `wms_node` VALUES ('50', 'Db', '数据库管理', '1', '', '0', '1', '2');
INSERT INTO `wms_node` VALUES ('51', 'index', '数据表列表', '1', '', '0', '50', '3');
INSERT INTO `wms_node` VALUES ('52', 'restore', '导入列表', '1', '', '0', '50', '3');
INSERT INTO `wms_node` VALUES ('53', 'zipList', '压缩包列表', '1', '', '0', '50', '3');
INSERT INTO `wms_node` VALUES ('54', 'repair', '优化与修复', '1', '', '0', '50', '3');
INSERT INTO `wms_node` VALUES ('55', 'status', '禁用/启用', '1', '', '0', '23', '3');
INSERT INTO `wms_node` VALUES ('56', 'restoreData', '导入', '1', '', '0', '50', '3');
INSERT INTO `wms_node` VALUES ('57', 'delSqlFiles', '删除SQL文件', '1', '', '0', '50', '3');
INSERT INTO `wms_node` VALUES ('58', 'sendSql', '发送邮箱', '1', '', '0', '50', '3');
INSERT INTO `wms_node` VALUES ('59', 'zipSql', '压缩为ZIP', '1', '', '0', '50', '3');
INSERT INTO `wms_node` VALUES ('60', 'unzipSqlfile', '解压缩为SQL', '1', '', '0', '50', '3');
INSERT INTO `wms_node` VALUES ('61', 'delZipFiles', '删除ZIP文件', '1', '', '0', '50', '3');
INSERT INTO `wms_node` VALUES ('62', 'downFile', '下载文件', '1', '', '0', '50', '3');
INSERT INTO `wms_node` VALUES ('63', 'Template', '模板管理', '1', '', '0', '1', '2');
INSERT INTO `wms_node` VALUES ('64', 'index', '文件列表', '1', '', '0', '63', '3');
INSERT INTO `wms_node` VALUES ('65', 'downFile', '下载文件', '1', '', '0', '63', '3');
INSERT INTO `wms_node` VALUES ('66', 'edit', '编辑', '1', '', '0', '63', '3');
INSERT INTO `wms_node` VALUES ('67', 'mkdir', '创建文件夹', '1', '', '0', '63', '3');
INSERT INTO `wms_node` VALUES ('68', 'reName', '重命名', '1', '', '0', '63', '3');
INSERT INTO `wms_node` VALUES ('69', 'delFile', '删除文件', '1', '', '0', '63', '3');
INSERT INTO `wms_node` VALUES ('70', 'Oplog', '日志管理', '1', '', '0', '1', '2');
INSERT INTO `wms_node` VALUES ('71', 'index', '日志列表', '1', '', '0', '70', '3');

-- ----------------------------
-- Table structure for `wms_oplog`
-- ----------------------------
DROP TABLE IF EXISTS `wms_oplog`;
CREATE TABLE `wms_oplog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主id',
  `model` varchar(30) NOT NULL DEFAULT '' COMMENT '模块',
  `action` varchar(30) NOT NULL DEFAULT '' COMMENT '动作',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `admin_name` varchar(50) DEFAULT '' COMMENT '用户名',
  `role_id` int(10) NOT NULL DEFAULT '0' COMMENT '管理角色id',
  `role_name` varchar(50) NOT NULL DEFAULT '' COMMENT '管理角色',
  `bak` varchar(256) NOT NULL DEFAULT '' COMMENT '备注',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='后台操作表';

-- ----------------------------
-- Records of wms_oplog
-- ----------------------------
INSERT INTO `wms_oplog` VALUES ('1', 'Public', 'loginout', '1', 'admin', '1', '管理员', '退出', '1406110377');
INSERT INTO `wms_oplog` VALUES ('2', 'Public', 'index', '1', 'admin', '1', '超级管理员', '登录', '1406110389');

-- ----------------------------
-- Table structure for `wms_position`
-- ----------------------------
DROP TABLE IF EXISTS `wms_position`;
CREATE TABLE `wms_position` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL COMMENT '职位名称',
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='职位表';

-- ----------------------------
-- Records of wms_position
-- ----------------------------
INSERT INTO `wms_position` VALUES ('1', '店长', '1461291852');
INSERT INTO `wms_position` VALUES ('2', '职员', '1461291852');

-- ----------------------------
-- Table structure for `wms_privilege`
-- ----------------------------
DROP TABLE IF EXISTS `wms_privilege`;
CREATE TABLE `wms_privilege` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(60) NOT NULL COMMENT '权限名称',
  `parent_id` mediumint(11) unsigned DEFAULT '0' COMMENT '父级id',
  `controller` varchar(20) DEFAULT NULL,
  `module` varchar(20) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of wms_privilege
-- ----------------------------
INSERT INTO `wms_privilege` VALUES ('1', '超级管理员', '0', '---', '---', '---');
INSERT INTO `wms_privilege` VALUES ('2', '角色管理', '0', 'Role', 'Role', 'index,add,edit,delete');
INSERT INTO `wms_privilege` VALUES ('3', '用户管理', '0', 'Account', 'User', 'index,add,edit,delete');
INSERT INTO `wms_privilege` VALUES ('4', '商品品牌', '0', 'Brand', 'Brand', 'index,add,edit,delete');
INSERT INTO `wms_privilege` VALUES ('5', '商品分类', '0', 'Category', 'Category', 'index,add,edit,delete');
INSERT INTO `wms_privilege` VALUES ('6', '商品管理', '0', 'Goods', 'Goods', 'index,add,edit,delete');
INSERT INTO `wms_privilege` VALUES ('7', '职位管理', '0', 'Position', 'Position', 'index,add,edit,delete');
INSERT INTO `wms_privilege` VALUES ('8', '权限管理', '0', 'Privilege', 'Privilege', 'index,add,edit,delete');
INSERT INTO `wms_privilege` VALUES ('9', '门店管理', '0', 'Store', 'Store', 'index,add,edit,delete');
INSERT INTO `wms_privilege` VALUES ('10', '管理员管理', '0', 'Admin', 'Admin', 'index,add,edit,delete');

-- ----------------------------
-- Table structure for `wms_record`
-- ----------------------------
DROP TABLE IF EXISTS `wms_record`;
CREATE TABLE `wms_record` (
  `goods_id` mediumint(9) unsigned NOT NULL,
  `no` varchar(40) NOT NULL COMMENT '员工编号',
  `name` varchar(18) NOT NULL COMMENT '员工姓名',
  `create_time` int(11) NOT NULL,
  `sn` varchar(50) NOT NULL,
  `goods_name` varchar(80) NOT NULL,
  `price` decimal(10,2) unsigned NOT NULL COMMENT '价格',
  `value` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='销售记录';

-- ----------------------------
-- Records of wms_record
-- ----------------------------
INSERT INTO `wms_record` VALUES ('1', '2016', 'bool', '1462774517', '001', '特步01', '20.00', 'L,蓝色 ');
INSERT INTO `wms_record` VALUES ('1', '2016', 'bool', '1462775581', '001', '特步01', '20.00', '41,黑色 ');
INSERT INTO `wms_record` VALUES ('2', '2016', 'bool', '1462775581', '001', '特步01', '20.00', '42,白色 ');
INSERT INTO `wms_record` VALUES ('2', '2016', 'bool', '1462775587', '001', '特步01', '20.00', '42,白色 ');
INSERT INTO `wms_record` VALUES ('2', '2016', 'bool', '1462775594', '001', '特步01', '20.00', '42,白色 ');
INSERT INTO `wms_record` VALUES ('2', '2016', 'bool', '1462775598', '001', '特步01', '20.00', '42,白色 ');
INSERT INTO `wms_record` VALUES ('1', '2016', 'bool', '1462775599', '001', '特步01', '20.00', '42,黑色 ');
INSERT INTO `wms_record` VALUES ('5', '2016', 'bool', '1462775637', '001', '特步01', '20.00', '40,白色 ');
INSERT INTO `wms_record` VALUES ('3', '2016', 'bool', '1462775637', '001', '特步01', '20.00', '41,白色 ');
INSERT INTO `wms_record` VALUES ('2', '2016', 'bool', '1462775637', '001', '特步01', '20.00', '42,白色 ');
INSERT INTO `wms_record` VALUES ('4', '2016', 'bool', '1462775657', '001', '特步01', '20.00', '34,白色 ');
INSERT INTO `wms_record` VALUES ('4', '2016', 'bool', '1462775657', '001', '特步01', '20.00', '34,黑色 ');
INSERT INTO `wms_record` VALUES ('3', '2016', 'bool', '1462775657', '001', '特步01', '20.00', '35,白色 ');
INSERT INTO `wms_record` VALUES ('3', '2016', 'bool', '1462775657', '001', '特步01', '20.00', '35,黑色 ');

-- ----------------------------
-- Table structure for `wms_role`
-- ----------------------------
DROP TABLE IF EXISTS `wms_role`;
CREATE TABLE `wms_role` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of wms_role
-- ----------------------------
INSERT INTO `wms_role` VALUES ('1', '超级管理员');
INSERT INTO `wms_role` VALUES ('6', '用户管理员');
INSERT INTO `wms_role` VALUES ('7', '角色管理员');
INSERT INTO `wms_role` VALUES ('8', '商品管理员');
INSERT INTO `wms_role` VALUES ('9', '职位管理员');
INSERT INTO `wms_role` VALUES ('10', '权限管理员');
INSERT INTO `wms_role` VALUES ('11', '门店管理员');

-- ----------------------------
-- Table structure for `wms_role_privilege`
-- ----------------------------
DROP TABLE IF EXISTS `wms_role_privilege`;
CREATE TABLE `wms_role_privilege` (
  `privliege_id` mediumint(12) unsigned NOT NULL COMMENT '权限id',
  `role_id` mediumint(12) unsigned NOT NULL COMMENT '角色id',
  KEY `role_id` (`role_id`),
  KEY `privliege_id` (`privliege_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限表，角色->权限';

-- ----------------------------
-- Records of wms_role_privilege
-- ----------------------------
INSERT INTO `wms_role_privilege` VALUES ('3', '6');
INSERT INTO `wms_role_privilege` VALUES ('2', '7');
INSERT INTO `wms_role_privilege` VALUES ('4', '8');
INSERT INTO `wms_role_privilege` VALUES ('5', '8');
INSERT INTO `wms_role_privilege` VALUES ('6', '8');
INSERT INTO `wms_role_privilege` VALUES ('7', '9');
INSERT INTO `wms_role_privilege` VALUES ('8', '10');
INSERT INTO `wms_role_privilege` VALUES ('9', '11');
INSERT INTO `wms_role_privilege` VALUES ('1', '1');
INSERT INTO `wms_role_privilege` VALUES ('2', '1');
INSERT INTO `wms_role_privilege` VALUES ('3', '1');
INSERT INTO `wms_role_privilege` VALUES ('4', '1');
INSERT INTO `wms_role_privilege` VALUES ('5', '1');
INSERT INTO `wms_role_privilege` VALUES ('6', '1');
INSERT INTO `wms_role_privilege` VALUES ('7', '1');
INSERT INTO `wms_role_privilege` VALUES ('8', '1');
INSERT INTO `wms_role_privilege` VALUES ('9', '1');

-- ----------------------------
-- Table structure for `wms_role_user`
-- ----------------------------
DROP TABLE IF EXISTS `wms_role_user`;
CREATE TABLE `wms_role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主id',
  `role_id` mediumint(9) unsigned DEFAULT NULL COMMENT '角色id',
  `user_id` char(32) DEFAULT NULL COMMENT '用户id',
  PRIMARY KEY (`id`),
  KEY `idx_role_id` (`role_id`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户角色';

-- ----------------------------
-- Records of wms_role_user
-- ----------------------------
INSERT INTO `wms_role_user` VALUES ('1', '1', '1');

-- ----------------------------
-- Table structure for `wms_sale`
-- ----------------------------
DROP TABLE IF EXISTS `wms_sale`;
CREATE TABLE `wms_sale` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='销售';

-- ----------------------------
-- Records of wms_sale
-- ----------------------------

-- ----------------------------
-- Table structure for `wms_stock`
-- ----------------------------
DROP TABLE IF EXISTS `wms_stock`;
CREATE TABLE `wms_stock` (
  `no_id` mediumint(12) unsigned NOT NULL COMMENT '货号id',
  `sn` varchar(30) NOT NULL COMMENT '产品sn号',
  `depot_id` mediumint(12) unsigned NOT NULL COMMENT '仓库id',
  `goods_id` mediumint(12) unsigned NOT NULL COMMENT '商品id',
  `store_id` mediumint(12) unsigned NOT NULL,
  `num` mediumint(12) unsigned NOT NULL,
  KEY `depot_id` (`depot_id`),
  KEY `goods_id` (`goods_id`),
  KEY `store_id` (`store_id`),
  KEY `sn` (`sn`),
  KEY `no_id` (`no_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存';

-- ----------------------------
-- Records of wms_stock
-- ----------------------------

-- ----------------------------
-- Table structure for `wms_store`
-- ----------------------------
DROP TABLE IF EXISTS `wms_store`;
CREATE TABLE `wms_store` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `leader` varchar(30) DEFAULT NULL COMMENT '负责人，领导人',
  `name` varchar(60) NOT NULL COMMENT '门店名称',
  `tel` varchar(20) DEFAULT NULL,
  `address` varchar(100) NOT NULL COMMENT '地址',
  `desc` varchar(200) DEFAULT NULL,
  `create_time` varchar(20) NOT NULL COMMENT '创建时间',
  `status` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `leader` (`leader`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='门店表';

-- ----------------------------
-- Records of wms_store
-- ----------------------------
INSERT INTO `wms_store` VALUES ('1', '李先生', '东创科技园金枫路分店', '0512-5689107', '江苏省苏州市', '描述', '2016-04-14', '0');
INSERT INTO `wms_store` VALUES ('2', '李先生', '观前街分店', '0512-5689108', '苏州市观前街', '描述内容', '2016-04-14', '0');
INSERT INTO `wms_store` VALUES ('3', '赵先生', '工业园区湖东分店', '0512-5689105', '江苏省苏州市工业园区湖东', '描述', '2016-04-14', '0');
INSERT INTO `wms_store` VALUES ('4', '李先生', '苏州市高新区木渎分店', '0512-5689102', '苏州市高新区木渎分店', '苏州市高新区木渎分店', '2016-04-22', '0');

-- ----------------------------
-- Table structure for `wms_user`
-- ----------------------------
DROP TABLE IF EXISTS `wms_user`;
CREATE TABLE `wms_user` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `nickname` varchar(16) DEFAULT NULL COMMENT '昵称',
  `username` varchar(16) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，0正常 1禁止 2删除',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `nickname` (`nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of wms_user
-- ----------------------------
INSERT INTO `wms_user` VALUES ('13', '布尔', 'bool', 'c506ff134babdd6e68ab3e6350e95305', '0', '1460968251');
INSERT INTO `wms_user` VALUES ('14', '毛毛', 'maomao', '4a8a08f09d37b73795649038408b5f33', '0', '1460969225');
INSERT INTO `wms_user` VALUES ('15', '布尔', 'a', '4a8a08f09d37b73795649038408b5f33', '0', '1460970912');
INSERT INTO `wms_user` VALUES ('16', '测试', 'b', '4a8a08f09d37b73795649038408b5f33', '0', '1460970931');
INSERT INTO `wms_user` VALUES ('17', 'ColorRabbit', 'ColorRabbit', '3e21a1642f4596362cf77c25c6d7a9d7', '0', '1461315134');
INSERT INTO `wms_user` VALUES ('18', '毛毛', 'maomao1', '202cb962ac59075b964b07152d234b70', '0', '1461721685');

-- ----------------------------
-- Table structure for `wms_userinfo`
-- ----------------------------
DROP TABLE IF EXISTS `wms_userinfo`;
CREATE TABLE `wms_userinfo` (
  `id` mediumint(11) unsigned NOT NULL,
  `no` varchar(25) DEFAULT NULL,
  `qq` int(11) unsigned DEFAULT NULL COMMENT 'qq',
  `tel` varchar(15) DEFAULT NULL COMMENT '电话',
  `email` varchar(40) DEFAULT NULL COMMENT '邮箱',
  `sex` enum('女','男') DEFAULT NULL,
  `position` int(10) unsigned DEFAULT NULL,
  `address` varchar(120) DEFAULT NULL,
  `post` int(7) DEFAULT NULL,
  `store_id` int(11) unsigned NOT NULL,
  KEY `store_id` (`store_id`),
  KEY `position` (`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wms_userinfo
-- ----------------------------
INSERT INTO `wms_userinfo` VALUES ('13', '2016', '30024167', '18101565682', '30024167@qq.com', '男', '2', '江苏省苏州市工业园区', '267000', '1');
INSERT INTO `wms_userinfo` VALUES ('14', '44444444', '123456', '1414141414', '141414@qq.com', '男', '2', '河南省商丘市', '267000', '2');
INSERT INTO `wms_userinfo` VALUES ('15', '123', '1222', '123', '1', '男', '1', '1', '233', '3');
INSERT INTO `wms_userinfo` VALUES ('16', 'b', '1233', '123456', '123456@qq.com', '男', '2', '江苏省苏州市', '123', '1');
INSERT INTO `wms_userinfo` VALUES ('17', 'CR20160422', '0', '', '', '男', '1', '', '0', '2');
INSERT INTO `wms_userinfo` VALUES ('18', 'mao123', '0', '', '', '男', '2', '', '0', '2');
