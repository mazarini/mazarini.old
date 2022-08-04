# Makefile

validate: composer cs container twig yaml phpstan test

#################################################################
# install
#################################################################
install:
	composer install

#################################################################
# composer
#################################################################
composer:
	composer validate --strict

#################################################################
# container
#################################################################
container:
	bin/console lint:container

#################################################################
# php-cs-fixer
#################################################################
cs:
	~/.config/composer/vendor/bin/php-cs-fixer fix --config config/phpcs/global.php

#################################################################
# phpmd
#################################################################
md:
	~/.config/composer/vendor/bin/phpmd src,lib text config/phpmd/rulesets.xml

#################################################################
# phpstan
#################################################################
phpstan:
	~/.config/composer/vendor/bin/phpstan -cconfig/phpstan/phpstan.neon.dist

#################################################################
# phpunit
#################################################################
test:
	bin/phpunit --cache-result-file var/phpunit.result.cache --configuration config/phpunit/phpunit.xml.dist

cover:
	XDEBUG_MODE=coverage bin/phpunit --cache-result-file var/phpunit.result.cache --configuration config/phpunit/phpunit.xml.dist --coverage-html var/cover

tst:
	XDEBUG_MODE=coverage bin/phpunit --cache-result-file var/phpunit.result.cache --configuration config/phpunit/phpunit.xml.dist --coverage-text

#################################################################
# twig
#################################################################
twig:
	bin/console lint:twig templates lib

#################################################################
# twig
#################################################################
yaml:
	bin/console lint:yaml config config/phpstan/phpstan.neon.dist .github/workflows
    
#################################################################
# Database
#################################################################

init:
	bin/console doctrine:database:drop --env=dev --force
	bin/console doctrine:database:drop --env=test --force
	bin/console doctrine:database:create --env=dev
	bin/console doctrine:database:create --env=test
	bin/console doctrine:migrations:migrate --no-interaction --env=dev
	bin/console doctrine:migrations:migrate --no-interaction --env=test


