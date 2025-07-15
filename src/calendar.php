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

// Handle Edit event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'edit') {
    // Sanitize and validate input
    $eventId = $_POST['event_id'] ?? null;
    $event = trim($_POST['event_name'] ?? '');
    $description = trim($_POST['event_description'] ?? '');
    $start = $_POST['start_date'] ?? '';
    $end = $_POST['end_date'] ?? '';

    // Check if all required fields are provided
    if ($eventId && $event && $description && $start && $end) {
        // Prepare and execute the SQL statement to update the event
        // MAYBE CHANGE CONNECTION TO CONN
        $stmt = $connection->prepare(
            "UPDATE events SET event_name = ?, event_description = ?, start_date = ?, end_date = ? WHERE id = ?"
        );
        
        // Bind parameters to the SQL statement
        $stmt->bind_param("ssssi", $event, $description, $start, $end, $eventId);
        
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