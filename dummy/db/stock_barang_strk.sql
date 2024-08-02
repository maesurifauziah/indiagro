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
-- Table structure for stock_barang
-- ----------------------------
DROP TABLE IF EXISTS `stock_barang`;
CREATE TABLE `stock_barang`  (
  `stock_id` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kategori_id` char(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kode_barang` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kode_jenis_barang` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_jenis_barang` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `photo_bukti_barang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `createdDate` datetime(0) NOT NULL,
  `userid` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` enum('y','n') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `approveDate` datetime(0) NOT NULL,
  `approveBy` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `approveStatus` enum('n','y') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'n',
  `soldoutDate` datetime(0) NOT NULL,
  `soldoutBy` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `soldoutStatus` enum('n','y') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'n',
  `deletedDate` datetime(0) NOT NULL,
  `deletedBy` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `deletedStatus` enum('n','y') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'n',
  `status_barang` enum('draft','approve','sold_out','cancel') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'draft',
  PRIMARY KEY (`stock_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
