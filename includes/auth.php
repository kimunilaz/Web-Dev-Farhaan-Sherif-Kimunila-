<?php
/**
 * Session + authentication helpers.
 * Included at the top of every page (via header.php) so
 * $_SESSION is always available.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

/**
 * Call this at the top of any page that requires authentication
 * (edit.php, delete.php). Anonymous visitors get bounced to login.php.
 */
function require_login(): void {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}