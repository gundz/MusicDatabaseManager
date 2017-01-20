FROM nginx

	COPY html /usr/share/nginx/html
	COPY default.conf /etc/nginx/conf.d/default.conf
	RUN apt-get update
	RUN apt-get install -y mediainfo