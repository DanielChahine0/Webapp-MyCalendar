<?php

include "calendar.php";

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>MyCalendar</title>

        <meta name="description" content="A self-hosted Google Calendar-style web app built with PHP, MySQL, HTML, CSS, and JS." />

        <link rel="stylesheet" href="css/style.css" />
    </head>

    <body>
        <header>
            <h1>MyCalendar</h1>
            <p>A self-hosted Google Calendar-style web app built with PHP, MySQL, HTML, CSS, and JS.</p>
        </header>

        <!-- ✅ Success / Error Messages -->
        <?php if ($success): ?>
            <div class="alert success">
                <?= $success ?>
            </div>
            
        <?php elseif ($error): ?>
            <div class="alert error">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Clock -->
        <div class="clock-container">
            <div id="clock"></div>
        </div>

        <!-- Calendar -->
        <div class="calendar">
            <!-- Navigation bar for the calendar -->
            <div class="nav-btn-container">
                <button onclick=changeMonth(-1) class="nav-btn">⏮️</button>
                <h2 id="monthYear" style="margin: 0"></h2>
                <button onclick=changeMonth(1) class="nav-btn">⏭️</button>
            </div>

            <div class="calendar-grid" id="calendar"></div>
        </div>

        <!-- Modal for Add/Edit/Delete Event -->
         <div class="modal" id="eventModal">
            <div class="modal-content">
                <div id="eventSelectorWrapper" style="display:none;">
                    <label for="eventSelector">
                        <strong>Select an event:</strong>
                    </label>
                    <select id="eventSelector">
                        <option disabled selected>-- Select an event --</option>
                    </select>
                </div>

                <!-- Main Form -->
                <form method="POST" id="eventForm">
                    <input type=hidden name="action" value="add" id="formAction" />
                    <input type="hidden" name="event_id" id="eventId" />
                    
                    <label for="eventName">Event Title:</label>
                    <input type="text" name="event_name" id="eventName" required />

                    <label for="eventDescription">Description:</label>
                    <input type="text" name="event_description" id="eventDescription" required/>

                    <label for="startDate">Start Date:</label>
                    <input type="date" name="start_date" id="startDate" required />

                    <label for="endDate">End Date:</label>
                    <input type="date" name="end_date" id="endDate" required />

                    <label for="startTime">Start Time:</label>
                    <input type="time" name="start_time" id="startTime" required/>

                    <label for="endTime">End Time:</label>
                    <input type="time" name="end_time" id="endTime" required/>

                    <button type="submit" id="eventFormSubmitBtn">Add Event</button>
                </form>

                <!-- Delete Form -->
                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');" id="deleteEventForm">
                    <input type="hidden" name="action" value="delete" />
                    <input type="hidden" name="event_id" id="deleteEventId" />
                    <button type="submit" class="submit-btn" style="display:none;" disabled>Delete Event</button>
                </form>

                <!-- Cancel -->
                <button type="button" onclick="closeModal()" class="submit-btn">Cancel</button>
            </div>
         </div>
        
        <script>
            const events = <?= json_encode($eventsFromDB, JSON_UNESCAPED_UNICODE); ?>;
        </script>
        
        <script src="js/calendar.js"></script>
    </body>
</html>