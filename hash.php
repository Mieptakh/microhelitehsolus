<?php
$password = "adminmhteams"; // Ganti dengan password yang ingin di-hash
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo "Password yang sudah di-hash: " . $hashedPassword;
?>