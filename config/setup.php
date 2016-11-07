<?php
require_once ('database.php');
try
{
	$DB = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$DB->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
	$DB->query('CREATE DATABASE IF NOT EXISTS JLCamagru');
	$DB = NULL;
	$DB = new PDO('mysql:host=localhost;dbname=JLCamagru', $DB_USER, $DB_PASSWORD);
	$DB->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
	$DB->query('CREATE TABLE IF NOT EXISTS Users (
		ID INT(11) AUTO_INCREMENT PRIMARY KEY,
		login VARCHAR(255),
		passwd VARCHAR(255),
		email VARCHAR(255),
		keyconfirm VARCHAR(255),
		confirm int(1) DEFAULT 0
	)');
	$DB->query('CREATE TABLE IF NOT EXISTS Photos (
		ID INT(11) AUTO_INCREMENT PRIMARY KEY,
		login VARCHAR(255),
		link MEDIUMTEXT
	)');
	$DB->query('CREATE TABLE IF NOT EXISTS Comments (
		ID INT(11) AUTO_INCREMENT PRIMARY KEY,
		ID_photo INT(11),
		loginphoto VARCHAR(255),
		login VARCHAR(255),
		comment VARCHAR(255),
		datecom DATE
	)');
	$DB->query('CREATE TABLE IF NOT EXISTS Love (
		ID INT(11) AUTO_INCREMENT PRIMARY KEY,
		ID_photo INT(11),
		login VARCHAR(255)
	)');
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
?>
