.PHONY: docker

docker:
	rm -rf images/front/www
	cp -R www images/front/
	docker-compose up
