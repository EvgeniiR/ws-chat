FROM debian:stretch
RUN apt-get update && apt-get install -y nginx vim nano
COPY nginx.conf /etc/nginx/nginx.conf
ADD sites-enabled /etc/nginx/sites-enabled
RUN rm /etc/nginx/sites-enabled/default
WORKDIR /var/www/html/symfony
EXPOSE 80
EXPOSE 443
CMD ["nginx"]
