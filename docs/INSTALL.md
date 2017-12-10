# Установка FileProfit Client

1. Установите composer (если не установлен и) выполните команду `composer install`

2. На основе файла `config/db.sample.php` создайте файл `config/db.php` и пропишите настройки подключения

3. На основе файла `phinx.sample.yml` создайте файл `phinx.yml` и пропишите настройки подключения

4. Выполните миграцию бд, выполнив команду `/vendor/bin/phinx migrate -e development`