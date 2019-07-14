FROM percona:5.7

# make root user for /mount access
USER root

RUN mkdir -p /mount/mysql-keyring/ \
    && touch /mount/mysql-keyring/keyring \
    && chown -R mysql:mysql /mount/mysql-keyring

USER mysql

COPY etc/ /etc/mysql/conf.d/
