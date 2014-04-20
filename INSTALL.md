# Installation Guide
There are a few dependencies, when we install the foodsharing software.
Here you will find our installation notes for different Plattforms

## Base Dependencies
- Nginx or Apache Webserver
- PHP 5.4+
- MongoDB 2.6+

## Debian Wheezy 7.1
At the Moment our developement server is an Debian Machin, wo here we go.

### System Update
First of all we will update our system.
´´´
apt-get update
apt-get upgrade
´´´
### Install Nginx Webserver
Nginx is available as a package for Debian Wheezy which we can install as follows.
´´´
apt-get install nginx
´´´
now lets start the webserver
´´´
service nginx start
´´´
To check if the webserver is running type in your web server's IP address or hostname into a browser *(e.g. http://192.168.0.100)*, and you will see something like "Welcome to nginx"
### Install PHP
Install PHP5 with very basicly extensions
´´´
apt-get install php5 php5-fpm php-pear php5-common php5-mcrypt php5-mysql php5-cli php5-gd php5-dev
´´´
### Configure Nginx
Nginx virtual host files are located by default at /etc/nginx/sites-available
´´´
cd /etc/nginx/sites-available
´´´
backup default config
´´´
mv default old.default
´´´
edit our own config file
´´´shell
vi default
´´´
basic configuration to put in there
´´´
server {
        listen   80; ## listen for ipv4; this line is default and implied
        listen   [::]:80 default_server ipv6only=on; ## listen for ipv6

        root /var/www/public;
        index index.php index.html index.htm;

        # Make site accessible from http://localhost/ or any other hostname
        server_name localhost;

        location / {
                # First attempt to serve request as file      
                try_files $uri $uri/ /index.html;
        }

        location /doc/ {
                alias /usr/share/doc/;
                autoindex on;
                allow 127.0.0.1;
                allow ::1;
                deny all;
        }

        #error_page 404 /404.html;

        # redirect server error pages to the static page /50x.html
        #
        error_page 500 502 503 504 /50x.html;
        location = /50x.html {
                root /usr/share/nginx/www;
        }

        # pass the PHP scripts to FastCGI server                            
        location ~ \.php$ {
                try_files $uri =404;
                fastcgi_split_path_info ^(.+\.php)(/.+)$;
                fastcgi_pass unix:/var/run/php5-fpm.sock;
                fastcgi_index index.php;
                include fastcgi_params;
        }

        # deny access to .htaccess files, if Apache's document root
        location ~ /\.ht {
                deny all;
        }
}

´´´
restart the webserver
´´´shell
service nginx restart
´´´
## Install MongoDB
Import the public key used by the package management system and install mongodb package
´´´shell
echo 'deb http://downloads-distro.mongodb.org/repo/debian-sysvinit dist 10gen' | tee /etc/apt/sources.list.d/mongodb.list
apt-get update
apt-get install mongodb-org
´´´
## Intall Mongo PHP Extension
install make
´´´shell
apt-get install make
´´´
install mongodb extension with pecl
´´´shell
pecl install mongo
´´´
add extension to php.ini
´´´shell
vi /etc/php5/fpm/php.ini
´´´
add this line to the end of php.ini
´´´shell
extension = mongo.so
´´´
and save it!
Now restart php-fpm wrapper
´´´shell
service php5-fpm restart
´´´
go to document root, install git and clean up
´´´shell
cd /var/www
rm -rf ./*
apt-get install git
´´´
and clone the source code into current document root directory
´´´shell
git clone https://github.com/Unity-Sharing/foodsharing-2.0.git .
´´´
make directories and chmod it
´´´shell
mkdir /var/www/tmp
mkdir /var/www/public/img
chmod 775 /var/www/tmp
chmod 775 /var/www/public/img
´´´
run install script
´´´shell
cd /var/www/public
php install.php
chmod 775 /var/www/tmp -R
´´´
Thats it! Point your Browser to host address IP address will not be working wit this setup! *( e.g. http://localhost/ )*
