<?php
session_start();

// Initialize session arrays if not already set
if (!isset($_SESSION['posts'])) {
    $_SESSION['posts'] = [];
}
if (!isset($_SESSION['friends'])) {
    $_SESSION['friends'] = [];
}
if (!isset($_SESSION['groups'])) {
    $_SESSION['groups'] = [];
}
if (!isset($_SESSION['profile_name'])) {
    $_SESSION['profile_name'] = 'Layh Ahyaw Lay';  // Default profile name
}
if (!isset($_SESSION['profile_image'])) {
    $_SESSION['profile_image'] = 'assets/user.jpg';  // Default profile image
}

// Handle Post Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add new post
    if (!empty($_POST['post_content'])) {
        $_SESSION['posts'][] = htmlspecialchars($_POST['post_content']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Delete post
    if (isset($_POST['delete_index'])) {
        $deleteIndex = $_POST['delete_index'];
        if (isset($_SESSION['posts'][$deleteIndex])) {
            array_splice($_SESSION['posts'], $deleteIndex, 1);
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Add Friend
    if (isset($_POST['add_friend']) && !empty($_POST['friend_name'])) {
        $_SESSION['friends'][] = htmlspecialchars($_POST['friend_name']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Delete Friend
    if (isset($_POST['delete_friend'])) {
        $index = $_POST['delete_friend'];
        if (isset($_SESSION['friends'][$index])) {
            array_splice($_SESSION['friends'], $index, 1);
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Add Group
    if (isset($_POST['join_group']) && !empty($_POST['group_name'])) {
        $_SESSION['groups'][] = htmlspecialchars($_POST['group_name']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Delete Group
    if (isset($_POST['delete_group'])) {
        $index = $_POST['delete_group'];
        if (isset($_SESSION['groups'][$index])) {
            array_splice($_SESSION['groups'], $index, 1);
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Update Profile Information
    if (isset($_POST['update_profile'])) {
        if (!empty($_POST['new_profile_name'])) {
            $_SESSION['profile_name'] = htmlspecialchars($_POST['new_profile_name']);
        }
        if (!empty($_FILES['profile_image']['name'])) {
            $targetDir = "assets/";
            $targetFile = $targetDir . basename($_FILES["profile_image"]["name"]);
            move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile);
            $_SESSION['profile_image'] = $targetFile;
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Usaping Kabataan</title>
  <link rel="stylesheet" href="home.css" />
  <style>
    .logout-button {
      margin-top: auto;
      text-align: center;
    }

    .logout-button button {
      padding: 12px 20px;
      background-color: #f44336;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      width: 100%;
      transition: background-color 0.3s ease;
    }

    .logout-button button:hover {
      background-color: #e53935;
    }

    .delete-btn {
      background: none;
      border: none;
      color: #f44336;
      font-size: 18px;
      cursor: pointer;
      margin-left: 10px;
      transition: color 0.3s ease;
    }
  </style>
</head>
<body>
  <!-- Top Bar -->
  <div class="top-bar">
    <div class="icon-bar">
      <a href="home.php" title="Home">🏠</a>
      <a href="anonymous-post.php" title="Anonymous Posts">🧵</a>
      <a href="bayanihan-events.php" title="Bayanihan Posts">🤝</a>
    </div>
    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search..." />
      <button id="searchButton">🔍</button>
    </div>
  </div>

  <div class="container">
    <!-- Left Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <img src="assets/Image.PNG" alt="Logo" style="width: 50px; height: 50px; margin-right: 10px; vertical-align: middle;" />
        Usaping Kabataan
      </div>
      <div class="subtitle-main">
        Let's Talk
      </div>
      <div class="subtitle-sub">
        Hang in there, friend
      </div>
      <nav class="nav-buttons">
        <a href="moodtracker.php" class="nav-btn">Mood Tracker</a>
        <a href="anonymous-post.php" class="nav-btn">Anonymous Post</a>
        <a href="reflection.php" class="nav-btn">Reflection Room</a>
        <a href="bayanihan-events.php" class="nav-btn">Bayanihan Board Events</a>
        <a href="settings.php" class="nav-btn">⚙️ Settings</a>
      </nav>
      <div class="logout-button">
        <button onclick="logout()">Log Out</button>
      </div>
      <footer>
        <p>© 2025 Usaping Kabataan | All rights reserved.</p>
        <a href="#">Privacy Policy</a> | <a href="#">User Agreement</a>
      </footer>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <section class="post-area">
        <h3>Post</h3>
        <form method="POST">
          <textarea name="post_content" placeholder="Share your thoughts..." required></textarea>
          <button type="submit">Post</button>
        </form>

        <!-- Display posts -->
        <div class="post-list">
          <?php
            foreach ($_SESSION['posts'] as $i => $post) {
              echo "
                <div class='post-card'>
                  <div class='post-header'>
                    <span class='post-user'>👤 Mr. Nobody</span>
                    <form method='POST' style='display:inline;'>
                      <input type='hidden' name='delete_index' value='$i'>
                      <button type='submit' class='delete-btn' title='Delete Post'>🗑️</button>
                    </form>
                  </div>
                  <div class='post-content'>
                    <p>$post</p>
                  </div>
                </div>
              ";
            }
          ?>
        </div>
      </section>
    </main>

    <!-- Right Sidebar -->
    <aside class="sidebar right">
      <div class="profile">
        <img src="<?php echo $_SESSION['profile_image']; ?>" alt="Profile" />
        <span class="profile-name"><?php echo $_SESSION['profile_name']; ?></span>
      </div>

      <!-- Profile Update Section -->
      <div class="profile-update">
        <h3>Update Profile</h3>
        <form method="POST" enctype="multipart/form-data">
          <input type="text" name="new_profile_name" placeholder="New Name" />
          <input type="file" name="profile_image" />
          <button type="submit" name="update_profile">Update</button>
        </form>
      </div>

      <div class="group-box">
        <h3>Friends</h3>
        <form method="POST">
          <input type="text" name="friend_name" placeholder="Friend name" />
          <button name="add_friend">➕ Add Friend</button>
        </form>
        <ul>
          <?php
            foreach ($_SESSION['friends'] as $i => $friend) {
              echo "<li>
                $friend
                <form method='POST' style='display:inline;'>
                  <button type='submit' name='delete_friend' value='$i' class='unfollow-btn'>Unfollow</button>
                </form>
              </li>";
            }
          ?>
        </ul>
      </div>

      <div class="group-box">
        <h3>Groups</h3>
        <form method="POST">
          <input type="text" name="group_name" placeholder="Group name" />
          <button name="join_group">➕ Join Groups</button>
        </form>
        <ul>
          <?php
            foreach ($_SESSION['groups'] as $i => $group) {
              echo "<li>
                $group
                <form method='POST' style='display:inline;'>
                  <button type='submit' name='delete_group' value='$i' class='unfollow-btn'>Unfollow</button>
                </form>
              </li>";
            }
          ?>
        </ul>
      </div>
    </aside>
  </div>

  <script>
    function logout() {
      Swal.fire({
        title: 'Are you sure you want to log out?',
        text: "You will be redirected to the login page.",
        imageUrl: 'assets/user.jpg',
        imageWidth: 300,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Logout',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "login.php"; 
        }
      });
    }
  </script>
</body>
</html>