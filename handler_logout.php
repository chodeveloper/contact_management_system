<?php
session_start();
// destory the session to sign out
session_destroy();
// go to index page
header("Location: .");
exit;
