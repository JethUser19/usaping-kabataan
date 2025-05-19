<?php
$success = "";
$error = "";

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";

    // Connect to database
    $conn = new mysqli("localhost", "root", "", "user_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Simulate sending reset link (you can implement actual email logic here)
        $success = "A password reset link has been sent to your email.";
    } else {
        $error = "No account found with that email.";
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
  <title>Forgot Password</title>
  <link rel="stylesheet" href="styles.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
</head>
<body>
  <div class="container">
    <div class="login-section">
      <form method="POST" action="reset_password.php">
        <h1>Forgot Password</h1>
        <p>Enter your email to receive a reset link.</p>

        <?php if ($success): ?>
          <p style="color: green;"><?php echo $success; ?></p>
        <?php elseif ($error): ?>
          <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <div class="input-box">
          <input
            type="email"
            name="email"
            placeholder="Enter your email"
            required
          />
        </div>

        <button type="submit" class="btn">Send Reset Link</button>

        <div class="register-link">
          <p><a href="login.php">Back to Login</a></p>
        </div>
      </form>
    </div>

    <div class="image-section">
      <img src="assets/Image.PNG" alt="Logo" />
    </div>
  </div>
</body>
</html>
