# Dockerized PHP Yii2 api using ElasticSearch, MySql, OAuth2

# Work In Progress

## Docker containers include:

* [Apache](https://github.com/tutumcloud/apache-php)
* [MySQL](https://github.com/tutumcloud/mysql)
* [Elasticsearch](https://github.com/tutumcloud/elasticsearch)
* [Yii2](http://www.yiiframework.com/)

I added vendors to the project to speed up building the docker containers, but ideally they should be excluded. You can skip and they'll be set up automatically in the docker build phase using Composer.


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


* Stopping the docker containers, deleting the images... etc.
run:
`make stop`
this will stop docker-compose and the running containers.
To delete an image, run `docker images | grep "front\|mysql\|elasticsearch"`
Copy the image ids and run `docker rmi img_id` on them

### Usage

* Now you can send requests to `localhost:8888`
**Anonymous endpoints:**
GET /posts
GET /posts/id
POST /search

**User endpoints:**

POST /posts
PUT /posts
DELETE /posts
GET /users
GET /id
POST /users
PUT /users
DELETE /users

* To authenticate a request, you must first get a token by sending a request to OAuth2 server:
POST /outh2/token

payload json:
```json
{
    "grant_type":"password",
    "username":"demo",
    "password":"password",
    "client_id":"testclient",
    "client_secret":"testpass"
}
```

* Users that are already available:
demo:password
test:password

* OAuth2 Client Id and Secret:
testclient:testpass

* Databases credentials
admin:password


### Resources:

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

Progress tracking:
- [x] Use elasticsearch active record
- [x] Users endpoints to list and create
- [x] authorize requests
- [x] CRUD for Posts
- [ ] Tests
- [ ] Lookup php linters for sublime and check coding style standards
- [-] Documentation (this doc)
- [ ] API versioning
- [ ] pagination?
- [ ] role based access control
- [ ] cleanup the project structrure and unneeded files
- [ ] proper exception handling
- [ ] rename the repo to something more meaningful
- [ ] find similar posts if the requested search yeilded no results
- [x] code comments
- [ ] format api responses
- [x] include type mapping in docker scripts
- [ ] add postman importable requests collection
- [ ] Separate the vendors in a different branch, if they might be needed to speed up building the docker image.
