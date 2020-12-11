# Drupal 8 Playground

## Table of Contents

* [About](#about)
* [Requirements](#requirements)
* [Setup](#setup)

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
    1. Pull in the database: `drush sql < databases/testDB-umami.sql` or `drush sql < databases/testDB-standard.sql`
    1. Get onetime login: `drush uli`

Ready to play with!
