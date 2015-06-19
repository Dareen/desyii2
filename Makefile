.PHONY: docker stop

docker:
	rm -rf images/front/www
	cp -R www images/front/
	# run docker in the background
	docker-compose up -d
	echo "Running yii migrate"
	docker-compose run front php /var/www/default/yii migrate --interactive=0

stop:
	docker-compose stop
