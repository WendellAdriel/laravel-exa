FROM nginx:alpine

WORKDIR /app

COPY ./public/swagger .

COPY ./docker/swagger/config/nginx.conf /etc/nginx/nginx.conf
