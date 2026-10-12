<?php
// db.php - connects to the MySQL database (import database/kai_db.sql first sa phpMyAdmin)
require_once __DIR__ . '/config.php';

/*
 * usage: $conn = getConnection();
 * returns null if the database is not available
 */
function getConnection(): ?mysqli
{
    mysqli_report(MYSQLI_REPORT_OFF); // we'll handle the errors ourselves

    $conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        // don't show the real error to visitors
        error_log('DB connection failed: ' . $conn->connect_error);
        return null;
    }

    $conn->set_charset('utf8mb4');
    return $conn;
}
