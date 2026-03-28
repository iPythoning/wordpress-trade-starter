# WordPress 外贸独立站一键部署模板

[![Clawhub](https://img.shields.io/badge/Clawhub-wordpress--trade--site-blue)](https://clawhub.ai/ipythoning/wordpress-trade-site)

**[English](README.md) | 中文**

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

## AI 引导式部署（通过 OpenClaw）

安装 Clawhub 技能，AI Agent 交互式引导你完成 9 个阶段的全流程部署：

```bash
clawhub install wordpress-trade-site
```

安装后告诉你的 OpenClaw Agent：**"帮我建一个外贸独立站"** — 它会从服务器准备一路引导到最终验收。

| 阶段 | 内容 | 耗时 |
|------|------|------|
| 1. 业务信息收集 | 公司名称、产品、目标市场、语言、联系方式 | 2 min |
| 2. 服务器准备 | SSH 连接、防火墙、swap、时区 | 5 min |
| 3. Docker 部署 | Clone 模板、生成 .env、启动三容器 | 3 min |
| 4. SSL 证书 | Let's Encrypt 或 Cloudflare Origin 证书 | 3 min |
| 5. WordPress 初始化 | 安装向导、wp-config、Permalinks | 3 min |
| 6. 主题与插件 | Astra + 10 款推荐插件批量安装 | 5 min |
| 7. 多语言 + SEO | Polylang 多语言、Rank Math SEO、基础页面 | 5 min |
| 8. Cloudflare + 性能 | DNS、SSL/TLS、三层缓存、PageSpeed 测试 | 5 min |
| 9. 安全加固 + 验收 | 文件权限、xmlrpc 封堵、备份、监控 | 5 min |

**约 35 分钟**，从零到生产就绪。

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

### 手动部署

如果你希望手动控制每个步骤，参见 [docs/02-docker-deploy.md](docs/02-docker-deploy.md)。

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
| 12 | [GEO 优化](docs/12-geo-optimization.md) | AI 搜索引擎优化（引用度、llms.txt、Schema） |

## 推荐插件

| 插件 | 用途 | 免费？ |
|------|------|--------|
| [Astra](https://wpastra.com/) | 轻量主题，兼容 Elementor | 是 |
| [Elementor](https://elementor.com/) | 可视化页面构建器 | 部分免费 |
| [Rank Math](https://rankmath.com/) | SEO（站点地图、结构化数据、Meta） | 是 |
| [WP Super Cache](https://wordpress.org/plugins/wp-super-cache/) | 页面缓存 | 是 |
| [Imagify](https://imagify.io/) | 图片优化 + WebP 转换 | 部分免费 |
| [Jetpack Boost](https://jetpack.com/boost/) | Critical CSS、懒加载 | 是 |
| [Polylang](https://polylang.pro/) | 多语言内容管理 | 是 |
| [Contact Form 7](https://contactform7.com/) | 联系表单 | 是 |
| [Flamingo](https://wordpress.org/plugins/flamingo/) | CF7 表单提交存入后台（防丢失） | 是 |
| [Chaty](https://premio.io/downloads/chaty/) | WhatsApp / 在线聊天小部件 | 部分免费 |
| [eCommerce Product Catalog](https://implecode.com/) | 产品展示（无需 WooCommerce） | 是 |

## 性能数据

在 1核 / 1GB VPS + Cloudflare 免费版上的测试结果：

| 指标 | 优化前 | 优化后 |
|------|--------|--------|
| PageSpeed Desktop | 45 | 78+ |
| TTFB | 1.8s | 0.3s |
| LCP | 4.2s | 2.1s |
| 页面总大小 | 3.2MB | 1.1MB |

## 文件结构

```
├── docker-compose.yml    # Docker 编排（WordPress + MySQL + Nginx）
├── nginx.conf            # Nginx：SSL、代理缓存、Gzip、WebP、Cloudflare
├── .htaccess             # Apache：Super Cache、浏览器缓存、WebP、Gzip
├── wp-config-extra.php   # wp-config.php 额外配置
├── setup.sh              # 一键部署脚本
├── .env.example          # 环境变量模板
├── skill/                # OpenClaw Clawhub 技能
└── docs/                 # 11 篇文档
```

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
