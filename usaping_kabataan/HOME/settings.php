<?php
session_start();
require 'db.php'; // This file must define $conn for MySQLi

$userId = 1;

// Fetch existing user data from `users_setting`
$stmt = $conn->prepare("SELECT * FROM users_setting WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $phoneCode = $_POST['phone_code'];
    $phoneNumber = $_POST['phone_number'];
    $dob = $_POST['dob'];
    $country = $_POST['country'];

    // Image upload (optional)
    $imagePath = $user['profile_image'];
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $uploadDir = 'uploads/';
        $filename = basename($_FILES['profile_image']['name']);
        $targetFile = $uploadDir . time() . "_" . $filename;
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    // Update query
    $stmt = $conn->prepare("UPDATE users_setting SET full_name=?, email=?, phone_code=?, phone_number=?, date_of_birth=?, country=?, profile_image=? WHERE id=?");
    $stmt->bind_param("sssssssi", $fullName, $email, $phoneCode, $phoneNumber, $dob, $country, $imagePath, $userId);
    $stmt->execute();

    header("Location: settings.php?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings - Usaping Kabataan</title>
    <link rel="stylesheet" href="settings.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">Usaping Kabataan</div>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="#">Events</a></li>
            <li><a href="#">Post</a></li>
        </ul>
        <h4>Features</h4>
        <ul>
            <li><a href="moodtracker.php">Mood Tracker</a></li>
            <li><a href="anonymous-post.php">Anonymous Post</a></li>
            <li><a href="reflection.php">Reflection Room</a></li>
            <li><a href="bayanihan-events.php">Bayanihan Board Event</a></li>
        </ul>
        <ul class="bottom-menu">
            <li><a href="#">Help and Support</a></li>
            <li><a class="active" href="#">Settings</a></li>
        </ul>
        <div class="user">
            <p><strong>SirComesAllot</strong><br><small>sirlot@gmail.com</small></p>
        </div>
    </div>

    <div class="main">
    <h2>Settings ⚙️</h2>

    <?php if (isset($_GET['success'])): ?>
        <p style="color: limegreen;">✅ Profile updated successfully.</p>
    <?php endif; ?>

    <div class="tabs">
        <button class="active">Profile Details</button>
        <button>Password</button>
    </div>

    <form method="POST" action="settings.php" class="settings-form" enctype="multipart/form-data">
        <div class="photo-section">
            <label>Your Photo</label><br>
            <?php if (!empty($_SESSION['profile_image'])): ?>
                <img src="<?= htmlspecialchars($_SESSION['profile_image']) ?>" alt="Profile" width="80" style="border-radius: 50%;">
            <?php endif; ?>
            <input type="file" name="profile_image" accept="image/*">
        </div>

        <label>Full Name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($_SESSION['profile_name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Phone Number</label>
        <div class="phone-group">
            <select name="phone_code">
                <option value="+64" <?= $user['phone_code'] == '+64' ? 'selected' : '' ?>>+64</option>
                <option value="+63" <?= $user['phone_code'] == '+63' ? 'selected' : '' ?>>+63</option>
            </select>
            <input type="text" name="phone_number" value="<?= htmlspecialchars($user['phone_number']) ?>" required>
        </div>

        <label>Date of Birth</label>
        <input type="date" name="dob" value="<?= htmlspecialchars($user['date_of_birth']) ?>" required>

        <label>Country</label>
        <input type="text" name="country" value="<?= htmlspecialchars($user['country']) ?>" required>

        <div class="form-actions">
            <button type="submit" class="save-btn">Save</button>
            <button type="reset" class="cancel-btn">Cancel</button>
        </div>
    </form>
</div>

</body>
</html>
