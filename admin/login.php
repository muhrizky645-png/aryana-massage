<?php
require_once __DIR__ . '/auth.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $creds = get_credentials();
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    if (hash_equals((string)$creds['username'], (string)$u) && hash_equals((string)$creds['password'], (string)$p)) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Username atau password salah.';
    }
}
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Login Admin - Aryana Massage</title>
<style>
  *{box-sizing:border-box;}
  body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;background:#0B0B0B;color:#F4EFE3;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;}
  .box{background:#1A1A1A;border:1px solid #2B2A26;border-radius:14px;padding:36px;width:340px;}
  h1{font-size:20px;margin:0 0 20px;color:#D4AF37;font-family:Georgia,serif;}
  label{display:block;margin-bottom:6px;font-size:13px;color:#A8A096;}
  input{width:100%;padding:10px 12px;margin-bottom:16px;border-radius:8px;border:1px solid #2B2A26;background:#131313;color:#F4EFE3;box-sizing:border-box;font-size:14px;}
  button{width:100%;padding:12px;border-radius:999px;border:none;background:#D4AF37;color:#20240F;font-weight:700;cursor:pointer;font-size:14px;}
  button:hover{background:#E4C24E;}
  .err{color:#ff8b8b;font-size:13px;margin-bottom:12px;}
  .info{color:#8ac97d;font-size:13px;margin-bottom:12px;}
</style>
</head>
<body>
  <form class="box" method="post">
    <h1>Admin Aryana Massage</h1>
    <?php if ($error): ?><div class="err"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
    <?php if ($msg): ?><div class="info"><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
    <label>Username</label>
    <input type="text" name="username" required autofocus />
    <label>Password</label>
    <input type="password" name="password" required />
    <button type="submit">Masuk</button>
  </form>
</body>
</html>
