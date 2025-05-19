<?php
$token = $_GET['token'] ?? '';
$error = "";
$success = "";

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['token'] ?? '';
    $new_password = $_POST['password'] ?? '';

    $conn = new mysqli("localhost", "root", "", "user_db");
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    // Check if token exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        // Update password and clear token
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?");
        $update->bind_param("ss", $hashed, $token);
        $update->execute();

        $success = "Password has been reset. <a href='login.php'>Log in now</a>";
    } else {
        $error = "Invalid or expired token.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reset Password</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <div class="login-section">
      <form method="POST" action="reset_password.php">
        <h1>Reset Password</h1>

        <?php if ($error): ?>
          <p style="color: red;"><?php echo $error; ?></p>
        <?php elseif ($success): ?>
          <p style="color: green;"><?php echo $success; ?></p>
        <?php else: ?>
          <p>Enter your new password below.</p>
        <?php endif; ?>

        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>"/>

        <?php if (!$success): ?>
        <div class="input-box">
          <input type="password" name="password" placeholder="New Password" required />
        </div>
        <button type="submit" class="btn">Reset Password</button>
        <?php endif; ?>
      </form>
    </div>
  </div>
</body>
</html>
