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

 Date: 23/06/2022 08:29:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order`  (
  `order_id` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `userid` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kategori_id` char(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kode_barang` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kode_jenis_barang` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga_total` int(11) NOT NULL,
  `qty_order` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tanggal` date(0) NOT NULL,
  `createdDate` datetime(0) NOT NULL,
  `status` enum('y','n') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status_barang` enum('draft','checkout') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'draft',
  PRIMARY KEY (`order_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
