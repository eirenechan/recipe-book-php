-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 17, 2023 at 12:18 PM
-- Server version: 8.0.33-0ubuntu0.22.04.1
-- PHP Version: 8.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_recipes`
--

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `category`) VALUES
(1, 'apple', 'fruits'),
(2, 'potato', 'carbohydrates'),
(3, 'sugar', 'condiments'),
(4, 'egg', NULL),
(5, 'rice', 'carbohydrates'),
(6, 'spaghetti', 'carbohydrates'),
(7, 'salt', 'condiments'),
(8, 'flour', 'dried ingredients'),
(9, 'pepper', 'condiments'),
(10, 'cabbage', 'vegetables'),
(11, 'pumpkin', 'vegetables'),
(12, 'avocado', 'fruits'),
(13, 'tomato', 'vegetables'),
(14, 'chicken breast', 'meat & seafood'),
(15, 'fish', 'meat & seafood'),
(16, 'pumpkin seed', 'dried ingredients'),
(17, 'pork', 'meat & seafood'),
(18, 'beef', 'meat & seafood'),
(19, 'zucchini', 'vegetables'),
(20, 'carrot', 'vegetables'),
(21, 'chick pea', 'vegetables'),
(22, 'spinach', 'vegetables'),
(23, 'mushroom', 'vegetables'),
(24, 'scallop', 'meat & seafood'),
(25, 'penne', 'carbohydrates'),
(26, 'milk', 'dairy'),
(27, 'maple syrup', NULL),
(28, 'banana', 'fruits'),
(29, 'cheese', 'dairy'),
(30, 'yogurt', 'dairy'),
(31, 'cocoa powder', 'dried ingredients'),
(32, 'baking soda', 'dried ingredients'),
(33, 'baking powder', 'dried ingredients'),
(34, 'oil', NULL),
(35, 'water', NULL),
(36, 'cinnamon', 'condiments'),
(37, 'bacon', 'meat & seafood');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `name`) VALUES
(69, 'One Bowl Chocolate Cake'),
(70, 'Pumpkin pie'),
(71, 'Spaghetti Carbonara');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ingredients`
--

CREATE TABLE `recipe_ingredients` (
  `id` int NOT NULL,
  `recipe_id` int NOT NULL,
  `ingredient_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recipe_ingredients`
--

INSERT INTO `recipe_ingredients` (`id`, `recipe_id`, `ingredient_id`) VALUES
(67, 69, 31),
(68, 69, 32),
(69, 69, 33),
(70, 69, 34),
(71, 69, 35),
(72, 69, 8),
(73, 69, 7),
(74, 69, 3),
(75, 69, 4),
(76, 69, 26),
(77, 70, 36),
(78, 70, 7),
(79, 70, 26),
(80, 70, 11),
(81, 70, 4),
(82, 71, 37),
(83, 71, 6),
(84, 71, 9),
(85, 71, 29),
(86, 71, 4),
(87, 71, 34);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_utensils`
--

CREATE TABLE `recipe_utensils` (
  `id` int NOT NULL,
  `recipe_id` int NOT NULL,
  `utensil_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recipe_utensils`
--

INSERT INTO `recipe_utensils` (`id`, `recipe_id`, `utensil_id`) VALUES
(6, 69, 17),
(7, 69, 18),
(8, 69, 19),
(9, 69, 16),
(10, 69, 3),
(11, 69, 4),
(12, 70, 16),
(13, 70, 17),
(14, 71, 1),
(15, 71, 5),
(16, 71, 3),
(18, 71, 1),
(19, 71, 5),
(20, 71, 3);

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `id` int NOT NULL,
  `recipe_id` int NOT NULL,
  `sequence` int NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `steps`
--

INSERT INTO `steps` (`id`, `recipe_id`, `sequence`, `description`) VALUES
(38, 69, 1, 'Preheat oven to 350 degrees F (175 degrees C). Grease and flour two nine inch round pans.'),
(39, 69, 2, 'In a large bowl, stir together the sugar, flour, cocoa, baking powder, baking soda and salt.'),
(40, 69, 3, 'Add the eggs, milk and oil, mix for 2 minutes on medium speed of mixer.'),
(41, 69, 4, 'Stir in the boiling water last. Batter will be thin.'),
(42, 69, 5, 'Pour evenly into the prepared molds.'),
(43, 69, 6, 'Bake 30 to 35 minutes in the preheated oven, until the cake tests done with a toothpick. Cool in the pans for 10 minutes, then remove to a wire rack to cool completely.'),
(44, 70, 1, 'Make pumpkin puree. Mix all the ingredients.'),
(45, 70, 2, 'Pour the mixture into your pie crust (store-bought or homemade is fine). Bake in the preheated oven until a knife inserted 1 inch from the crust comes out clean.'),
(46, 70, 3, 'Let cool and serve, refrigerate, or freeze.'),
(47, 71, 1, 'Cook the bacan in olive oil until browned and crispy, then drain on paper towels.'),
(48, 71, 2, 'Boil the spaghetti in salted water. Drain and return to the pot. Let cool.'),
(49, 71, 3, 'Whisk the eggs, 1/2 of the cheese, and some pepper in a bowl until smooth.'),
(50, 71, 4, 'Pour the egg mixture over the pasta, stirring quickly, until creamy.'),
(51, 71, 5, 'Stir in the pork, then top with the remaining cheese and more black pepper.');

-- --------------------------------------------------------

--
-- Table structure for table `utensils`
--

CREATE TABLE `utensils` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `utensils`
--

INSERT INTO `utensils` (`id`, `name`) VALUES
(1, 'frying pan'),
(2, 'measuring cup'),
(3, 'spatula'),
(4, 'whisker'),
(5, 'saucepan'),
(6, 'teaspoon'),
(7, 'tablespoon'),
(8, 'fork'),
(9, 'knife'),
(10, 'cutting board'),
(11, 'drainer'),
(12, 'spoon'),
(13, 'cup'),
(14, 'peeler'),
(15, 'blender'),
(16, 'mixing bowl'),
(17, 'oven'),
(18, 'mixer'),
(19, 'baking mold');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingredient` (`ingredient_id`),
  ADD KEY `recipe` (`recipe_id`);

--
-- Indexes for table `recipe_utensils`
--
ALTER TABLE `recipe_utensils`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utensil` (`utensil_id`),
  ADD KEY `recipe_utensil` (`recipe_id`);

--
-- Indexes for table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `steps` (`recipe_id`);

--
-- Indexes for table `utensils`
--
ALTER TABLE `utensils`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `recipe_utensils`
--
ALTER TABLE `recipe_utensils`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `steps`
--
ALTER TABLE `steps`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `utensils`
--
ALTER TABLE `utensils`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD CONSTRAINT `ingredient` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`),
  ADD CONSTRAINT `recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recipe_utensils`
--
ALTER TABLE `recipe_utensils`
  ADD CONSTRAINT `recipe_utensil` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utensil` FOREIGN KEY (`utensil_id`) REFERENCES `utensils` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `steps` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
