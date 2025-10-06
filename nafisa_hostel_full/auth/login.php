<?php
session_start();
require_once __DIR__.'/../inc/config.php';
if (isset($_SESSION['user_id'])) header('Location: ../admin/dashboard.php');
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    if ($email && $pass) {
        $stmt = $pdo->prepare("SELECT id,fullname,password,role FROM users WHERE email=?");
        $stmt->execute([$email]);
        $u = $stmt->fetch();
        if ($u && password_verify($pass, $u['password'])) {
            $_SESSION['user_id']=$u['id'];
            $_SESSION['user_name']=$u['fullname'];
            $_SESSION['role']=$u['role'];
            header('Location: ../admin/dashboard.php');
            exit;
        } else $msg='ইমেইল বা পাসওয়ার্ড ভুল';
    } else $msg='সব ফিল্ড পূরণ করুন';
}
?>
<!doctype html>
<html lang="bn"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>লগইন - Nafisa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center"><div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="card-title mb-3">Nafisa Hostel - লগইন</h4>
        <?php if($msg): ?><div class="alert alert-danger"><?=htmlspecialchars($msg)?></div><?php endif; ?>
        <form method="post" novalidate>
          <div class="mb-3"><label class="form-label">ইমেইল</label><input name="email" type="email" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">পাসওয়ার্ড</label><input name="password" type="password" class="form-control" required></div>
          <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-primary">লগইন</button>
            <a href="register.php">রেজিস্টার করুন</a>
          </div>
        </form>
      </div>
    </div>
  </div></div>
</div>
</body></html>
