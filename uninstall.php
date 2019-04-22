<?php
/**
 * Created by PhpStorm.
 * User: zdl
 * Date: 2019/3/21
 * Time: 10:50
 */
if(!defined('WP_UNINSTALL_PLUGIN')){
	// 如果 uninstall 不是从 WordPress 调用，则退出
	exit();
}

$wpqiniu_options = get_option('wpqiniu_options');
update_option('upload_path', $wpqiniu_options['upload_information']['wpqiniu']['upload_path']);
update_option('upload_url_path', $wpqiniu_options['upload_information']['wpqiniu']['upload_url_path']);
// 从 options 表删除选项
delete_option( 'wpqiniu_options' );