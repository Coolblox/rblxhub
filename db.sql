-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 12, 2021 at 06:17 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id16177648_rblxhubdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `abuse_reports`
--

CREATE TABLE `abuse_reports` (
  `id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL,
  `target_type` varchar(255) NOT NULL,
  `reporter` int(11) NOT NULL,
  `comment` varchar(2048) NOT NULL,
  `time_reported` int(11) NOT NULL,
  `status` enum('PENDING','MODERATED','IGNORED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `name_file` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `avatar_cache`
--

CREATE TABLE `avatar_cache` (
  `id` int(11) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `head_color` int(14) NOT NULL,
  `torso_color` int(14) NOT NULL,
  `leftarm_color` int(14) NOT NULL,
  `rightarm_color` int(14) NOT NULL,
  `leftleg_color` int(14) NOT NULL,
  `rightleg_color` int(14) NOT NULL,
  `hatid1` int(14) NOT NULL,
  `hatid2` int(14) NOT NULL,
  `hatid3` int(14) NOT NULL,
  `faceid` int(14) NOT NULL,
  `toolid` int(14) NOT NULL,
  `shirtid` int(14) NOT NULL,
  `pantsid` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bans`
--

CREATE TABLE `bans` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `userid` int(14) NOT NULL,
  `moderator` int(14) NOT NULL,
  `reason` varchar(4096) NOT NULL,
  `unbantime` bigint(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `bantype` enum('reminder','warning','1dayban','3dayban','7dayban','14dayban','deleteaccount','hwidban','ipban') NOT NULL,
  `unbanned` tinyint(1) NOT NULL,
  `note` varchar(4096) NOT NULL DEFAULT '',
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

CREATE TABLE `blocked_users` (
  `id` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bodycolors`
--

CREATE TABLE `bodycolors` (
  `color_id` int(11) NOT NULL,
  `hex_color` varchar(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `catalog`
--

CREATE TABLE `catalog` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(1024) NOT NULL DEFAULT '',
  `creator` int(14) NOT NULL,
  `creator_type` enum('User','Guild') NOT NULL DEFAULT 'User',
  `currency` enum('Robux','Tickets') NOT NULL DEFAULT 'Robux',
  `price` bigint(255) NOT NULL DEFAULT 0,
  `time_created` int(14) NOT NULL,
  `sales` int(11) NOT NULL DEFAULT 0,
  `favourites` int(11) NOT NULL DEFAULT 0,
  `type` varchar(255) NOT NULL,
  `moderation_status` enum('PENDING','ACCEPTED','REJECTED') NOT NULL DEFAULT 'PENDING',
  `is_limited` tinyint(1) NOT NULL DEFAULT 0,
  `total_stock` int(50) NOT NULL DEFAULT 0,
  `time_updated` int(14) NOT NULL,
  `onsale_until` int(11) NOT NULL DEFAULT 0,
  `updated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `userid` int(14) NOT NULL,
  `assetid` int(14) NOT NULL,
  `content` varchar(256) NOT NULL,
  `time_posted` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `discord_verify`
--

CREATE TABLE `discord_verify` (
  `id` int(11) NOT NULL,
  `token` varchar(256) NOT NULL,
  `discord_id` varchar(255) NOT NULL,
  `linked_account` int(11) DEFAULT NULL,
  `time_created` int(11) NOT NULL,
  `unlinked` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `id` int(11) NOT NULL,
  `author` int(14) NOT NULL,
  `reply_to` int(14) NOT NULL,
  `title` varchar(64) CHARACTER SET utf8mb4 NOT NULL,
  `content` varchar(8192) CHARACTER SET utf8mb4 NOT NULL,
  `time_posted` bigint(255) NOT NULL,
  `category` int(14) NOT NULL,
  `is_pinned` int(11) NOT NULL DEFAULT 0,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `is_important` tinyint(1) NOT NULL DEFAULT 0,
  `is_announcement` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum_groups`
--

CREATE TABLE `forum_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

CREATE TABLE `forum_topics` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `parent` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `forum_views`
--

CREATE TABLE `forum_views` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_from` int(14) NOT NULL,
  `user_to` int(14) NOT NULL,
  `arefriends` tinyint(1) NOT NULL,
  `hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `gamehashes`
--

CREATE TABLE `gamehashes` (
  `id` int(11) NOT NULL,
  `gameid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL DEFAULT 'localhost',
  `port` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `creator_id` int(15) NOT NULL,
  `name` varchar(48) NOT NULL,
  `description` varchar(512) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `port` int(5) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `playing` int(14) NOT NULL DEFAULT 0,
  `last_ping` int(14) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ip_bans`
--

CREATE TABLE `ip_bans` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `join_tokens`
--

CREATE TABLE `join_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `gameid` int(14) NOT NULL,
  `userid` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `limited_sales`
--

CREATE TABLE `limited_sales` (
  `id` int(14) NOT NULL,
  `item_id` int(14) NOT NULL,
  `price` int(14) NOT NULL,
  `time` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `id` int(11) NOT NULL,
  `user_id` int(14) NOT NULL,
  `ip` varchar(256) NOT NULL,
  `username` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_from` int(14) NOT NULL,
  `user_to` int(14) NOT NULL,
  `subject` varchar(64) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `datesent` int(14) NOT NULL,
  `readfrom` tinyint(1) NOT NULL DEFAULT 0,
  `readto` tinyint(1) NOT NULL DEFAULT 0,
  `deletefrom` tinyint(1) NOT NULL DEFAULT 0,
  `deleteto` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `on_sale_limiteds`
--

CREATE TABLE `on_sale_limiteds` (
  `id` int(11) NOT NULL,
  `item_id` int(14) NOT NULL,
  `user_id` int(14) NOT NULL,
  `owneditem_id` int(14) NOT NULL,
  `price` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `owneditems`
--

CREATE TABLE `owneditems` (
  `id` int(11) NOT NULL,
  `assetid` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `serial` int(14) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `owned_achievements`
--

CREATE TABLE `owned_achievements` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `achievement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pageviews`
--

CREATE TABLE `pageviews` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `userid` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `txnid` varchar(255) NOT NULL,
  `payment_amount` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `itemid` varchar(255) NOT NULL,
  `createdtime` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `placehostrequests`
--

CREATE TABLE `placehostrequests` (
  `id` int(14) NOT NULL,
  `gameid` int(14) NOT NULL,
  `year` varchar(7) NOT NULL,
  `instance_id` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `placeshutdownrequests`
--

CREATE TABLE `placeshutdownrequests` (
  `id` int(11) NOT NULL,
  `processid` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_from` int(14) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `time_posted` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `post_reactions`
--

CREATE TABLE `post_reactions` (
  `id` int(11) NOT NULL,
  `userid` int(14) NOT NULL,
  `postid` int(14) NOT NULL,
  `reaction` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rblxhub_jobs`
--

CREATE TABLE `rblxhub_jobs` (
  `id` int(11) NOT NULL,
  `userid` int(14) NOT NULL,
  `time` int(14) NOT NULL,
  `content` varchar(4096) NOT NULL,
  `position` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `recover_account_tokens`
--

CREATE TABLE `recover_account_tokens` (
  `id` int(11) NOT NULL,
  `userid` int(14) NOT NULL,
  `token` varchar(255) NOT NULL,
  `time_sent` int(14) NOT NULL,
  `recovered` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reset_compromised_tokens`
--

CREATE TABLE `reset_compromised_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `userid` int(14) NOT NULL,
  `time_sent` int(14) NOT NULL,
  `finished` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE `servers` (
  `id` int(11) NOT NULL,
  `gameid` int(14) NOT NULL,
  `port` int(14) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `player_count` int(14) NOT NULL,
  `in_game` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `session_tokens`
--

CREATE TABLE `session_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `user_id` int(14) NOT NULL,
  `ip_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `value` varchar(4096) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `thumbnailchangerequests`
--

CREATE TABLE `thumbnailchangerequests` (
  `id` int(11) NOT NULL,
  `type` enum('Avatar','Place','Hat','Shirt','Pant','Model','Misc') NOT NULL,
  `indicator` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `thumbnailque`
--

CREATE TABLE `thumbnailque` (
  `userid` int(11) NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trades`
--

CREATE TABLE `trades` (
  `id` int(11) NOT NULL,
  `user_from` int(14) NOT NULL,
  `user_to` int(14) NOT NULL,
  `f1` int(14) NOT NULL,
  `f2` int(14) NOT NULL,
  `f3` int(14) NOT NULL,
  `f4` int(14) NOT NULL,
  `t1` int(14) NOT NULL,
  `t2` int(14) NOT NULL,
  `t3` int(14) NOT NULL,
  `t4` int(14) NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('PENDING','DENIED','COMPLETED','ERROR') NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trade_currency`
--

CREATE TABLE `trade_currency` (
  `id` int(11) NOT NULL,
  `userid` int(14) NOT NULL,
  `amount` bigint(255) NOT NULL,
  `ratio` float NOT NULL,
  `offered_currency` enum('Robux','Tickets') NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL,
  `target_type` enum('User','Guild') NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` enum('User','Guild') NOT NULL,
  `amount` bigint(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `currency` enum('Robux','Tickets') NOT NULL,
  `time` int(14) NOT NULL,
  `type` enum('ADD','REMOVE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `underthirteen` tinyint(1) NOT NULL DEFAULT 0,
  `supersafechat` tinyint(1) NOT NULL DEFAULT 0,
  `time_joined` int(14) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `robux` bigint(255) NOT NULL DEFAULT 0,
  `tickets` bigint(255) NOT NULL DEFAULT 15,
  `avatar_hash` varchar(255) NOT NULL DEFAULT 'f8a2247dbf239836d3f645559ae6ab71',
  `lastseen` int(14) NOT NULL DEFAULT 0,
  `description` varchar(512) NOT NULL DEFAULT '',
  `next_tix_reward` int(16) NOT NULL DEFAULT 0,
  `next_bricks_award` int(255) NOT NULL DEFAULT 0,
  `permission_level` enum('DEFAULT','ASSET_MODERATOR','ASSET_UPLOADER','ADMINISTRATOR') NOT NULL DEFAULT 'DEFAULT',
  `membership_type` enum('NONE','LEVEL_1','LEVEL_2','LEVEL_3','PRO') NOT NULL DEFAULT 'NONE',
  `membership_expire_time` bigint(255) UNSIGNED NOT NULL DEFAULT 1,
  `is_banned` tinyint(1) NOT NULL DEFAULT 0,
  `site_theme` varchar(255) NOT NULL DEFAULT 'light',
  `discord_token` varchar(255) NOT NULL DEFAULT 'UNDEFINED',
  `discord_uid` varchar(255) NOT NULL DEFAULT 'UNDEFINED',
  `auth` varchar(256) NOT NULL DEFAULT 'UNDEFINED',
  `has_game_access` tinyint(1) NOT NULL DEFAULT 0,
  `remove_ads` tinyint(1) NOT NULL DEFAULT 0,
  `vpn_mode` tinyint(1) NOT NULL DEFAULT 0,
  `failed_login_attempts` int(14) NOT NULL DEFAULT 0,
  `compromised` tinyint(1) NOT NULL DEFAULT 0,
  `experience` bigint(255) UNSIGNED NOT NULL DEFAULT 0,
  `lastlevel` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `beta_tester` tinyint(1) NOT NULL DEFAULT 0,
  `referer` int(11) DEFAULT 0,
  `referral_code` int(11) DEFAULT NULL,
  `membership_refers` int(11) NOT NULL DEFAULT 0,
  `adblock_lastping` int(11) NOT NULL DEFAULT 0,
  `adblock_exception` tinyint(1) NOT NULL DEFAULT 0,
  `ugc_eligible` tinyint(1) NOT NULL DEFAULT 0,
  `super_mod` tinyint(1) NOT NULL DEFAULT 0,
  `image_mod` tinyint(1) NOT NULL DEFAULT 0,
  `forum_mod` tinyint(1) NOT NULL DEFAULT 0,
  `maintenance_access` tinyint(1) NOT NULL DEFAULT 0,
  `imgTime` int(128) NOT NULL DEFAULT 0,
  `avatarurl` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_action_log`
--

CREATE TABLE `user_action_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action_type` enum('REGISTER','LOGIN','PURCHASE_ITEM','UPDATE_AVATAR','POST_COMMENT','POST_FORUM_THREAD','POST_FORUM_REPLY','CREATE_GAME','CREATE_ASSET','ADD_FRIEND','SEND_MESSAGE','CHANGE_PASSWORD','CHANGE_USERNAME','CHANGE_DESCRIPTION','RECOVERED_ACCOUNT','RECOVERED_ACCOUNT_COMPROMISED','CONVERTED_CURRENCY','JOINED_ORGANIZATION','CREATED_ORGANIZATION','CREATED_ROLE_ORGANIZATION','MODIFIED_ROLE_ORGANIZATION','MODIFIED_USER_ORGANIZATION') NOT NULL,
  `info` varchar(4096) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL,
  `user_from` int(14) NOT NULL,
  `user_to` int(14) NOT NULL,
  `message` varchar(256) NOT NULL,
  `time` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wall`
--

CREATE TABLE `wall` (
  `id` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `time_posted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abuse_reports`
--
ALTER TABLE `abuse_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_file` (`name_file`);

--
-- Indexes for table `avatar_cache`
--
ALTER TABLE `avatar_cache`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bodycolors`
--
ALTER TABLE `bodycolors`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discord_verify`
--
ALTER TABLE `discord_verify`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_groups`
--
ALTER TABLE `forum_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_topics`
--
ALTER TABLE `forum_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_views`
--
ALTER TABLE `forum_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gamehashes`
--
ALTER TABLE `gamehashes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ip_bans`
--
ALTER TABLE `ip_bans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `join_tokens`
--
ALTER TABLE `join_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `limited_sales`
--
ALTER TABLE `limited_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `on_sale_limiteds`
--
ALTER TABLE `on_sale_limiteds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owneditems`
--
ALTER TABLE `owneditems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owned_achievements`
--
ALTER TABLE `owned_achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pageviews`
--
ALTER TABLE `pageviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `placehostrequests`
--
ALTER TABLE `placehostrequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `placeshutdownrequests`
--
ALTER TABLE `placeshutdownrequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_reactions`
--
ALTER TABLE `post_reactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rblxhub_jobs`
--
ALTER TABLE `rblxhub_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recover_account_tokens`
--
ALTER TABLE `recover_account_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_compromised_tokens`
--
ALTER TABLE `reset_compromised_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session_tokens`
--
ALTER TABLE `session_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thumbnailchangerequests`
--
ALTER TABLE `thumbnailchangerequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trades`
--
ALTER TABLE `trades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trade_currency`
--
ALTER TABLE `trade_currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referral_code` (`referral_code`);

--
-- Indexes for table `user_action_log`
--
ALTER TABLE `user_action_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wall`
--
ALTER TABLE `wall`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abuse_reports`
--
ALTER TABLE `abuse_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `avatar_cache`
--
ALTER TABLE `avatar_cache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bans`
--
ALTER TABLE `bans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blocked_users`
--
ALTER TABLE `blocked_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discord_verify`
--
ALTER TABLE `discord_verify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_groups`
--
ALTER TABLE `forum_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_topics`
--
ALTER TABLE `forum_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_views`
--
ALTER TABLE `forum_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamehashes`
--
ALTER TABLE `gamehashes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_bans`
--
ALTER TABLE `ip_bans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `join_tokens`
--
ALTER TABLE `join_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `limited_sales`
--
ALTER TABLE `limited_sales`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `on_sale_limiteds`
--
ALTER TABLE `on_sale_limiteds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owneditems`
--
ALTER TABLE `owneditems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owned_achievements`
--
ALTER TABLE `owned_achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pageviews`
--
ALTER TABLE `pageviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `placehostrequests`
--
ALTER TABLE `placehostrequests`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `placeshutdownrequests`
--
ALTER TABLE `placeshutdownrequests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_reactions`
--
ALTER TABLE `post_reactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rblxhub_jobs`
--
ALTER TABLE `rblxhub_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recover_account_tokens`
--
ALTER TABLE `recover_account_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reset_compromised_tokens`
--
ALTER TABLE `reset_compromised_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `session_tokens`
--
ALTER TABLE `session_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thumbnailchangerequests`
--
ALTER TABLE `thumbnailchangerequests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trades`
--
ALTER TABLE `trades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trade_currency`
--
ALTER TABLE `trade_currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_action_log`
--
ALTER TABLE `user_action_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wall`
--
ALTER TABLE `wall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
