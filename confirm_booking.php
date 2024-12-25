<?php
require 'db.php';
session_start();

// تحقق مما إذا كان المستخدم مسجلاً دخوله
if (!isset($_SESSION['user_id'])) {
    echo "يرجى تسجيل الدخول أولاً.";
    exit;
}

// تحقق مما إذا كانت البيانات قد تم إرسالها عبر POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // تعريف المتغيرات مع قيم افتراضية
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $bus_type = isset($_POST['bus_type']) ? $_POST['bus_type'] : '';
    $start_location = isset($_POST['start_location']) ? $_POST['start_location'] : '';
    $end_location = isset($_POST['end_location']) ? $_POST['end_location'] : '';
    $seats_booked = isset($_POST['seats_booked']) ? (int)$_POST['seats_booked'] : 0;

    // تحقق من أن جميع الحقول مطلوبة
    if (empty($name)  empty($email)  empty($phone)  empty($bus_type)  empty($start_location)  empty($end_location)  $seats_booked < 1) {
        echo "جميع الحقول مطلوبة.";
        exit;
    }

    // تحقق من صحة البريد الإلكتروني
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "البريد الإلكتروني غير صالح.";
        exit;
    }

    // تحديد سعر الرحلة
    $price_per_seat = ($bus_type === 'VIP') ? 100 : 50;
    $total_price = $price_per_seat * $seats_booked;

    // إدخال الحجز إلى قاعدة البيانات
    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, name, email, phone, bus_type, start_location, end_location, seats_booked, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $user_id = $_SESSION['user_id'];

    // تنفيذ الاستعلام
    if ($stmt->execute([$user_id, $name, $email, $phone, $bus_type, $start_location, $end_location, $seats_booked, $total_price])) {
        echo "تم الحجز بنجاح. سعر الرحلة هو: " . htmlspecialchars($total_price) . " ريال.";
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "حدث خطأ أثناء الحجز: " . htmlspecialchars($errorInfo[2]);
    }
} else {
    echo "الرجاء تقديم البيانات بشكل صحيح.";
}
?>