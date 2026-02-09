# WPQiNiu 七牛云对象存储插件

WordPress 七牛云对象存储插件，将网站附件（图片、文件）自动同步到七牛云对象存储，实现静态资源与网站分离，提升网站加载速度。

## 功能特点

- **自动同步**：上传到媒体库的附件自动同步至七牛云
- **自定义域名**：支持 CDN 加速域名，可自定义存储目录
- **多站点共用**：一个存储桶可多网站使用，通过目录区分
- **自动重命名**：上传时自动重命名，避免中文或重复文件名问题
- **本地可选**：支持仅存云端或本地+云端双备份
- **禁止缩略图**：可一键禁止生成缩略图，仅上传原图
- **MIME 正确**：上传时自动设置正确 MIME 类型，七牛云中图片可正常预览
- **移动端适配**：设置页在移动端自动隐藏侧边栏

## 环境要求

| 项目 | 要求 |
|------|------|
| WordPress | 5.3 及以上 |
| PHP | 7.4 及以上（含 PHP 8.x） |
| 七牛云 | 需已开通对象存储空间 |

## 安装

1. 将 `wpqiniu` 文件夹上传到 `/wp-content/plugins/` 目录
2. 在 WordPress 后台 **插件** 列表中激活插件
3. 进入 **设置** → **七牛云存储设置** 进行配置

## 配置说明

在插件设置页面需要填写：

| 配置项 | 说明 |
|--------|------|
| 存储空间名称 | 七牛云对象存储的 Bucket 名称 |
| 融合 CDN 加速域名 | 自定义域名，如 `https://cdn.example.com`，不要以 `/` 结尾 |
| AccessKey | 七牛云控制台 → 密钥管理 |
| SecretKey | 七牛云控制台 → 密钥管理 |
| 自动重命名 | 上传时自动重命名，格式：`时间戳+随机数.扩展名` |
| 不在本地保存 | 勾选后仅上传到七牛，不保留本地副本 |
| 禁止缩略图 | 勾选后不生成 WordPress 缩略图，仅上传原图 |

## 目录结构

```
wpqiniu/
├── api.php          # 七牛 API 封装
├── index.php        # 插件主入口
├── setting.php      # 设置页面
├── uninstall.php    # 卸载清理
├── sdk/             # 七牛官方 PHP SDK
├── layui/           # 前端 UI 框架
└── README.md
```

## 常见问题

**Q: 图片上传后七牛控制台能看到但无法预览？**  
A: 5.0 版本已修复此问题，上传时会正确设置 MIME 类型。

**Q: 已有网站如何迁移？**  
A: 先用插件上传新附件测试，确认无误后，将本地 `wp-content/uploads` 目录上传到七牛对应路径，可使用 [Kodo Browser](https://developer.qiniu.com/kodo/tools) 工具批量上传。

**Q: 升级前建议？**  
A: 5.0 版本移除了图片编辑和一键替换功能，建议升级前备份网站和数据库。

## 安全说明

- 上传 Token 缓存于 `wp-content/cache/wpqiniu/`，该目录通过 `.htaccess` 禁止 Web 访问
- 使用 Nginx 需在站点配置中单独添加：
  ```nginx
  location ~ ^/wp-content/cache/wpqiniu/ {
      deny all;
  }
  ```

## 更新日志

### 5.0
- 要求 PHP 7.4+，兼容 PHP 8.x
- 修复上传 MIME 类型，解决七牛云图片无法预览
- 移除图片编辑、一键替换功能
- Token 缓存移至 `wp-content/cache`，并添加访问保护

## 许可证

GPL v2 或更高版本

## 插件团队和技术支持

[乐在云](https://www.lezaiyun.com/)（老蒋和他的伙伴们），本着资源共享原则，在运营网站过程中用到的或者是有需要用到的主题、插件资源，有选择的免费分享给广大的网友站长，希望能够帮助到你建站过程中提高效率。

感谢团队成员，以及网友提出的优化工具的建议，才有后续产品的不断迭代适合且满足用户需要。不能确保100%的符合兼容网站，我们也仅能做到在工作之余不断的接近和满足你的需要。

| 类目            | 信息                                                         |
| --------------- | ------------------------------------------------------------ |
| 插件更新地址    | https://www.lezaiyun.com/1097.html                           |
| 团队成员        | [老蒋](https://www.laojiang.me/)、老赵、[CNJOEL](https://www.rakvps.com/)、木村 |
| 支持网站        | 乐在云、主机评价网、老蒋玩主机                               |
| 建站资源推荐    | [便宜VPS推荐](https://www.zhujipingjia.com/pianyivps.html)、[美国VPS推荐](https://www.zhujipingjia.com/uscn2gia.html)、[外贸建站主机](https://www.zhujipingjia.com/wordpress-hosting.html)、[SSL证书推荐](https://www.zhujipingjia.com/two-ssls.html)、[WordPress主机推荐](https://www.zhujipingjia.com/wpblog-host.html) |
| 提交WP官网（F） | https://cn.wordpress.org/plugins/wpqiniu/                    |

![](wechat.png)
