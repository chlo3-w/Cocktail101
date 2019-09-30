<?php
    require_once('checklog.php');
    include_once('functions.php');
    $sess_userID = $_SESSION['userID'];
    if(trim($_POST['submit'])=='Submit'){
        if(trim($_POST['delete'] )==1) {
             require_once("db_connect.php");
             if (!$db_server){
                 die("Unable to connect to MySQL: " . mysqli_connect_error($db_server));
            }else{
                 mysqli_select_db($db_server, $db_database) or
                     die("<h1>Couldn't find db</h1>");
            //DELETE records from comments table
                $query="DELETE FROM Comment WHERE userID=$sess_userID";
                mysqli_query($db_server, $query) or 
                    die("Delete 1 failed".mysqli_error($db_server));
            //DELETE record from users table
                 $query = "DELETE FROM Users WHERE ID=$sess_userID";
                 mysqli_query($db_server, $query) or
                     die("Delete 2 failed".mysqli_error($db_server));
            //LOGOUT AND DESTROY SESSION
                 $_SESSION = array();
                 session_destroy();
                 header('Location: home.php');     
            }
            require_once("db_close.php");
       }else{ 
             header('location: index.php');
        }
    }
    include_once('headerlogged.html');
?>

<div id="deleteaccount" class="container-fluid bg-1 text-center">
    <img src="sketch.png" height="400" alt="cocktailsketch"/>
</div>
<div class="container-fluid bg-3">
    <div class="content">
        <h2>Hello <?php echo $_SESSION['username']; ?></h2>
        <h3>Are you sure you want to delete your account?</h3>
        <form action="delete_account.php" method="post">
       Yes &nbsp; <input type="radio" name="delete" value="1" /><br />
       No &nbsp; <input type="radio" name="delete" value="0" checked="checked" /><br />
        <input type="submit" name="submit" value="Submit" />
    </form>
    </div>
</div>

<?php 
include_once("footer.html"); 
?>