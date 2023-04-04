start: docker-down-clear docker-pull docker-build-pull docker-up app-init
stop: docker-down-clear
check: cs-lint analyse test

docker-up:
	docker compose up -d

docker-down-clear:
	docker compose down -v --remove-orphans

docker-pull:
	docker compose pull

docker-build-pull:
	docker compose build --pull

app-init: composer-install

composer-install:
	docker compose run --rm php-cli composer install

composer-update:
	docker compose run --rm php-cli composer update

composer-require:
	docker compose run --rm php-cli composer require $(p)

cs-lint:
	docker compose run --rm php-cli composer cs-lint

cs-fix:
	docker compose run --rm php-cli composer cs-fix

analyse:
	docker compose run --rm php-cli composer analyse

test:
	docker compose run --rm php-cli composer test
