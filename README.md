# Drupal 8 Playground

## Table of Contents

* [About](#about)
* [Requirements](#requirements)
* [Setup](#setup)
  * [PHPStorm with PHPUnit](#phpstorm-with-phpunit)

## About

This is a simple Drupal 8 project that includes a very basic database aimed at getting Drupal up and running as quick as possible to play around in.


## Requirements

This project has the following requirements:

* [Docker](https://www.docker.com/products/docker-app)
* [Pygmy](https://pygmy.readthedocs.io/en/master/installation/)

## Setup

1. Clone this repo: `https://github.com/elistone/drupal-8-tests`
1. Build & up the containers: `docker-compose up -d` (`dup`)
1. Enter the container: `docker-compose exec cli bash` (`lssh`)
1. Inside the container:
    1. Composer install: `composer install`
    1. Pull in the database: `drush sql-cli < databases/testDB-standard.sql`
    1. Get onetime login: `drush uli`

Ready to play with!

### PHPStorm with PHPUnit

The following steps should help with configuring PHPStorm to remotely connect to docker and allow for PHPUnit testing to be run and configured correctly.

1. Make a copy and rename `phpunit.xml.dist` to `phpunit.xml` (found in the root)
1. Copy the renamed `phpunit.xml` into `web/core`
1. Setup docker:
   1. `File` > `Settings` > `Build, execution, deployment` > `docker`
   1. Press `+`
   1. Select `Docker for mac`
1. Add a new CLI interpreter:
   1. `File` > `Settings` > `Languages & Frameworks` > `PHP`
   1. Press `...` and then `+`
   1. Next select `Add a new CLI interpreter from Docker, vagrant...`
   1. Use the following configurations:
      * Server: `[Docker setup in previous step]`
      * Configuration file(s): `./docker-compose.yml`
      * Service: `cli`
      * Lifecycle: `Connect to existing container ('docker-compose exec')'`
   1. Path mappings:
      * Local path: `[path to repo root]`
      * Remote path: `/app`
1. Setup Remote Interpreter
   1. `File` > `Settings` > `Languages & Frameworks` > `PHP` > `Test Frameworks`
   1. Press `+` and select `PHPUnit by Remote Interpreter`
   1. Use the following configurations:
      * CLI Interpreter: `[CLI interpreter setup in previous step]`
      * Path mappings: `[Project root] -> /app`
      * PHPUnit: `Use Composer autoloader`
      * Path to script: `/app/vendor/autoload.php`
      * Default configuration file: `/app/web/core/phpunit.xml`

#### Setup docker - Image
![Setup docker](./screenshots/1-docker-setup.png | width=400)
#### CLI interpreter - Image
![CLI interpreter](./screenshots/2-cli-interpreter.png | width=400)
#### Remote Interpreter - Image
![Remote Interpreter](./screenshots/3-remote-interpreter-setup.png | width=400)
