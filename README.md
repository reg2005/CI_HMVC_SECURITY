# CI_HMVC_SECURITY
This is my version assembly Codeigniter and HMVC extension. My package used Composer.
Package have components:
<ul>
  <li>Codeigniter</li>
  <li>HMVC extension (for module structure)</li>
  <li>Bootstrap</li>
  <li>Smarty Parser</li>
  <li>Beutiful debug helper d([]) by raveren/kint</li>
  <li>Eloquent ORM</li>
  <li>Jquery</li>
  <li>JqueryUI</li>
</ul>

<h1>How to use:</h1>
Just configurate your web-server to folder: /public.

<h1>Nginx example config:</h1>
```
server {
        listen   80;
        root /home/user/project/public;
        index index.php;
		    server_name crmci.test;
		    client_max_body_size 100m;

		    # access_log  /home/user/logs/nginx.access.log;
		    error_log  /home/user/logs/nginx.error.log;

        location / {

                 try_files $uri $uri/ /index.php;
        }

        #error_page 500 502 503 504 /50x.html;
        location = /50x.html {
                root /usr/share/nginx/www;
        }




  	location ~ \.php$ {
                try_files $uri =404;
                fastcgi_split_path_info ^(.+\.php)(/.+)$;
                fastcgi_pass 127.0.0.1:9000;
                fastcgi_index index.php;
                include fastcgi_params;

		        #Bug fix big header from codeigniter
            		fastcgi_buffer_size 128k;
            		fastcgi_buffers 256 16k;
            		fastcgi_busy_buffers_size 256k;
            
            		fastcgi_connect_timeout 60;
            		fastcgi_send_timeout 180;
            		fastcgi_read_timeout 180;
            		fastcgi_max_temp_file_size 0;
            		fastcgi_temp_file_write_size 256k;
            		fastcgi_intercept_errors on;
    }

    location ~ /\.ht {
                deny all;
    }
}
```
