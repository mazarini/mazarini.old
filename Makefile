# Makefile

validate: composer phpcs container twig yaml phpstan phpunit

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
phpcs:
	~/.config/composer/vendor/bin/php-cs-fixer fix --config config/.php-cs-fixer.dist.php

#################################################################
# phpstan
#################################################################
phpstan:
	phpstan

#################################################################
# phpunit
#################################################################
phpunit:
	bin/phpunit

#################################################################
# twig
#################################################################
twig:
	bin/console lint:twig templates lib

#################################################################
# twig
#################################################################
yaml:
	bin/console lint:yaml config phpstan.neon.dist
    
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


