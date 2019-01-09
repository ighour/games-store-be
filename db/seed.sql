-- User (password = secret)
INSERT INTO users (username, email, password, role, avatar) VALUES ('admin', 'admin@gmail.com', '$2y$10$4khdTZNpyfM6zKvf/OFTCuH7nCqCQbwrUcW0AAhSJCJHhjAtDDtF.', 'admin', 'user1.png');
INSERT INTO users (username, email, password, avatar) VALUES ('user1', 'user1@gmail.com', '$2y$10$4khdTZNpyfM6zKvf/OFTCuH7nCqCQbwrUcW0AAhSJCJHhjAtDDtF.', 'user2.png');
INSERT INTO users (username, email, password, avatar) VALUES ('user2', 'user2@gmail.com', '$2y$10$4khdTZNpyfM6zKvf/OFTCuH7nCqCQbwrUcW0AAhSJCJHhjAtDDtF.', 'user3.png');
INSERT INTO users (username, email, password, avatar) VALUES ('user3', 'user3@gmail.com', '$2y$10$4khdTZNpyfM6zKvf/OFTCuH7nCqCQbwrUcW0AAhSJCJHhjAtDDtF.', NULL);
INSERT INTO users (username, email, password, avatar) VALUES ('user4', 'user4@gmail.com', '$2y$10$4khdTZNpyfM6zKvf/OFTCuH7nCqCQbwrUcW0AAhSJCJHhjAtDDtF.', 'user4.png');
INSERT INTO users (username, email, password, avatar) VALUES ('user5', 'user5@gmail.com', '$2y$10$4khdTZNpyfM6zKvf/OFTCuH7nCqCQbwrUcW0AAhSJCJHhjAtDDtF.', NULL);

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
INSERT INTO items (name, type, description, amount, image, item_category_id, user_id) VALUES ('Red Dead Redemption II', 'used', NULL, 68.2, 'game1.png', 1, 2);
INSERT INTO items (name, type, description, amount, image, item_category_id, user_id) VALUES ('God of War', 'new', NULL, 42.0, 'game2.png', 1, 2);
INSERT INTO items (name, type, description, amount, image, item_category_id, user_id) VALUES ('Horizon Zero Dawn', 'used', 'Special Edition', 27.32, 'game3.png', 1, 2);

INSERT INTO items (name, type, description, amount, image, item_category_id, user_id) VALUES ('Dark Souls', 'new', NULL, 7.12, NULL, 2, 3);
INSERT INTO items (name, type, description, amount, image, item_category_id, user_id) VALUES ('The Last of Us', 'used', NULL, 9.0, 'game5.png', 2, 3);

INSERT INTO items (name, type, description, amount, image, item_category_id, user_id) VALUES ('The Legend of Zelda', 'new', 'Limited Edition', 42.0, 'game6.png', 6, 4);
INSERT INTO items (name, type, description, amount, image, item_category_id, user_id) VALUES ('Diablo III', 'used', NULL, 21.4, NULL, 6, 4);
INSERT INTO items (name, type, description, amount, image, item_category_id, user_id) VALUES ('Monster Hunter Generations Ultimate', 'used', 'Bough on 04 November 2018', 12.7, 'game8.png', 6, 4);