<?php
// Usaremos la contraseña simple 'admin123'
$new_hash = password_hash("87654321", PASSWORD_DEFAULT);
echo $new_hash;
?>