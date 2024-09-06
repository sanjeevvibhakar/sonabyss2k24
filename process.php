<?php
// Database configuration
$host = 'localhost';
$db = 'your_database_name';
$user = 'your_database_user';
$pass = 'your_database_password';

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $number = htmlspecialchars($_POST['number']);
    $address = htmlspecialchars($_POST['address']);
    $message = htmlspecialchars($_POST['message']);
    
    // Prepare an SQL statement to insert the data
    $sql = "INSERT INTO users (name, email, number, address, message) VALUES (:name, :email, :number, :address, :message)";
    $stmt = $pdo->prepare($sql);
    
    // Execute the SQL statement
    try {
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':number' => $number,
            ':address' => $address,
            ':message' => $message
        ]);

        // Redirect to the payment page
        header("Location: payment.php");
        exit();
    } catch (PDOException $e) {
        die("Database query failed: " . $e->getMessage());
    }
}
?>
