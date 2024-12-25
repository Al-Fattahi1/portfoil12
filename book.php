<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حجز باص</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>حجز باص</h1>
    <div class="container">
        <form action="confirm_booking.php" method="POST">
            <label for="name">الاسم:</label>
            <input type="text" name="name" required>

            <label for="email">البريد الإلكتروني:</label>
            <input type="email" name="email" required>

            <label for="phone">رقم الهاتف:</label>
            <input type="text" name="phone" required>

            <label for="bus_type">نوع الباص:</label>
            <select name="bus_type" required>
                <option value="VIP">VIP</option>
                <option value="عادي">عادي</option>
            </select>

            <label for="start_location">مكان الانطلاق:</label>
            <input type="text" name="start_location" required>

            <label for="end_location">الوجهة:</label>
            <input type="text" name="end_location" required>

            <label for="seats">عدد المقاعد:</label>
            <input type="number" name="seats_booked" min="1" required>

            <button type="submit">تأكيد الحجز</button>
        </form>
    </div>
</body>
</html>