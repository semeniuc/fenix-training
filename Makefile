install:
	make host-access
	make start
	make server-access
	
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
	sudo chmod -R ug+rwx app/ data/

server-access:
	docker compose exec php chgrp -R www-data /var/www/project/
	docker compose exec php chown -R www-data:www-data /var/www/project/
	docker compose exec php chmod -R ug+rwx /var/www/project/