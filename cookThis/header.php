<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Cook This - Rob's Project 4 Recipe Logger</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/journal/bootstrap.min.css" rel="stylesheet" integrity="sha384-0d2eTc91EqtDkt3Y50+J9rW3tCXJWw6/lDgf1QNHLlV0fadTyvcA120WPsSOlwga" crossorigin="anonymous">    
    </head>

    <div class="container">
    <body>
    
        <div class="jumbotron">
        <h1>Cook <em>this</em></h1>
        <p><em>Keep Track&trade;</em></p>
        </div>
<?php 
    session_start();
    
    if (isset($_SESSION['user_id']) && isset($_COOKIE['user_id']))
    {
        require_once('connectvars.php');
        echo'<p>You are logged in as ' . $_SESSION['username'] . '. <a href="logout.php">Log Out</a></p>';
        require_once('nav.php');
    }
?>
        