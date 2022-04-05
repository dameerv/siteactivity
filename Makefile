DOCKER_CONTAINER_PHP_ACTIVITY = activity
DOCKER_CONTAINER_PHP_LANDING = landing
EXEC=docker exec


build: docker-build bootstrap
up: docker-up
stop: docker-down
restart: stop up
start-dev: start docker-logs

enter-land:
	$(EXEC) -it $(DOCKER_CONTAINER_PHP_LANDING) /bin/sh

enter-act:
	$(EXEC) -it $(DOCKER_CONTAINER_PHP_ACTIVITY) /bin/bash

bootstrap:
	$(EXEC) $(DOCKER_CONTAINER_PHP_ACTIVITY) composer install
	$(EXEC) $(DOCKER_CONTAINER_PHP_LANDING) composer install

	$(EXEC) $(DOCKER_CONTAINER_PHP_ACTIVITY) bin/console c:c
	$(EXEC) $(DOCKER_CONTAINER_PHP_LANDING) bin/console c:c

	$(EXEC) $(DOCKER_CONTAINER_PHP_LANDING) yarn install
	$(EXEC) $(DOCKER_CONTAINER_PHP_LANDING) yarn build

	$(EXEC) -d $(DOCKER_CONTAINER_PHP_LANDING) bin/console messenger:consume amqp_activity_register

docker-restart: docker-down docker-up
docker-build:
	docker-compose up -d --build

docker-up:
	docker-compose up -d
	$(EXEC) -d $(DOCKER_CONTAINER_PHP_LANDING) bin/console messenger:consume amqp_activity_register

docker-down:
	docker-compose down --remove-orphans

ps:
	docker-compose ps

docker-logs:
	docker-compose logs -t -f --tail="all"


composer-install: activity-composer-install landing-composer-install

activity-composer-install:
	$(EXEC) $(DOCKER_CONTAINER_PHP_ACTIVITY) composer install --optimize-autoloader

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
	$(EXEC) $(DOCKER_CONTAINER_PHP_ACTIVITY) bin/console c:c

migration:
	$(EXEC) $(DOCKER_CONTAINER_PHP_ACTIVITY) bin/console doctrine:migrations:migrate

consume:
	$(EXEC) $(DOCKER_CONTAINER_PHP_LANDING) bin/console messenger:consume amqp_activity_register -vv
