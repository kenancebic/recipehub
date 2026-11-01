CREATE DATABASE IF NOT EXISTS recipehub
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE recipehub;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS meal_plan_items;
DROP TABLE IF EXISTS meal_plans;
DROP TABLE IF EXISTS saved_recipes;
DROP TABLE IF EXISTS recipe_ingredients;
DROP TABLE IF EXISTS ingredients;
DROP TABLE IF EXISTS recipes;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    instructions TEXT NOT NULL,
    difficulty ENUM('easy', 'medium', 'hard') NOT NULL DEFAULT 'easy',
    prep_time INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE RESTRICT
);

CREATE TABLE ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE recipe_ingredients (
    recipe_id INT NOT NULL,
    ingredient_id INT NOT NULL,
    quantity VARCHAR(100) NOT NULL,
    PRIMARY KEY (recipe_id, ingredient_id),
    FOREIGN KEY (recipe_id) REFERENCES recipes(id)
        ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id)
        ON DELETE CASCADE
);

CREATE TABLE saved_recipes (
    user_id INT NOT NULL,
    recipe_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, recipe_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id)
        ON DELETE CASCADE
);

CREATE TABLE meal_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE TABLE meal_plan_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    meal_plan_id INT NOT NULL,
    recipe_id INT NOT NULL,
    planned_date DATE NOT NULL,
    meal_type ENUM('breakfast', 'lunch', 'dinner', 'snack') NOT NULL,
    FOREIGN KEY (meal_plan_id) REFERENCES meal_plans(id)
        ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id)
        ON DELETE CASCADE
);

INSERT INTO users (name, email, password, role) VALUES
('RecipeHub Admin', 'admin@recipehub.test', 'sample_hash_admin', 'admin'),
('Demo User', 'user@recipehub.test', 'sample_hash_user', 'user');

INSERT INTO categories (name) VALUES
('Breakfast'),
('Lunch'),
('Dinner'),
('Dessert');

INSERT INTO recipes
(user_id, category_id, title, description, instructions, difficulty, prep_time)
VALUES
(2, 1, 'Pancakes', 'Simple fluffy pancakes.',
 'Mix ingredients, pour into a hot pan, cook both sides.', 'easy', 20),
(2, 2, 'Vegetable Pasta', 'Pasta with fresh vegetables.',
 'Cook pasta, sauté vegetables, combine and serve.', 'easy', 30),
(1, 3, 'Roasted Chicken', 'Oven-roasted chicken.',
 'Season chicken and roast until fully cooked.', 'medium', 60),
(1, 4, 'Chocolate Cake', 'A simple chocolate cake.',
 'Mix batter and bake until ready.', 'medium', 50);

INSERT INTO ingredients (name) VALUES
('Flour'),
('Milk'),
('Eggs'),
('Pasta'),
('Tomatoes'),
('Chicken'),
('Chocolate'),
('Sugar');

INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity) VALUES
(1, 1, '200 g'),
(1, 2, '250 ml'),
(1, 3, '2'),
(2, 4, '200 g'),
(2, 5, '2'),
(3, 6, '1 whole'),
(4, 7, '100 g'),
(4, 8, '150 g');

INSERT INTO saved_recipes (user_id, recipe_id) VALUES
(2, 1),
(2, 2);

INSERT INTO meal_plans (user_id, name, start_date, end_date) VALUES
(2, 'My First Weekly Plan', '2026-11-02', '2026-11-08');

INSERT INTO meal_plan_items
(meal_plan_id, recipe_id, planned_date, meal_type)
VALUES
(1, 1, '2026-11-02', 'breakfast'),
(1, 2, '2026-11-02', 'lunch'),
(1, 3, '2026-11-03', 'dinner');