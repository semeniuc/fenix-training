install:
	make host-access
	make start
	make server-access
	make ngrok
	
start:
	docker compose up --build -d

stop:
	docker compose down --remove-orphans

restart:
	make stop
	make start

bash:
	docker compose exec -it php bash

ngrok:
	docker run --net=host -it -e NGROK_AUTHTOKEN=${NGROK_AUTHTOKEN} ngrok/ngrok:latest http 80

host-access:
	sudo chgrp -R ${USER} app/ data/
	sudo chown -R ${USER}:${USER} app/ data/
	sudo chmod -R 755 app/ data/

server-access:
	docker compose exec php chown -R www-data:www-data /var/www/project/var
	docker compose exec php chmod -R 775 /var/www/project/