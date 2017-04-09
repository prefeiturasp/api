server {
server_name {{ app.vhost.server_name }};
root "{{ app.base_path }}/current/web";

location / {
    try_files $uri /index.php$is_args$args;
}

location ~ ^/index\.php(/|$) {
    fastcgi_pass   unix:/var/run/php/php{{ php.version }}-fpm.sock;

    fastcgi_split_path_info ^(.+\.php)(/.*)$;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    fastcgi_param DOCUMENT_ROOT $realpath_root;
}

location ~ \.php$ {
    return 404;
}

error_log /var/log/nginx/{{ app.vhost.server_name }}_error.log;
access_log /var/log/nginx/{{ app.vhost.server_name }}_access.log;
}