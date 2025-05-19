<?php
session_start();
require_once("db.php");

// Handle event form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["eventDate"]) && !empty($_POST["eventDesc"]) && !empty($_POST["eventTime"]) && !empty($_POST["eventLocation"])) {
        $date = $_POST["eventDate"];
        $description = $_POST["eventDesc"];
        $time = $_POST["eventTime"];
        $location = $_POST["eventLocation"];

        $stmt = $conn->prepare("INSERT INTO bayanihan_events (event_date, description, event_time, location) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $date, $description, $time, $location);
        $stmt->execute();
        $stmt->close();
        header("Location: bayanihan-events.php");
        exit;
    }
}

// Handle event deletion
if (isset($_POST['delete_event_id'])) {
    $event_id = (int) $_POST['delete_event_id'];
    $stmt = $conn->prepare("DELETE FROM bayanihan_events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->close();
    header("Location: bayanihan-events.php");
    exit;
}

// Fetch events
$events = [];
$result = $conn->query("SELECT * FROM bayanihan_events ORDER BY event_date ASC");
if ($result && $result->num_rows > 0) {
    $events = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Bayanihan Board Events</title>
    <link rel="stylesheet" href="bayanihan-events.css" />
  </head>
  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo">
          <img
            src="/HOME/assets/Image.PNG"
            alt=""
            style="width: 50px; height: 50px; margin-right: 10px; vertical-align: middle;"
          />
          Usaping Kabataan
        </div>
        <div class="subtitle">Let's Talk <span>Hang in there friend</span></div>
        <div class="nav-buttons">
          <a href="home.php" class="nav-btn">Home</a>
          <a href="moodtracker.php" class="nav-btn">Mood Tracker</a>
          <a href="anonymous-post.php" class="nav-btn">Anonymous Post</a>
          <a href="reflection.php" class="nav-btn">Reflection Room</a>
          <a href="bayanihan-events.php" class="nav-btn active">Bayanihan Board Events</a>
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
        <h2>Bayanihan Board Events</h2>
        <p class="subheading">Date and Schedules for upcoming events</p>

        <form method="POST" class="event-form">
          <input type="date" name="eventDate" required />
          <input type="text" name="eventDesc" placeholder="Description" required />
          <input type="text" name="eventTime" placeholder="Time (e.g. 6:00 - 10:00 am)" required />
          <input type="text" name="eventLocation" placeholder="Location" required />
          <button type="submit" class="join-btn">Add Event</button>
        </form>

        <div id="eventList">
          <?php foreach ($events as $event): ?>
          <div class="event-card">
            <h3>
              📅 <?= htmlspecialchars($event['event_date']) ?>
            </h3>
            <p>
              <strong>Description:</strong> <?= htmlspecialchars($event['description']) ?>
            </p>
            <p>
              <strong>Time:</strong> <?= htmlspecialchars($event['event_time']) ?>
            </p>
            <p>
              <strong>Location:</strong> <?= htmlspecialchars($event['location']) ?>
            </p>
            <button class="join-btn" onclick="alert('You have joined this event!')">Join</button>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="delete_event_id" value="<?= $event['id'] ?>">
              <button type="submit" class="delete-btn" title="Delete">🗑️ Delete</button>
            </form>
          </div>
          <?php endforeach; ?>
        </div>
      </main>
    </div>

    <script>
      function logout() {
        alert("You have been logged out.");
        window.location.href = "login.html";
      }
    </script>
  </body>
</html>
