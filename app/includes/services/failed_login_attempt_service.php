<?php
function is_ip_address_banned($conn, $ip_address) {
    $query = <<<QUERY
SELECT COUNT(*) AS number_of_attempts FROM failed_login_attempts
WHERE attempt_at BETWEEN DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 HOUR) AND CURRENT_TIMESTAMP
AND ip_address = ?
QUERY;

    $result = mysqli_execute_query($conn, $query, [$ip_address]);
    $row = mysqli_fetch_assoc($result);

    return $row["number_of_attempts"] >= ALLOWED_NUMBER_OF_FAILED_LOGIN_ATTEMPTS;
}

function log_failed_login_attempt($conn, $ip_address) {
    $query = "INSERT INTO failed_login_attempts (ip_address) VALUES (?)";
    mysqli_execute_query($conn, $query, [$ip_address]);
}
