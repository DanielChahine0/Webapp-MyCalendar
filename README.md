# Webapp-MyCalendar
MyCalendar is a self-hosted Google Calendar-style web app built with PHP, MySQL, HTML, CSS, and JS, offering drag-and-drop scheduling, multi-view (month/week/day) layouts, recurring events—all under an MIT license.

## `Index.php`
- The view port is set to a device width to be able to scale across multiple devices.
- The for our model for adding the events, the label name has to match the id of the input. This is required so when we click on the label, the focus will be shifted to the input.