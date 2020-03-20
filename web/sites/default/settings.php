<?php

/**
 * @file
 * AmazeeIO Drupal 8 configuration file.
 *
 * You should not edit this file, please use environment specific files!
 * They are loaded in this order:
 * - settings.all.php
 *   For settings that should be applied to all environments (dev, prod, staging, vagrant, etc).
 * - services.all.yml
 *   For services that should be applied to all environments (dev, prod, staging, vagrant, etc).
 * - settings.production.php
 *   For settings only for the production environment.
 * - services.production.yml
 *   For services only for the production environment.
 * - settings.development.php
 *   For settings only for the development environment (dev servers, vagrant).
 * - services.development.yml
 *   For services only for the development environment (dev servers, vagrant).
 * - settings.local.php
 *   For settings only for the local environment, this file will not be commited in GIT!
 * - services.local.yml
 *   For services only for the local environment, this file will not be commited in GIT!
 *
 */

### amazee.io Solr connection
// WARNING: you have to create a search_api server having "solr" machine name at
// /admin/config/search/search-api/add-server to make this work.
if (getenv('AMAZEEIO_SOLR_HOST') && getenv('AMAZEEIO_SOLR_PORT')) {
  $config['search_api.server.solr']['backend_config']['connector_config']['host'] = getenv('AMAZEEIO_SOLR_HOST');
  $config['search_api.server.solr']['backend_config']['connector_config']['path'] = '/solr/' . (getenv('AMAZEEIO_SOLR_CORE') ?: getenv('AMAZEEIO_SITENAME')) . '/';
  $config['search_api.server.solr']['backend_config']['connector_config']['port'] = getenv('AMAZEEIO_SOLR_PORT');
  $config['search_api.server.solr']['backend_config']['connector_config']['username'] = (getenv('AMAZEEIO_SOLR_USER') ?: '');
  $config['search_api.server.solr']['backend_config']['connector_config']['password'] = (getenv('AMAZEEIO_SOLR_PASSWORD') ?: '');
  $config['search_api.server.solr']['name'] = 'AmazeeIO Solr - Environment: ' . getenv('AMAZEEIO_SITE_ENVIRONMENT');
  $config['search_api.server.solr']['description'] = 'The solr instance for environment: ' . getenv('AMAZEEIO_SITE_ENVIRONMENT');
}

### AMAZEE.IO Varnish & Reverse proxy settings
if (getenv('AMAZEEIO_VARNISH_HOSTS') && getenv('AMAZEEIO_VARNISH_SECRET')) {
  $varnish_hosts = explode(',', getenv('AMAZEEIO_VARNISH_HOSTS'));
  array_walk($varnish_hosts, function(&$value, $key) { $value .= ':6082'; });

  $settings['reverse_proxy'] = TRUE;
  $settings['reverse_proxy_addresses'] = array_merge(explode(',', getenv('AMAZEEIO_VARNISH_HOSTS')), array('127.0.0.1'));
  $settings['varnish_control_terminal'] = implode($varnish_hosts, " ");
  $settings['varnish_control_key'] = getenv('AMAZEEIO_VARNISH_SECRET');
  $settings['varnish_version'] = 3;
}

### AMAZEE.IO Redis settings
if (getenv('AMAZEEIO_REDIS_HOST') && getenv('AMAZEEIO_REDIS_PORT')) {
  $settings['redis_client_interface'] = 'PhpRedis';
  $settings['redis_client_host'] = getenv('AMAZEEIO_REDIS_HOST');
  $settings['redis_client_port'] = getenv('AMAZEEIO_REDIS_PORT');
}

### AMAZEE.IO Database connection
if(getenv('AMAZEEIO_SITENAME')){
  $databases['default']['default'] = array(
    'driver' => 'mysql',
    'database' => getenv('AMAZEEIO_SITENAME'),
    'username' => getenv('AMAZEEIO_DB_USERNAME'),
    'password' => getenv('AMAZEEIO_DB_PASSWORD'),
    'host' => getenv('AMAZEEIO_DB_HOST'),
    'port' => getenv('AMAZEEIO_DB_PORT'),
    'prefix' => '',
  );
}

### Base URL
if (getenv('AMAZEEIO_SITE_URL')) {
  $base_url = 'https://' . getenv('AMAZEEIO_SITE_URL');
}

### Temp directory
if (getenv('AMAZEEIO_TMP_PATH')) {
  $config['system.file']['path']['temporary'] = getenv('AMAZEEIO_TMP_PATH');
}

// Settings for all environments
if (file_exists(__DIR__ . '/settings.all.php')) {
  include __DIR__ . '/settings.all.php';
}

// Services for all environments
if (file_exists(__DIR__ . '/services.all.yml')) {
  $settings['container_yamls'][] = __DIR__ . '/services.all.yml';
}

if(getenv('AMAZEEIO_SITE_ENVIRONMENT')){
  // Environment specific settings files.
  if (file_exists(__DIR__ . '/settings.' . getenv('AMAZEEIO_SITE_ENVIRONMENT') . '.php')) {
    include __DIR__ . '/settings.' . getenv('AMAZEEIO_SITE_ENVIRONMENT') . '.php';
  }

  // Environment specific services files.
  if (file_exists(__DIR__ . '/services.' . getenv('AMAZEEIO_SITE_ENVIRONMENT') . '.yml')) {
    $settings['container_yamls'][] = __DIR__ . '/services.' . getenv('AMAZEEIO_SITE_ENVIRONMENT') . '.yml';
  }
}

// Last: this servers specific settings files.
if (file_exists(__DIR__ . '/settings.local.php')) {
  include __DIR__ . '/settings.local.php';
}
// Last: This server specific services file.
if (file_exists(__DIR__ . '/services.local.yml')) {
  $settings['container_yamls'][] = __DIR__ . '/services.local.yml';
}

$config_directories['sync'] = '../config/sync';
$config['config_split.config_split.dev']['status'] = TRUE;
