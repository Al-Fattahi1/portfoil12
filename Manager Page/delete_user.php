<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

require '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];

    // تحقق من أن المستخدم موجود
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if ($user) {
        // حذف المستخدم
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        if ($stmt->execute([$user_id])) {
            header("Location: view_users.php?success=true");
            exit;
        } else {
            header("Location: view_users.php?error=true");
            exit;
        }
    } else {
        header("Location: view_users.php?error=true");
        exit;
    }
} else {
    header("Location: view_users.php");
    exit;
}
?>