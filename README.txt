Creation de la base :

USE snaptext;

CREATE TABLE texts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    text_content TEXT NOT NULL,
    link_hash VARCHAR(255) NOT NULL,
    expiration_date DATETIME,
    max_views INT,
    views INT DEFAULT 0
);


Virtual Host : 


<VirtualHost *:80>
    ServerName snaptext.linuxtricks.lan
    DocumentRoot /var/www/html/snaptext/public

    <Directory /var/www/html/snaptext/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog /var/log/httpd/snaptext_error.log
    CustomLog /var/log/httpd/snaptext_access.log combined
</VirtualHost>
