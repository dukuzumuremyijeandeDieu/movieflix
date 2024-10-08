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
$admin_Id = $_SESSION['admin_id'] ?? null;
$userId = $_GET['user_id'];


if ($userId === null) {
    die('User is not logged in.');
}

// Database credentials
$host = 'localhost';
$db = 'rukari'; // Replace with your database name
$user = 'root';             // Replace with your database username
$pass = '';                 // Replace with your database password
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

    // Prepare the SQL statement to select the profile picture
    $stmt = $pdo->prepare("SELECT firstname,lastname,profile_image FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $user = $stmt->fetch();

    $firstname = $user['firstname'];
    $lastname = $user['lastname'];

    // Check if a profile picture exists
    if ($user && !empty($user['profile_image'])) {
        // Store the profile picture path in a variable
        $profilePic = $user['profile_image'];
    } else {
        // Default image if no profile picture is set
        $profilePic = './assest/images/default/default-user-profile.jpg';
    }
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin Account page</title>

    <!--custom css-->
    <link rel="stylesheet" href="../asset/css/style.css">

    <!--swiper css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!--google links-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  </head>
  <body id="page-top">

    <nav class="navbar bg-dark fixed-top ">
        <a class="navbar-brand" href="index.html">
            <div class="logo">
                <img src="../asset/images/logo.png" class="img-fluid" alt="">
            </div>
        </a>
      
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2 text-white" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-red my-2 my-sm-0" type="submit">
              <i class="bi bi-search"></i>
          </button>
        </form>   
        
        <div class="right-container">
          <span class="toggled-icon" id="toggled-icon">
            <i class="bi bi-search"></i>
          </span>
          <div class="user-profile dropdown no-arrow">
            <a class="dropdown-toggle user-dropdown-link" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="image">
                <img src="<?= htmlspecialchars($profilePic); ?>" class="img-fluid" alt="">
              </div>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="account.php"><i class="fas fa-fw fa-user-circle"></i> &nbsp; My Account</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-fw fa-sign-out-alt"></i> &nbsp; Logout</a>
             </div>
            </a>
              
          </div>
        </div>
        
    </nav>

    <div class="top-mobile-search box" id="top-mobile-search">
        <div class="row">
          <div class="col-md-12">   
            <form class="form-inline row mobile-search">
              <div class="input-group">
                <input type="text" placeholder="Search for..." class="form-control">
                  <div class="">
                    <button type="button" class="btn btn-primary">
                      <i class="bi bi-search"></i>
                    </button>
                  </div>
              </div>
            </form>
           </div>
        </div>
    </div>

    <div id="wrapper">
        <!--sidebar bottom-->
      <div class="bottom-sidebar">
        <div class="bottom-sidebar-container">
          <ul class="bottom-navbar navbar-nav">
            <li class="bottom-nav-item active" tabindex="0">
              <a class="nav-link" href="dashboard.php">
               <i class="bi bi-house"></i>
              <span>Home</span>
              </a>
           </li>
            <li class="bottom-nav-item" tabindex="0">
              <a class="nav-link" href="Latest.html">
               <i class="bi bi-house"></i>
               <span>Latest</span>
            </a>
            </li>
           <li class="bottom-nav-item" tabindex="0">
              <a class="nav-link" href="category.html">
               <i class="bi bi-list-ul"></i>
              <span>Categories</span>
              </a>
           </li>
           <li class="bottom-nav-item" tabindex="0">
            <a class="nav-link" href="help.html">
             <i class="bi bi-film"></i>
            <span>Help</span>
            </a>
         </li>
          </ul>
        </div>
      </div>
      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
           <a class="nav-link" href="dashboard.php">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
           </a>
        </li>
        <li class="nav-item">
           <a class="nav-link" href="Latest.html">
            <i class="bi bi-calendar4"></i>
           <span>Latest</span>
           </a>
        </li>
        <li class="nav-item">
           <a class="nav-link" href="category.html">
            <i class="bi bi-list-ul"></i>
           <span>Categories</span>
           </a>
        </li>
        <li class="nav-item" tabindex="0">
            <a class="nav-link" href="movie.html">
             <i class="bi bi-film"></i>
            <span>Help</span>
            </a>
        </li>
      </ul>

      <div id="content-wrapper">
        <div class="container-fluid pd-0">
            <div class="row justify-content-center">
                <div class="col-md-6 mt-5">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Update Profile</h4>
                        </div>
                        <div class="card-body">
                            <form action="admin_update_profile.php" method="post" enctype="multipart/form-data" id="update-profile-form">
                                <!-- Profile Picture -->
                                <div class="mb-3 text-center">
                                    <img src="<?= htmlspecialchars($profilePic); ?>" alt="Profile Picture" class="img-thumbnail mb-3" id="profile-pic-preview" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50% !important;">
                                    <input type="file" class="form-control" id="profile_pic" name="profile_pic" accept="image/*">
                                </div>
        
                                <!-- First Name -->
                                <div class="mb-3">
                                    <label for="first-name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first-name" value="<?= htmlspecialchars($firstname); ?>" name="firstname" required>
                                </div>
        
                                <!-- Last Name -->
                                <div class="mb-3">
                                    <label for="last-name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last-name" value="<?= htmlspecialchars($lastname); ?>" name="lastname" required>
                                </div>
        
                                <!-- Submit Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
        <!--container-fluid-->
            
      </div>
      <!-- Sticky Footer -->
    <footer class="sticky-footer">
        <div class="container">
           <div class="row no-gutters">
              <div class="col-lg-6 col-sm-6">
                <p class="pb-0"><span><strong class="text-red">E-mail:</strong></span> abijurujothan@gmail.com</p>
                <p class="pb-0"><span><strong class="text-red">Tel:</strong></span>+2507888888</p>
              </div>
              <div class="col-lg-6 col-sm-6 text-right">
                 <div class="app">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-whatsapp"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                 </div>
                </div>     
           </div>
        </div>
     </footer>
      <!--content-wrapper-->
    </div>
    </div>
    
    <!-- Overflow icon-->
    <a href="" class="social-icon rounded">
        <img src="../asset/images/get-logo-whatsapp-png-pictures-1.png" width="24px" height="24px" class="img-fluid" alt="">
    </a>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
               <button class="close" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
               <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
               <a class="btn btn-primary" href="admin_login.html">Logout</a>
            </div>
         </div>
      </div>
    
  <!-- swiper js-->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Optional JavaScript; choose one of the two! -->
   <script src="../asset/js/main.js"></script>

  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <!--jQuery-->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script src="../asset/js/jquery.js"></script>

  
  <!-- Core plugin JavaScript-->
  <script src="../asset/vendor/jquery-easing/jquery.easing.min.js"></script>

  </body>
  </html>