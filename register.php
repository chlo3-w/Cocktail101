<?php  
require_once('checklog3.php'); //DIFFERENT NAV BAR FOR LOGGED IN USERS
require "functions.php"; //CLEAN STRING AND PASSWORD ENCRYPTION
$submit = trim($_POST['submit']);
$username = trim($_POST['username']);
$password = trim($_POST['password']); 
$repeatpassword = trim($_POST['repeatpassword']);
$message = '';
$s_username = '';

// Determine whether user is logged in  
if (isset($_SESSION['logged'])){
    $s_username = $_SESSION['username'];
    $message = "You are already logged in as $s_username.
                Please <a href='logout.php'>logout</a> before trying to register.";
    }else{ 
    
    if ($submit=='Register'){
            $captcha=$_POST['g-recaptcha-response'];
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $secretkey = "6Le4CAETAAAAAGQftFiDise1KTxFd6qTsowFR-TL"; 
            $response = file_get_contents($url."?secret=".$secretkey."&response=".$captcha); 
            $data = json_decode($response);
                if (isset($data->success) AND $data->success==true) {
                    // Process valid submission data here
                        if($username&&$password&&$repeatpassword) {
                            if ($password==$repeatpassword) {
                                if (strlen($username)>25) {
                                    $message = "Username is too long";
                                }else{
                                    if (strlen($password)>25||strlen($password)<6) {
                                        $message = "Password must be 6-25 characters";
                                    }else{
                                        require_once("db_connect.php");
                                        if($db_server){
                                            $username = clean_string($db_server, $username);
                                            $password = clean_string($db_server, $password);
                                            mysqli_select_db($db_server, $db_database);
                                            $query="SELECT username FROM Users WHERE username='$username'";
                                            $result=mysqli_query($db_server, $query);
                                                if ($row = mysqli_fetch_array($result)){
                                                        $message = "Username already exists, Please try again.";
                                                }else{
                                                    $password = salt($password);
                                                    $query = "INSERT INTO Users (username, password) VALUES ('$username','$password')";
                                                    mysqli_query($db_server, $query) or die("Insert failed. ". mysqli_error($db_server));
                                                    $message = "<strong>Registration successful!</strong>";
                                                    
                                                }
                                            mysqli_free_result($result);
                                        }else{
                                            $message = "Error: could not connect to the database.";        
                                        }
                                    require_once("db_close.php");
                                    }
                                }
                            }else{
                                $message = "Both password fields must match";
                            }
                        }else{
                            $message =  "Please fill in all fields";    
                        }  
                }else{
                    $message = "reCAPTCHA failed: ".$data->{'error-codes'}[0]; 
            }                            
     }
}

?>


<div id="register" class="container-fluid bg-1 text-center">
 <img src="sketch.png" height="400" alt="cocktailsketch"/>
</div>
<div class="container-fluid bg-3">
    <div class="content">
        <form action="register.php" method="post">
            <h2> Register </h2>
            <div class="col-sm-9 slideanim">
                <div class="row">
                    <div class="col-sm-9 form-group">
                        <input class="form-control" id="name" name="username" placeholder="Username" type="text" value="<?php echo $username; ?>">
                    </div>
                    <div class="col-sm-9 form-group">
                        <input class="form-control" id="email" name="password" placeholder="Password" type="password">
                    </div>
                    <div class="col-sm-9 form-group">
                        <input class="form-control" id="email" name="repeatpassword" placeholder="Repeat Password" type="password">
                    </div>
                    <div class="col-sm-9 form-group">
                        <div class="g-recaptcha" data-sitekey="6Le4CAETAAAAAJ58ZxBrDGRawcYuHhjxIXJoZ45g"></div>
                    </div>
                    <div class="col-sm-9 form-group">
                        <input type="submit" name="submit" value="Register">
                        <input name="reset" type="reset" value="Reset">
                    </div>
                </div>
                <h3>Already registered?<br/><a href="login.php">Login here</a></h3>
            </div>
        </form>
    </div>
</div>

<?php 
    include_once("footer.html");
?>