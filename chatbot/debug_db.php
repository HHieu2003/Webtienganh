<?php
// chatbot/debug_db.php

require_once('config.php');

echo "<h2>🔍 Debug Database</h2>";

// Test database connection
if ($conn) {
    echo "<p>✅ Database connected successfully</p>";
} else {
    echo "<p>❌ Database connection failed</p>";
    exit;
}

// Check hocvien table structure
echo "<h3>📊 Bảng hocvien:</h3>";
$sql = "DESCRIBE hocvien";
$result = $conn->query($sql);

if ($result) {
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr style='background: #f0f0f0;'><th>Column</th><th>Type</th><th>Null</th><th>Key</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>❌ Cannot describe hocvien table</p>";
}

// Check session
echo "<h3>🔐 Session Info:</h3>";
echo "<pre>";
echo "Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Inactive') . "\n";
echo "User Logged In: " . (isUserLoggedIn() ? 'Yes' : 'No') . "\n";
if (isset($_SESSION['id_hocvien'])) {
    echo "User ID: " . $_SESSION['id_hocvien'] . "\n";
}
if (isset($_SESSION['user'])) {
    echo "Username: " . $_SESSION['user'] . "\n";
}
echo "</pre>";

// Test getUserInfo
echo "<h3>👤 User Info Test:</h3>";
$userInfo = getUserInfo();
if ($userInfo) {
    echo "<pre>";
    print_r($userInfo);
    echo "</pre>";
} else {
    echo "<p>❌ Cannot get user info (not logged in or error)</p>";
}

// Test chat_history table
echo "<h3>💬 Chat History Table:</h3>";
$sql = "SHOW TABLES LIKE 'chat_history'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<p>✅ chat_history table exists</p>";
    
    $sql = "SELECT COUNT(*) as count FROM chat_history";
    $result = $conn->query($sql);
    if ($result) {
        $count = $result->fetch_assoc()['count'];
        echo "<p>📊 Total messages: " . $count . "</p>";
    }
} else {
    echo "<p>❌ chat_history table not found</p>";
}

// Test courses table
echo "<h3>📚 Courses Table:</h3>";
$sql = "SHOW TABLES LIKE 'khoahoc'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<p>✅ khoahoc table exists</p>";
    
    $sql = "SELECT COUNT(*) as count FROM khoahoc";
    $result = $conn->query($sql);
    if ($result) {
        $count = $result->fetch_assoc()['count'];
        echo "<p>📊 Total courses: " . $count . "</p>";
    }
} else {
    echo "<p>❌ khoahoc table not found</p>";
}

echo "<hr>";
echo "<p><strong>✅ Debug completed!</strong></p>";
echo "<p><a href='index.php'>← Back to Chatbot</a></p>";
?>
