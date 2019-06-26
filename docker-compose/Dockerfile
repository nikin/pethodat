FROM debian:9-slim

RUN export DEBIAN_FRONTEND=noninteractive &&\
    apt-get -yq update && apt-get -yq upgrade &&\
    apt-get -yq install busybox-static \ 
                        net-tools \
                        sudo \
                        parallel \
                        \
                        imagemagick \
                        \
                        lighttpd \
                        php-cgi \
                        php-mysql \
                        libterm-readline-perl-perl \
                        \
                        php-xdebug \
                        graphviz \
                        \
                        mariadb-server \
                        mariadb-client \
                        && \
    apt-get clean autoclean &&\
    apt-get autoremove --yes &&\
    rm -rf /var/lib/{apt,dpkg,cache,log}/

RUN useradd pethodat &&\ 
    echo "pethodat:pethodat" | chpasswd &&\ 
    usermod -a -G sudo pethodat &&\
    mkdir -p /home/pethodat &&\ 
    chown -R pethodat:pethodat /home/pethodat

COPY lighttpd.conf /etc/lighttpd/lighttpd.conf
COPY etc_init.d_lighttpd /etc/init.d/lighttpd
COPY etc_php_7.0_cgi_php.ini /etc/php/7.0/cgi/php.ini
COPY etc_php_7.0_mods-available_xdebug.ini /etc/php/7.0/mods-available/xdebug.ini

RUN mkdir -p /var/run/lighttpd &&\
    mkdir -p /var/cache/lighttpd/uploads &&\
    touch /var/run/lighttpd.pid &&\
    chown pethodat:pethodat /var/run/lighttpd.pid &&\
    chown -R pethodat:pethodat /var/run/lighttpd &&\
    chown -R pethodat:pethodat /var/log/lighttpd &&\
    chown -R pethodat:pethodat /var/cache/lighttpd &&\
    rm -rf /var/www/* &&\
    chmod a+rx /var/www &&\ 
    chown -R pethodat:pethodat /var/www &&\
    lighttpd-enable-mod fastcgi-php

EXPOSE 80 443

CMD service lighttpd restart;\
    service mysql restart;\
    parallel --tagstring "{}:" --line-buffer tail -f {} ::: /var/log/lighttpd/error.log \
                                                            /var/log/lighttpd/access.log

