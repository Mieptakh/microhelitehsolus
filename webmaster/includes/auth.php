<?php

function isLoggedIn(): bool {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function loginAdmin() {
    $_SESSION['admin_logged_in'] = true;
}

function logoutAdmin() {
    unset($_SESSION['admin_logged_in']);
}
