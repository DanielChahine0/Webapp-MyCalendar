<?php

// Connection to the local database (mysql) using XAMPP
$username = "root";
$connection = new mysqli("localhost", $username, "", "mycalendar");
$connection->set_charset("utf8mb4");

