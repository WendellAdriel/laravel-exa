# Well documented Makefiles
DEFAULT_GOAL := help
help:
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z0-9_-]+:.*?##/ { printf "  \033[36m%-40s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

##@ [Docker]
start: ## Spin up the containers and run the app UI in watch mode
	docker compose up -d

stop: ## Shut down the containers
	docker compose down \
	&& rm -f docker/redis/data/dump.rdb

build: ## Build all docker images OR a specific image by providing the service name via: make build SERVICE_NAME=<service>
	docker compose build $(SERVICE_NAME)

##@ [Application]
configure: ## Configures the application when setting it for the first time
	cp .env.example .env \
	&& make install \
	&& make art ARGS="key:generate --ansi"

composer: ## Run composer commands. Specify the command e.g. via make composer ARGS="install|update|require <dependency>"
	docker compose run --rm app composer $(ARGS)

install: ## Install all the dependencies
	docker compose run --rm app composer install

composer-bump: ## Updates the dependencies and the min version on composer.json
	docker compose run --rm app composer update \
	&& docker compose run --rm app composer bump \

art: ## Run artisan commands. Specify the command e.g. via make art ARGS="tinker"
	docker compose run --rm app php artisan $(ARGS)

lint: ## Run the Linter. Pass arguments and options via make lint ARGS="-q"
	docker compose run --rm app ./vendor/bin/pint $(ARGS)

test: ## Run all the tests. Pass arguments and options via make test ARGS="--filter=ExampleTest"
	docker compose run --rm app ./vendor/bin/pest $(ARGS)

prepare: ## Run tools to prepare for commit
	docker compose run --rm app ./vendor/bin/pint --dirty

hooks: ## Run the CGHooks commands. Specify the command e.g. via make hooks ARGS="update"
	docker-compose run --rm app ./vendor/bin/cghooks $(ARGS)
