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

-- Items
INSERT INTO items (name, type, description, amount, item_category_id, user_id) VALUES ('Red Dead Redemption II', 'used', NULL, 68.2, 1, 2);
INSERT INTO items (name, type, description, amount, item_category_id, user_id) VALUES ('God of War', 'new', NULL, 42.0, 1, 2);
INSERT INTO items (name, type, description, amount, item_category_id, user_id) VALUES ('Horizon Zero Dawn', 'used', 'Special Edition', 27.32, 1, 2);

INSERT INTO items (name, type, description, amount, item_category_id, user_id) VALUES ('Dark Souls', 'new', NULL, 7.12, 2, 3);
INSERT INTO items (name, type, description, amount, item_category_id, user_id) VALUES ('The Last of Us', 'used', NULL, 9.0, 2, 3);

INSERT INTO items (name, type, description, amount, item_category_id, user_id) VALUES ('The Legend of Zelda', 'new', 'Limited Edition', 42.0, 6, 4);
INSERT INTO items (name, type, description, amount, item_category_id, user_id) VALUES ('Diablo III', 'used', NULL, 21.4, 6, 4);
INSERT INTO items (name, type, description, amount, item_category_id, user_id) VALUES ('Monster Hunter Generations Ultimate', 'used', 'Bough on 04 November 2018', 12.7, 6, 4);