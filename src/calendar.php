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
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=2");
        exit;
    }
    else {
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=2");
        exit;
    }

}

// Handle Delete event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    // Sanitize and validate input
    $eventId = $_POST['event_id'] ?? null;

    // Check if event ID is provided
    if ($eventId) {
        // Prepare and execute the SQL statement to delete the event
        $stmt = $connection->prepare("DELETE FROM events WHERE id = ?");
        
        // Bind parameters to the SQL statement
        $stmt->bind_param("i", $eventId);
        
        $stmt->execute();

        $stmt->close();

        // Set success message
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=3");
        exit;
    }
    else {
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=3");
        exit;
    }
}

// Success handling
if (isset($_GET['success'])) {
    $success = match ($_GET['success']) {
        '1' => "✅ Event added successfully!",
        '2' => "✅ Event updated successfully!",
        '3' => "✅ Event deleted successfully!",
        default => "✅ Action completed successfully!"
    };
}

// Error handling
if (isset($_GET['error'])) {
    $error = match ($_GET['error']) {
        '1' => "❌ Failed to add event.",
        '2' => "❌ Failed to update event.",
        '3' => "❌ Failed to delete event.",
        default => "❌ An error occurred."
    };
}

// Fetch events from the database and spread over the date range
$result = $conn->query("SELECT * FROM events ORDER BY start_date ASC");

// Check if the query was successful and fetch results
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $start = new DateTime($row['start_date']);
        $end = new DateTime($row['end_date']);

        // Ensure the end date is inclusive
        while ($start <= $end) {
            // Store each event with its details in the array
            $eventsFromDB[] = [
                'id' => $row['id'],
                'name' => $row['event_name'],
                'description' => $row['event_description'],
                'date' => $start->format('Y-m-d'),
                'start' => $row['start_date'],
                'end' => $row['end_date']
            ];

            // Move to the next day
            $start->modify('+1 day');
        }
    }
}

// Close the database connection
$connection->close();