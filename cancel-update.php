<?php # Ensure no straggling sessions from update-form
    session_start(); # Resume session from update-form.php
    session_unset(); # Unset variables
    session_destroy(); # Destroy session

    echo '<pre> Session: ';
    print_r($_SESSION);
    echo '</pre>';

    header("Location: wordlist.php");
?>