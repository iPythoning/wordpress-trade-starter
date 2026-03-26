# WordPress 外贸独立站一键部署模板

[English](README.md) | 中文

> 面向外贸企业的 WordPress 独立站生产级模板。Docker 一键部署，性能优化，多语言开箱即用。

```
                    ┌─────────────┐
                    │  Cloudflare  │  CDN + WAF + SSL
                    │   (免费版)    │
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │    Nginx     │  反向代理 + 缓存 + Gzip
                    │   :80/:443  │
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │  WordPress   │  6.7 + Apache
                    │   + 插件     │  Super Cache / Imagify / Rank Math
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │   MySQL 8    │  持久化存储
                    └─────────────┘
```

## 特性

- **一键部署** — `setup.sh` 自动安装 Docker、申请 SSL 证书、配置 Nginx
- **三层缓存** — WP Super Cache + Nginx 代理缓存 + Cloudflare CDN
- **自动 WebP** — Imagify 转换图片，Nginx/Apache 自动为支持的浏览器提供 WebP
- **SEO 就绪** — Rank Math 结构化数据、XML 站点地图、Open Graph
- **多语言** — Polylang 多语言支持（中/英/俄/西/...）
- **安全加固** — 全站 HTTPS、禁用文件编辑器、Cloudflare WAF
- **实战验证** — 已在真实的 B2B 半挂车制造商网站上验证

## 快速开始（5 分钟）

### 前置条件

- Linux 服务器（推荐 Ubuntu 22.04+），最低 1核 / 1GB 内存
- 域名并可管理 DNS

### 部署

```bash
git clone https://github.com/iPythoning/wordpress-trade-starter.git
cd wordpress-trade-starter
cp .env.example .env        # 编辑你的域名和密码
sudo bash setup.sh
```

完成后打开 `https://你的域名/wp-admin` 进行 WordPress 初始化设置。

## 文档目录

| # | 主题 | 说明 |
|---|------|------|
| 01 | [服务器选购](docs/01-server-setup.md) | 服务器选择与初始化配置 |
| 02 | [Docker 部署](docs/02-docker-deploy.md) | 使用 Docker Compose 部署 WordPress |
| 03 | [SSL 证书](docs/03-ssl-https.md) | Let's Encrypt 证书申请与配置 |
| 04 | [WordPress 配置](docs/04-wordpress-setup.md) | WordPress 基础设置 |
| 05 | [主题与插件](docs/05-theme-plugins.md) | 推荐主题和插件组合 |
| 06 | [多语言](docs/06-multilingual.md) | Polylang 多语言配置 |
| 07 | [SEO 优化](docs/07-seo-optimization.md) | Rank Math SEO 优化指南 |
| 08 | [性能优化](docs/08-performance.md) | 完整性能优化攻略 |
| 09 | [Cloudflare](docs/09-cloudflare.md) | Cloudflare CDN 配置 |
| 10 | [安全加固](docs/10-security.md) | 安全加固清单 |
| 11 | [日常运维](docs/11-maintenance.md) | 日常维护与监控 |

## 推荐插件

| 插件 | 用途 | 免费？ |
|------|------|--------|
| Astra | 轻量主题，兼容 Elementor | 是 |
| Elementor | 可视化页面构建器 | 部分免费 |
| Rank Math | SEO（站点地图、结构化数据、Meta） | 是 |
| WP Super Cache | 页面缓存 | 是 |
| Imagify | 图片优化 + WebP 转换 | 部分免费 |
| Jetpack Boost | Critical CSS、懒加载 | 是 |
| Polylang | 多语言内容管理 | 是 |
| Contact Form 7 | 联系表单 | 是 |
| Chaty | WhatsApp / 在线聊天小部件 | 部分免费 |
| eCommerce Product Catalog | 产品展示（无需 WooCommerce） | 是 |

## 性能数据

在 1核 / 1GB VPS + Cloudflare 免费版上的测试结果：

| 指标 | 优化前 | 优化后 |
|------|--------|--------|
| PageSpeed Desktop | 45 | 78+ |
| TTFB | 1.8s | 0.3s |
| LCP | 4.2s | 2.1s |
| 页面总大小 | 3.2MB | 1.1MB |

## 适用人群

- **外贸企业** — 制造商、出口商、贸易公司建设 B2B 网站
- **WordPress 新手** — 想要一个生产级的起点
- **开发者** — 为国际客户部署 WordPress 站点

## 贡献

欢迎提 Issue 和 PR！

## 许可证

[MIT](LICENSE)

---

**基于 [TitanPuls.com](https://titanpuls.com) 的实战经验** — 一家服务 50+ 国家的半挂车制造商。
