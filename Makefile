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
	docker-compose run front bash -c " curl -XPOST \"http://admin:password@elasticsearch:9200/posts\" -d'{\"mappings\":{\"post\":{\"_source\":{\"enabled\":true},\"properties\":{\"id\":{\"type\":\"string\"},\"user_id\":{\"type\":\"integer\"},\"created_at\":{\"type\":\"date\"},\"updated_at\":{\"type\":\"date\",\"index\":\"not_analyzed\"},\"updated_by\":{\"type\":\"date\",\"index\":\"not_analyzed\"},\"status\":{\"type\":\"integer\"},\"title\":{\"type\":\"string\"},\"price\":{\"type\":\"float\"},\"description\":{\"type\":\"string\",\"index\":\"not_analyzed\"},\"mobile\":{\"type\":\"string\"},\"email\":{\"type\":\"string\"},\"slug\":{\"type\":\"string\",\"index\":\"not_analyzed\"}}}}}' "

stop:
	docker-compose stop
