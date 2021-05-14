FROM nginx:stable
ARG MAX_EXECUTION_TIME
ARG SERVER_NAME

# Configure Nginx
ADD nginx.conf /etc/nginx/
RUN sed "/fastcgi_read_timeout 60s;/c\  fastcgi_read_timeout ${MAX_EXECUTION_TIME}s;" -i /etc/nginx/nginx.conf
ADD symfony.conf /etc/nginx/sites-available/
RUN sed "/server_name symfony.dev;/c\  server_name ${SERVER_NAME};" -i /etc/nginx/sites-available/symfony.conf
RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf
RUN usermod -u 1000 www-data

# Configure the virtual host
RUN mkdir -p /etc/nginx/sites-enabled
RUN ln -s /etc/nginx/sites-available/symfony.conf /etc/nginx/sites-enabled/symfony.conf
RUN rm /etc/nginx/conf.d/default.conf

# Expose ports
EXPOSE 80
EXPOSE 443

CMD ["nginx", "-g", "daemon off;"]