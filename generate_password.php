<?php
// generate_password.php

$password = 'admin123'; // Ваш пароль
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Хэшированный пароль: " . $hash;