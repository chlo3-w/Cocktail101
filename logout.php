<?php
    session_start();
    // Unset all of the session variables.
    $_SESSION = array();
    // Destroy the session
    session_destroy();
    // Print out the confirmation page
    include_once('header.html');   
?>

<div id="logout" class="container-fluid bg-1 text-center">
    <img src="sketch.png" height="400" alt="cocktailsketch"/>
    <br/>
</div>
<div class="container-fluid bg-2">
    <div class="content">
        <?php echo "<h1>You have logged out.</h1>
            <p>Go to the <a href='index.php'>homepage</a> or
            <a href='login.php'>log back in</a>.</p>"; //Your login page
        ?>
    </div>
</div>

<?php
    require_once("footer.html");
?>
    

