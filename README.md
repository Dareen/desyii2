# Basic php yii2 api with docker

# Work In Progress

## Docker containers

* [Apache](https://github.com/tutumcloud/apache-php)
* [MySQL](https://github.com/tutumcloud/mysql)
* [Elasticsearch](https://github.com/tutumcloud/elasticsearch)

## Getting started

To setup the docker machine with all the needed requirements to run the application, please follow these steps:
1. Please generate a GitHub OAuth token to go over the API rate limit
Head to https://github.com/settings/tokens/new?scopes=repo&description=Composer+on+6d7eca279c5e+2015-06-19+1846
to retrieve a token.

2. Copy the token to the Dockerfile [here](https://github.com/Dareen/yii2php-elasticsearch/blob/master/images/front/Dockerfile#L3)

### Requirements

* [Docker](https://docker.com/)
* [Docker Compose](http://docs.docker.com/compose/)

### Instructions



Settings --> Applications --> Generate New Token

please

```sh
# Clone the repository (using hub)
$ git clone git@github.com:Dareen/yii2php.git
$ cd yii2php

# Run using make
$ make docker
```


Resources:

* [Yii2 Rest Guide](http://www.yiiframework.com/doc-2.0/guide-rest-quick-start.html)
* [Basic Yii2 Rest API](http://budiirawan.com/setup-restful-api-yii2/)
https://devops.profitbricks.com/tutorials/configure-a-docker-container-to-automatically-pull-from-github-using-oauth/
http://www.yiiframework.com/doc-2.0/guide-start-installation.html#recommended-apache-configuration
https://github.com/composer/composer/blob/master/doc/articles/troubleshooting.md#api-rate-limit-and-oauth-tokens
