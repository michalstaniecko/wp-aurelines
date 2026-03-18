FROM wordpress:latest
COPY aurelines/ /var/www/html/wp-content/themes/aurelines/
COPY .htaccess /var/www/html/.htaccess

RUN mkdir -p /var/www/html/wp-content/uploads \
    && chown -R www-data:www-data /var/www/html/wp-content/uploads \
    && chmod -R 755 /var/www/html/wp-content/uploads
