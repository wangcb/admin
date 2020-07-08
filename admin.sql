/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : ruanwen

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-07-08 14:23:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for login_log
-- ----------------------------
DROP TABLE IF EXISTS `login_log`;
CREATE TABLE `login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of login_log
-- ----------------------------
INSERT INTO `login_log` VALUES ('117', '1', '127.0.0.1', '2020-06-19 19:02:01');
INSERT INTO `login_log` VALUES ('118', '1', '127.0.0.1', '2020-06-22 15:01:34');
INSERT INTO `login_log` VALUES ('119', '1', '127.0.0.1', '2020-06-22 16:20:55');
INSERT INTO `login_log` VALUES ('120', '1', '127.0.0.1', '2020-06-22 16:53:04');
INSERT INTO `login_log` VALUES ('121', '1', '127.0.0.1', '2020-06-22 16:55:23');
INSERT INTO `login_log` VALUES ('122', '1', '192.168.1.90', '2020-06-22 17:21:56');
INSERT INTO `login_log` VALUES ('123', '1', '192.168.1.90', '2020-06-22 17:22:17');
INSERT INTO `login_log` VALUES ('124', '1', '192.168.1.90', '2020-06-22 17:22:29');
INSERT INTO `login_log` VALUES ('125', '1', '192.168.1.90', '2020-06-22 17:22:53');
INSERT INTO `login_log` VALUES ('126', '1', '127.0.0.1', '2020-06-23 09:07:53');
INSERT INTO `login_log` VALUES ('127', '1', '127.0.0.1', '2020-06-23 09:21:45');
INSERT INTO `login_log` VALUES ('128', '1', '192.168.1.90', '2020-06-23 09:42:10');
INSERT INTO `login_log` VALUES ('129', '1', '127.0.0.1', '2020-06-23 10:12:29');
INSERT INTO `login_log` VALUES ('130', '1', '127.0.0.1', '2020-06-23 15:24:19');
INSERT INTO `login_log` VALUES ('131', '1', '127.0.0.1', '2020-06-23 15:25:16');
INSERT INTO `login_log` VALUES ('132', '1', '127.0.0.1', '2020-06-24 09:18:12');
INSERT INTO `login_log` VALUES ('133', '1', '127.0.0.1', '2020-06-29 17:37:26');
INSERT INTO `login_log` VALUES ('134', '1', '127.0.0.1', '2020-06-30 09:20:17');
INSERT INTO `login_log` VALUES ('135', '1', '127.0.0.1', '2020-07-06 16:29:52');
INSERT INTO `login_log` VALUES ('136', '1', '127.0.0.1', '2020-07-08 11:52:12');

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------
INSERT INTO `model_has_permissions` VALUES ('1', 'App\\Model\\User', '1');

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES ('1', 'app\\model\\User', '1');
INSERT INTO `model_has_roles` VALUES ('13', 'app\\model\\User', '1');
INSERT INTO `model_has_roles` VALUES ('13', 'app\\model\\User', '9');
INSERT INTO `model_has_roles` VALUES ('14', 'app\\model\\User', '1');
INSERT INTO `model_has_roles` VALUES ('24', 'app\\model\\User', '1');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '接口地址',
  `display_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '页面路由',
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序，数字越大越在前面',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_time` timestamp NULL DEFAULT NULL,
  `updated_time` timestamp NULL DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0菜单，1按钮',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', '46', 'user/lists', '用户管理', '#/system/user', 'web', '60', 'layui-icon layui-icon-username', '2020-04-24 02:44:37', '2020-04-24 02:44:37', '0');
INSERT INTO `permissions` VALUES ('2', '1', 'user/create', '创建用户', '', 'web', '0', null, '2020-04-24 02:44:37', '2020-04-24 02:44:37', '1');
INSERT INTO `permissions` VALUES ('3', '1', 'user/edit', '修改用户', null, 'web', '0', null, '2020-05-25 13:54:41', '2020-05-25 13:54:46', '1');
INSERT INTO `permissions` VALUES ('4', '1', 'user/delete', '删除用户', null, 'web', '0', null, '2020-05-25 13:55:40', '2020-05-25 13:55:43', '1');
INSERT INTO `permissions` VALUES ('5', '46', 'role/lists', '角色管理', '#/system/role', 'web', '50', 'layui-icon layui-icon-user', null, null, '0');
INSERT INTO `permissions` VALUES ('6', '5', 'role/create', '创建角色', null, 'web', '0', null, null, null, '1');
INSERT INTO `permissions` VALUES ('7', '5', 'role/edit', '修改角色', null, 'web', '0', null, null, null, '1');
INSERT INTO `permissions` VALUES ('8', '5', 'role/delete', '删除角色', null, 'web', '0', null, null, null, '1');
INSERT INTO `permissions` VALUES ('9', '5', 'role/permission', '分配权限', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('10', '46', 'permission/lists', '权限管理', '#/system/authorities', 'web', '40', 'layui-icon layui-icon-layouts', null, null, '0');
INSERT INTO `permissions` VALUES ('11', '10', 'permission/create', '创建权限', null, 'web', '0', null, null, null, '1');
INSERT INTO `permissions` VALUES ('12', '10', 'permission/edit', '修改权限', null, 'web', '0', null, null, null, '1');
INSERT INTO `permissions` VALUES ('13', '10', 'permission/delete', '删除权限', null, 'web', '0', null, null, null, '1');
INSERT INTO `permissions` VALUES ('14', '22', '', '媒体属性', '#/system/attribute', 'web', '80', 'layui-icon layui-icon-component', null, null, '0');
INSERT INTO `permissions` VALUES ('15', '14', 'attribute/create', '属性添加', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('16', '14', 'attribute/edit', '属性修改', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('17', '14', 'attribute/delete', '属性删除', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('18', '14', 'attribute/values', '值列表', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('19', '14', 'attribute/createValue', '值添加', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('20', '14', 'attribute/editValue', '值修改', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('21', '14', 'attribute/deleteValue', '值删除', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('22', '0', '', '媒体分类', '', 'web', '70', 'layui-icon layui-icon-app', null, null, '0');
INSERT INTO `permissions` VALUES ('23', '22', 'media/lists', '媒体平台', '#/system/media', 'web', '100', 'layui-icon layui-icon-website', null, null, '0');
INSERT INTO `permissions` VALUES ('24', '22', 'media/lists', '自媒体', '#/system/media/model=1', 'web', '90', 'layui-icon layui-icon-release', null, null, '0');
INSERT INTO `permissions` VALUES ('25', '22', 'media/create', '添加', '#system/mediaadd', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('26', '0', 'article/create', '文章发布', '#/system/articleadd', 'web', '60', 'layui-icon layui-icon-release', null, null, '0');
INSERT INTO `permissions` VALUES ('27', '45', 'article/lists', '订单管理', '#/system/order', 'web', '0', 'layui-icon layui-icon-form', null, null, '0');
INSERT INTO `permissions` VALUES ('31', '27', 'article/state', '发布/拒绝', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('29', '45', 'cash/index', '提现管理', '#/system/cash', 'web', '0', 'layui-icon layui-icon-rmb', null, null, '0');
INSERT INTO `permissions` VALUES ('30', '45', 'user/transaction', '交易流水', '#/system/transaction', 'web', '0', 'layui-icon layui-icon-chart', null, null, '0');
INSERT INTO `permissions` VALUES ('32', '45', 'userbank/index', '银行卡管理', '#/system/userbank', 'web', '0', 'layui-icon layui-icon-read', null, null, '0');
INSERT INTO `permissions` VALUES ('33', '32', 'userbank/add', '新增', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('34', '1', 'user/state', '用户状态', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('35', '32', 'userbank/update', '修改', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('36', '32', 'userbank/delete', '删除', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('37', '46', 'login/log', '登录日志', '#/system/loginlog', 'web', '0', 'layui-icon layui-icon-survey', null, null, '0');
INSERT INTO `permissions` VALUES ('38', '29', 'cash/change', '提现审核', '#/system/cash', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('39', '29', 'cash/add', '添加', '#/system/cash', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('43', '22', 'media/edit', '修改', '#system/mediaadd', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('42', '29', 'cash/views', '查看', '#/system/cash', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('44', '22', 'media/delete', '删除', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('45', '0', '', '财务管理', '', 'web', '90', 'layui-icon layui-icon-dollar', null, null, '0');
INSERT INTO `permissions` VALUES ('46', '0', '', '系统管理', '', 'web', '100', 'layui-icon layui-icon-set', null, null, '0');
INSERT INTO `permissions` VALUES ('47', '1', 'user/change', '修改余额', '#/system/user', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('48', '46', 'news/index', '使用手册管理', '#/system/news', 'web', '-1', 'layui-icon layui-icon-template-1', null, null, '0');
INSERT INTO `permissions` VALUES ('53', '48', 'news/add', '添加', '#system/newsadd', 'web', '0', 'layui-icon layui-icon-read', null, null, '1');
INSERT INTO `permissions` VALUES ('51', '48', 'news/update', '修改', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('52', '48', 'news/delete', '删除', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('55', '27', '', '查看', '', 'web', '0', '', null, null, '1');
INSERT INTO `permissions` VALUES ('56', '27', 'article/detail', '再发布', '', 'web', '0', '', null, null, '1');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', '管理员', '', 'web', '2020-04-24 02:44:37', '2020-04-24 02:44:37');
INSERT INTO `roles` VALUES ('13', '媒体平台', '', 'web', '2020-05-17 14:22:49', '2020-06-08 14:37:39');
INSERT INTO `roles` VALUES ('14', '自媒体', '', 'web', '2020-05-17 14:22:51', '2020-06-08 14:37:46');
INSERT INTO `roles` VALUES ('24', '普通用户', '', 'web', '2020-06-11 17:36:24', '2020-06-11 17:36:24');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES ('1', '1');
INSERT INTO `role_has_permissions` VALUES ('2', '1');
INSERT INTO `role_has_permissions` VALUES ('3', '1');
INSERT INTO `role_has_permissions` VALUES ('4', '1');
INSERT INTO `role_has_permissions` VALUES ('5', '1');
INSERT INTO `role_has_permissions` VALUES ('6', '1');
INSERT INTO `role_has_permissions` VALUES ('7', '1');
INSERT INTO `role_has_permissions` VALUES ('8', '1');
INSERT INTO `role_has_permissions` VALUES ('9', '1');
INSERT INTO `role_has_permissions` VALUES ('10', '1');
INSERT INTO `role_has_permissions` VALUES ('11', '1');
INSERT INTO `role_has_permissions` VALUES ('12', '1');
INSERT INTO `role_has_permissions` VALUES ('13', '1');
INSERT INTO `role_has_permissions` VALUES ('14', '1');
INSERT INTO `role_has_permissions` VALUES ('15', '1');
INSERT INTO `role_has_permissions` VALUES ('16', '1');
INSERT INTO `role_has_permissions` VALUES ('17', '1');
INSERT INTO `role_has_permissions` VALUES ('18', '1');
INSERT INTO `role_has_permissions` VALUES ('19', '1');
INSERT INTO `role_has_permissions` VALUES ('20', '1');
INSERT INTO `role_has_permissions` VALUES ('21', '1');
INSERT INTO `role_has_permissions` VALUES ('22', '1');
INSERT INTO `role_has_permissions` VALUES ('22', '13');
INSERT INTO `role_has_permissions` VALUES ('23', '1');
INSERT INTO `role_has_permissions` VALUES ('23', '13');
INSERT INTO `role_has_permissions` VALUES ('24', '1');
INSERT INTO `role_has_permissions` VALUES ('24', '13');
INSERT INTO `role_has_permissions` VALUES ('25', '1');
INSERT INTO `role_has_permissions` VALUES ('26', '1');
INSERT INTO `role_has_permissions` VALUES ('26', '13');
INSERT INTO `role_has_permissions` VALUES ('26', '14');
INSERT INTO `role_has_permissions` VALUES ('26', '24');
INSERT INTO `role_has_permissions` VALUES ('27', '1');
INSERT INTO `role_has_permissions` VALUES ('27', '13');
INSERT INTO `role_has_permissions` VALUES ('27', '14');
INSERT INTO `role_has_permissions` VALUES ('27', '24');
INSERT INTO `role_has_permissions` VALUES ('29', '1');
INSERT INTO `role_has_permissions` VALUES ('29', '13');
INSERT INTO `role_has_permissions` VALUES ('29', '14');
INSERT INTO `role_has_permissions` VALUES ('29', '24');
INSERT INTO `role_has_permissions` VALUES ('30', '1');
INSERT INTO `role_has_permissions` VALUES ('30', '13');
INSERT INTO `role_has_permissions` VALUES ('30', '14');
INSERT INTO `role_has_permissions` VALUES ('30', '24');
INSERT INTO `role_has_permissions` VALUES ('31', '1');
INSERT INTO `role_has_permissions` VALUES ('31', '13');
INSERT INTO `role_has_permissions` VALUES ('31', '14');
INSERT INTO `role_has_permissions` VALUES ('32', '1');
INSERT INTO `role_has_permissions` VALUES ('32', '13');
INSERT INTO `role_has_permissions` VALUES ('32', '24');
INSERT INTO `role_has_permissions` VALUES ('33', '1');
INSERT INTO `role_has_permissions` VALUES ('33', '13');
INSERT INTO `role_has_permissions` VALUES ('33', '24');
INSERT INTO `role_has_permissions` VALUES ('34', '1');
INSERT INTO `role_has_permissions` VALUES ('35', '1');
INSERT INTO `role_has_permissions` VALUES ('35', '13');
INSERT INTO `role_has_permissions` VALUES ('35', '24');
INSERT INTO `role_has_permissions` VALUES ('36', '1');
INSERT INTO `role_has_permissions` VALUES ('36', '13');
INSERT INTO `role_has_permissions` VALUES ('36', '24');
INSERT INTO `role_has_permissions` VALUES ('37', '1');
INSERT INTO `role_has_permissions` VALUES ('37', '13');
INSERT INTO `role_has_permissions` VALUES ('37', '14');
INSERT INTO `role_has_permissions` VALUES ('37', '24');
INSERT INTO `role_has_permissions` VALUES ('38', '1');
INSERT INTO `role_has_permissions` VALUES ('39', '1');
INSERT INTO `role_has_permissions` VALUES ('39', '13');
INSERT INTO `role_has_permissions` VALUES ('42', '1');
INSERT INTO `role_has_permissions` VALUES ('42', '24');
INSERT INTO `role_has_permissions` VALUES ('43', '1');
INSERT INTO `role_has_permissions` VALUES ('44', '1');
INSERT INTO `role_has_permissions` VALUES ('45', '1');
INSERT INTO `role_has_permissions` VALUES ('45', '13');
INSERT INTO `role_has_permissions` VALUES ('45', '14');
INSERT INTO `role_has_permissions` VALUES ('45', '24');
INSERT INTO `role_has_permissions` VALUES ('46', '1');
INSERT INTO `role_has_permissions` VALUES ('46', '24');
INSERT INTO `role_has_permissions` VALUES ('47', '1');
INSERT INTO `role_has_permissions` VALUES ('48', '1');
INSERT INTO `role_has_permissions` VALUES ('51', '1');
INSERT INTO `role_has_permissions` VALUES ('52', '1');
INSERT INTO `role_has_permissions` VALUES ('53', '1');
INSERT INTO `role_has_permissions` VALUES ('55', '1');
INSERT INTO `role_has_permissions` VALUES ('55', '24');
INSERT INTO `role_has_permissions` VALUES ('56', '1');
INSERT INTO `role_has_permissions` VALUES ('56', '13');
INSERT INTO `role_has_permissions` VALUES ('56', '14');
INSERT INTO `role_has_permissions` VALUES ('56', '24');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常，1禁用',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0女，1男，2未知',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `profile` varchar(255) DEFAULT NULL COMMENT '简介',
  `credit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `frozen` decimal(10,2) NOT NULL DEFAULT '0.00',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'cloud', '#72a0a3923c1b07df60fa3b6da207e94c', '管理员', '18156821027', '', '0', '1', '我', '海纳百川，有容乃大1', '1000.00', '0.00', '2020-05-04 16:43:02', '2020-06-19 17:48:38');
INSERT INTO `user` VALUES ('9', 'yunzhang', '#72a0a3923c1b07df60fa3b6da207e94c', '云掌财经', '18156814563', null, '0', '0', '', null, '0.00', '0.00', '2020-06-22 16:18:47', '2020-06-22 16:18:47');
