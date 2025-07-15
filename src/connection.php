<?php

// Connection to the local database (mysql) using XAMPP
$username = "root";
$connection = new mysqli("localhost", $username, "", "calendar");
$connection->set_charset("utf8mb4");

