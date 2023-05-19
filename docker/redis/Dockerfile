FROM redis:alpine

RUN mkdir -p /usr/local/etc/redis
COPY docker/redis/config/redis.conf /usr/local/etc/redis/redis.conf

VOLUME /data

EXPOSE 6379

CMD ["redis-server", "/usr/local/etc/redis/redis.conf"]
