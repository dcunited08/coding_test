FROM php:5.6
MAINTAINER dcunited08 <dcunited08@gmail.com>

RUN apt-get update
RUN apt-get install -y git zip build-essential libssl-dev

WORKDIR /root
RUN git clone https://github.com/nmap/nmap.git
WORKDIR /root/nmap
RUN ./configure
RUN make
RUN make install
RUN ln -s /usr/local/bin/nmap /usr/bin/nmap


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

COPY . /code
WORKDIR /code

RUN composer install --no-plugins --no-scripts --prefer-source --no-interaction
CMD ["./vendor/bin/phpunit"]
