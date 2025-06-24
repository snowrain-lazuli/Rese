FROM php:7.4.9-fpm

# php.ini を設定
COPY php.ini /usr/local/etc/php/

# 必要パッケージをインストール
RUN apt update \
  && apt install -y \
  cron \
  default-mysql-client \
  zlib1g-dev \
  libzip-dev \
  unzip \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  && docker-php-ext-install pdo_mysql zip \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

# タイムゾーンを東京に設定
ENV TZ=Asia/Tokyo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# cronジョブファイルをコピー
COPY laravel-scheduler /etc/cron.d/laravel-scheduler

# cronジョブファイルの権限設定と登録
RUN chmod 0644 /etc/cron.d/laravel-scheduler \
  && crontab /etc/cron.d/laravel-scheduler \
  && touch /var/log/cron.log

# 起動スクリプトをコピー（cronとphp-fpmを同時に起動）
COPY start-container.sh /usr/local/bin/start-container.sh
RUN chmod +x /usr/local/bin/start-container.sh

# 作業ディレクトリ
WORKDIR /var/www

# 起動コマンド
CMD ["start-container.sh"]
