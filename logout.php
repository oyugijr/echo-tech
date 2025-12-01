<?php
require_once 'includes/auth.php';

logoutUser();
redirectWithMessage('login.php', 'You have been signed out successfully.', 'success');
?>
