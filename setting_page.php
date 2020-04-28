<?php
/**
 *  插件设置页面
 */
function wpqiniu_setting_page() {
// 如果当前用户权限不足
	if (!current_user_can('manage_options')) {
		wp_die('Insufficient privileges!');
	}

	$wpqiniu_options = get_option('wpqiniu_options');
	if ($wpqiniu_options && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce']) && !empty($_POST)) {
		if($_POST['type'] == 'cos_info_set') {
			$wpqiniu_options['no_local_file'] = (isset($_POST['no_local_file'])) ? True : False;
			$wpqiniu_options['bucket'] = (isset($_POST['bucket'])) ? sanitize_text_field(trim(stripslashes($_POST['bucket']))) : '';
			$wpqiniu_options['accessKey'] = (isset($_POST['accessKey'])) ? sanitize_text_field(trim(stripslashes($_POST['accessKey']))) : '';
			$wpqiniu_options['secretKey'] = (isset($_POST['secretKey'])) ? sanitize_text_field(trim(stripslashes($_POST['secretKey']))) : '';

			// 不管结果变没变，有提交则直接以提交的数据 更新wpqiniu_options
			update_option('wpqiniu_options', $wpqiniu_options);

			# 替换 upload_url_path 的值
			update_option('upload_url_path', esc_url_raw(trim(trim(stripslashes($_POST['upload_url_path'])))));

			?>
             <div class="notice notice-success settings-error is-dismissible"><p><strong>设置已保存。</strong></p></div>

			<?php

		}
}

?>

   
<div class="wrap">
    <h1 class="wp-heading-inline">WPQiNiu - WordPress + 七牛对象存储设置</h1> <a href="https://www.laobuluo.com/2591.html" target="_blank"class="page-title-action">插件介绍</a>
        <hr class="wp-header-end">        
    
        <p>WordPress 七牛（简称:WPQiNiu），基于七牛云存储与WordPress实现静态资源到对象存储中。</p>
         <p>快速导航：七牛云存储付费充值专属优惠码：<font color="red"><b>19345821</b></font>。<a href="https://www.itbulu.com/qiniu-recharge.html" target="_blank">查看详细使用指南</a> / 站长QQ群： <a href="https://jq.qq.com/?_wv=1027&k=5IpUNWK" target="_blank"> <font color="red">1012423279</font></a>（交流建站和运营） / 公众号：QQ69377078（插件反馈）</p>   
        
     <hr/>
    <form action="<?php echo wp_nonce_url('./admin.php?page=' . WPQiNiu_BASEFOLDER . '/actions.php'); ?>" name="wpcosform" method="post">
        <table class="form-table">
            <tr>
                <th scope="row">
                       存储空间名称
                    </th>
               
                <td>
                    <input type="text" name="bucket" value="<?php echo esc_attr($wpqiniu_options['bucket']); ?>" size="50"
                           placeholder="七牛对象存储空间名称"/>

                    <p>1. 需要在七牛云对象存储创建存储空间。</p>
                    <p>2. 示范： <code>laobuluo</code></p>
                </td>
            </tr>

            <tr>
                 <th scope="row">
                       融合CDN加速域名
                    </th>
               
                <td>
                    <input type="text" name="upload_url_path" value="<?php echo esc_url(get_option('upload_url_path')); ?>" size="50"
                           placeholder="融合CDN加速域名"/>

                    <p><b>设置注意事项：</b></p>

                    <p>1. 输入我们自定义的域名，比如：<code>http（https）://{自定义域名}</code>，不要用"/"结尾。</p>
                    <p>2. 七牛云存储绑定域名需要ICP备案后才可以添加。</p>
                  
                </td>
            </tr>

            <tr>
                   <th scope="row">
                       AccessKey 参数
                    </th>
                
                <td><input type="text" name="accessKey" value="<?php echo esc_attr($wpqiniu_options['accessKey']); ?>" size="50" placeholder="accessKey"/></td>
            </tr>
            <tr>
                 <th scope="row">
                      SecretKey 参数
                    </th>
               
                <td>
                    <input type="text" name="secretKey" value="<?php echo esc_attr($wpqiniu_options['secretKey']); ?>" size="50" placeholder="secretKey"/>
                    <p>登入 <a href="https://portal.qiniu.com/user/key" target="_blank">密钥管理</a> 可以看到 <code>  AccessKey/SecretKey</code>。如果没有设置的需要创建一组。</p>
                </td>
            </tr>
            <tr>
                   <th scope="row">
                     不在本地保存
                    </th>
                
                <td>
                    <input type="checkbox"
                           name="no_local_file"
                        <?php
                            if ($wpqiniu_options['no_local_file']) {
                                echo 'checked="TRUE"';
                            }
					    ?>
                    />

                    <p>如果不想同步在服务器中备份静态文件就 "勾选"。我个人喜欢只存储在七牛云存储中，这样缓解服务器存储量。</p>
                </td>
            </tr>
            
            <tr>
                <th>
                    
                </th>
                <td><input type="submit" name="submit" value="保存设置" class="button button-primary" /></td>

            </tr>
        </table>
        
        <input type="hidden" name="type" value="cos_info_set">
    </form>
    <p><b>插件注意事项：</b></p>
    <p>1. 如果我们有多个网站需要使用WPQiNiu插件，需要给每一个网站设置一个对象存储，独立空间名。</p>
    <p>2. 使用WPQiNiu插件分离图片、附件文件，存储在七牛云存储空间根目录，比如：2019、2018、2017这样的直接目录，不会有wp-content这样目录。</p>
    <p>3. 如果我们已运行网站需要使用WPQiNiu插件，插件激活之后，需要将本地wp-content目录中的文件对应时间目录上传至七牛存储空间中，且需要在数据库替换静态文件路径生效。</p>
    

    <hr>
        <div style='text-align:center;line-height: 50px;'>
            <a href="https://www.laobuluo.com/" target="_blank">插件主页</a> | <a href="https://www.laobuluo.com/2591.html" target="_blank">插件发布页面</a> | <a href="https://jq.qq.com/?_wv=1027&k=5IpUNWK" target="_blank">QQ群：1012423279</a> | 公众号：QQ69377078（插件反馈）

        </div>
</div>
<?php
}
?>