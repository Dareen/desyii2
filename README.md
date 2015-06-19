# Basic php yii2 api with docker

# Work In Progress

## Docker containers

* [Apache](https://github.com/tutumcloud/apache-php)
* [MySQL](https://github.com/tutumcloud/mysql)
* [Elasticsearch](https://github.com/tutumcloud/elasticsearch)

## Getting started

### Requirements

* [Docker](https://docker.com/)
* [Docker Compose](http://docs.docker.com/compose/)

### Instructions

You will need a github token to setup yii2 in the docker container, please generate a token

Settings --> Applications --> Generate New Token

please create a GitHub OAuth token to go over the API rate limit
Head to https://github.com/settings/tokens/new?scopes=repo&description=Composer+on+6d7eca279c5e+2015-06-19+1846
to retrieve a token.

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
