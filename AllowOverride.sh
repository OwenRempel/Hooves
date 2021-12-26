#this is a script to modify the container so that htaccess files will work
docker exec HovesAPI sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride all/' /etc/apache2/apache2.conf 
docker exec HovesAPI service apache2 reload