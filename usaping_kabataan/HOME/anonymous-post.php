<?php
session_start();
require_once("db.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["anonymous_input"])) {
    $text = trim($_POST["anonymous_input"]);

    if (!empty($text)) {
        $stmt = $conn->prepare("INSERT INTO anonymous_posts (content, created_at) VALUES (?, NOW())");
        $stmt->bind_param("s", $text);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: anonymous-post.php");
    exit;
}

// Handle delete post
if (isset($_POST['delete_post_id'])) {
    $post_id = (int) $_POST['delete_post_id'];
    $stmt = $conn->prepare("DELETE FROM anonymous_posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->close();
    header("Location: anonymous-post.php");
    exit;
}

// Fetch posts
$posts = [];
$result = $conn->query("SELECT * FROM anonymous_posts ORDER BY created_at DESC");
if ($result && $result->num_rows > 0) {
    $posts = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Anonymous Post - Usaping Kabataan</title>
    <link rel="stylesheet" href="anonymous-post.css" />
  </head>
  <body>
    <!-- Top Bar -->
    <div class="top-bar">
      <div class="icon-bar">
        <a href="home.php" title="Home">🏠</a>
        <a href="anonymous-post.php" title="Anonymous Post">🧵</a>
        <a href="bayanihan-events.php" title="Bayanihan Events">🤝</a>
      </div>
      <div class="search-bar">
        <input type="text" placeholder="Search..." />
      </div>
    </div>

    <div class="container">
      <div class="sidebar">
        <div class="logo">
          <img
            src="/HOME/assets/Image.PNG"
            alt="Logo"
            style="width: 50px; height: 50px; margin-right: 10px; vertical-align: middle;"
          />
          Usaping Kabataan
        </div>
        <div class="subtitle">Let's Talk <span>Hang in there friend</span></div>
        <div class="nav-buttons">
          <a href="home.php" class="nav-btn">Home</a>
          <a href="moodtracker.php" class="nav-btn">Mood Tracker</a>
          <a href="anonymous-post.php" class="nav-btn active">Anonymous Post</a>
          <a href="reflection.php" class="nav-btn">Reflection Room</a>
          <a href="bayanihan-events.php" class="nav-btn">Bayanihan Board Events</a>
          <a href="settings.php" class="nav-btn">⚙️ Settings</a>
        </div>
        <div class="logout-button">
          <button onclick="logout()">Log Out</button>
        </div>
        <footer>
          <p>© 2025 Usaping Kabataan | All rights reserved.</p>
          <a href="#">Privacy Policy</a> | <a href="#">User Agreement</a>
        </footer>
      </div>

      <div class="main-content">
        <h2>Anonymous Post <span class="emoji">🕵️‍♂️</span></h2>
        <p class="subheading">Don't worry friend, you are hidden here.</p>

        <form method="POST" class="post-form">
          <textarea
            name="anonymous_input"
            placeholder="Say what's on your mind..."
            required
          ></textarea>
          <button type="submit">Post</button>
        </form>

        <div class="posts-container">
          <?php foreach ($posts as $post): ?>
          <div class="post-card">
            <div class="post-header">
              <span class="post-user">👤 Mr. Nobody</span>
              <div class="post-actions">
                <button class="btn-like" title="Like">👍</button>
                <button class="btn-share" title="Share">🔗</button>
                <button class="btn-bookmark" title="Bookmark">🔖</button>
                <!-- Delete Button -->
                <form method="POST" style="display:inline;">
                  <input type="hidden" name="delete_post_id" value="<?= $post['id'] ?>">
                  <button type="submit" class="btn-delete" title="Delete">🗑️</button>
                </form>
              </div>
            </div>
            <div class="post-content">
              <p><?= htmlspecialchars($post['content']) ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <script>
      function logout() {
        if (confirm("Are you sure you want to log out?")) {
          localStorage.clear();
          window.location.href = "../login/login.html";
        }
      }

      document
        .querySelectorAll(".btn-like")
        .forEach((btn) =>
          btn.addEventListener("click", () => (btn.textContent = "❤️"))
        );
      document
        .querySelectorAll(".btn-bookmark")
        .forEach((btn) =>
          btn.addEventListener("click", () => (btn.textContent = "📌"))
        );
      document
        .querySelectorAll(".btn-share")
        .forEach((btn) =>
          btn.addEventListener("click", () => alert("Shared anonymously!"))
        );
    </script>
  </body>
</html>
