<?php
include('session.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Assuming the user is logged in and user_id is stored in the session
$adminId = $_SESSION['admin_id'] ?? null;

if ($adminId === null) {
    die('User is not logged in.');
}

// Database credentials
$host = 'localhost';
$db = 'rukari';  // Replace with your database name
$user = 'root';              // Replace with your database username
$pass = '';                  // Replace with your database password
$charset = 'utf8mb4';

// Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Collect form data
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);

        // Initialize variables for profile picture
        $profilePicPath = null;

        // Handle profile picture upload
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/profile_pics/'; // Folder to store uploaded images
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif','image/jpg'];

            // Check if the uploaded file type is allowed
            if (in_array($_FILES['profile_pic']['type'], $allowedTypes)) {
                // Generate a unique name for the file to avoid overwriting
                $fileName = uniqid() . '-' . basename($_FILES['profile_pic']['name']);
                $profilePicPath = $uploadDir . $fileName;

                // Move the uploaded file to the specified directory
                if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profilePicPath)) {
                    // File successfully uploaded, profilePicPath contains the file location
                } else {
                    echo 'Failed to upload file.';
                    exit();
                }
            } else {
                echo 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
                exit();
            }
        }

        // If no new image was uploaded, use the existing image
        if ($profilePicPath === null) {
            // Fetch the current profile picture from the database
            $stmt = $pdo->prepare("SELECT profile_image FROM admin WHERE admin_id = :admin_id");
            $stmt->execute(['admin_id' => $adminId]);
            $currentUser = $stmt->fetch();
            $profilePicPath = $currentUser['profile_image'];
        }

        // Prepare the SQL update query
        $stmt = $pdo->prepare("
            UPDATE admin 
            SET firstname = :firstname, lastname = :lastname, profile_image = :profile_image 
            WHERE admin_id = :admin_id
        ");

        // Execute the update query
        $stmt->execute([
            ':firstname'    => $firstname,
            ':lastname'     => $lastname,
            ':profile_image'  => $profilePicPath,
            ':admin_id'      => $adminId
        ]);

        // Redirect or show success message
        echo 'Profile updated successfully.';
        header('location:./account.php');
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
