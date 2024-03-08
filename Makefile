start:
	docker compose up --build -d

stop:
	docker compose down --remove-orphans

restart:
	make stop
	make start

php:
	docker compose exec -it php bash

host-access:
	sudo chgrp -R ${USER} /app
	sudo chown -R ${USER}:${USER} /app
	sudo chmod -R ug+rwx /app

server-access:
	docker compose exec php chgrp -R www-data /var/www/project/
	docker compose exec php chown -R www-data:www-data /var/www/project/
	docker compose exec php chmod -R ug+rwx /var/www/project/