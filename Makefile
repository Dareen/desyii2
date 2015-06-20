.PHONY: docker stop

docker:
	rm -rf images/front/www
	cp -R www images/front/
	# run docker in the background so we can run migrations
	docker-compose up -d
	# run migrations after the docker has been built and run
	echo "Running yii migrate"
	docker-compose run front php /var/www/default/yii migrate --interactive=0
	docker-compose run front php /var/www/default/yii migrate --migrationPath=@vendor/filsh/yii2-oauth2-server/migrations --interactive=0

stop:
	docker-compose stop
