<?php
session_start();
include("db.php");

$moodData = [];
$counts = ["happy" => 0, "sad" => 0, "angry" => 0, "anxious" => 0, "tired" => 0];
$total = 0;

// Retrieve the mood data
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT mood_value FROM reflections WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $moodData[] = $row['mood_value'];
        $counts[$row['mood_value']]++;
        $total++;
    }
    $stmt->close();
}

$percentages = [];
foreach ($counts as $mood => $count) {
  $percentages[$mood] = $total ? round(($count / $total) * 100) : 0;
}

$emojiMap = [
  "happy" => "😀",
  "sad" => "😞",
  "angry" => "😡",
  "anxious" => "😱",
  "tired" => "😴"
];

$max = max($counts);
$topMoods = array_keys($counts, $max);

function generateMessage($moods, $emojiMap) {
  if (count($moods) === 1) {
    switch ($moods[0]) {
      case "happy": return "😀 You're shining with happiness today. Keep smiling!";
      case "sad": return "😞 It's okay to feel sad. You are not alone.";
      case "angry": return "😡 Take a deep breath. Let’s release that anger calmly.";
      case "anxious": return "😱 Everything feels like too much? You’re doing your best.";
      case "tired": return "😴 Rest is not a luxury, it’s a need. Take care of yourself.";
      default: return "🙂 Your feelings are valid. You are doing great.";
    }
  } else {
    $list = implode(", ", array_map(fn($m) => "{$emojiMap[$m]} " . ucfirst($m), $moods));
    return "You're feeling a mix of emotions: $list. That's completely okay — it's part of being human. 💖";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mood Tracker</title>
  <link rel="stylesheet" href="moodtracker.css" />
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <div class="logo">
        <img src="Image.PNG" alt="" style="width: 50px; height: 50px; margin-right: 10px; vertical-align: middle;" />
        Usaping Kabataan
      </div>
      <div class="subtitle">Let's Talk <span>Hang in there friend</span></div>
      <div class="nav-buttons">
        <a href="home.php" class="nav-btn">Home</a>
        <a href="moodtracker.php" class="nav-btn active">Mood Tracker</a>
        <a href="anonymous-post.php" class="nav-btn">Anonymous Post</a>
        <a href="reflection.php" class="nav-btn">Reflection Room</a>
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
      <div class="tracker-card">
        <h2>Mood Tracker</h2>
        <p>What do you feel?</p>

        <?php if (empty($moodData)): ?>
          <p class="summary">Please complete the Reflection Room first.</p>
        <?php else: ?>
          <?php foreach ($percentages as $mood => $percentage): ?>
            <div class="mood-row">
              <div class="mood-label"><?php echo $emojiMap[$mood]; ?> <?php echo ucfirst($mood); ?> <?php echo $percentage; ?>%</div>
              <div class="bar-container">
                <div class="bar <?php echo $mood; ?>" style="width: <?php echo $percentage; ?>%;"></div>
              </div>
            </div>
          <?php endforeach; ?>
          <p class="summary"><?php echo generateMessage($topMoods, $emojiMap); ?></p>
        <?php endif; ?>
      </div>
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
