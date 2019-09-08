<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## 安装方法
1.在bt面板新建一个网站，伪静态选择laravel，环境版本php7.3+ mysql5.7，首先安装composer并设置淘宝镜像：
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/


如果出错，需要根据出错的信息，安装php相应扩展，或开启相应函数。一般遇到的要安装的扩展：fileinfo和openssl，开启openlog函数。
安装成功后，查看版本信息：
composer -v


2. 克隆git-hub上的项目到网站目录，再将网站的文件全部授权www:www以755权限。
git clone https://github.com/datangkang123/jiancebgcx.git
复制代码
如果没有git，先安装：
yun install git


3.复制根目录下的 .env.example 文件并重命名为 .env，修改里面的网址和数据库信息

APP_URL=http://blog.dzbfsj.com
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=数据库名
DB_USERNAME=数据库用户名
DB_PASSWORD=数据库密码


4.执行安装命令
composer install
复制代码

5.生成 APP_KEY 并自动写入到 .env 文件中的

php artisan key:generate


6.生成数据库：
php artisan migrate


7.如果有测试数据，则执行数据填充（默认不要执行）
php artisan db:seed ;


安装完毕，这时可以访问了。
