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

 Date: 29/05/2022 14:06:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for etalase_barang
-- ----------------------------
DROP TABLE IF EXISTS `etalase_barang`;
CREATE TABLE `etalase_barang`  (
  `kode_barang` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_barang` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kategori_id` char(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `createdDate` datetime(0) NOT NULL,
  `status` enum('y','n') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `userid` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`kode_barang`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
