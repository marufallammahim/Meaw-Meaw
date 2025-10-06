<?php
// inc/config.php - DB and common bootstrap
$DB_HOST='localhost';
$DB_NAME='nafisa_hostel';
$DB_USER='root';
$DB_PASS='';
try {
  $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
  ]);
} catch (Exception $e) {
  echo "DB connection failed. ".$e->getMessage();
  exit;
}
function e($v){ return htmlspecialchars($v); }
