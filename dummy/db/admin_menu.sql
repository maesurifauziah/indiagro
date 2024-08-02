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

 Date: 24/07/2022 17:46:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu`  (
  `menu_id` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `menu_desc` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `icon` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '',
  `aktif` enum('y','n') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'y',
  `parent_menuid` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `menu_for` enum('mobile','web','mobile/web') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `seq` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `level_menu` enum('root','child','function') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'root',
  PRIMARY KEY (`menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES ('M0001', 'Home', 'fas fa-home', '', 'y', '', 'mobile', '1', 'root');
INSERT INTO `admin_menu` VALUES ('M0002', 'Order', 'fas fa-shopping-basket', 'order', 'y', '', 'mobile', '2', 'root');
INSERT INTO `admin_menu` VALUES ('M0003', 'Stock', 'fas fa-boxes', 'stock_barang', 'y', '', 'mobile', '3', 'root');
INSERT INTO `admin_menu` VALUES ('M0004', 'Transaksi', 'fas fa-clipboard-list', 'transaksi', 'y', '', 'mobile', '4', 'root');
INSERT INTO `admin_menu` VALUES ('M0005', 'Ekspedisi', 'fas fa-shipping-fast', 'ekspedisi', 'y', '', 'mobile', '5', 'root');
INSERT INTO `admin_menu` VALUES ('M0006', 'Keranjang', '', 'keranjang', 'y', '', 'mobile/web', '', 'function');

SET FOREIGN_KEY_CHECKS = 1;
