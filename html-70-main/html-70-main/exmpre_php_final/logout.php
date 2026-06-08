<?php
session_start();
session_destroy();
echo "Logged out successfully. <a href='login.php'>Login again</a>";
?>