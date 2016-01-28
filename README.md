# AAPF
Async API Proxy FrameWork With PHP-Yaf and PHP-Yar

# Support Rpc | Api Type

 - RESTFul
 - Yar
 - 

# Install

```shell
    
    pecl install yaf
    
    pecl install yar
    
    pecl install seaslog
    
    pecl install soap

```


# Configure with Httpd

```
<VirtualHost *:80>
    DocumentRoot "/data/www/aapf/AAPF/src/public"
    ServerName dev.aapfdemo.com

	<Directory />
		Options FollowSymLinks
		AllowOverride None
	</Directory>
	<Directory /data/www/aapf/AAPF/src/public>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride all
		Order allow,deny
		allow from all
	</Directory>

    ErrorLog "/usr/local/var/log/apache2/aapf-error_log"
    CustomLog "/usr/local/var/log/apache2/aapf-access_log" common
</VirtualHost>
```


# Client Demo

```
    php examples/ClientDemo.php
    
    
    Array
    (
        [code] => 1000
        [msg] => success
        [data] => Array
            (
                [ip_result] => {"ret":1,"start":-1,"end":-1,"country":"\u4e2d\u56fd","province":"\u6cb3\u5317","city":"\u5eca\u574a","district":"","isp":"","type":"","desc":""}
                [sub_result] => 15
                [add_result] => 30
            )
    
    )
```