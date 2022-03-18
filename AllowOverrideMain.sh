#this is a script to modify the container so that htaccess files will work
docker exec HovesMain sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride all/' /etc/apache2/apache2.conf 
docker exec HovesMain service apache2 reload