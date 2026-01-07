.PHONY: help build up down restart logs shell db-shell composer artisan test clear rebuild clean

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Available targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-15s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build Docker containers
	docker-compose build

build-no-cache: ## Build Docker containers without cache
	docker-compose build --no-cache

up: ## Start Docker containers
	docker-compose up -d

down: ## Stop Docker containers
	docker-compose down

restart: ## Restart Docker containers
	docker-compose restart

stop: ## Stop Docker containers without removing them
	docker-compose stop

start: ## Start existing Docker containers
	docker-compose start

logs: ## View Docker container logs
	docker-compose logs -f

logs-app: ## View application container logs
	docker-compose logs -f test-web

logs-db: ## View database container logs
	docker-compose logs -f db

shell: ## Access application container shell
	docker exec -it cpmr_drugtest_app bash

db-shell: ## Access MySQL database shell
	docker exec -it cpmr_db mysql -uroot -proot drag_analysis_db

composer: ## Run composer install
	docker exec cpmr_drugtest_app composer install

composer-update: ## Run composer update
	docker exec cpmr_drugtest_app composer update

artisan: ## Run artisan command (usage: make artisan CMD="migrate")
	docker exec cpmr_drugtest_app php artisan $(CMD)

migrate: ## Run database migrations
	docker exec cpmr_drugtest_app php artisan migrate

migrate-fresh: ## Drop all tables and re-run migrations
	docker exec cpmr_drugtest_app php artisan migrate:fresh

migrate-rollback: ## Rollback the last migration
	docker exec cpmr_drugtest_app php artisan migrate:rollback

seed: ## Run database seeders
	docker exec cpmr_drugtest_app php artisan db:seed

migrate-seed: ## Run migrations and seeders
	docker exec cpmr_drugtest_app php artisan migrate --seed

test: ## Run tests
	docker exec cpmr_drugtest_app php artisan test

phpunit: ## Run PHPUnit tests
	docker exec cpmr_drugtest_app vendor/bin/phpunit

clear: ## Clear Laravel caches
	docker exec cpmr_drugtest_app php artisan cache:clear
	docker exec cpmr_drugtest_app php artisan config:clear
	docker exec cpmr_drugtest_app php artisan route:clear
	docker exec cpmr_drugtest_app php artisan view:clear

optimize: ## Optimize Laravel application
	docker exec cpmr_drugtest_app php artisan optimize

rebuild: ## Rebuild and restart containers
	docker-compose down
	docker-compose build --no-cache
	docker-compose up -d

clean: ## Remove all containers, volumes, and images
	docker-compose down -v --rmi all

ps: ## Show running containers
	docker-compose ps

xdebug-log: ## View Xdebug log
	docker exec cpmr_drugtest_app cat /tmp/xdebug.log

php-info: ## Show PHP information
	docker exec cpmr_drugtest_app php -i

php-version: ## Show PHP version
	docker exec cpmr_drugtest_app php -v

npm-install: ## Run npm install
	docker exec cpmr_drugtest_app npm install

npm-dev: ## Run npm dev
	docker exec cpmr_drugtest_app npm run dev

npm-watch: ## Run npm watch
	docker exec cpmr_drugtest_app npm run watch

npm-prod: ## Run npm production build
	docker exec cpmr_drugtest_app npm run prod

permissions: ## Fix Laravel permissions
	docker exec cpmr_drugtest_app chown -R www-data:www-data /var/www/html/storage
	docker exec cpmr_drugtest_app chown -R www-data:www-data /var/www/html/bootstrap/cache
	docker exec cpmr_drugtest_app chmod -R 775 /var/www/html/storage
	docker exec cpmr_drugtest_app chmod -R 775 /var/www/html/bootstrap/cache

license-test: ## Run interactive license test script
	./test-license.sh

license-status: ## Check current license status
	@docker exec cpmr_drugtest_app php -r "require 'vendor/autoload.php'; \$$app = require_once 'bootstrap/app.php'; \$$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); use App\Services\LicenseService; \$$status = LicenseService::getLicenseStatus(); echo json_encode(\$$status, JSON_PRETTY_PRINT) . PHP_EOL;"

license-refresh: ## Force refresh license from API
	@docker exec cpmr_drugtest_app php -r "require 'vendor/autoload.php'; \$$app = require_once 'bootstrap/app.php'; \$$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); use App\Services\LicenseService; \$$result = LicenseService::forceRefresh(); echo json_encode(\$$result, JSON_PRETTY_PRINT) . PHP_EOL;"

license-db: ## View license table in database
	docker exec cpmr_db mysql -uroot -proot drag_analysis_db -e "SELECT id, feature, is_active, expires_at, last_checked_at, api_url FROM licenses WHERE feature = 'evaluate_report';"

license-logs: ## View license-related log entries
	docker exec cpmr_drugtest_app tail -100 storage/logs/laravel.log | grep -i "license" | tail -20