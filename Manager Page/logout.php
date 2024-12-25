<?php
session_start();

// تحقق مما إذا كانت الجلسة نشطة
if (isset($_SESSION['username'])) {
    // قم بتعطيل الجلسة
    session_unset();
    session_destroy();
    header("Location: login.php"); // إعادة التوجيه إلى صفحة تسجيل الدخول
    exit;
} else {
    // إذا لم يكن هناك جلسة نشطة
    header("Location: login.php"); // إعادة التوجيه أيضًا
    exit;
}
?>