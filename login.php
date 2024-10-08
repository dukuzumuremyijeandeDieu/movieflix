<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session

header('Content-Type: application/json'); // Set header for JSON response

// Database credentials
$host = 'localhost';
$db   = 'rukari'; // Replace with your database name
$user = 'root';              // Replace with your database username
$pass = '';                  // Replace with your database password
$charset = 'utf8mb4';

// Data Source Name
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Options for PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Error mode
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch mode
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulation
];

try {
    // Create PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Handle connection errors
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit();
}

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Both email and password are required.']);
        exit();
    }

    try {
        // Prepare and execute the SELECT statement
        $stmt = $pdo->prepare("SELECT user_id, firstname, lastname, email, user_password FROM users WHERE  email = ?");
        $stmt->execute([$email]);

        // Fetch the user data
        $user = $stmt->fetch();

        if ($user) {
            // Verify the password
            if (password_verify($password, $user['user_password'])) {

                session_regenerate_id(true); // Regenerate session ID
                
                // Password is correct, set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];

                echo json_encode(['status' => 'success', 'message' => 'Login successful! Redirecting...']);
                exit();
            } else {
                // Password is incorrect
                echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
                exit();
            }
        } else {
            // Username does not exist
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
            exit();
        }
    } catch (PDOException $e) {
        // Handle SQL errors
        echo json_encode(['status' => 'error', 'message' => 'Error fetching user data: ' . $e->getMessage()]);
        exit();
    }
} else {
    // If not a POST request, return error
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}
?>
