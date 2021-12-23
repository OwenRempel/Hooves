docker run -i -t -p "80:80" --name "HovesAPI" -v ${PWD}/API/app:/app  -v ${PWD}/API/mysql:/var/lib/mysql -v ${PWD}/API/logs:/var/log/apache2 -e CREATE_MYSQL_BASIC_USER_AND_DB=true -e MYSQL_USER_NAME='HovesAdmin' \
 -e MYSQL_USER_DB='HovesAdmin' \
 -e MYSQL_USER_PASS='GTV4DYv6KA5Hp9A2uShe8f4PYcQeRCmPxKyUxGL4' \
 -e MYSQL_ADMIN_PASS='3ntry150' \
  mattrayner/lamp:latest
