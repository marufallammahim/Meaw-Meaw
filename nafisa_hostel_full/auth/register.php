<?php
session_start();
require_once __DIR__.'/../inc/config.php';
$msg='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'student';
    if ($fullname && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password)>=6) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email=?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) $msg='ইমেইলটি ইতোমধ্যেই আছে';
        else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $pdo->prepare("INSERT INTO users (fullname,email,password,role,created_at) VALUES (?,?,?,?,NOW())");
            $ins->execute([$fullname,$email,$hash,$role]);
            header('Location: login.php?registered=1');
            exit;
        }
    } else $msg='সঠিক তথ্য দিন (পাসওয়ার্ড ৬ অক্ষর বা বেশি)';
}
?>
<!doctype html><html lang="bn"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>রেজিস্টার - Nafisa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="bg-light">
<div class="container py-5"><div class="row justify-content-center"><div class="col-md-7">
<div class="card"><div class="card-body">
<h4>নতুন অ্যাকাউন্ট তৈরি</h4>
<?php if($msg): ?><div class="alert alert-danger"><?=htmlspecialchars($msg)?></div><?php endif; ?>
<form method="post">
  <div class="mb-3"><label>পূর্ণ নাম</label><input name="fullname" class="form-control" required></div>
  <div class="mb-3"><label>ইমেইল</label><input name="email" type="email" class="form-control" required></div>
  <div class="mb-3"><label>পাসওয়ার্ড</label><input name="password" type="password" class="form-control" minlength="6" required></div>
  <div class="mb-3"><label>রোল</label>
    <select name="role" class="form-select"><option value="student">Student</option><option value="admin">Admin</option></select>
  </div>
  <button class="btn btn-success">রেজিস্টার</button>
  <a class="btn btn-link" href="login.php">লগইন</a>
</form>
</div></div></div></div></div>
</body></html>
