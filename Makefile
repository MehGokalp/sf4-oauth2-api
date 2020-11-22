build: docker-compose.yml
	@echo 'Building the container'
	docker-compose up -d --build --remove-orphans && \
	sleep 3 && \
	docker exec -it docker-entrypoint -f
	@echo 'Container built. You can access the server: http://localhost:80'

default: build