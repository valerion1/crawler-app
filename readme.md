# Crawler
## How to run
**With docker:**

1. Generate autoload:

``docker run --rm -v "$PWD":/app -w /app composer dump-autoload``

2. Run crawler app:

``docker run --rm -v $(pwd):/app -w /app php:7.2-cli ./bin/crawler https://example.com``

**For run with docker compose use bash script:**

1. Run bash script with input parameter - target domain. Example:

``./bin/dc_crawler https://example.com``

## run tests:

1. Install dependency:

``docker run --rm -v $(pwd):/app -w /app composer install``

2. Run phpunit:

``docker run --rm -v $(pwd):/app -w /app php:7.2-cli ./vendor/bin/phpunit``

## run code checkstyle:

1. Install dependency:

``docker run --rm -v $(pwd):/app -w /app composer install``

2. Run phpcs:

``docker run --rm -v $(pwd):/app -w /app php:7.2-cli ./vendor/bin/phpcs --standard=PSR1,PSR2 --ignore=./vendor/* .``


## what can this app?

* crawl all pages on target domain
* count img tags on each page
* generate html report and save into _./reports_ dir