# Code Notes for `src` Directory

---

## 1. `calendar.php`

- Handles all backend logic for event CRUD (Create, Read, Update, Delete) operations.
- Includes the database connection from `connection.php`.
- Processes POST requests for adding, editing, and deleting events.
- Sanitizes and validates user input before interacting with the database.
- Uses prepared statements to prevent SQL injection.
- Fetches all events from the database, expanding multi-day events into individual days for frontend use.
- Sets `$success` and `$error` messages based on operation results.
- Exports `$eventsFromDB` as an array for use in the frontend.

---

## 2. `connection.php`

- Establishes a connection to the MySQL database using MySQLi.
- Sets the character set to `utf8mb4` for proper Unicode support.
- Uses default XAMPP credentials (`root` user, no password).
- The `$connection` variable is used throughout the backend for database operations.

---

## 3. `index.php`

- Main entry point and frontend for the calendar web app.
- Includes `calendar.php` to handle backend logic and data fetching.
- Displays success/error messages at the top of the page.
- Renders the header, clock, and calendar container.
- Contains the modal for adding, editing, and deleting events.
- Injects the `$eventsFromDB` PHP array into JavaScript for frontend rendering.
- Loads the main stylesheet and the `calendar.js` script for dynamic UI.

---

## 4. `js/calendar.js`

- Handles all frontend interactivity and dynamic rendering of the calendar.
- Renders the calendar grid for the selected month, including days and events.
- Provides navigation between months.
- Handles opening and populating the modal for adding/editing events.
- Manages the event selector dropdown for editing/deleting events.
- Updates the real-time clock display.
- Communicates with the backend via form submissions (no AJAX).

---

## 5. `css/style.css`

- Contains all styles for the calendar app.
- Defines color variables and font settings for consistent theming.
- Styles the header, clock, calendar grid, days, events, and modal.
- Responsive design for both desktop and mobile devices.
- Styles for alerts, buttons, overlays, and event forms.
- Ensures a modern, clean, and user-friendly interface.