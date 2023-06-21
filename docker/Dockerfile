FROM httpd:latest
WORKDIR /var/www/
RUN mkdir apcs
COPY .. /apcs

FROM mysql:8.0
RUN mysql -u root
