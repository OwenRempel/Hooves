docker run -d -p "80:80" --name "HovesMain" -v ${PWD}/Built/app:/app  -v ${PWD}/Built/mysql:/var/lib/mysql -v ${PWD}/Built/logs:/var/log/apache2 mattrayner/lamp:latest