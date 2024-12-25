<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

require '../db.php'; // تأكد من تضمين ملف الاتصال بقاعدة البيانات

// استرجاع جميع الرحلات
$stmt = $pdo->query("SELECT * FROM trips");
$trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

// إضافة رحلة جديدة
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bus_id = $_POST['bus_id'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $route = $_POST['route'];

    // تحقق من وجود bus_id في جدول buses
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM buses WHERE id = ?");
    $stmt->execute([$bus_id]);
    $busExists = $stmt->fetchColumn();

    if (!$busExists) {
        // إذا لم يكن الباص موجودًا، قم بإضافته
        $stmt = $pdo->prepare("INSERT INTO buses (id, bus_name) VALUES (?, ?)");
        $bus_name = "باص " . $bus_id; // يمكنك تخصيص اسم الباص كما تريد
        $stmt->execute([$bus_id, $bus_name]);
    }

    // الآن يمكن إضافة الرحلة
    $stmt = $pdo->prepare("INSERT INTO trips (bus_id, departure_time, arrival_time, route) VALUES (?, ?, ?, ?)");
    $stmt->execute([$bus_id, $departure_time, $arrival_time, $route]);
    header("Location: manage_trips.php"); // إعادة التوجيه إلى الصفحة بعد الإضافة
    exit;
}

// حذف رحلة
if (isset($_GET['delete'])) {
    $trip_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM trips WHERE id = ?");
    $stmt->execute([$trip_id]);
    header("Location: manage_trips.php"); // إعادة التوجيه إلى الصفحة بعد الحذف
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الرحلات</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="number"],
        input[type="datetime-local"],
        input[type="text"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
    <h1>إدارة الرحلات</h1>

    <form action="manage_trips.php" method="post">
        <h2>إضافة رحلة جديدة</h2>
        <label for="bus_id">رقم الباص:</label>
        <input type="number" name="bus_id" required>
        
        <label for="departure_time">وقت المغادرة:</label>
        <input type="datetime-local" name="departure_time" required>
        
        <label for="arrival_time">وقت الوصول:</label>
        <input type="datetime-local" name="arrival_time" required>
        
        <label for="route">المسار:</label>
        <input type="text" name="route" required>
        
        <button type="submit">إضافة</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>رقم الرحلة</th>
                <th>رقم الباص</th>
                <th>وقت المغادرة</th>
                <th>وقت الوصول</th>
                <th>المسار</th>
                <th>إجراء</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($trips && count($trips) > 0): ?>
                <?php foreach ($trips as $trip): ?>
                    <tr>
                        <td><?= htmlspecialchars($trip['id']) ?></td>
                        <td><?= htmlspecialchars($trip['bus_id']) ?></td>
                        <td><?= htmlspecialchars($trip['departure_time']) ?></td>
                        <td><?= htmlspecialchars($trip['arrival_time']) ?></td>
                        <td><?= htmlspecialchars($trip['route']) ?></td>
                        <td>
                            <a href="?delete=<?= htmlspecialchars($trip['id']) ?>" onclick="return confirm('هل أنت متأكد أنك تريد حذف هذه الرحلة؟')">حذف</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">لا توجد رحلات مسجلة.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>