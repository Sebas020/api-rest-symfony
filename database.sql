CREATE DATABASE IF NOT EXISTS api_rest_symfony;
USE api_rest_symfony;

CREATE TABLE users(
id          int(255) auto_increment NOT NULL,
name        varchar(50) NOT NULL,
surname     varchar(150),
email       varchar(255) NOT NULL,
password    varchar(255) NOT NULL,
role        varchar(20),
created_at  datetime DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT PK_users PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE videos(
id          int(255) auto_increment NOT NULL,
user_id     int (255) NOT NULL,
title       varchar(255) NOT NULL,
description text,
url         varchar(255) NOT NULL,
status      varchar(50)
created_at  datetime DEFAULT CURRENT_TIMESTAMP,
updated_at  datetime DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT PK_video PRIMARY KEY(id),
CONSTRAINT FK_video_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;