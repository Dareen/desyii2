.PHONY: run stop

run:
	rm -rf images/front/www
	cp -R www images/front/
	# run docker in the background so we can run migrations
	docker-compose up -d
	# run migrations after the docker has been built and run
	echo "Running yii migrate"
	docker-compose run front php /var/www/default/yii migrate --interactive=0
	docker-compose run front php /var/www/default/yii migrate --migrationPath=@vendor/filsh/yii2-oauth2-server/migrations --interactive=0
	# ES table mapping
	docker-compoer run front bash -c " curl -XPOST ""http://admin:password@elasticsearch:9200/posts/post/_search"" -d'{""query"":{""filtered"":{""query"":{""match"":{""title"":""car""}},""filter"":[{""range"":{""created_at"":{""gte"":""2014-10-21T20:03:12.963""}}},{""range"":{""price"":{""gte"":10,""lte"":550}}}]}}}' "

stop:
	docker-compose stop
