### 简介

一个Laravel的商城项目，目前实现了书籍，购物车，订单等基础功能。

### 本地安装

获取源码。

	git clone https://github.com/hi-phper/Store.git
	
进入项目目录。

	cd Store
	
安装项目依赖。

	composer install

创建.env文件。

	cp .env.example .env

生成APP Key

	php artisan key:generate

创建MySQL数据库。

	mysql -u root -p
	CREATE DATABASE store;

编辑.env文件,根据本地数据库配置情况修改。

	DB_HOST=localhost
	DB_DATABASE=数据库名称
	DB_USERNAME=用户名
	DB_PASSWORD=密码

运行数据迁移和数据填充。

	php artisan migrate
	php artisan db:seed

启动测试服务器。

	php artisan serve

网站访问地址为 http://localhost:8000

后台管理地址为 http://localhost:8000/admin

默认已创建一个普通用户，和一个管理员。

普通用户信息如下：

	用户名 user
	邮箱 user@user.com
	密码 user

管理员信息如下：

	用户名 admin
	邮箱 admin@admin.com
	密码 admin
