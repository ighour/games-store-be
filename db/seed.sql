-- User (password = secret)
INSERT INTO users (username, email, password, role) VALUES ('admin', 'admin@gmail.com', '$2y$10$4khdTZNpyfM6zKvf/OFTCuH7nCqCQbwrUcW0AAhSJCJHhjAtDDtF.', 'admin');
INSERT INTO users (username, email, password) VALUES ('user1', 'user1@gmail.com', '$2y$10$4khdTZNpyfM6zKvf/OFTCuH7nCqCQbwrUcW0AAhSJCJHhjAtDDtF.');
INSERT INTO users (username, email, password) VALUES ('user2', 'user2@gmail.com', '$2y$10$4khdTZNpyfM6zKvf/OFTCuH7nCqCQbwrUcW0AAhSJCJHhjAtDDtF.');
INSERT INTO users (username, email, password) VALUES ('user3', 'user3@gmail.com', '$2y$10$4khdTZNpyfM6zKvf/OFTCuH7nCqCQbwrUcW0AAhSJCJHhjAtDDtF.');
INSERT INTO users (username, email, password) VALUES ('user4', 'user4@gmail.com', '$2y$10$4khdTZNpyfM6zKvf/OFTCuH7nCqCQbwrUcW0AAhSJCJHhjAtDDtF.');
INSERT INTO users (username, email, password) VALUES ('user5', 'user5@gmail.com', '$2y$10$4khdTZNpyfM6zKvf/OFTCuH7nCqCQbwrUcW0AAhSJCJHhjAtDDtF.');

-- Item Category
INSERT INTO item_categories (name) VALUES ('PS4');
INSERT INTO item_categories (name) VALUES ('PS3');
INSERT INTO item_categories (name) VALUES ('PS Vita');
INSERT INTO item_categories (name) VALUES ('Xbox One');
INSERT INTO item_categories (name) VALUES ('Xbox 360');
INSERT INTO item_categories (name) VALUES ('Nintendo Switch');
INSERT INTO item_categories (name) VALUES ('Wii U');
INSERT INTO item_categories (name) VALUES ('Nintendo 3DS');