Creation de la base :

USE secure_text_db;

CREATE TABLE texts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    text_content TEXT NOT NULL,
    link_hash VARCHAR(255) NOT NULL,
    expiration_date DATETIME,
    max_views INT,
    views INT DEFAULT 0
);



