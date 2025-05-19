<?php 
session_start();

$error = "";
$success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? '';
    $surname = $_POST["surname"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    // Database connection
    $conn = new mysqli("localhost", "root", "", "user_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check for existing email
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $error = "An account with this email already exists.";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user with name and surname
        $stmt = $conn->prepare("INSERT INTO users (name, surname, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $surname, $email, $hashedPassword);

        if ($stmt->execute()) {
            // Get the new user ID
            $user_id = $stmt->insert_id;

            // Initialize session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['profile_name'] = $name . ' ' . $surname;
            $_SESSION['profile_image'] = 'assets/user.jpg'; // default image
            $_SESSION['posts'] = [];
            $_SESSION['friends'] = [];
            $_SESSION['groups'] = [];

            // Redirect to home.php
            header("Location: home.php");
            exit();
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create Account</title>
  <link rel="stylesheet" href="styles.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>
  <div class="container">
    <div class="login-section">
      <form method="POST" action="register.php">
        <h1>Create new account.</h1>
        <p>Please Enter your account details.</p>

        <?php if ($error): ?>
          <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <div class="input-row">
          <div class="input-box">
            <input type="text" name="name" placeholder="Name" required />
          </div>
          <div class="input-box">
            <input type="text" name="surname" placeholder="Surname" required />
          </div>
        </div>

        <div class="input-box">
          <input type="email" name="email" placeholder="Enter your email" required />
        </div>
       
        <div class="input-box">
          <input type="password" name="password" id="loginPassword" placeholder="Password" required />
          <button type="button" id="toggleLoginPassword" class="material-symbols-outlined visibility-icon" aria-label="Toggle password visibility">
            visibility_off
          </button>
        </div>

        <button type="submit" class="btn">Create account</button>
        <div class="register-link">
          <p>Already have an account? <a href="login.php">Log in</a></p>
        </div>
      </form>
    </div>

    <div class="image-section">
      <img src="assets/Image.PNG" alt="Logo" />
    </div>
  </div>

  <script>
    const toggleBtn = document.getElementById("toggleLoginPassword");
    const passwordField = document.getElementById("loginPassword");

    toggleBtn.addEventListener("click", () => {
      const isPassword = passwordField.type === "password";
      passwordField.type = isPassword ? "text" : "password";
      toggleBtn.textContent = isPassword ? "visibility" : "visibility_off";
    });
  </script>
  <script src="script.js"></script>
</body>
</html>