#!/bin/bash

cp composer.json original-composer.json

sed '/    printerClass="Codedungeon\\PHPUnitPrettyResultPrinter\\Printer"/d' phpunit.xml > phpunit-56.xml
composer remove codedungeon/phpunit-result-printer --no-update --dev
composer require "orchestra/testbench:3.6.*" --no-update --dev
composer require "phpunit/phpunit:6.*" --no-update --dev
composer update --prefer-source --no-interaction

rm composer.json
mv original-composer.json composer.json

mkdir -p ./build/logs
php -n vendor/bin/phpunit --configuration phpunit-56.xml --coverage-text --coverage-clover ./build/logs/clover.xml
rm phpunit-56.xml
