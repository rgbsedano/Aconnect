<?php
/**
 * Password Hasher for Testing
 * Use this to generate hashed passwords for your employer accounts
 */

// Example: Hash a password
$password = "password123"; // Change this to your desired password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

echo "Original Password: " . $password . "<br>";
echo "Hashed Password: " . $hashed_password . "<br><br>";

echo "Copy the hashed password and update your employers table in HeidiSQL:<br>";
echo "UPDATE employers SET password = '" . $hashed_password . "' WHERE email = 'your_email@example.com';<br>";
?>
