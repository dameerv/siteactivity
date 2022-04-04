DOCKER_CONTAINER_PHP_ACTIVITY = activity
DOCKER_CONTAINER_PHP_LANDING = landing
EXEC=docker exec -it
DOCKER_EXEC_ACTIVITY = $(EXEC) $(DOCKER_CONTAINER_PHP_ACTIVITY)
DOCKER_EXEC_LADING = $(EXEC) $(DOCKER_CONTAINER_PHP_LANDING)

build: docker-up bootstrap
up: docker-up
stop: docker-down
restart: stop up
start-dev: start docker-logs

enter-land:
	$(DOCKER_EXEC_LANDING) /bin/sh

enter-act:
	$(DOCKER_EXEC_ACTIVITY) /bin/bash

bootstrap:
	$(DOCKER_EXEC_ACTIVITY) composer install
	$(DOCKER_EXEC_LADING) composer install

	$(DOCKER_EXEC_ACTIVITY) bin/console c:c
	$(DOCKER_EXEC_LADING) bin/console c:c

	$(DOCKER_EXEC_LADING) yarn install
	$(DOCKER_EXEC_LADING) yarn build

docker-restart: docker-down docker-up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

ps:
	docker-compose ps

docker-logs:
	docker-compose logs -t -f --tail="all"


composer-install: activity-composer-install landing-composer-install

activity-composer-install:
	$(DOCKER_EXEC_ACTIVITY) composer install --optimize-autoloader

landing-composer-install:
	$(DOCKER_EXEC_LANDING)  composer install --optimize-autoloader

composer-update: activity-composer-update landing-composer-update

activity-composer-update:
	$(DOCKER_EXEC_ACTIVITY) composer  update --optimize-autoloader

landing-composer-update:
	$(DOCKER_EXEC_LANDING)  composer  update --optimize-autoloader


cache: cc

cc:
	$(DOCKER_EXEC_LANDING) bin/console c:c
	$(DOCKER_EXEC_ACTIVITY) bin/console c:c

migration:
	$(DOCKER_EXEC_ACTIVITY) bin/console doctrine:migrations:migrate
