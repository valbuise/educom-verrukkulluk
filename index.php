<?php

require_once("lib/database.php");
require_once("lib/artikel.php");

/// INIT
$db = new database();
$art = new artikel($db->getConnection());


/// VERWERK 
$data = $art->selecteerArtikel(8);

/// RETURN
var_dump($data);