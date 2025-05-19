<?php
session_start();
include("db.php");

$questions = [
  "How do you feel about today?",
  "How is your energy level?",
  "How do you feel emotionally?",
  "How are your thoughts?",
  "How is your motivation?",
  "How are your social interactions?",
  "How is your stress level?",
  "How's your sleep quality?",
  "How are you coping today?",
  "How do you feel overall?"
];

$emojis = [
  "happy" => "😀",
  "sad" => "😞",
  "angry" => "😡",
  "anxious" => "😱",
  "tired" => "😴"
];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $moods = $_POST['mood'];

        $stmt1 = $conn->prepare("INSERT INTO reflections (user_id, question_id, mood_value) VALUES (?, ?, ?)");
        $stmt2 = $conn->prepare("INSERT INTO mood_entries (user_id, mood, question_index, created_at) VALUES (?, ?, ?, NOW())");

        foreach ($moods as $question_id => $mood_value) {
            $stmt1->bind_param("iis", $user_id, $question_id, $mood_value);
            $stmt1->execute();

            $stmt2->bind_param("ssi", $user_id, $mood_value, $question_id);
            $stmt2->execute();
        }

        $stmt1->close();
        $stmt2->close();
        $conn->close();

        header("Location: moodtracker.php?submitted=1");
        exit();
    } else {
        $error = "You need to be logged in to submit a reflection.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reflection Room</title>
  <link rel="stylesheet" href="reflection.css" />
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <div class="logo">
        <img src="/HOME/assets/Image.PNG" alt="" style="width: 50px; height: 50px; margin-right: 10px; vertical-align: middle;" />
        Usaping Kabataan
      </div>
      <div class="subtitle">Let's Talk <span>Hang in there friend</span></div>
      <div class="nav-buttons">
        <a href="home.php" class="nav-btn">Home</a>
        <a href="moodtracker.php" class="nav-btn">Mood Tracker</a>
        <a href="anonymous-post.php" class="nav-btn">Anonymous Post</a>
        <a href="reflection.php" class="nav-btn active">Reflection Room</a>
        <a href="bayanihan-events.php" class="nav-btn">Bayanihan Board Events</a>
        <a href="settings.php" class="nav-btn">⚙️ Settings</a>
      </div>
      <div class="logout-button">
        <button onclick="logout()">Log Out</button>
      </div>
      <footer>
        <p>© 2025 Usaping Kabataan | All rights reserved.</p>
      </footer>
    </aside>

    <main class="main-content">
      <section class="post-area">
        <h2>Reflection Room</h2>
        <p>Share anything friend. We are here for you</p>

        <?php if (isset($_GET['submitted'])): ?>
          <div class="success-message" style="color: green; font-weight: bold; margin-bottom: 15px;">
            Your reflection has been submitted successfully!
          </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
          <div class="error-message" style="color: red; font-weight: bold; margin-bottom: 15px;">
            <?php echo $error; ?>
          </div>
        <?php endif; ?>

        <form method="POST" action="reflection.php">
          <?php foreach ($questions as $index => $question): ?>
            <div class="question">
              <p><?php echo $question; ?></p>
              <div class="emoji-options">
                <?php foreach ($emojis as $value => $emoji): ?>
                  <label>
                    <input type="radio" name="mood[<?php echo $index; ?>]" value="<?php echo $value; ?>" required />
                    <?php echo $emoji; ?>
                  </label>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
          <button type="submit">Track Mood</button>
        </form>
      </section>
    </main>
  </div>

  <script>
    function logout() {
      alert("You have been logged out.");
      window.location.href = "login.php";
    }
  </script>
</body>
</html>
