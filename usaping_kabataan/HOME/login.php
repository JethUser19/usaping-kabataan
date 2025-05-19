<?php
session_start();

$error = "";
$success = "";

// Display registration success message
if (isset($_GET['register']) && $_GET['register'] === 'success') {
    $success = "Account created successfully! You can now log in.";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    // Connect to database
    $conn = new mysqli("localhost", "root", "", "user_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Look up user by email
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;  // Set the session variable for user ID
            header("Location: home.php");  // Redirect to home.php after successful login
            exit();  // Make sure to stop further execution of the script
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Log In</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <div class="login-section">
      <form id="loginForm" method="POST" action="login.php">
        <h1>Log in</h1>
        <p>Welcome Back Friend! Please Enter your account.</p>

        <?php if ($error): ?>
          <p style="color: red;"><?php echo $error; ?></p>
        <?php elseif ($success): ?>
          <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <div class="input-box">
          <input type="email" name="email" placeholder="Enter your email" required />
        </div>

        <div class="input-box">
        <input type="password" name="password" id="loginPassword" placeholder="Password" required />
        <button type="button" id="toggleLoginPassword" class="material-icons visibility-icon" aria-label="Toggle password visibility">
        visibility_off
        </button>
        </div>

        <div class="remember-forgot">
          <a href="forgot.php">Forgot your Password?</a>
        </div>

        <button type="submit" class="btn">Log In</button>

        <div class="register-link">
          <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </div>
      </form>
    </div>

    <div class="image-section">
      <img src="assets/Website Logo.PNG" alt="" />
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
</body>
</html>
