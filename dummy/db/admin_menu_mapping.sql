/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3309
 Source Server Type    : MySQL
 Source Server Version : 100420
 Source Host           : localhost:3309
 Source Schema         : db_agro_indo

 Target Server Type    : MySQL
 Target Server Version : 100420
 File Encoding         : 65001

 Date: 24/07/2022 17:46:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_menu_mapping
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu_mapping`;
CREATE TABLE `admin_menu_mapping`  (
  `user_group` varchar(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `menu_id` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`user_group`, `menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_menu_mapping
-- ----------------------------
INSERT INTO `admin_menu_mapping` VALUES ('0001', 'M0001');
INSERT INTO `admin_menu_mapping` VALUES ('0001', 'M0002');
INSERT INTO `admin_menu_mapping` VALUES ('0001', 'M0003');
INSERT INTO `admin_menu_mapping` VALUES ('0001', 'M0004');
INSERT INTO `admin_menu_mapping` VALUES ('0001', 'M0005');
INSERT INTO `admin_menu_mapping` VALUES ('0001', 'M0006');
INSERT INTO `admin_menu_mapping` VALUES ('0002', 'M0001');
INSERT INTO `admin_menu_mapping` VALUES ('0002', 'M0003');
INSERT INTO `admin_menu_mapping` VALUES ('0003', 'M0001');
INSERT INTO `admin_menu_mapping` VALUES ('0003', 'M0002');
INSERT INTO `admin_menu_mapping` VALUES ('0003', 'M0004');
INSERT INTO `admin_menu_mapping` VALUES ('0003', 'M0006');
INSERT INTO `admin_menu_mapping` VALUES ('0004', 'M0001');
INSERT INTO `admin_menu_mapping` VALUES ('0004', 'M0005');
INSERT INTO `admin_menu_mapping` VALUES ('0005', 'M0001');
INSERT INTO `admin_menu_mapping` VALUES ('0005', 'M0002');
INSERT INTO `admin_menu_mapping` VALUES ('0005', 'M0003');
INSERT INTO `admin_menu_mapping` VALUES ('0005', 'M0004');
INSERT INTO `admin_menu_mapping` VALUES ('0005', 'M0005');
INSERT INTO `admin_menu_mapping` VALUES ('0005', 'M0006');

SET FOREIGN_KEY_CHECKS = 1;
