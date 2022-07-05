/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100413
 Source Host           : localhost:3306
 Source Schema         : trajche

 Target Server Type    : MySQL
 Target Server Version : 100413
 File Encoding         : 65001

 Date: 06/07/2022 04:43:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL DEFAULT 1,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for videocomments
-- ----------------------------
DROP TABLE IF EXISTS `videocomments`;
CREATE TABLE `videocomments`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `videoid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of videocomments
-- ----------------------------
INSERT INTO `videocomments` VALUES (15, 20, 1, 'Test Data');
INSERT INTO `videocomments` VALUES (16, 20, 1, 'test data');

-- ----------------------------
-- Table structure for videodetails
-- ----------------------------
DROP TABLE IF EXISTS `videodetails`;
CREATE TABLE `videodetails`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `videoid` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of videodetails
-- ----------------------------
INSERT INTO `videodetails` VALUES (16, 20, 'test', '../uploads/edit and delete button_1657038237.png', 'test');

-- ----------------------------
-- Table structure for videoratings
-- ----------------------------
DROP TABLE IF EXISTS `videoratings`;
CREATE TABLE `videoratings`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `videoid` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of videoratings
-- ----------------------------
INSERT INTO `videoratings` VALUES (19, 20, 0, 0);

-- ----------------------------
-- Table structure for videos
-- ----------------------------
DROP TABLE IF EXISTS `videos`;
CREATE TABLE `videos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of videos
-- ----------------------------
INSERT INTO `videos` VALUES (20, 1, '../uploads/1_1657038228.mp4');

SET FOREIGN_KEY_CHECKS = 1;