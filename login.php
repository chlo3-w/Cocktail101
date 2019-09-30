<?php 
session_start();
require "functions.php";
$username = trim($_POST['username']);
$password = trim($_POST['password']);
    
if (isset($_SESSION['logged'])){
    $s_username = $_SESSION['username'];
    $message2 = "You are already logged in as $s_username.
                Please <a href='logout.php'>logout</a> before trying to register.";
    }

if(isset($_POST['submit'])) {
    if ($username&&$password){
        require_once("db_connect.php");
        mysqli_select_db($db_server, $db_database) or die("Couldn't find db");
        $username = clean_string($db_server, $username);
        $password = clean_string($db_server, $password);
        $query = "SELECT * FROM Users WHERE username='$username'";
        $result = mysqli_query($db_server, $query);
            if($row = mysqli_fetch_array($result)){
                $db_username = $row['username'];
                $db_password = $row['password'];
                $db_id = $row['ID'];
                    if($username==$db_username&&salt($password)==$db_password){
                        $_SESSION['username']=$username;
                        $_SESSION['userID']=$db_id;
                        $_SESSION['logged']="logged";
                        header('Location: home.php');
                    }else{
                        $message = "<h1>Incorrect password!</h1>";
                    }
            }else{
                $message = "<h1>User does not exist</h1>" . "Please try again</a>";
            }
        mysqli_free_result($result);
        require_once("db_close.php");
        
     }else{
        $message = "<h3>Please enter a valid username/password</h3>";
    } 
}
require_once('checklog3.php');
?>


<div id="login" class="container-fluid bg-1 text-center">
    <img src="sketch.png" height="400" alt="cocktailsketch"/>
    <br/>
</div>

<div class="container-fluid bg-2">
    <div class="content">
        <div class="row">
            <h2>Login</h2>
            <h4><?php echo $message2; ?></h4>
        </div>
        <form action='login.php' method='POST'>  
            <div class="col-sm-7 slideanim">
                <div class="row">
                    <div class="col-sm-8 form-group">
                        <input class="form-control" id="name" name="username" placeholder="Username" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 form-group">
                        <input class="form-control" id="email" name="password" placeholder="Password" type="password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <input type='submit' name='submit' value='Login'>
                        <input name='reset' type='reset' value='Reset'>
                    </div>
                </div>
                <?php echo $message; ?> <br/>
            </div>
        </form>
        <div class="col-sm-5">
            <h3 class="row"><a href='register.php'> Haven't registered?<br>Please click here</a></h3>
        </div>
    </div>
</div>

<?php
    include_once("footer.html"); 
?>


    
