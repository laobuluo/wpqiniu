=== WPQiNiu七牛云对象存储 ===

Contributors: laobuluo
Donate link: https://www.lezaiyun.com/donate/
Tags:WordPress对象存储,七牛对象存储,七牛云存储WordPress,七牛WordPress,七牛加速WordPress,WordPress加速
Requires at least: 5.3
Tested up to: 6.9.1
Stable tag: 5.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WordPress 七牛云对象存储（简称:WPQiNiu），基于七牛云对象存储与WordPress实现静态资源到对象存储中，让静态资源包括图片、附件分离WordPress根目录，提高网站打开速度。

== Description ==

WordPress 七牛云对象存储（简称:WPQiNiu），基于七牛云对象存储与WordPress实现静态资源到对象存储中，让静态资源包括图片、附件分离WordPress根目录，提高网站打开速度。

## 插件特点

1. 支持自定义域名设置
2. 支持一键禁止缩略图
3. 支持自定义任意对象存储目录，一个存储桶可以多网站
4. 支持自动文件重命名
5. 支持本地和对象存储分离和同步
6. 上传时正确设置 MIME 类型，确保七牛云中图片可正常预览
7. 兼容 PHP 7.4 及 PHP 8.x 版本

七牛云对象存储插件安装方法：[https://www.lezaiyun.com/1097.html](https://www.lezaiyun.com/1097.html)

## 网站支持

* [老蒋玩运营](https://www.laojiang.me/ "老蒋玩运营")

* [乐在云工作室](https://www.lezaiyun.com/ "乐在云工作室")

* 欢迎加入插件和站长微信公众号：老蒋朋友圈（公众号）

== Installation ==

* 1、把wpqiniu文件夹上传到/wp-content/plugins/目录下<br />
* 2、在后台插件列表中激活wpqiniu<br />
* 3、在左侧【设置】-【七牛对象存储设置】菜单中输入七牛云对象存储空间名称、自定义域名、API信息。<br />

== Frequently Asked Questions ==

* 1.当发现插件出错时，开启调试获取错误信息。
* 2.我们可以选择备份对象存储或者本地同时备份。
* 3.如果已有网站使用wpqiniu，插件调试没有问题之后，需要将原有本地静态资源上传到七牛云对象存储中，然后修改数据库原有固定静态文件链接路径。、
* 4.如果不熟悉使用这类插件的用户，一定要先备份，确保错误设置导致网站故障。

== Screenshots ==

1. screenshot-1.png

== Changelog ==

= 5.0 =
* 要求 PHP 7.4 及以上版本，兼容 PHP 8.x
* 修复上传时 MIME 类型未设置导致七牛云图片无法预览的问题
* 移除图片编辑（数据万象）功能
* 移除一键替换七牛对象存储地址功能
* 优化安全性：Token 缓存移至 wp-content/cache、表单 Nonce 校验改进
* 修复 key_handler 在空 URL 时的 PHP 8 兼容性
* 修复多处 PHP 7.4/8.x 兼容性问题

= 4.9 =
* 检测兼容WP6.2
* 修复php8.2启动报错

= 4.8 =
* 检测兼容WP6.1

= 4.7 =
* 检测兼容WP5.9.3

= 4.6 =
* 检测兼容WP5.7

= 4.5 =
* 微调部分功能优化
* 检测兼容WP5.6

= 4.4 =
* 微调部分功能优化
* 检测兼容WP5.5.1

= 4.3 =
* 修复上传超时问题
* 检测兼容WP5.5

= 4.2 =
* 重构插件前端 体验更友好
* 优化细节问题 修复说明文档

= 4.1 =
* 又拍云对象存储插件新年定稿
* 支持图片处理功能
* 优化速度和文档说明

= 3.1 =
* 调试兼容最新WP5.4.2
* 重写前端代码
* 测试兼容最新3.0新功能，发布

= 3.0 =
* 重构全部插件代码，优化逻辑结构，执行效率更高
* 新增图片编辑、压缩、裁剪等 采用七牛云存储接口
* 新增重命名、禁止缩略图等功能

= 1.2.1 =
* 更新CSS样式极简风格
* 准备重构插件代码
* 检测支持WP5.4

= 1.2.2 =
* 兼容WP5.4.1测试

= 1.1 =
* 感谢网友emerge同学提出来解决删除媒体库小图不删除问题

= 1.0 =
* 检查是否支持WP5.3
* 修复新版本WP5.3的图片处理逻辑

= 0.9 =
* 在完成WPCOS、WPOSS等传统云存储插件之后，有网友呼吁开发一个七牛云对象存储的。
* 根据已有项目的结构和用户体验设计，老赵完成WPQINIU插件的设计。
* 体验实际功能可以确保插件的完整性，但是可能会有与其他插件或者主题冲突。

== Upgrade Notice ==

= 5.0 =
* 重要更新：要求 PHP 7.4+，修复图片预览问题，移除图片编辑和一键替换功能。建议升级前备份。 