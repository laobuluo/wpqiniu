<?php
//	if(version_compare(PHP_VERSION,'5.3.0', '<')){
//		echo '当前版本为'.phpversion().'小于5.3.0哦';
//	}else {
//		echo '当前版本为' . PHP_VERSION . '大于5.3.0';
//	}
	require 'sdk/autoload.php';
	
	use \Qiniu\Auth;
	use \Qiniu\Storage\UploadManager;	// 引入上传类
	use \Qiniu\Storage\BucketManager;


	class QiNiuApi
	{
		// 用于签名的公钥和私钥
		private $bucket;  // = 'laojiang';
		private $token_expires = 3600;  // Token 的超时时间。
		protected $auth;
		private $cache_path;

		public function __construct($option) {
			$this->bucket = $option['bucket'];
			// 初始化签权对象
			$this->auth = new Auth($option['accessKey'], $option['secretKey']);

			// 使用 wp-content/cache 目录，避免 token 文件被直接访问
			$cache_dir = defined('WP_CONTENT_DIR') ? WP_CONTENT_DIR . '/cache/wpqiniu/' : plugin_dir_path(__FILE__);
			if ($cache_dir !== plugin_dir_path(__FILE__)) {
				if (!file_exists($cache_dir)) {
					wp_mkdir_p($cache_dir);
					file_put_contents($cache_dir . 'index.php', '<?php // Silence is golden');
				}
				// 禁止通过 Web 访问 cache 目录（Apache）
				$htaccess_file = $cache_dir . '.htaccess';
				if (!file_exists($htaccess_file)) {
					$htaccess = "<IfModule mod_authz_core.c>\nRequire all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\nOrder deny,allow\nDeny from all\n</IfModule>";
					@file_put_contents($htaccess_file, $htaccess);
				}
			}
			$this->cache_path = $cache_dir . 'access_token.json';
		}

		public function uploadToken() {
			$uploadToken = (file_exists($this->cache_path)) ? json_decode(file_get_contents($this->cache_path), true) : null;
			$c_time = time();
			if (empty($uploadToken) or empty($uploadToken['access_token']) or $c_time > $uploadToken['expires']) {
				$token = $this->auth->uploadToken($this->bucket, null, $this->token_expires);
				$uploadToken = [
				    'access_token' => $token,
                    'expires'      => $c_time + 3600,
                ];
				file_put_contents($this->cache_path, json_encode($uploadToken), LOCK_EX);
			}
			return $uploadToken['access_token'];
		}

		public function Upload($key, $localFilePath) {
			// 构建鉴权对象
			// 生成上传 Token
			$token = $this->uploadToken();

			// 获取正确的 MIME 类型，否则七牛会存储为 application/octet-stream 导致图片无法预览
			$mimeType = $this->getFileMimeType($localFilePath);

			// 初始化 UploadManager 对象并进行文件的上传。
			$uploadMgr = new UploadManager();
			// 调用 UploadManager 的 putFile 方法进行文件的上传，传入正确的 MIME 类型
			list($ret, $err) = $uploadMgr->putFile($token, $key, $localFilePath, null, $mimeType);
			if ($err !== null) {
//				var_dump($err);
				return False;
			} else {
//				var_dump($ret);
				return True;
			}
		}

		public function Delete($keys) {
			$config = new \Qiniu\Config();
			$bucketManager = new BucketManager($this->auth, $config);
			//每次最多不能超过1000个
			$ops = $bucketManager->buildBatchDelete($this->bucket, $keys);
			list($ret, $err) = $bucketManager->batch($ops);
			if ($err) {
//				print_r($err);
				return False;
			} else {
//				print_r($ret);
				return True;
			}
		}

		/**
		 * 获取文件的 MIME 类型，确保上传到七牛后图片可正确预览
		 * @param string $filePath 本地文件路径
		 * @return string MIME 类型
		 */
		private function getFileMimeType($filePath) {
			if (!file_exists($filePath)) {
				return 'application/octet-stream';
			}
			// 优先使用 finfo 检测（最准确）
			if (function_exists('finfo_open')) {
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				if ($finfo) {
					$mime = finfo_file($finfo, $filePath);
					finfo_close($finfo);
					if ($mime && $mime !== 'application/octet-stream') {
						return $mime;
					}
				}
			}
			// 备用：WordPress 的 wp_check_filetype 根据扩展名判断
			if (function_exists('wp_check_filetype')) {
				$wpType = wp_check_filetype($filePath, null);
				if (!empty($wpType['type'])) {
					return $wpType['type'];
				}
			}
			// 最终备用：常见图片扩展名映射
			$ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
			$mimeMap = array(
				'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'jpe' => 'image/jpeg',
				'gif' => 'image/gif', 'png' => 'image/png', 'bmp' => 'image/bmp',
				'tiff' => 'image/tiff', 'tif' => 'image/tiff', 'ico' => 'image/x-icon',
				'webp' => 'image/webp', 'svg' => 'image/svg+xml',
			);
			return isset($mimeMap[$ext]) ? $mimeMap[$ext] : 'application/octet-stream';
		}

		public function hasExist($key) {
			$config = new \Qiniu\Config();
			$bucketManager = new \Qiniu\Storage\BucketManager($this->auth, $config);
			list($fileInfo, $err) = $bucketManager->stat($this->bucket, $key);
			if ($err) {
//				print_r($err);
				return False;
			} else {
//				print_r($fileInfo);
				return True;
			}
		}

	}
