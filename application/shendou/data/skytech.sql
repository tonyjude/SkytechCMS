-- phpMyAdmin SQL Dump
-- version 4.3.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-12-13 10:27:33
-- 服务器版本： 5.6.22
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 表的结构 `skytech_article`
--

CREATE TABLE IF NOT EXISTS `skytech_article` (
  `id` int(10) unsigned NOT NULL,
  `art_catalog_id` int(10) unsigned NOT NULL,
  `art_author` varchar(200) COLLATE utf8_bin NOT NULL,
  `art_title` varchar(200) COLLATE utf8_bin NOT NULL,
  `art_image` varchar(255) COLLATE utf8_bin DEFAULT '/images/nopic.jpg',
  `art_seo_title` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `art_content` longtext COLLATE utf8_bin,
  `art_content_option1` longtext COLLATE utf8_bin,
  `art_content_option2` longtext COLLATE utf8_bin,
  `art_content_option3` longtext COLLATE utf8_bin,
  `art_tag` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `art_excerpt` text COLLATE utf8_bin COMMENT '文章摘要',
  `art_keywords` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `art_postdate` date NOT NULL,
  `art_readcount` int(11) DEFAULT '50',
  `art_commentcount` int(11) DEFAULT NULL,
  `art_status` bit(1) DEFAULT b'1',
  `art_url` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `recommend` tinyint(2) DEFAULT '0' COMMENT '0默认 1推荐 2特荐 3跳转'
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `skytech_categories`
--

CREATE TABLE IF NOT EXISTS `skytech_categories` (
  `id` int(11) NOT NULL,
  `cate_name` varchar(150) COLLATE utf8_bin NOT NULL,
  `cate_url` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `cate_parent_id` int(11) DEFAULT '0',
  `cate_level` int(11) DEFAULT '1',
  `cate_sort` int(11) DEFAULT '50',
  `cate_is_display` tinyint(1) DEFAULT '1',
  `cate_seo_title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `cate_keywords` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `cate_description` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `cate_list_template` varchar(250) COLLATE utf8_bin DEFAULT 'list',
  `cate_article_templte` varchar(255) COLLATE utf8_bin DEFAULT 'item',
  `cate_topic_templte` varchar(255) COLLATE utf8_bin DEFAULT 'topic',
  `cate_status` tinyint(1) DEFAULT '1',
  `cate_path` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `cate_is_topic` tinyint(4) DEFAULT '0',
  `cate_is_linked` tinyint(1) DEFAULT '0',
  `cate_linked_url` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `skytech_categories_article`
--

CREATE TABLE IF NOT EXISTS `skytech_categories_article` (
  `categorie_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `skytech_cate_navigation`
--

CREATE TABLE IF NOT EXISTS `skytech_cate_navigation` (
  `id` int(11) NOT NULL,
  `cate_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `cate_url` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `cate_parent_id` int(11) DEFAULT '0',
  `cate_level` int(11) DEFAULT NULL,
  `cate_sort` int(11) DEFAULT '50',
  `cate_seo_title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `cate_keywords` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `cate_description` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `cate_path` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `skytech_company`
--

CREATE TABLE IF NOT EXISTS `skytech_company` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '企业标识',
  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '企业名称',
  `description` text COLLATE utf8_bin COMMENT '企业描述',
  `banner` varchar(300) COLLATE utf8_bin DEFAULT NULL COMMENT '头部图片',
  `company_image` varchar(500) COLLATE utf8_bin DEFAULT NULL COMMENT '公司图片',
  `telephone` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `qq` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `skype` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `facebook` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `twitter` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `googeplus` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `linkedin` varchar(500) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `skytech_company`
--

INSERT INTO `skytech_company` (`id`, `uid`, `title`, `description`, `banner`, `company_image`, `telephone`, `address`, `phone`, `email`, `qq`, `skype`, `facebook`, `twitter`, `googeplus`, `linkedin`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `skytech_flinks`
--

CREATE TABLE IF NOT EXISTS `skytech_flinks` (
  `id` int(11) NOT NULL,
  `flink_site` varchar(250) COLLATE utf8_bin NOT NULL,
  `flink_sort` int(5) DEFAULT '10',
  `flink_logo` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `flink_target` tinyint(4) DEFAULT '1',
  `flink_name` varchar(250) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `skytech_flinks`
--

INSERT INTO `skytech_flinks` (`id`, `flink_site`, `flink_sort`, `flink_logo`, `flink_target`, `flink_name`) VALUES
(1, 'http://www.facebook.com', 10, '', 1, 'Facebook'),
(2, 'https://plus.google.com', 10, '', 1, 'Google+'),
(3, 'https://www.linkedin.com/', 10, '', 1, 'Linkedin'),
(4, 'https://twitter.com/', 10, '', 1, 'Twitter'),
(5, 'https://www.skype.com/zh-Hans/', 10, '', 1, 'Skype');

-- --------------------------------------------------------

--
-- 表的结构 `skytech_links`
--

CREATE TABLE IF NOT EXISTS `skytech_links` (
  `id` int(11) NOT NULL,
  `link_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `link_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `link_description` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `skytech_member_info`
--

CREATE TABLE IF NOT EXISTS `skytech_member_info` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '采集对应的用户ID',
  `industry_id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_bin DEFAULT NULL COMMENT '用户登录名',
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `keyword` varchar(250) COLLATE utf8_bin DEFAULT NULL COMMENT '采集对应的关键词',
  `description` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `web_title` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `web_keywords` varchar(500) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `skytech_menu`
--

CREATE TABLE IF NOT EXISTS `skytech_menu` (
  `id` int(11) NOT NULL,
  `menu_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '菜单名称',
  `menu_url` varchar(250) COLLATE utf8_bin NOT NULL COMMENT 'URL',
  `menu_parent_id` int(11) NOT NULL COMMENT '父级菜单',
  `menu_level` tinyint(3) unsigned NOT NULL COMMENT '级别',
  `menu_is_display` bit(1) DEFAULT b'1',
  `menu_sort` int(11) DEFAULT '50',
  `menu_intro` varchar(500) COLLATE utf8_bin DEFAULT NULL COMMENT '简介'
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `skytech_menu`
--

INSERT INTO `skytech_menu` (`id`, `menu_name`, `menu_url`, `menu_parent_id`, `menu_level`, `menu_is_display`, `menu_sort`, `menu_intro`) VALUES
(2, '留言板', '/skytech_admin.php?s=msgboard/index', 0, 1, b'1', 50, ''),
(6, '网站配置', '/skytech_admin.php?s=custmer/config', 0, 1, b'1', 50, NULL),
(8, '用户管理', '', 0, 1, b'1', 50, NULL),
(9, '会员管理', '/skytech_admin.php?s=user/index', 8, 2, b'1', 50, NULL),
(10, '用户组', '/skytech_admin.php?s=user/group', 8, 2, b'1', 50, NULL),
(11, '权限设置', '/skytech_admin.php?s=user/set', 8, 3, b'0', 50, NULL),
(12, '修改状态', '/skytech_admin.php?s=user/change', 8, 3, b'0', 50, NULL),
(15, '栏目管理', '/skytech_admin.php?s=categories/index', 0, 1, b'1', 50, NULL),
(16, '文章管理', '/skytech_admin.php?s=article/index', 0, 1, b'1', 50, NULL),
(17, '标签管理', '/skytech_admin.php?s=tag/index', 0, 1, b'1', 50, NULL),
(18, '添加栏目', '/skytech_admin.php?s=categories/addOrUpdateCate', 15, 2, b'0', 50, NULL),
(19, '删除栏目', '/skytech_admin.php?s=categories/delete', 15, 2, b'0', 50, NULL),
(20, '网站详情', '/skytech_admin.php?s=custmer/info', 6, 3, b'0', 50, NULL),
(21, '企业详情', '/skytech_admin.php?s=company/info', 7, 3, b'0', 50, NULL),
(24, '更新企业详情', '/skytech_admin.php?s=company/update', 7, 3, b'0', 50, NULL),
(25, '更新网站详情', '/skytech_admin.php?s=custmer/update', 6, 3, b'0', 50, NULL),
(26, '添加或修改文章', '/skytech_admin.php?s=article/addOrUpdate', 16, 2, b'0', 50, NULL),
(27, '删除文章', '/skytech_admin.php?s=article/delete', 16, 2, b'0', 50, NULL),
(28, '专题管理', '/skytech_admin.php?s=topic/index', 0, 1, b'1', 50, NULL),
(29, '专题修改/添加', '/skytech_admin.php?s=topic/addOrUpdate', 28, 2, b'0', 50, NULL),
(30, '专题删除', '/skytech_admin.php?s=topic/delete', 28, 2, b'0', 50, NULL),
(31, '生成更新', '/skytech_admin.php?s=static/index', 0, 1, b'1', 50, NULL),
(32, '网站地图', '/skytech_admin.php?s=sitemap/index', 0, 1, b'1', 50, NULL),
(33, '添加用户', '/skytech_admin.php?s=user/addOrUpdate', 9, 3, b'0', 50, NULL),
(34, '查看留言', '/skytech_admin.php?s=msgboard/info', 2, 3, b'0', 50, NULL),
(35, '删除留言', '/skytech_admin.php?s=msgboard/delete', 2, 3, b'0', 50, NULL),
(36, '批量添加栏目', '/skytech_admin.php?s=categories/batchAdd', 15, 2, b'0', 50, NULL),
(37, '媒体链接', '/skytech_admin.php?s=company/flinks', 0, 1, b'1', 50, NULL),
(38, '添加或修改媒体链接', '/skytech_admin.php?s=company/addOrUpdateFlinks', 37, 2, b'0', 50, NULL),
(39, '删除媒体链接', '/skytech_admin.php?s=company/deleteFlinks', 37, 2, b'0', 50, NULL),
(40, '模板管理', '/skytech_admin.php?s=template/index', 0, 1, b'1', 50, NULL),
(41, '模板详情', '/skytech_admin.php?s=template/template', 40, 2, b'0', 50, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `skytech_msgboard`
--

CREATE TABLE IF NOT EXISTS `skytech_msgboard` (
  `id` int(11) NOT NULL,
  `msg_company` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `msg_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `msg_product` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `msg_email` varchar(100) COLLATE utf8_bin NOT NULL,
  `msg_fax` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `msg_phone` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `msg_date` datetime DEFAULT NULL,
  `msg_country` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `msg_city` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `msg_address` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `msg_comments` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `msg_status` bit(1) DEFAULT b'1',
  `msg_public` int(1) DEFAULT '0',
  `msg_from` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '来自哪个客户网站的留言',
  `msg_isread` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `skytech_purchase`
--

CREATE TABLE IF NOT EXISTS `skytech_purchase` (
  `id` int(11) NOT NULL,
  `purchase_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `purchase_channel` int(11) NOT NULL COMMENT '采集数据来源网站',
  `purchase_quantity` varchar(250) COLLATE utf8_bin NOT NULL COMMENT '采购数量',
  `purchase_post_date` date DEFAULT NULL COMMENT '发布时间',
  `purchase_quote_left` int(11) DEFAULT NULL COMMENT '报价左',
  `purchase_valid_date` date DEFAULT NULL COMMENT '有效期至',
  `purchase_request` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '采购源国家',
  `purchase_description` varchar(2000) COLLATE utf8_bin DEFAULT NULL COMMENT '采购描述',
  `purchase_url` varchar(180) COLLATE utf8_bin DEFAULT NULL COMMENT '采购源地址',
  `purchase_time` datetime DEFAULT NULL,
  `purchase_for_id` int(11) NOT NULL COMMENT '为哪个客户采集'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `skytech_relation`
--

CREATE TABLE IF NOT EXISTS `skytech_relation` (
  `role_id` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `skytech_relation`
--

INSERT INTO `skytech_relation` (`role_id`, `menu_id`) VALUES
(1, 2),
(1, 6),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(2, 2),
(2, 6),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 34),
(2, 35),
(2, 37),
(2, 38),
(2, 39),
(3, 6),
(3, 15),
(3, 16),
(3, 17),
(3, 20),
(3, 25),
(3, 28),
(3, 32);

-- --------------------------------------------------------

--
-- 表的结构 `skytech_role`
--

CREATE TABLE IF NOT EXISTS `skytech_role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(250) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `skytech_role`
--

INSERT INTO `skytech_role` (`id`, `role_name`) VALUES
(1, '超级管理员'),
(2, '栏目管理员'),
(3, '信息发布员');

-- --------------------------------------------------------

--
-- 表的结构 `skytech_topic`
--

CREATE TABLE IF NOT EXISTS `skytech_topic` (
  `id` int(11) NOT NULL,
  `topic_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `topic_title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `topic_content` longtext COLLATE utf8_bin,
  `topic_content_option1` longtext COLLATE utf8_bin,
  `topic_content_option2` longtext COLLATE utf8_bin,
  `topic_author` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `topic_img` varchar(255) COLLATE utf8_bin DEFAULT '/images/nopic.jpg',
  `topic_seo_title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `topic_keywords` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `topic_postdate` date DEFAULT NULL,
  `topic_description` text COLLATE utf8_bin,
  `topic_status` int(1) DEFAULT '1',
  `topic_url` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `topic_templte` varchar(100) COLLATE utf8_bin DEFAULT 'topic',
  `topic_readcount` int(11) DEFAULT '50'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `skytech_user`
--

CREATE TABLE IF NOT EXISTS `skytech_user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) COLLATE utf8_bin NOT NULL,
  `user_password` varchar(100) COLLATE utf8_bin NOT NULL,
  `user_role` int(11) NOT NULL,
  `rigister_time` datetime NOT NULL,
  `status` bit(1) DEFAULT b'1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `skytech_user`
--

INSERT INTO `skytech_user` (`id`, `user_name`, `user_password`, `user_role`, `rigister_time`, `status`) VALUES
(1, 'skytech', 'a048d83498fb39db6d03c0042c407c0a', 1, '2016-06-02 11:47:03', b'1');

-- --------------------------------------------------------

--
-- 表的结构 `skytech_web_info`
--

CREATE TABLE IF NOT EXISTS `skytech_web_info` (
  `industry` varchar(250) COLLATE utf8_bin NOT NULL,
  `id` int(11) NOT NULL,
  `description` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `web_title` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `web_keywords` varchar(500) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `sky_tag`
--

CREATE TABLE IF NOT EXISTS `sky_tag` (
  `id` int(11) NOT NULL,
  `tag_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `tag_num` int(11) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `sky_tag_relation`
--

CREATE TABLE IF NOT EXISTS `sky_tag_relation` (
  `id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `skytech_article`
--
ALTER TABLE `skytech_article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skytech_categories`
--
ALTER TABLE `skytech_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skytech_categories_article`
--
ALTER TABLE `skytech_categories_article`
  ADD PRIMARY KEY (`categorie_id`,`article_id`);

--
-- Indexes for table `skytech_cate_navigation`
--
ALTER TABLE `skytech_cate_navigation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skytech_company`
--
ALTER TABLE `skytech_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skytech_flinks`
--
ALTER TABLE `skytech_flinks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skytech_links`
--
ALTER TABLE `skytech_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skytech_member_info`
--
ALTER TABLE `skytech_member_info`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `skytech_menu`
--
ALTER TABLE `skytech_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skytech_msgboard`
--
ALTER TABLE `skytech_msgboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skytech_purchase`
--
ALTER TABLE `skytech_purchase`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `purchase_url` (`purchase_url`);

--
-- Indexes for table `skytech_relation`
--
ALTER TABLE `skytech_relation`
  ADD UNIQUE KEY `role_id` (`role_id`,`menu_id`);

--
-- Indexes for table `skytech_role`
--
ALTER TABLE `skytech_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skytech_topic`
--
ALTER TABLE `skytech_topic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skytech_user`
--
ALTER TABLE `skytech_user`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `skytech_web_info`
--
ALTER TABLE `skytech_web_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sky_tag`
--
ALTER TABLE `sky_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sky_tag_relation`
--
ALTER TABLE `sky_tag_relation`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `tag_id` (`tag_id`,`article_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `skytech_article`
--
ALTER TABLE `skytech_article`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `skytech_categories`
--
ALTER TABLE `skytech_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `skytech_cate_navigation`
--
ALTER TABLE `skytech_cate_navigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `skytech_company`
--
ALTER TABLE `skytech_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `skytech_flinks`
--
ALTER TABLE `skytech_flinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `skytech_links`
--
ALTER TABLE `skytech_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `skytech_member_info`
--
ALTER TABLE `skytech_member_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `skytech_menu`
--
ALTER TABLE `skytech_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `skytech_msgboard`
--
ALTER TABLE `skytech_msgboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `skytech_purchase`
--
ALTER TABLE `skytech_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `skytech_role`
--
ALTER TABLE `skytech_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `skytech_user`
--
ALTER TABLE `skytech_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `skytech_web_info`
--
ALTER TABLE `skytech_web_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sky_tag`
--
ALTER TABLE `sky_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `sky_tag_relation`
--
ALTER TABLE `sky_tag_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
