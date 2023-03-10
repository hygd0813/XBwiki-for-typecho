## XBwiki-Theme-For-Typecho

XBwiki Theme 是一款 使用说明 / 帮助文件 / WIKI文档使用的Typecho主题，由技术小白开发，故取名 `XBwiki` 。

![ppuPrvD.png](https://s1.ax1x.com/2023/03/10/ppuPrvD.png)

## 注意

1. 启用主题前需要在`typecho_metas`表添加字段 `iconfont`

SQL语句如下：

<code>
ALTER TABLE typecho_metas ADD  iconfont varchar(20) DEFAULT 'fa-bars';
</code>

2. 修改程序文件（可选项，需修改程序文件）

> 替换程序文件1： admin/manage-categories.php

> 替换程序文件2：var/Widget/Metas/Category/Edit.php

## 亮点功能：

- 自适应PC端和手机端
- 自带主题搜索功能（JS版）
- 自定义栏目主题图标（可选项，需修改程序文件）
- 顶栏菜单固定置顶
- 傻瓜式制作帮助说明文件
- 支持MarkDown语法
- 支持代码高亮
- 支持代码文字一键复制
- 内置字体图标Font-Awesome（共675个字体图标）
- 丰富的后台主题设置
- 动静态文件分离，方便CDN加速

## 使用环境

本主题主要在 `Typecho1.2` ，`PHP7.2` ，`MYSQL5.7` 环境下开发测试，其他环境请自行测试，若有问题，联系作者(hygd0813@qq.com)。

## 演示地址

https://wiki.80srz.com

## 更新记录

- 2023/3/4 开始开发发布 V1.1 版；
- 2023/3/10 更新 V1.2 版；


