<?php
    require_once('checklog.php'); // IF USER ISN'T LOGGED IN REDIRECT THEM TO LOGIN PAGE
    include_once('headerlogged.html'); //SHOW NAVBAR FOR LOGGED IN USERS
?>

<div id="account" class="container-fluid bg-1 text-center">
    <img src="sketch.png" height="400" alt="cocktailsketch"/>
    <br/>
</div>

<div class="container-fluid bg-3">
    <div class="content">
        <h2>Hello <?php echo $_SESSION['username'] ?></h2>
        <p>What can we help you with?</p><br />
        <a href=changepassword.php><h3 style="color: #2d2d30;">Change my password</h3></a>
        <a href=delete_account.php><h3 style="color: #2d2d30;">Delete my account </h3></a>
        <h3>FAQs</h3>
    </div>
</div>

<?php
 include_once("footer.html");
?>