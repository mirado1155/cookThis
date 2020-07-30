-- Adminer 4.7.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE `ingredients` (
  `ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ingredient_name` varchar(30) NOT NULL,
  PRIMARY KEY (`ingredient_id`),
  KEY `ingredients_users` (`user_id`),
  CONSTRAINT `ingredients_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `ingredients` (`ingredient_id`, `user_id`, `ingredient_name`) VALUES
(1,	1,	'Flour, all purpose'),
(2,	1,	'Baking Powder'),
(3,	1,	'Salt'),
(4,	1,	'Sugar, white'),
(5,	1,	'milk'),
(6,	1,	'egg'),
(7,	1,	'butter');

DROP TABLE IF EXISTS `recipes`;
CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `time_posted` datetime NOT NULL,
  `recipe_name` varchar(55) NOT NULL,
  `recipe_procedure` varchar(2500) NOT NULL,
  `notes` varchar(250) NOT NULL,
  PRIMARY KEY (`recipe_id`,`user_id`,`time_posted`),
  KEY `recipes_users` (`user_id`),
  CONSTRAINT `recipes_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `recipes` (`recipe_id`, `user_id`, `time_posted`, `recipe_name`, `recipe_procedure`, `notes`) VALUES
(1,	1,	'2020-05-03 12:44:17',	'Pancakessssssssssssssssssss from Allrecipes',	'In a large bowl, sift together the flour, baking powder, salt and sugar. Make a well in the center and pour in the milk, egg and melted butter; mix until smooth.\r\nHeat a lightly oiled griddle or frying pan over medium high heat. Pour or scoop the batter onto the griddle, using approximately 1/4 cup for each pancake. Brown on both sides and serve hot.',	'Note here'),
(2,	1,	'2020-05-03 12:45:21',	'Pancakessssssssssssssssssss from Allrecipes',	'In a large bowl, sift together the flour, baking powder, salt and sugar. Make a well in the center and pour in the milk, egg and melted butter; mix until smooth.\r\nHeat a lightly oiled griddle or frying pan over medium high heat. Pour or scoop the batter onto the griddle, using approximately 1/4 cup for each pancake. Brown on both sides and serve hot.',	'Note here Second note here');

DROP TABLE IF EXISTS `recipe_ingredients`;
CREATE TABLE `recipe_ingredients` (
  `recipe_ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
  `ingredient_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `ingredient_quantity` double(5,2) NOT NULL,
  PRIMARY KEY (`recipe_ingredient_id`,`ingredient_id`,`recipe_id`),
  KEY `recipe_ingredients_ingredients` (`ingredient_id`),
  KEY `recipe_ingredients_recipes` (`recipe_id`),
  KEY `recipe_ingredients_units` (`unit_id`),
  CONSTRAINT `recipe_ingredients_ingredients` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`ingredient_id`) ON DELETE CASCADE,
  CONSTRAINT `recipe_ingredients_recipes` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE,
  CONSTRAINT `recipe_ingredients_units` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `recipe_ingredients` (`recipe_ingredient_id`, `ingredient_id`, `recipe_id`, `unit_id`, `ingredient_quantity`) VALUES
(1,	1,	1,	5,	1.50),
(2,	2,	1,	2,	3.50),
(3,	3,	1,	2,	1.00),
(4,	4,	1,	3,	1.00),
(5,	6,	1,	1,	1.00),
(6,	7,	1,	3,	3.00),
(7,	1,	2,	5,	1.50),
(8,	2,	2,	2,	3.50),
(9,	3,	2,	2,	1.00),
(10,	4,	2,	3,	1.00),
(11,	6,	2,	1,	1.00),
(12,	7,	2,	3,	3.50);

DROP TABLE IF EXISTS `temp_ingredients`;
CREATE TABLE `temp_ingredients` (
  `temp_ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `ingredient_quantity` double(5,2) NOT NULL,
  PRIMARY KEY (`temp_ingredient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(20) NOT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `units` (`unit_id`, `unit_name`) VALUES
(1,	'Individual'),
(2,	'tsp'),
(3,	'tbsp'),
(4,	'oz'),
(5,	'cup'),
(6,	'qt'),
(7,	'gal'),
(8,	'ml'),
(9,	'litre'),
(10,	'lb'),
(11,	'gram'),
(12,	'mg'),
(13,	'kg'),
(14,	'pinch'),
(15,	'dash'),
(16,	'handful'),
(17,	'stick');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(80) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(1,	'newguy',	'f3bbbd66a63d4bf1747940578ec3d0103530e21d');

-- 2020-05-03 18:01:20