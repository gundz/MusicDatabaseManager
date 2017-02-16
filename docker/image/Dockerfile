FROM php:7-fpm
	
	ENV LANG C.UTF-8
	
	RUN apt-get update
	RUN apt-get install -y mediainfo
	RUN echo "log_errors = On\nerror_log = /dev/stderr\n" >> "/usr/local/etc/php/php.ini"
