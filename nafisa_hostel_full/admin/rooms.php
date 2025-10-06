<?php
session_start();
require_once __DIR__.'/../inc/config.php';
if (!isset($_SESSION['user_id'])) header('Location: ../auth/login.php');
$act = $_GET['act'] ?? '';
if ($act==='add' && $_SERVER['REQUEST_METHOD']==='POST') {
    $name=trim($_POST['name']); $capacity=(int)$_POST['capacity'];
    $stmt=$pdo->prepare("INSERT INTO rooms (name,capacity,created_at) VALUES (?,?,NOW())");
    $stmt->execute([$name,$capacity]); header('Location: rooms.php');
}
if ($act==='del') {
    $id=(int)$_GET['id']; $pdo->prepare("DELETE FROM rooms WHERE id=?")->execute([$id]); header('Location: rooms.php');
}
$rooms = $pdo->query("SELECT * FROM rooms ORDER BY id DESC")->fetchAll();
?>
<!doctype html><html lang="bn"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>Rooms - Nafisa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<div class="container py-4"><h3>Rooms</h3>
<form class="row g-2 mb-3" method="post" action="?act=add">
  <div class="col"><input name="name" required class="form-control" placeholder="Room name eg: A-101"></div>
  <div class="col-2"><input name="capacity" type="number" min="1" value="1" class="form-control" required></div>
  <div class="col-2"><button class="btn btn-primary">Add Room</button></div>
</form>
<table class="table table-striped"><thead><tr><th>ID</th><th>Name</th><th>Capacity</th><th>Action</th></tr></thead><tbody>
<?php foreach($rooms as $r): ?>
<tr><td><?=e($r['id'])?></td><td><?=e($r['name'])?></td><td><?=e($r['capacity'])?></td>
<td><a class="btn btn-sm btn-danger" href="?act=del&id=<?=e($r['id'])?>" onclick="return confirm('Sure?')">Delete</a></td></tr>
<?php endforeach; ?>
</tbody></table>
<a href="dashboard.php" class="btn btn-link">Back</a>
</div></body></html>
