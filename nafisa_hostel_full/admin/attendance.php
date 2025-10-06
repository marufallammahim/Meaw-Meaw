<?php
session_start();
require_once __DIR__.'/../inc/config.php';
if (!isset($_SESSION['user_id'])) header('Location: ../auth/login.php');
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['student_id'])) {
    $student=(int)$_POST['student_id']; $status = $_POST['status'];
    $pdo->prepare("INSERT INTO attendance (student_id,status,created_at) VALUES (?,?,NOW())")->execute([$student,$status]);
    header('Location: attendance.php');
}
$atts = $pdo->query("SELECT a.*, s.name FROM attendance a LEFT JOIN students s ON s.id=a.student_id ORDER BY a.created_at DESC")->fetchAll();
$students = $pdo->query("SELECT id,name FROM students")->fetchAll();
?>
<!doctype html><html lang="bn"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>Attendance - Nafisa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<div class="container py-4"><h3>Attendance</h3>
<form method="post" class="row g-2 mb-3">
  <div class="col"><select name="student_id" class="form-select"><?php foreach($students as $s): ?><option value="<?=e($s['id'])?>"><?=e($s['name'])?></option><?php endforeach;?></select></div>
  <div class="col-2"><select name="status" class="form-select"><option value="present">Present</option><option value="absent">Absent</option></select></div>
  <div class="col-2"><button class="btn btn-primary">Mark</button></div>
</form>
<table class="table"><thead><tr><th>When</th><th>Student</th><th>Status</th></tr></thead><tbody>
<?php foreach($atts as $a): ?><tr><td><?=e($a['created_at'])?></td><td><?=e($a['name'])?></td><td><?=e($a['status'])?></td></tr><?php endforeach;?>
</tbody></table>
<a href="dashboard.php" class="btn btn-link">Back</a>
</div></body></html>
