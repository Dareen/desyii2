GITHUB_TOKEN = fake_token

.PHONY: docker stop

docker:
	rm -rf images/front/www
	sed -i 's/__GITHUB_TOKEN__/$(GITHUB_TOKEN)/' www/default/composer.json
	cp -R www images/front/
	# run docker in the background
	docker-compose up -d
	echo "Running yii migrate"
	docker-compose run front php /var/www/default/yii migrate --interactive=0

stop:
	docker-compose stop
