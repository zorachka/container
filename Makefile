start: docker-down-clear docker-pull docker-build-pull docker-up composer-install
stop: docker-down-clear
check: lint analyze test

docker-up:
	docker compose up -d

docker-down-clear:
	docker compose down -v --remove-orphans

docker-pull:
	docker compose pull

docker-build-pull:
	docker compose build --pull

composer-install:
	docker compose run --rm php-cli composer install

composer-dump:
	docker compose run --rm php-cli composer dump-autoload

lint:
	docker compose run --rm php-cli composer php-cs-fixer fix -- --dry-run --diff

cs-fix:
	docker compose run --rm php-cli composer php-cs-fixer fix

analyze:
	docker compose run --rm php-cli composer psalm

test:
	docker compose run --rm php-cli composer test
