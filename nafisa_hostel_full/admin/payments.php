<?php
session_start();
require_once __DIR__.'/../inc/config.php';
if (!isset($_SESSION['user_id'])) header('Location: ../auth/login.php');
$act=$_GET['act'] ?? '';
if ($act==='add' && $_SERVER['REQUEST_METHOD']==='POST') {
    $student_id=(int)$_POST['student_id']; $amount=(float)$_POST['amount']; $due=(float)$_POST['amount_due'];
    $stmt=$pdo->prepare("INSERT INTO payments (student_id,amount,amount_due,notes,created_at) VALUES (?,?,?,?,NOW())");
    $stmt->execute([$student_id,$amount,$due,$_POST['notes']]);
    header('Location: payments.php');
}
if ($act==='del'){ $id=(int)$_GET['id']; $pdo->prepare("DELETE FROM payments WHERE id=?")->execute([$id]); header('Location: payments.php'); }
$payments = $pdo->query("SELECT p.*, s.name AS student FROM payments p LEFT JOIN students s ON s.id=p.student_id ORDER BY p.id DESC")->fetchAll();
$students = $pdo->query("SELECT id,name FROM students")->fetchAll();
?>
<!doctype html><html lang="bn"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>Payments - Nafisa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<div class="container py-4"><h3>Payments</h3>
<form method="post" action="?act=add" class="row g-2 mb-3">
  <div class="col"><select name="student_id" class="form-select"><?php foreach($students as $st): ?><option value="<?=e($st['id'])?>"><?=e($st['name'])?></option><?php endforeach;?></select></div>
  <div class="col-2"><input name="amount" type="number" step="0.01" class="form-control" placeholder="Amount" required></div>
  <div class="col-2"><input name="amount_due" type="number" step="0.01" class="form-control" placeholder="Due"></div>
  <div class="col"><input name="notes" class="form-control" placeholder="Notes"></div>
  <div class="col-1"><button class="btn btn-primary">Add</button></div>
</form>
<table class="table"><thead><tr><th>ID</th><th>Student</th><th>Amount</th><th>Due</th><th>When</th><th>Action</th></tr></thead><tbody>
<?php foreach($payments as $p): ?>
<tr><td><?=e($p['id'])?></td><td><?=e($p['student'])?></td><td><?=e($p['amount'])?></td><td><?=e($p['amount_due'])?></td><td><?=e($p['created_at'])?></td>
<td><a class="btn btn-sm btn-danger" href="?act=del&id=<?=e($p['id'])?>" onclick="return confirm('Sure?')">Delete</a></td></tr>
<?php endforeach;?>
</tbody></table>
<a href="dashboard.php" class="btn btn-link">Back</a>
</div></body></html>
