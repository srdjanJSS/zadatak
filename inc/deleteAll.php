<?php 
require_once('crud.php');

$posts = new Crud();

$posts->deleteAll();

header('Location: ..//index.php');
?>