FROM nginx:1.25

COPY nginx.conf /etc/nginx/
COPY upstream.conf /etc/nginx/conf.d/
COPY default.conf /etc/nginx/conf.d/

CMD ["nginx", "-g", "daemon off;"]

RUN usermod -u 1000 www-data

WORKDIR /var/www/project