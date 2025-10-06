<?php
session_start();
require_once __DIR__.'/../inc/config.php';
if (!isset($_SESSION['user_id'])) header('Location: ../auth/login.php');
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $title=trim($_POST['title']); $body=trim($_POST['body']);
    $pdo->prepare("INSERT INTO notices (title,body,created_at) VALUES (?,?,NOW())")->execute([$title,$body]);
    header('Location: notices.php');
}
if (isset($_GET['del'])) { $pdo->prepare("DELETE FROM notices WHERE id=?")->execute([(int)$_GET['del']]); header('Location: notices.php'); }
$notes = $pdo->query("SELECT * FROM notices ORDER BY created_at DESC")->fetchAll();
?>
<!doctype html><html lang="bn"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>Notices - Nafisa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<div class="container py-4"><h3>Notices</h3>
<form method="post" class="mb-3">
  <input name="title" class="form-control mb-2" placeholder="Title" required>
  <textarea name="body" class="form-control mb-2" placeholder="Body"></textarea>
  <button class="btn btn-primary">Post Notice</button>
</form>
<ul class="list-group">
<?php foreach($notes as $n): ?><li class="list-group-item">
  <strong><?=e($n['title'])?></strong> <small class="text-muted"><?=e($n['created_at'])?></small>
  <p><?=e($n['body'])?></p>
  <a class="btn btn-sm btn-danger" href="?del=<?=e($n['id'])?>" onclick="return confirm('Delete?')">Delete</a>
</li><?php endforeach;?>
</ul>
<a href="dashboard.php" class="btn btn-link">Back</a>
</div></body></html>
