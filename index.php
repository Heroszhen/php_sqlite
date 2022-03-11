<?php

require_once "ToolService.php";
require_once "Tables.php";

//1.get PDO and connect to database
$db_path = "dbs/test.db";
$pdo = new PDO("sqlite:" . $db_path);
if ($pdo) echo "connected";
else echo "err";

//2.create or drop tables
Tables::createTables($pdo, "tables.sql");
//Tables::emptyBDD($pdo);

//$query = "insert into user (name) values (:name)";
$query = "select * from contact";
$query = Tables::exec($pdo, $query);
$data = $query->fetchAll(PDO::FETCH_ASSOC);

ToolService::dump($data);
