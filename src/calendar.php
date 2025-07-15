<?php

// Include the connection file to establish a database connection
include 'src/connection.php';

// variables
$success = '';
$error = '';
$eventsFromDB = []; // Array to hold events fetched from the database

// Handle Add event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    // Sanitize and validate input
    $event = trim($_POST['event_name'] ?? '');
    $description = trim($_POST['event_description'] ?? '');
    $start = $_POST['start_date'] ?? '';
    $end = $_POST['end_date'] ?? '';

    if ($event && $description && $start && $end) {
        // Prepare and execute the SQL statement to insert the event
        $stmt = $connection->prepare(
            "INSERT INTO events (event_name, event_description, start_date, end_date) VALUES (?, ?, ?, ?)"
        );
        
        // Bind parameters to the SQL statement
        $stmt->bind_param("ssss", $event, $description, $start, $end);
        
        $stmt->execute();

        $stmt->close();

        // Set success message
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        exit;
    }
    else {
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=1");
        exit;
    }
}
