<?php
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // التحقق من عدم وجود اسم المستخدم مسبقًا
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        $error = "اسم المستخدم مستخدم مسبقًا.";
    } else {
        // تشفير كلمة المرور
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // إدخال البيانات في قاعدة البيانات
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'admin')");
        if ($stmt->execute([$username, $hashed_password, $email])) {
            $success = "تم إنشاء حساب المدير بنجاح.";
        } else {
            $error = "حدث خطأ أثناء إنشاء الحساب.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب مدير</title>
</head>
<body>
    <h1>إنشاء حساب مدير</h1>
    <form action="register_admin.php" method="POST">
        <input type="text" name="username" placeholder="اسم المستخدم" required>
        <input type="email" name="email" placeholder="البريد الإلكتروني" required>
        <input type="password" name="password" placeholder="كلمة المرور" required>
        <button type="submit">إنشاء حساب</button>
    </form>
    <?php if (isset($error)): ?>
        <p><?= $error ?></p>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <p><?= $success ?></p>
    <?php endif; ?>
</body>
</html>