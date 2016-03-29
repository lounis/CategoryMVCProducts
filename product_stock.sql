-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 29 Mars 2016 à 12:27
-- Version du serveur: 5.5.47-0ubuntu0.14.04.1
-- Version de PHP: 5.6.19-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `product_stock`
--
CREATE DATABASE IF NOT EXISTS `product_stock` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `product_stock`;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `category` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'Shampoing'),
(3, 'style');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `designation` varchar(25) NOT NULL,
  `price` decimal(10,0) DEFAULT '0',
  `vat` decimal(3,2) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `categoryId` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `products`
--

INSERT INTO `products` (`id`, `designation`, `price`, `vat`, `quantity`, `categoryId`) VALUES
(2, 'head & shoulders', 56, 9.99, 10, 1),
(3, 'DOP', 56, 9.99, 10, 1),
(5, 'head &', 56, 9.99, 20, 1),
(6, 'T-shirt', 10, 9.99, 10, 3);

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateOfStock` timestamp NULL DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `productId` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `stock`
--

INSERT INTO `stock` (`id`, `dateOfStock`, `quantity`, `productId`) VALUES
(1, '0000-00-00 00:00:00', 5555, 1),
(2, '0000-00-00 00:00:00', 555, 1),
(3, '2016-03-20 23:00:00', 10, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
