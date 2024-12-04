<?php

session_start();
session_destroy();
header("Location: LR_Login.html");
exit();

?>
