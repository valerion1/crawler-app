# Crawler
## How to run
With docker:

``docker run --rm -v $(pwd):/app -w /app php:7.2-cli ./bin/crawler https://example.com``

For run with docker compose use bash script:

``./bin/dc_crawler https://example.com``

## run tests:

``docker run --rm -v $(pwd):/app -w /app php:7.2-cli ./vendor/bin/phpunit``

## what can a this app?

* crawl all pages on target domain
* count img tags on each page
* generate html report and save into reports dir
