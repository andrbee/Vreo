<?php

require_once(__DIR__."/../../application.php");
require_once(__DIR__."/../functions_app_developer.php");
appHeaders();
requiresDeveloperAuth();

?>



<html>
    <body>
        <a href='../'>Back</a> | <a href='account_logout.php'>Logout</a> | <a href='account_edit.php'>Account</a><br>
        <br>
        <br>
        <br>
        
        <h1>Developer Panel</h1><br>
        
        <a href="edit_developer_games.php">Edit Games</a><br>
        <br>
        <a href="view_developer_games_statistics.php">View Statistics</a><br>
    </body>
</html>







