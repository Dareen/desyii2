# Dockerized PHP Yii2 api using ElasticSearch, MySql, Oauth2, RBAC

# Work In Progress

## Docker containers

* [Apache](https://github.com/tutumcloud/apache-php)
* [MySQL](https://github.com/tutumcloud/mysql)
* [Elasticsearch](https://github.com/tutumcloud/elasticsearch)
* [Yii2](http://www.yiiframework.com/)
Vendors are added to speed up building the docker container, but you can ignore them, and they'll be set up automatically in the docker build phase.

TODO: consider deleting vendors later...

### Requirements

* [Docker](https://docker.com/)
* [Docker Compose](http://docs.docker.com/compose/)

## Getting started

To setup the docker machine with all the needed requirements to run the application, please follow these steps:

* Install [Docker](https://docker.com/) and [Docker Compose](http://docs.docker.com/compose/)


* Clone the repository
```sh
$ git clone git@github.com:Dareen/desyii2.git
```

* Generate a GitHub OAuth token to go over the API rate limit
Head to https://github.com/settings/tokens/new?scopes=repo&description=Composer+on+6d7eca279c5e+2015-06-19+1846
to retrieve a token.

* Copy the token to the Dockerfile [here](https://github.com/Dareen/desyii2/blob/master/images/front/Dockerfile#L3)

* Run using make
```sh
$ cd desyii2
$ make run
```

TODO: stopping the containers, deleting the images... etc.

### Usage


Resources:

* [Initial docker containers](https://github.com/kasperisager/phpstack)
* [Yii2 Rest Guide](http://www.yiiframework.com/doc-2.0/guide-rest-quick-start.html)
* [GitHub Rate Limit](https://github.com/composer/composer/blob/master/doc/articles/troubleshooting.md#api-rate-limit-and-oauth-tokens)
* [Docker with GitHub token](https://devops.profitbricks.com/tutorials/configure-a-docker-container-to-automatically-pull-from-github-using-oauth/)
* [Basic Yii2 Rest API](http://budiirawan.com/setup-restful-api-yii2/)
* [Installing Yii2](http://www.yiiframework.com/doc-2.0/guide-start-installation.html#recommended-apache-configuration)
* [Yii2 Elasticsearch Active Record](http://www.yiiframework.com/doc-2.0/yii-elasticsearch-activerecord.html)
* http://stackoverflow.com/questions/25522462/yii2-rest-query
* http://www.yiiframework.com/wiki/748/building-a-rest-api-in-yii2-0/
* http://www.yiiframework.com/doc-2.0/guide-rest-authentication.html
* http://oauth.net/2/
* https://github.com/bshaffer/oauth2-server-php
* https://github.com/Filsh/yii2-oauth2-server
* Issue: https://github.com/yiisoft/yii2/issues/4575 => used except

Progress tracking:
- [x] Use elasticsearch active record
- [x] Users endpoints to list and create
- [x] authorize requests
- [ ] CRUD for Posts
- [ ] Tests
- [ ] Lookup php linters for sublime and check coding style standards
- [-] Documentation (this doc)
- [ ] API versioning
- [ ] pagination?
- [ ] role based access control
- [ ] cleanup the project structrure
- [ ] rename the repo to something more meaningful
- [ ] find similar posts if the requested search yeilded no results
- [ ] consider integrating with Kafka for a SOA enabled system
- [x] code comments
- [ ] format api responses: https://github.com/ikaras/yii2-oauth2-rest-template/blob/master/application/api/config/api.php#L31
- [x] include type mapping in docker scripts
- [ ] add postman importable requests collection
