<?php
require_once("db.php"); // include database connection

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["mood"])) {
    $moods = $_POST["mood"]; // array of moods from reflection form
    $responses = array_values($moods); // e.g., ["happy", "tired", ...]

    // Optional: associate with a user (if session is used)
    session_start();
    $user_id = $_SESSION['user_id'] ?? null;

    $stmt = $conn->prepare("INSERT INTO mood_entries (user_id, mood, question_index, created_at) VALUES (?, ?, ?, NOW())");

    foreach ($responses as $index => $mood) {
        $stmt->bind_param("isi", $user_id, $mood, $index);
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    header("Location: moodtracker.php");
    exit;
} else {
    header("Location: reflection.php");
    exit;
}
