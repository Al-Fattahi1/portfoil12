<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

require '../db.php';

$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_id = $_POST['bus_id'];
    $bus_number = $_POST['bus_number'];
    $seats = $_POST['seats'];
    $route = $_POST['route'];

    $stmt = $pdo->prepare("UPDATE buses SET bus_number = ?, seats = ?, route = ? WHERE id = ?");
    if ($stmt->execute([$bus_number, $seats, $route, $bus_id])) {
        $message = "تم تعديل الباص بنجاح.";
    } else {
        $error = "حدث خطأ أثناء تعديل الباص.";
    }
}

if (isset($_GET['id'])) {
    $bus_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM buses WHERE id = ?");
    $stmt->execute([$bus_id]);
    $bus = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تعديل باص</title>
    <style>
        /* نفس تصميم صفحة إضافة الباص */
    </style>
</head>
<body>
    <h1>تعديل باص</h1>
    <div class="container">
        <form action="edit_bus.php" method="POST">
            <input type="hidden" name="bus_id" value="<?= htmlspecialchars($bus['id']) ?>">
            <input type="text" name="bus_number" value="<?= htmlspecialchars($bus['bus_number']) ?>" placeholder="رقم الباص" required>
            <input type="number" name="seats" value="<?= htmlspecialchars($bus['seats']) ?>" placeholder="عدد المقاعد" required>
            <input type="text" name="route" value="<?= htmlspecialchars($bus['route']) ?>" placeholder="الوجهة" required>
            <button type="submit">تعديل الباص</button>
        </form>
        <?php if ($message): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        
        <a href="manage_buses.php" class="back-link">عودة إلى إدارة الباصات</a>
    </div>
</body>
</html>