<?php
require '../db.php'; // تأكد من توافر اتصال قاعدة البيانات
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php'); // إعادة توجيه غير المخولين
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_id = $_POST['bus_id']; // تأكد من إضافة هذا السطر
    $bus_type = $_POST['bus_type'];
    $start_location = $_POST['start_location'];
    $end_location = $_POST['end_location'];
    $departure_time = $_POST['departure_time'];
    $seats_available = $_POST['seats_available'];

    // إدخال الرحلة
    $stmt = $pdo->prepare("INSERT INTO trips (bus_id, bus_type, start_location, end_location, departure_time, seats_available) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$bus_id, $bus_type, $start_location, $end_location, $departure_time, $seats_available]);

    echo "تم إضافة الرحلة بنجاح!";
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إضافة رحلة جديدة</title>
</head>
<body>
    <h1>إضافة رحلة جديدة</h1>
    <form method="POST">
        <label for="bus_id">رقم الباص:</label>
        <input type="number" name="bus_id" id="bus_id" required> <!-- حقل إدخال bus_id -->
        
        <label for="bus_type">نوع الباص:</label>
        <input type="text" name="bus_type" id="bus_type" required>
        
        <label for="start_location">مكان الانطلاق:</label>
        <input type="text" name="start_location" id="start_location" required>

        <label for="end_location">مكان الوصول:</label>
        <input type="text" name="end_location" id="end_location" required>

        <label for="departure_time">وقت الرحيل:</label>
        <input type="datetime-local" name="departure_time" id="departure_time" required>

        <label for="seats_available">عدد المقاعد المتاحة:</label>
        <input type="number" name="seats_available" id="seats_available" required>

        <input type="submit" value="أضف الرحلة">
    </form>
</body>
</html>