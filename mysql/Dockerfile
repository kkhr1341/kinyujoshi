FROM mysql:5.6

COPY ./my.cnf /etc/mysql/conf.d/

COPY db.sql /docker-entrypoint-initdb.d/prepare.sql