# Docker

## Build 1 service php (https://hub.docker.com/_/php), 1 serivce nginx (https://hub.docker.com/_/nginx) để cho thể show được trang php info lên web bằng docker


```
server {
        listen 80;
	    server_name localhost;
        root /public_html;

        location / {
            index index.php index.html;
        }

        location ~* \.php$ {
            fastcgi_pass    php:9000;
            fastcgi_index   index.php;
            include         fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param PATH_INFO $fastcgi_path_info;
            }
}
```


```
version: '3'

services:
     web:
       image: nginx:alpine
       ports:
           - "8080:80"
       volumes:
           - ./public_html:/public_html
           - ./conf.d:/etc/nginx/conf.d
           - /etc/localtime:/etc/localtime
       networks:
           - nginxphp

     php:
       image: php:7.1.11-fpm-alpine
       volumes:
           - ./public_html:/public_html
       expose:
           - 9000
       networks:
           - nginxphp

networks:
     nginxphp:
```

```
- sudo docker-compose up -d
```

![](./images/docker1.png)

Ket qua:

![](./images/docker2.png)

## Thêm 1 service mysql (https://hub.docker.com/_/mysql), viết một chương trình php connect đến service mysql

Sửa file docker-compose.yml
```
version: '3'

services:
  web:
    image: nginx:alpine
    ports:
      - "8080:80"
    volumes:
      - ./public_html:/public_html
      - ./conf.d:/etc/nginx/conf.d
      - /etc/localtime:/etc/localtime
    networks:
      - nginxphp

  php:
    image: php:7.1.11-fpm-alpine
    volumes:
      - ./public_html:/public_html
    expose:
      - 9000
    networks:
      - nginxphp

  mysql:
    image: mysql:latest
    ports:
      - "3306:3306"
    environment: 
      - MYSQL_ROOT_PASSWORD=password

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    links:
      - mysql:db
    ports:
      - "8082:80"
    environment:
      - PMA_USER=root
      - PMA_PASSWORD=password
      - PHP_UPLOAD_MAX_FILESIZE=100MB

networks:
  nginxphp:
```

```
- sudo docker-compose up -d
```

Kết quả

![](./images/mysql.png)