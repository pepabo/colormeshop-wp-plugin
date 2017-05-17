FROM wordpress:php7.0

RUN apt-get update \
 && apt-get -y install subversion \
 && apt-get -y install mysql-client; \
 rm -rf /var/lib/apt/lists/*
