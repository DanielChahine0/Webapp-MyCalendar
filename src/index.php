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

        <!-- Clock -->
        <div class="clock-container">
            <div id="clock"></div>
        </div>

        <!-- Calendar -->
        <div class="calendar">
            <!-- Navigation bar for the calendar -->
            <div class="nav-btn-container">
                <button class="nav-btn">⏮️</button>
                <h2 id="month-year" style="margin: 0"></h2>
                <button class="nav-btn">⏭️</button>
            </div>

            <div class="calendar-grid" id="calendar"></div>
        </div>

        <!-- Model for Add/Edit/Delete Appointment -->
        <div id="eventSelectorWrapper">
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
        </form>
    </body>
</html>