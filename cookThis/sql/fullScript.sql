-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2020-04-28 21:55:32.668

-- foreign keys
ALTER TABLE recipe_ingredients
    DROP FOREIGN KEY recipe_ingredients_ingredients;

ALTER TABLE recipe_ingredients
    DROP FOREIGN KEY recipe_ingredients_recipes;

ALTER TABLE recipe_ingredients
    DROP FOREIGN KEY recipe_ingredients_units;

ALTER TABLE recipes
    DROP FOREIGN KEY recipes_users;

-- tables
DROP TABLE ingredients;

DROP TABLE recipe_ingredients;

DROP TABLE recipes;

DROP TABLE units;

DROP TABLE users;

DROP TABLE temp_ingredients;

-- End of file.

-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2020-04-28 21:55:32.668

-- tables
-- Table: ingredients
CREATE TABLE ingredients (
    ingredient_id int NOT NULL AUTO_INCREMENT,
    user_id int NOT NULL, 
    ingredient_name varchar(30) NOT NULL,
    CONSTRAINT ingredients_pk PRIMARY KEY (ingredient_id)
);

-- Table: recipe_ingredients
CREATE TABLE recipe_ingredients (
    recipe_ingredient_id int NOT NULL AUTO_INCREMENT,
    ingredient_id int NOT NULL,
    recipe_id int NOT NULL,
    unit_id int NOT NULL,
    ingredient_quantity double(5,2) NOT NULL,
    CONSTRAINT recipe_ingredients_pk PRIMARY KEY (recipe_ingredient_id,ingredient_id,recipe_id)
);

-- Table: recipes
CREATE TABLE recipes (
    recipe_id int NOT NULL AUTO_INCREMENT,
    user_id int NOT NULL,
    time_posted datetime NOT NULL,
    recipe_name varchar(55) NOT NULL,
    recipe_procedure varchar(2500) NOT NULL,
    notes varchar(250) NOT NULL,
    CONSTRAINT recipes_pk PRIMARY KEY (recipe_id,user_id,time_posted)
);

-- Table: units
CREATE TABLE units (
    unit_id int NOT NULL AUTO_INCREMENT,
    unit_name varchar(20) NOT NULL,
    CONSTRAINT units_pk PRIMARY KEY (unit_id)
);

-- Table: users
CREATE TABLE users (
    user_id int NOT NULL AUTO_INCREMENT,
    username varchar(50) NOT NULL,
    password char(80) NOT NULL,
    CONSTRAINT users_pk PRIMARY KEY (user_id)
);

-- foreign keys
-- Reference: recipe_ingredients_ingredients (table: recipe_ingredients)
ALTER TABLE recipe_ingredients ADD CONSTRAINT recipe_ingredients_ingredients FOREIGN KEY recipe_ingredients_ingredients (ingredient_id)
    REFERENCES ingredients (ingredient_id)
    ON DELETE CASCADE;

-- Reference: recipe_ingredients_recipes (table: recipe_ingredients)
ALTER TABLE recipe_ingredients ADD CONSTRAINT recipe_ingredients_recipes FOREIGN KEY recipe_ingredients_recipes (recipe_id)
    REFERENCES recipes (recipe_id)
    ON DELETE CASCADE;

-- Reference: recipe_ingredients_units (table: recipe_ingredients)
ALTER TABLE recipe_ingredients ADD CONSTRAINT recipe_ingredients_units FOREIGN KEY recipe_ingredients_units (unit_id)
    REFERENCES units (unit_id);

-- Reference: recipes_users (table: recipes)
ALTER TABLE recipes ADD CONSTRAINT recipes_users FOREIGN KEY recipes_users (user_id)
    REFERENCES users (user_id);

-- End of file.



-- CONSTRAINT ADDED BY ROB
ALTER TABLE ingredients ADD CONSTRAINT ingredients_users FOREIGN KEY ingredients_users (user_id)
    REFERENCES users (user_id);

-- NEW TABLE BY ROB

CREATE TABLE temp_ingredients (
    temp_ingredient_id int NOT NULL AUTO_INCREMENT,
    user_id int NOT NULL,
    ingredient_id int NOT NULL,
    unit_id int NOT NULL,
    ingredient_quantity double(5,2) NOT NULL,
    CONSTRAINT temp_ingredient_pk PRIMARY KEY (temp_ingredient_id)
);

INSERT INTO units (unit_name) VALUES ('Individual');

INSERT INTO units (unit_name) VALUES ('tsp');

INSERT INTO units (unit_name) VALUES ('tbsp');

INSERT INTO units (unit_name) VALUES ('oz');

INSERT INTO units (unit_name) VALUES ('cup');

INSERT INTO units (unit_name) VALUES ('qt');

INSERT INTO units (unit_name) VALUES ('gal');

INSERT INTO units (unit_name) VALUES ('ml');

INSERT INTO units (unit_name) VALUES ('litre');

INSERT INTO units (unit_name) VALUES ('lb');

INSERT INTO units (unit_name) VALUES ('gram');

INSERT INTO units (unit_name) VALUES ('mg');

INSERT INTO units (unit_name) VALUES ('kg');

INSERT INTO units (unit_name) VALUES ('pinch');

INSERT INTO units (unit_name) VALUES ('dash');

INSERT INTO units (unit_name) VALUES ('handful');

INSERT INTO units (unit_name) VALUES ('stick');