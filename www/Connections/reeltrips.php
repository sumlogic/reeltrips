<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_reeltrips = "localhost";
$database_reeltrips = "reeltrips";
$username_reeltrips = "root";
$password_reeltrips = "";
$reeltrips = mysql_pconnect($hostname_reeltrips, $username_reeltrips, $password_reeltrips) or trigger_error(mysql_error(),E_USER_ERROR); 
?>