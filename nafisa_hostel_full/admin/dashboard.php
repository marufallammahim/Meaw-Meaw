<?php
session_start();
require_once __DIR__.'/../inc/config.php';
if (!isset($_SESSION['user_id'])) header('Location: ../auth/login.php');
?>
<!doctype html><html lang="bn"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>ড্যাশবোর্ড - Nafisa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
 <div class="container"><a class="navbar-brand" href="#">Nafisa Hostel</a>
 <div class="collapse navbar-collapse">
   <ul class="navbar-nav me-auto">
     <li class="nav-item"><a class="nav-link" href="dashboard.php">ড্যাশবোর্ড</a></li>
     <li class="nav-item"><a class="nav-link" href="rooms.php">Rooms</a></li>
     <li class="nav-item"><a class="nav-link" href="students.php">Students</a></li>
     <li class="nav-item"><a class="nav-link" href="payments.php">Payments</a></li>
     <li class="nav-item"><a class="nav-link" href="notices.php">Notices</a></li>
     <li class="nav-item"><a class="nav-link" href="attendance.php">Attendance</a></li>
     <li class="nav-item"><a class="nav-link" href="meals.php">Meals</a></li>
   </ul>
   <span class="text-light me-3">স্বাগতম, <?=e($_SESSION['user_name'])?></span>
   <a class="btn btn-outline-light btn-sm" href="../auth/logout.php">লগআউট</a>
 </div></div>
</nav>
<div class="container py-4">
  <div class="row g-3">
    <div class="col-md-3"><div class="card p-3">Users: <?php $c=$pdo->query("SELECT COUNT(*) AS c FROM users")->fetch(); echo $c['c'];?></div></div>
    <div class="col-md-3"><div class="card p-3">Rooms: <?php $c=$pdo->query("SELECT COUNT(*) AS c FROM rooms")->fetch(); echo $c['c'];?></div></div>
    <div class="col-md-3"><div class="card p-3">Students: <?php $c=$pdo->query("SELECT COUNT(*) AS c FROM students")->fetch(); echo $c['c'];?></div></div>
    <div class="col-md-3"><div class="card p-3">Due: ৳ <?php $s=$pdo->query("SELECT IFNULL(SUM(amount_due),0) AS s FROM payments")->fetch(); echo $s['s'];?></div></div>
  </div>

  <div class="mt-4">
    <h5>সর্বশেষ নোটিশ</h5>
    <ul>
      <?php foreach($pdo->query("SELECT title,created_at FROM notices ORDER BY created_at DESC LIMIT 5") as $n): ?>
        <li><?=e($n['title'])?> — <?=e($n['created_at'])?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
</body></html>
