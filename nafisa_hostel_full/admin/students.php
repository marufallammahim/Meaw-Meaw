<?php
session_start();
require_once __DIR__.'/../inc/config.php';
if (!isset($_SESSION['user_id'])) header('Location: ../auth/login.php');
$act = $_GET['act'] ?? '';
if ($act==='add' && $_SERVER['REQUEST_METHOD']==='POST') {
    $name=trim($_POST['name']); $email=trim($_POST['email']); $room_id=(int)$_POST['room_id'];
    $stmt=$pdo->prepare("INSERT INTO students (name,email,room_id,created_at) VALUES (?,?,?,NOW())");
    $stmt->execute([$name,$email,$room_id]); header('Location: students.php');
}
if ($act==='del') { $id=(int)$_GET['id']; $pdo->prepare("DELETE FROM students WHERE id=?")->execute([$id]); header('Location: students.php'); }
$students = $pdo->query("SELECT s.*, r.name AS room_name FROM students s LEFT JOIN rooms r ON r.id=s.room_id ORDER BY s.id DESC")->fetchAll();
$rooms = $pdo->query("SELECT * FROM rooms")->fetchAll();
?>
<!doctype html><html lang="bn"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>Students - Nafisa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<div class="container py-4"><h3>Students</h3>
<form class="row g-2 mb-3" method="post" action="?act=add">
  <div class="col"><input name="name" required class="form-control" placeholder="Full name"></div>
  <div class="col"><input name="email" type="email" class="form-control" placeholder="Email"></div>
  <div class="col-2"><select name="room_id" class="form-select"><?php foreach($rooms as $r): ?><option value="<?=e($r['id'])?>"><?=e($r['name'])?></option><?php endforeach;?></select></div>
  <div class="col-2"><button class="btn btn-primary">Add Student</button></div>
</form>
<table class="table"><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Room</th><th>Action</th></tr></thead><tbody>
<?php foreach($students as $s): ?>
<tr><td><?=e($s['id'])?></td><td><?=e($s['name'])?></td><td><?=e($s['email'])?></td><td><?=e($s['room_name'])?></td>
<td><a class="btn btn-sm btn-danger" href="?act=del&id=<?=e($s['id'])?>" onclick="return confirm('Sure?')">Delete</a></td></tr>
<?php endforeach;?>
</tbody></table>
<a href="dashboard.php" class="btn btn-link">Back</a>
</div></body></html>
