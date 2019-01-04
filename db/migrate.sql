-- DB
CREATE DATABASE IF NOT EXISTS saw;

-- User
CREATE TABLE users (
  id int NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  role varchar(255),
  PRIMARY KEY (id)
);

-- Blacklist Token
CREATE TABLE token_blacklist (
  id int NOT NULL AUTO_INCREMENT,
  token text NOT NULL,
  PRIMARY KEY (id)
);