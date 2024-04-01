## Introduction

This package contains my own services and settings for [yourivw/sailor](https://github.com/yourivw/sailor).

## Installation

Install this package as a dev dependency using composer:

```composer require yourivw/sailor-services:dev-main --dev```

## Usage

See the documentation of [yourivw/sailor](https://github.com/yourivw/sailor) for information on usage.

## Services

### HTTPS

The HTTPS service is a proxy based on the [Nginx docker image](https://hub.docker.com/_/nginx), forwarding HTTPS traffic to Laravel. A certificate and CA certificate are automatically generated using mkcert. The CA can be changed by (re)placing the required files in ``./.docker/https/CA``, or by specifying a different directory containing these files (``./.docker/https/CA:/etc/nginx/CA`` in the docker-compose file). Two files are expected in this CA directory, ``rootCA.pem`` containing the CA certificate, and ``rootCA-key.pem`` containing the PKCS#8 private key.

#### Proxies

Extra proxies can be added by modifying the SSL_SERVICES environment variable. In the following example, port 443 will be forwarded to port 80 on the laravel.test service, and port 8443 will be forwarded to port 80 on the api service.
```yml
https:
    environment:
        SSL_SERVICES: 'laravel.test:80:443;api:80:8443'
```

#### Certificate domains

By default the following domains/IP's will be added to the certificate:
* $APP_SERVICE (from .env, defaults to laravel.test)
* *.$APP_SERVICE
* localhost
* 127.0.0.1

Additional domains/IP's can be added as a string through the CERT_DOMAINS environment variable:
```yml
https:
    environment:
        CERT_DOMAINS: 'laravel.local laravel.example 192.168.2.1
```
### PHPMyAdmin

A service based on the [PHPMyAdmin docker image](https://hub.docker.com/_/phpmyadmin) with basic configuration. See related documentation for additional configuration.

### Redis Commander

A service based on the [redis-commander docker image](https://hub.docker.com/r/rediscommander/redis-commander) with basic configuration. See related documentation for additional configuration.

### RedisInsight

A service based on the [RedisInsight docker image](https://hub.docker.com/r/redis/redisinsight) with basic configuration. See related documentation for additional configuration.
An connection to redis:6379 is pre-added, named 'Local'.

## Contributing

Since this package contains my personal services, I'm not accepting contributions to this package.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).
