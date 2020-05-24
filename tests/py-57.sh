#!/bin/bash

cp composer.json original-composer.json

composer require codedungeon/phpunit-result-printer --no-update --dev
sed '/    printerClass="Codedungeon\\PHPUnitPrettyResultPrinter\\Printer"/d' phpunit.xml > phpunit-57.xml
composer remove codedungeon/phpunit-result-printer --no-update --dev
composer require "orchestra/testbench:3.8.*" --no-update --dev
composer require "phpunit/phpunit:8.*" --no-update --dev
composer update --prefer-source --no-interaction
apt-get install python-psutil

rm composer.json
mv original-composer.json composer.json

mkdir -p ./build/logs
php -n vendor/bin/phpunit --configuration phpunit-57.xml --coverage-text --coverage-clover ./build/logs/clover.xml
rm phpunit-57.xml
