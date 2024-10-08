<?php
header('Content-Type: application/json'); // Set header for JSON response

// Database credentials
$host = 'localhost';
$db   = 'rukari';
$user = 'root';
$pass = ''; // Replace with your actual password
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
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName  = trim($_POST['last_name'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';
    $currentTimestamp = date('Y-m-d H:i:s'); // Get the current date and time

    // Basic validation
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit();
    }
    $profileImageUrl = './asset/images/default/default-user-profile.jpg'; // Path to the default image

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Allowed file extensions
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            // Directory to save uploaded images
            $uploadFileDir = './uploads/';
            // Create directory if not exists
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            $dest_path = $uploadFileDir . $newFileName;

            // Move the file
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // File is successfully uploaded
                $profileImageUrl = $dest_path; // Update the profile image URL to the uploaded file
            } else {
                echo json_encode(['status' => 'error', 'message' => 'There was an error moving the uploaded file.']);
                exit();
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Upload failed. Allowed file types: ' . implode(', ', $allowedExtensions)]);
            exit();
        }
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    // Insert user data into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, email, user_password, profile_image,created_time) VALUES (?, ?, ?, ?, ?,?)");
        $stmt->execute([$firstName, $lastName, $email, $hashedPassword, $profileImageUrl,$currentTimestamp]);
        echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error inserting user data: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}

?>