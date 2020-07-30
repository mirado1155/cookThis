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

