FROM node:21-alpine AS node
FROM php:8.3.7-fpm-alpine3.20

ARG XDEBUG_VERSION=3.3.2

RUN apk update \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
    && apk add --no-cache \
        libstdc++ \
        libgcc \
        git \
        bash \
        zsh \
        libxml2-dev \
        libzip-dev \
        libmcrypt-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        libxml2-dev \
        icu-dev \
        autoconf \
        rabbitmq-c-dev \
        libxslt-dev \
        postgresql-dev \
    && apk add --update \
        linux-headers \
    && pecl update-channels \
    && pecl install grpc \
        redis \
        xdebug-${XDEBUG_VERSION} \
        protobuf \
    && pecl clear-cache \
    && rm -rf /tmp/* /var/cache/apk/* \
    && apk del .build-deps

RUN docker-php-ext-enable xdebug \
    && docker-php-ext-enable grpc \
    && docker-php-ext-enable protobuf \
    && docker-php-ext-enable redis \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install xsl \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pdo_pgsql

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/include/node /usr/local/include/node
COPY --from=node /usr/local/share/man/man1/node.1 /usr/local/share/man/man1/node.1
COPY --from=node /usr/local/share/doc/node /usr/local/share/doc/node
COPY --from=node /usr/local/bin/node /usr/local/bin/node
COPY --from=node /opt/ /opt/

RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm
RUN ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx
RUN ln -s /opt/yarn-$(ls /opt/ | grep yarn | sed 's/yarn-//')/bin/yarn /usr/local/bin/yarn
RUN ln -s /opt/yarn-$(ls /opt/ | grep yarn | sed 's/yarn-//')/bin/yarnpkg /usr/local/bin/yarnpkg

RUN curl -OL https://getcomposer.org/download/2.7.6/composer.phar \
    && mv ./composer.phar /usr/bin/composer \
    && chmod +x /usr/bin/composer \
    && curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

ARG LINUX_USER_ID

RUN addgroup --gid $LINUX_USER_ID docker \
    && adduser --uid $LINUX_USER_ID --ingroup docker --home /home/docker --shell /bin/zsh --disabled-password --gecos "" docker

COPY /var /srv/app/var
RUN chmod -R 0777 /srv/app/var

USER $LINUX_USER_ID

RUN wget https://github.com/robbyrussell/oh-my-zsh/raw/65a1e4edbe678cdac37ad96ca4bc4f6d77e27adf/tools/install.sh -O - | zsh
RUN echo 'export ZSH=/home/docker/.oh-my-zsh' > ~/.zshrc \
    && echo 'ZSH_THEME="simple"' >> ~/.zshrc \
    && echo 'source $ZSH/oh-my-zsh.sh' >> ~/.zshrc \
    && echo 'PROMPT="%{$fg_bold[yellow]%}php:%{$fg_bold[blue]%}%(!.%1~.%~)%{$reset_color%} "' > ~/.oh-my-zsh/themes/simple.zsh-theme

WORKDIR /srv/app
