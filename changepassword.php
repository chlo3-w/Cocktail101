<?php 
    require_once('checklog.php'); //REDIRECTS USERS TO LOGIN PAGE IF NOT LOGGED IN
    include_once('functions.php'); //PASSWORD ENCRYPTION
    $submit = trim($_POST['submit']);
    $password = trim($_POST['password']);
    $newpassword = trim($_POST['newpassword']); 
    $repeatpassword = trim($_POST['repeatpassword']);
    $message = '';

 if(isset($_POST['submit'])){
        if($password&&$newpassword&&$repeatpassword) {
            if ($newpassword==$repeatpassword) {
                   if (strlen($newpassword)>25||strlen($newpassword)<6) {
                        $message = "Password must be 6-25 characters";
                            }else{
                                require_once("db_connect.php");
                                if ($db_server){
                                mysqli_select_db($db_server, $db_database) or die("Couldn't find db");
                                $password = clean_string($db_server, $password);
                                $newpassword = clean_string($db_server, $newpassword);
                                $repeatpassword = clean_string($db_server, $repeatpassword);
                                    
                                if ($newpassword <> '') {
                                    $newpassword = salt($newpassword);
                                    $query = "UPDATE Users SET password = '$newpassword' WHERE id=" . $_SESSION['userID'] . " ";
                                    mysqli_query($db_server, $query) or die("Insert failed. ". mysqli_error($db_server));
                                    $message = "<strong>Password has been changed!</strong>";
                                }else{
                                    $message = "<h3>Please enter a new password.</h3>";
                                }
                                
                                    require_once("db_close.php");
                             }else{
                                $message = "Error: could not connect to the database.";        
                            }
                   }
            }else{
                $message = "Both password fields must match";
            }
        }else{
            $message =  "Please fill in all fields";
        }
 }
include_once('headerlogged.html');
?>

<div id="changepassword" class="container-fluid bg-1 text-center">
    <img src="sketch.png" height="400" alt="cocktailsketch"/>
</div>
<div class="container-fluid bg-3">
    <div class="content">
        <form action="changepassword.php" method="post">
            <h2> Change Password </h2>
            <div class="col-sm-9 slideanim">
                <div class="row">
                    <div class="col-sm-8 form-group">
                        <input class="form-control" name="password" placeholder="Old password" type="password">
                    </div>
                    <div class="col-sm-8 form-group">
                        <input class="form-control" name="newpassword" placeholder="New password" type="password">
                    </div>
                    <div class="col-sm-8 form-group">
                        <input class="form-control" name="repeatpassword" placeholder="Repeat Password" type="password">
                    </div>
                    <div class="col-sm-8 form-group">
                        <input type="submit" name="submit" value="Change password">
                        <input name="reset" type="reset" value="Reset">
                    </div>
                    </form>
                <h4><?php echo $message; ?></h4>
            </div>
            </div>
    </div>
</div>

<?php  
include_once("footer.html"); 
?>