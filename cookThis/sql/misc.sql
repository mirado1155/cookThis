
-- This query gets ingredient, unit, and quantity in order to display them in a table
SELECT ingredient_name, unit_name, ingredient_quantity
    FROM ingredients as i
    JOIN temp_ingredients as t ON t.ingredient_id = i.ingredient_id
    JOIN units as u ON u.unit_id = t.unit_id
    WHERE t.ingredient_id = i.ingredient_id
    AND t.user_id = 1;


-- This query gets a list of ingredients
SELECT ingredient_id, ingredient_name FROM ingredients;


-- Gets a specific recipe
SELECT recipe_id, user_id, recipe_name, recipe_procedure, notes
    FROM recipes
    WHERE user_id = ''
    AND recipe_id = '';

-- Gets ingredients for a specific recipe
SELECT i.ingredient_name, u.unit_name, ri.ingredient_quantity
    FROM ingredients as i
    JOIN recipe_ingredients as ri ON i.ingredient_id = ri.ingredient_id
    JOIN units as u ON u.unit_id = ri.unit_id
    JOIN recipes as r ON r.recipe_id = ri.recipe_id
    WHERE ri.ingredient_id = i.ingredient_id
    AND ri.recipe_id = 5
    AND r.user_id = 1;

