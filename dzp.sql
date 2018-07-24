/*
Navicat MySQL Data Transfer

Source Server         : test
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : dzp

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-07-24 13:12:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dzp_activity
-- ----------------------------
DROP TABLE IF EXISTS `dzp_activity`;
CREATE TABLE `dzp_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `desc` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dzp_activity
-- ----------------------------
INSERT INTO `dzp_activity` VALUES ('1', '红包活动', null, null, null);
INSERT INTO `dzp_activity` VALUES ('2', '大转盘活动', null, null, null);

-- ----------------------------
-- Table structure for dzp_card
-- ----------------------------
DROP TABLE IF EXISTS `dzp_card`;
CREATE TABLE `dzp_card` (
  `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `desc` varchar(100) DEFAULT NULL,
  `sudoku_id` varchar(50) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  PRIMARY KEY (`card_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dzp_card
-- ----------------------------
INSERT INTO `dzp_card` VALUES ('1', '集齐Bet卡,365卡,V卡,I卡,P卡可以获取我公司赠送的周杰伦演唱会门票', '2,4,5,7,8', null);
INSERT INTO `dzp_card` VALUES ('2', '集齐Bet卡,365卡可以获取我公司赠送的iphone-x', '2,4', null);

-- ----------------------------
-- Table structure for dzp_cj
-- ----------------------------
DROP TABLE IF EXISTS `dzp_cj`;
CREATE TABLE `dzp_cj` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `count` int(11) DEFAULT NULL,
  `mem_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `activity_type` int(11) DEFAULT NULL,
  `order` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dzp_cj
-- ----------------------------

-- ----------------------------
-- Table structure for dzp_jika
-- ----------------------------
DROP TABLE IF EXISTS `dzp_jika`;
CREATE TABLE `dzp_jika` (
  `jika_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(20) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `huodong_desc` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`jika_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dzp_jika
-- ----------------------------

-- ----------------------------
-- Table structure for dzp_manager
-- ----------------------------
DROP TABLE IF EXISTS `dzp_manager`;
CREATE TABLE `dzp_manager` (
  `manager_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `salt` varchar(30) DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `remember_token` varchar(115) DEFAULT NULL,
  PRIMARY KEY (`manager_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dzp_manager
-- ----------------------------
INSERT INTO `dzp_manager` VALUES ('1', 'root', '$2y$10$Uuvgt/a6AP/L2IMm3QTUf.ZdQcJIkaq/2kzbE5Bs7PmYzIzxdiQCm', null, null, '1', '2018-07-08 12:58:44', '2018-07-07 18:12:05', null, '', 'EyMLOiSYUvR6liriSSRDDZiOFBlWcbVMD2CGMLzgdlKvrreiDT9x4m8PQ20o');
INSERT INTO `dzp_manager` VALUES ('2', '乐乐', '$2y$10$pjkQZwdp4flq.2cBUUPdg.8wE7YdxG5PPOSMBlmCv4jcrEyXSEhGy', '30', null, '1', '2018-07-17 17:28:52', '2018-07-07 18:12:02', null, null, 'YjbcjO2yR9KSL85eZqXRbNvxQHRHNEe2Bxmtk2UKWH5QUvSUqZ2PSsPBZ1YV');
INSERT INTO `dzp_manager` VALUES ('3', 'linken', '$2y$10$Z9FfouZrBP27ar0cTWnknO/z1bt936rBbIk8PBww6VIm7KPF.8tI.', '31', null, '0', null, '2018-07-07 18:12:00', null, null, null);
INSERT INTO `dzp_manager` VALUES ('4', 'linlin', '$2y$10$Z9FfouZrBP27ar0cTWnknO/z1bt936rBbIk8PBww6VIm7KPF.8tI.', '31', null, '0', '2018-07-18 21:09:18', '2018-07-07 18:11:56', null, null, null);
INSERT INTO `dzp_manager` VALUES ('5', 'admin', '$2y$10$lCmIY59sMOl2wo.lwW/pw.dSXai/ARLrvrfOcRiQKFr.2dFOjhmOC', '31', null, null, '2018-07-18 21:07:30', '2018-07-15 14:13:14', null, null, null);

-- ----------------------------
-- Table structure for dzp_member
-- ----------------------------
DROP TABLE IF EXISTS `dzp_member`;
CREATE TABLE `dzp_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mem_no` varchar(50) DEFAULT '',
  `mem_name` varchar(50) DEFAULT '',
  `mem_pwd` varchar(255) DEFAULT '',
  `mem_mobile` varchar(50) DEFAULT '',
  `mg_name` varchar(11) DEFAULT NULL,
  `order` varchar(30) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `activity_type` int(11) DEFAULT NULL,
  `cj_sum` varchar(20) DEFAULT NULL,
  `cj_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(115) DEFAULT NULL,
  `session_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dzp_member
-- ----------------------------

-- ----------------------------
-- Table structure for dzp_permission
-- ----------------------------
DROP TABLE IF EXISTS `dzp_permission`;
CREATE TABLE `dzp_permission` (
  `ps_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ps_name` varchar(20) DEFAULT NULL,
  `ps_pid` int(11) DEFAULT NULL,
  `ps_c` varchar(50) DEFAULT NULL,
  `ps_a` varchar(50) DEFAULT NULL,
  `ps_route` varchar(50) DEFAULT NULL,
  `ps_level` enum('2','1','0') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ps_id`)
) ENGINE=MyISAM AUTO_INCREMENT=147 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dzp_permission
-- ----------------------------
INSERT INTO `dzp_permission` VALUES ('100', '会员管理', '0', null, null, null, '0', '2018-07-08 15:03:24', null, null);
INSERT INTO `dzp_permission` VALUES ('101', '红包活动', '0', '', '', '', '0', '2018-07-07 13:40:40', '2018-07-07 16:17:14', null);
INSERT INTO `dzp_permission` VALUES ('102', '九宫格活动', '0', null, null, null, '0', '2018-07-07 16:14:48', '2018-07-07 16:15:47', null);
INSERT INTO `dzp_permission` VALUES ('103', '权限管理', '0', '', '', '', '0', '2018-07-07 13:41:55', null, null);
INSERT INTO `dzp_permission` VALUES ('104', '未知', '101', 'Stream', 'index', 'admin/stream/index', '1', '2018-07-07 13:40:37', null, null);
INSERT INTO `dzp_permission` VALUES ('105', '未知', '104', 'Livecourse', 'index', 'admin/livecourse/index', '2', '2018-07-07 13:41:52', null, null);
INSERT INTO `dzp_permission` VALUES ('106', '未知', '101', 'Lesson', 'index', 'admin/lesson/index', '1', '2018-07-07 13:41:47', null, null);
INSERT INTO `dzp_permission` VALUES ('107', '活动设置', '102', 'Game', 'index', '/game/index', '1', '2018-07-07 13:40:42', '2018-07-12 14:11:33', null);
INSERT INTO `dzp_permission` VALUES ('108', '奖品录入', '134', 'Game', 'prize_input', '/game/prize_input', '2', '2018-07-07 13:41:49', '2018-07-15 13:03:14', null);
INSERT INTO `dzp_permission` VALUES ('109', '管理员列表', '103', 'Manager', 'index', '/manager/index', '1', '2018-07-07 13:40:34', null, null);
INSERT INTO `dzp_permission` VALUES ('110', '角色列表', '103', 'Role', 'index', '/role/index', '1', '2018-07-07 13:40:31', null, null);
INSERT INTO `dzp_permission` VALUES ('111', '权限列表', '103', 'Permission', 'index', '/permission/index', '1', '2018-07-07 13:39:36', null, null);
INSERT INTO `dzp_permission` VALUES ('112', '权限分配', '110', 'Role', 'distribute', '/role/distribute', '2', '2018-07-07 16:24:12', '2018-07-07 16:24:12', null);
INSERT INTO `dzp_permission` VALUES ('113', '角色删除', '110', 'Role', 'del', '/role/del', '2', '2018-07-07 16:24:50', '2018-07-07 16:24:50', null);
INSERT INTO `dzp_permission` VALUES ('114', '添加权限', '111', 'Permission', 'add', '/permission/add', '2', '2018-07-07 16:25:28', '2018-07-07 16:26:06', null);
INSERT INTO `dzp_permission` VALUES ('115', '编辑权限', '111', 'Permission', 'edit', '/permission/edit', '2', '2018-07-07 16:26:38', '2018-07-07 16:26:38', null);
INSERT INTO `dzp_permission` VALUES ('116', '删除权限', '111', 'Permission', 'del', '/permission/del', '2', '2018-07-07 16:27:00', '2018-07-07 16:28:32', null);
INSERT INTO `dzp_permission` VALUES ('117', '添加管理员', '109', 'Manager', 'add', '/manager/add', '2', '2018-07-08 14:32:31', '2018-07-08 14:32:31', null);
INSERT INTO `dzp_permission` VALUES ('118', '编辑管理员', '109', 'Manager', 'edit', '/manager/edit', '2', '2018-07-08 14:33:16', '2018-07-08 14:33:16', null);
INSERT INTO `dzp_permission` VALUES ('119', '删除管理员', '109', 'Manager', 'del', '/manager/del', '2', '2018-07-08 14:33:47', '2018-07-08 14:33:47', null);
INSERT INTO `dzp_permission` VALUES ('120', '员工密码丢失', '109', 'Manager', 'set', '/manager/set', '2', '2018-07-08 14:34:10', '2018-07-08 14:34:10', null);
INSERT INTO `dzp_permission` VALUES ('121', '修改密码', '109', 'Manager', 'change_pwd', '/manager/change_pwd', '2', '2018-07-08 14:34:38', '2018-07-08 14:34:38', null);
INSERT INTO `dzp_permission` VALUES ('122', '会员导入', '100', 'Member', 'import', '/member/import', '1', '2018-07-08 15:13:58', '2018-07-08 16:37:24', null);
INSERT INTO `dzp_permission` VALUES ('123', '活动类型/批号查询', '122', 'Member', 'search', '/member/search', '2', '2018-07-09 15:26:21', '2018-07-09 20:39:28', null);
INSERT INTO `dzp_permission` VALUES ('124', '会员列表', '100', 'Member', 'index', '/member/index', '1', '2018-07-10 14:29:46', '2018-07-10 14:29:46', null);
INSERT INTO `dzp_permission` VALUES ('125', '实时编辑', '124', 'Member', 'real_edit', '/member/real_edit', '2', '2018-07-10 20:20:34', '2018-07-10 20:20:34', null);
INSERT INTO `dzp_permission` VALUES ('126', '会员修改密码', '124', 'Member', 'reset_pwd', '/member/reset_pwd', '2', '2018-07-10 20:58:54', '2018-07-10 20:58:54', null);
INSERT INTO `dzp_permission` VALUES ('127', '会员删除', '124', 'Member', 'del', '/member/del', '2', '2018-07-10 21:44:00', '2018-07-10 21:44:00', null);
INSERT INTO `dzp_permission` VALUES ('128', '导入抽奖次数记录', '124', 'Cj', 'cj_logs', '/member/cj_logs', '2', '2018-07-11 12:37:03', '2018-07-11 12:37:21', null);
INSERT INTO `dzp_permission` VALUES ('129', '增减抽奖次数', '124', 'Cj', 'zj', '/member/zj', '2', '2018-07-11 17:49:50', '2018-07-11 17:50:10', null);
INSERT INTO `dzp_permission` VALUES ('130', '会员派彩', '100', 'Member', 'show', '/exchange/show', '1', '2018-07-12 13:16:11', '2018-07-19 17:54:19', null);
INSERT INTO `dzp_permission` VALUES ('131', '九宫格显示', '107', 'Rules', 'sudoku', '/sudoku/index', '2', '2018-07-14 12:37:41', '2018-07-17 20:35:33', null);
INSERT INTO `dzp_permission` VALUES ('132', '集卡规则', '102', 'Game', 'rules', '/game/rules', '1', '2018-07-14 19:18:06', '2018-07-18 22:06:59', null);
INSERT INTO `dzp_permission` VALUES ('133', '图片上传', '107', 'Upload', 'upload', '/upload', '2', '2018-07-14 20:46:36', '2018-07-14 20:46:36', null);
INSERT INTO `dzp_permission` VALUES ('134', '奖品管理', '102', 'Game', 'prize_index', '/game/prize_index', '1', '2018-07-15 13:02:30', '2018-07-15 18:48:38', null);
INSERT INTO `dzp_permission` VALUES ('135', '奖项编辑', '134', 'Game', 'prize_edit', '/game/prize_edit', '2', '2018-07-15 14:38:01', '2018-07-15 14:38:01', null);
INSERT INTO `dzp_permission` VALUES ('136', '奖项删除', '134', 'Game', 'prize_del', '/game/prize_del', '2', '2018-07-15 15:28:33', '2018-07-15 15:28:33', null);
INSERT INTO `dzp_permission` VALUES ('137', '奖品图片的联动', '107', 'Game', 'linkage', '/game/linkage', '2', '2018-07-15 16:10:37', '2018-07-15 16:10:37', null);
INSERT INTO `dzp_permission` VALUES ('138', '数据回滚', '122', 'Member', 'rollback', '/member/rollback', '2', '2018-07-16 14:24:45', '2018-07-16 14:24:45', null);
INSERT INTO `dzp_permission` VALUES ('139', '概率控制器', '107', 'Game', 'control', '/game/control', '2', '2018-07-16 17:31:00', '2018-07-16 17:31:00', null);
INSERT INTO `dzp_permission` VALUES ('140', '轮询最新抽奖记录', '130', 'Member', 'newdata', '/exchange/newdata', '2', '2018-07-18 19:24:55', '2018-07-18 19:24:55', null);
INSERT INTO `dzp_permission` VALUES ('141', '派送完毕彩金', '130', 'Member', 'sended', '/exchange/sended', '2', '2018-07-18 19:59:51', '2018-07-18 19:59:51', null);
INSERT INTO `dzp_permission` VALUES ('142', '集卡信息保存', '132', 'Game', 'setSave', '/game/setSave', '2', '2018-07-19 14:26:58', '2018-07-19 14:26:58', null);
INSERT INTO `dzp_permission` VALUES ('143', '集卡信息添加', '132', 'Game', 'addrules', '/game/addrules', '2', '2018-07-19 16:18:54', '2018-07-19 16:19:41', null);
INSERT INTO `dzp_permission` VALUES ('144', '会员集卡', '100', 'Member', 'make', '/jika/list', '1', '2018-07-21 21:47:15', '2018-07-22 14:50:37', null);
INSERT INTO `dzp_permission` VALUES ('145', '会员备注修改', '144', 'Member', 'jikaset', '/jika/jikaset', '2', '2018-07-22 15:30:17', '2018-07-22 15:30:17', null);
INSERT INTO `dzp_permission` VALUES ('146', '轮询最新的集卡数据', '144', 'Member', 'jika_new_data', '/jika/jika_new_data', '2', '2018-07-22 16:31:09', '2018-07-22 16:31:09', null);

-- ----------------------------
-- Table structure for dzp_prize
-- ----------------------------
DROP TABLE IF EXISTS `dzp_prize`;
CREATE TABLE `dzp_prize` (
  `prize_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `p_name` varchar(50) DEFAULT NULL,
  `p_img` varchar(255) DEFAULT NULL,
  `p_rules` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`prize_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dzp_prize
-- ----------------------------
INSERT INTO `dzp_prize` VALUES ('1', '8彩金', '/images/sudoku-20180715151756-32392.jpg', '1', null, '2018-07-18 21:20:44', '2018-07-15 14:28:12');
INSERT INTO `dzp_prize` VALUES ('2', '58彩金', '/images/sudoku-20180715151801-99075.jpg', '1', null, '2018-07-18 21:20:39', '2018-07-15 14:28:58');
INSERT INTO `dzp_prize` VALUES ('3', '88彩金', '/images/sudoku-20180718214236-72469.jpg', '1', null, '2018-07-18 21:42:39', '2018-07-15 14:29:10');
INSERT INTO `dzp_prize` VALUES ('4', '365卡', '/images/sudoku-20180719174622-43648.png', '0', null, '2018-07-19 17:46:23', '2018-07-15 14:29:23');
INSERT INTO `dzp_prize` VALUES ('5', 'V神卡', '/images/sudoku-20180719174631-80109.png', '0', null, '2018-07-19 17:46:32', '2018-07-15 14:29:34');
INSERT INTO `dzp_prize` VALUES ('6', 'I卡', '/images/sudoku-20180719174637-17014.png', '0', null, '2018-07-19 17:46:38', '2018-07-15 14:29:48');
INSERT INTO `dzp_prize` VALUES ('7', 'P卡', '/images/sudoku-20180719174645-53627.png', '0', null, '2018-07-19 17:46:46', '2018-07-15 14:29:57');
INSERT INTO `dzp_prize` VALUES ('8', 'Bet卡', '/images/sudoku-20180719174652-33141.png', '0', null, '2018-07-19 17:46:53', '2018-07-15 14:30:06');
INSERT INTO `dzp_prize` VALUES ('9', '158彩金', '/images/sudoku-20180715152332-68260.jpg', '1', null, '2018-07-18 21:44:12', '2018-07-15 15:23:34');
INSERT INTO `dzp_prize` VALUES ('10', '288彩金', '/images/sudoku-20180718214425-36301.jpg', '1', null, '2018-07-18 21:46:35', '2018-07-15 15:37:25');
INSERT INTO `dzp_prize` VALUES ('11', '365卡', '/images/sudoku-20180718213734-77196.png', '0', '2018-07-18 21:43:28', '2018-07-18 21:43:28', '2018-07-18 21:37:36');
INSERT INTO `dzp_prize` VALUES ('12', 'V卡', '/images/sudoku-20180718213757-74452.png', '0', '2018-07-18 21:43:21', '2018-07-18 21:43:21', '2018-07-18 21:37:58');

-- ----------------------------
-- Table structure for dzp_prize_logs
-- ----------------------------
DROP TABLE IF EXISTS `dzp_prize_logs`;
CREATE TABLE `dzp_prize_logs` (
  `logs_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mem_no` varchar(50) DEFAULT NULL,
  `prize_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`logs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dzp_prize_logs
-- ----------------------------

-- ----------------------------
-- Table structure for dzp_role
-- ----------------------------
DROP TABLE IF EXISTS `dzp_role`;
CREATE TABLE `dzp_role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) DEFAULT NULL,
  `ps_ids` text,
  `ps_ca` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dzp_role
-- ----------------------------
INSERT INTO `dzp_role` VALUES ('30', '开发', '100,122,123,138,124,125,126,127,128,129,130,140,141,144,145,146,102,107,131,133,137,139,132,142,143,134,108,135,136,103,109,117,118,119,120,121,110,112,113,111,114,115,116', 'Game-index,Game-prize_input,Manager-index,Role-index,Permission-index,Role-distribute,Role-del,Permission-add,Permission-edit,Permission-del,Manager-add,Manager-edit,Manager-del,Manager-set,Manager-change_pwd,Member-import,Member-search,Member-index,Member-real_edit,Member-reset_pwd,Member-del,Cj-cj_logs,Cj-zj,Member-show,Rules-sudoku,Game-rules,Upload-upload,Game-prize_index,Game-prize_edit,Game-prize_del,Game-linkage,Member-rollback,Game-control,Member-newdata,Member-sended,Game-setSave,Game-addrules,Member-make,Member-jikaset,Member-jika_new_data', null, '2018-07-22 16:31:16', null);
INSERT INTO `dzp_role` VALUES ('31', '执行长一', '100,122,123,138,124,125,126,127,128,129,130,140,141,102,107,131,133,137,139,132,142,143,134,108,135,136', 'Game-index,Game-prize_input,Member-import,Member-search,Member-index,Member-real_edit,Member-reset_pwd,Member-del,Cj-cj_logs,Cj-zj,Member-show,Rules-sudoku,Game-rules,Upload-upload,Game-prize_index,Game-prize_edit,Game-prize_del,Game-linkage,Member-rollback,Game-control,Member-newdata,Member-sended,Game-setSave,Game-addrules', null, '2018-07-19 18:42:25', null);
INSERT INTO `dzp_role` VALUES ('32', '执行长二', '106', 'Lesson-index', null, '2018-07-07 12:28:29', null);
INSERT INTO `dzp_role` VALUES ('33', '执行长三', '106', 'Lesson-index', null, '2018-07-07 12:30:38', null);
INSERT INTO `dzp_role` VALUES ('36', '执行长四', '106', 'Lesson-index', null, '2018-07-07 21:28:37', '2018-07-07 21:28:37');

-- ----------------------------
-- Table structure for dzp_sudoku
-- ----------------------------
DROP TABLE IF EXISTS `dzp_sudoku`;
CREATE TABLE `dzp_sudoku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place` char(10) DEFAULT NULL,
  `keyword` varchar(30) DEFAULT NULL,
  `prize_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `percent` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dzp_sudoku
-- ----------------------------
INSERT INTO `dzp_sudoku` VALUES ('1', '左上', '8元彩金', '1', null, '2018-07-19 18:35:35', '50');
INSERT INTO `dzp_sudoku` VALUES ('2', '中上', 'Bet神卡', '8', null, '2018-07-22 14:37:39', '90');
INSERT INTO `dzp_sudoku` VALUES ('3', '右上', '58彩金', '2', null, '2018-07-18 21:51:02', '20');
INSERT INTO `dzp_sudoku` VALUES ('4', '左中', '365卡', '4', null, '2018-07-22 13:33:38', '240');
INSERT INTO `dzp_sudoku` VALUES ('5', '右中', 'V神卡', '5', null, '2018-07-22 14:37:37', '20');
INSERT INTO `dzp_sudoku` VALUES ('6', '左下', '88彩金', '3', null, '2018-07-22 14:37:34', '0');
INSERT INTO `dzp_sudoku` VALUES ('7', '中下', 'I神卡', '6', null, '2018-07-22 14:37:29', '0');
INSERT INTO `dzp_sudoku` VALUES ('8', '右下', 'P卡', '7', null, '2018-07-22 14:37:31', '40');
