-- DB
CREATE DATABASE IF NOT EXISTS saw;

-- User
CREATE TABLE users (
  id int NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  role varchar(255),
  avatar varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
);

-- Blacklist Token
CREATE TABLE token_blacklist (
  id int NOT NULL AUTO_INCREMENT,
  token text NOT NULL,
  PRIMARY KEY (id)
);

-- Recover Password Token
CREATE TABLE recover_tokens (
  id int NOT NULL AUTO_INCREMENT,
  token text NOT NULL,
  email varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

-- Item Categories
CREATE TABLE item_categories (
  id int NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL UNIQUE,
  PRIMARY KEY (id)
);

-- Items
CREATE TABLE items (
  id int NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  type ENUM('new', 'used') NOT NULL,
  description varchar(255) DEFAULT NULL,
  amount DOUBLE(10, 2) NOT NULL,
  item_category_id INT NOT NULL,
  user_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (item_category_id) REFERENCES item_categories(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);