ALTER TABLE `tbl_advertising_campaign` ADD COLUMN `site_category_id` int UNSIGNED NOT NULL AFTER `sponsor_id`;
ALTER TABLE tbl_sites DROP ftp_username;
ALTER TABLE tbl_sites DROP ftp_password;
ALTER TABLE tbl_sites DROP ftp_port;
ALTER TABLE tbl_sites DROP ftp_server;
ALTER TABLE tbl_sites DROP ftp_path;
ALTER TABLE tbl_sites DROP configuration;
ALTER TABLE tbl_sites DROP admin_username;
ALTER TABLE tbl_sites DROP admin_password;
--aug 16, 8:23 am
ALTER TABLE `agsacom`.`tbl_video_categories` DROP COLUMN `adv`,
 DROP COLUMN `has_image`,
 ADD COLUMN `image_name` varchar(50)  NOT NULL AFTER `parent_cat_id`;


