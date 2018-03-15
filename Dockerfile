FROM centos:7

# update yum
RUN yum -y update
RUN yum -y install yum-utils
RUN yum clean all

RUN yum -y install epel-release
RUN yum -y groupinstall "Development Tools"
RUN yum -y install wget git vim zsh curl

# install remi repo
RUN wget http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
RUN rpm -Uvh remi-release-7*.rpm
RUN yum-config-manager --enable remi-php70

# install php7
RUN \
  yum -y install \
    php php-common \
    php-mbstring \
    php-mcrypt \
    php-devel \
    php-xml \
    php-mysqlnd \
    php-pdo \
    php-opcache --nogpgcheck \
    php-bcmath

# install nvm
RUN \
  git clone https://github.com/creationix/nvm.git ~/.nvm && \
  source ~/.nvm/nvm.sh && \
  echo 'source ~/.nvm/nvm.sh' >> .bashrc && \
  nvm install v6.13.1

# install composer
RUN curl -sS https://getcomposer.org/installer | php && \
  mv composer.phar /usr/local/bin/composer

# timezone setting
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

# application directory
RUN mkdir /app
WORKDIR /app

CMD ["/sbin/init"]

EXPOSE 8080
