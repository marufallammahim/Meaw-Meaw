<?php
session_start();
require_once __DIR__.'/../inc/config.php';
if (!isset($_SESSION['user_id'])) header('Location: ../auth/login.php');
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['menu'])) {
    $menu=trim($_POST['menu']); $for_date=$_POST['for_date'];
    $pdo->prepare("INSERT INTO meals (menu,for_date,created_at) VALUES (?,?,NOW())")->execute([$menu,$for_date]);
    header('Location: meals.php');
}
$meals = $pdo->query("SELECT * FROM meals ORDER BY for_date DESC")->fetchAll();
?>
<!doctype html><html lang="bn"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>Meals - Nafisa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<div class="container py-4"><h3>Meals</h3>
<form method="post" class="mb-3">
  <input name="for_date" type="date" class="form-control mb-2" required>
  <input name="menu" class="form-control mb-2" placeholder="Menu (e.g., Rice, Curry, Salad)" required>
  <button class="btn btn-primary">Add Meal</button>
</form>
<ul class="list-group">
<?php foreach($meals as $m): ?><li class="list-group-item"><?=e($m['for_date'])?> — <?=e($m['menu'])?></li><?php endforeach;?>
</ul>
<a href="dashboard.php" class="btn btn-link">Back</a>
</div></body></html>
