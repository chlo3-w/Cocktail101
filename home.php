<?php
    require_once('checklog.php'); //SEES IF USER IS LOGGED IN - REDIRECTS TO LOGIN PAGE IF NOT
    include_once('headerlogged.html'); //NAV BAR FOR LOGGED IN USERS
    require_once "db_connect.php"; //CONNECTS TO DATABASE
    require "functions.php"; //CLEAN STRING FUNCTION AND ENCRYPTION
?>

<!-- CAROUSEL -->
<div style="margin-top:50px">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-slide-to="0" class="active"></li>
        <li data-slide-to="1"></li>
        <li data-slide-to="2"></li>
    </ol>
<!-- SLIDES -->
<div class="carousel-inner" role="listbox">
    <!-- SLIDE 1 -->
    <div class="item active">
    <img src="cocktail22.png" alt="Cocktail1" width="1200" height="700"/>
        <div class="carousel-caption">
            <h3 style="font-size:60px; font-family: 'Unica One', sans-serif">Cocktail 101</h3>
            <p>Fancy a cocktail and need to know the ingredients?</p>
        </div>      
    </div>
    <!-- SLIDE 2 -->
    <div class="item">
    <img src="cocktail11.png" alt="Cocktail2" width="1200" height="700"/>
        <div class="carousel-caption">
            <h3 style="font-size:45px; font-family: 'Unica One', sans-serif">Alcohol Search Tool</h3>
            <p>Find out what cocktails you can make with what alcohol here.</p>
        </div>      
    </div>
    <!-- SLIDE 3 -->
    <div class="item">
    <img src="cocktail33.png" alt="Cocktail3" width="1200" height="700"/>
        <div class="carousel-caption">
          <h3 style="font-size:40px; font-family: 'Unica One', sans-serif">Comment board</h3>
          <p>Post about our cocktails or see what others have to say<br/> Posted images even get uploaded to our <a href="gallery.php" style="color:#C6CB92;">gallery</a>!</p>
        </div>      
      </div> 
</div>
<!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
</div>
</div>



<!-- Container (The Cocktail Selection) -->
<div class="bg-1" id="cocktail">
<div class="container" id="form-anchor1">
<div class="text-center">  
<?php 
    if (!$db_server){
            die("Unable to connect to MySQL: " . mysqli_connect_error($db_server));
            $db_status = "not connected";
    }else{
             
         if(isset($_POST['submit'])) {
             if(trim($_POST['submit']) == "Submit") {          
                    $cocktailname = clean_string($db_server, $_POST['cocktailname']);
                    $query = "SELECT ID, cocktailname, typeofdrink, ingredient1, ingredient2, ingredient3, ingredient4, ingredient5, ingredient6, garnish FROM Cocktails WHERE ID=$cocktailname";
                    mysqli_select_db($db_server, $db_database);
                    $result = mysqli_query($db_server, $query);
                    if (!$result) die ("Database access failed: " . mysqli_error($db_server));

                    while($row = mysqli_fetch_array($result)) {
                        $output1 = '<p><h3>' . $row['cocktailname'] . ' is a ' . $row['typeofdrink'] . ' and contains <br/><br/> <ul style="list-style-type:none;"><li>' . $row ['ingredient1'] . '</li><li>' . $row ['ingredient2'] . '</li><li>' . $row ['ingredient3'] . '</li><li>' . $row ['ingredient4'] . '</li><li>' . $row ['ingredient5'] . '</li><li>' . $row ['ingredient6'] . '</li><br/><li>' . $row ['garnish'] . '</li></ul></h3></div>';
                    }

                    mysqli_free_result($result);

                }
            }
        }
    
    mysqli_select_db($db_server, $db_database);
        $query = "SELECT ID, cocktailname FROM Cocktails ORDER BY cocktailname";
        $result = mysqli_query($db_server, $query);
    if (!$result) die("Query failed: " . mysqli_error($db_server));
          
    while($row = mysqli_fetch_array($result)){
            $str_options .= "<option value='" . $row['ID'] . "'>"; 
            $str_options .=     $row['cocktailname'];
            $str_options .= "</option>"; 
    } 
    mysqli_free_result($result);
?>

<form action="home.php#form-anchor1" method="post">
    <h1 style="font-size:30px; font-family: 'Montserrat', sans-serif"> Please select a cocktail </h1><br/>
    <select name="cocktailname">
    <?php echo $str_options; ?><br/>
    </select><br/><br/>
      <input type="submit" id="submit" name="submit" value="Submit" />
</form>     
<br/> 
</div> 
<?php 
        echo $output1;
        echo $message1;
?>
     
</div>
</div>



<!-- Container (ALCOHOL SEARCH Section) -->
<div id="alcohol" class="bg-3">
  <div class="container">
     <?php
      if(isset($_POST['submit2'])) {
        if(trim($_POST['submit2']) == "Submit") {
            $ingredient1 = trim($_POST['ingredient1']);
            if(empty ($ingredient1)) {
            $message2= "Please fill in field";
            }else{
                $ingredient1 = clean_string($db_server, $_POST['ingredient1']);
                $query = "SELECT ID, cocktailname, typeofdrink, ingredient1 FROM Cocktails WHERE ingredient1 LIKE '%$ingredient1%'";
                mysqli_select_db($db_server, $db_database);
                $result = mysqli_query($db_server, $query);
                if (!$result) die("Database access failed: " . mysqli_error($db_server));
                $message22= "<h3>Thanks for your input!<p>Your search found the following cocktail(s):</p></h3>";
                $message222= "<br/><br/><h5>Now select a cocktail in the search above to see its full ingredients!</h5>";
                while($row = mysqli_fetch_array($result)){
                    $output2 .= '<p>' . $row['cocktailname'] . ' which is a ' . $row['typeofdrink'] . ' and contains ' . $row ['ingredient1'];
                }
                mysqli_free_result($result);
            }
        }
      }
    
?>

<h1 style="font-size:30px; font-family: 'Montserrat', sans-serif; text-align:center"> Struggling to decide on which cocktail to make?</h1> 
      <div class="col-sm-4">
          <img src="drink.png" height="200px"/>
      </div>
      <div class="col-sm-8">
          <br/>
          <h5 class="text-center" style="font-family: 'Montserrat', sans-serif;">Search for an alcohol</h5>
          <form action="home.php#form-anchor2" id="form-anchor2" method="post" style="text-align:center;"><input type="text" name="ingredient1" onkeyup="showHint(this.value)" size="30" />
              <br/>
              <input type="submit" id="submit2" name="submit2" value="Submit" />
          </form>
          <p>Suggestions- <span id="txtHint"></span></p>
      </div>
      <br/>

<?php
    echo $message22;
    echo $output2;
    echo $message2;
?>
    </div>
</div>    
    
    
<!-- Container (COMMENTS Section) -->
<div id="comments" class="bg-2">
  <div class="container" id="form-anchor3">
      <h1 class="text-center" style="font-size:30px; font-family: 'Montserrat', sans-serif;">Comment board</h1>
      <h5 class="text-center"><a href="gallery.php" style="color:#f1f1f1;">Click here for the image gallery</a></h5>

<!-- (COMMENT BOARD PHP) -->
<?php
     if (!$db_server){
            die("Unable to connect to MySQL: " . mysqli_connect_error($db_server));
            $db_status = "not connected";
    }else{
             
         if(isset($_POST['submit3'])) {
             if(trim($_POST['submit3']) == "Submit") {
                $cocktailname = clean_string($db_server, $_POST['cocktailname']);
                $query = "SELECT ID, cocktailname, typeofdrink, ingredient1 FROM Cocktails WHERE ID=$cocktailname";
                mysqli_select_db($db_server, $db_database);
                $result = mysqli_query($db_server, $query);
                if (!$result) die ("Database access failed: " . mysqli_error($db_server));

            mysqli_free_result($result);

                $comment = clean_string($db_server, $_POST['comment']);
                $selection = clean_string($db_server, $_POST['cocktailname']);
                $imagedescription = clean_string($db_server, $_POST['imagedescription']);
                $name = $n = "";
                if (($comment <> '') or (is_uploaded_file($_FILES['filename']['tmp_name']))) {
                    if ($_FILES) {
                        //Put file properties into variables
                        $name = $_FILES['filename']['name'];
                        $size = $_FILES['filename']['size'];
                        $tmp_name = $_FILES['filename']['tmp_name'];
                        //Determine whether file is png, jpg or other
                        switch($_FILES['filename']['type']) {
                            case 'image/jpeg':      $ext = "jpg"; break;
                            case 'image/png':       $ext = "png"; break;
                            default:                $ext = ''; break;
                        }
                            if ($ext) { //if $ext is empty string image is not a jpg or png
                                if($size < 100000) { //validate against file size
                                    $n = "$name";
                                    $n = ereg_replace("[^A-Za-z0-9.]","",$n);
                                    $n = strtolower($n); //Convert to lower case(platform independence)
                                    $n = "uploaded_images/$n"; //Add folder to force safe location
                                    move_uploaded_file($tmp_name, $n);
                                    echo "<p>Uploaded image '$name' as '$n': </p>";
                                    echo "<img src='$n' />";
                                    $query = "INSERT INTO Comment (userID, comment, selection, imagename, imagedescription) VALUES (" . $_SESSION['userID'] . ", '$comment', '$selection', '$n', '$imagedescription')";
                mysqli_select_db($db_server, $db_database);
                mysqli_query($db_server, $query) or die("Insert failed: " . mysqli_error($db_server));
                $message3 = "Thanks for your comment!";
                               }else{ 
                                    echo "<p><h2>'$name' is too big - 100kb max (100000 bytes).</h2></p>";
                                }
                            }
                        }else echo "<p><h2> No image has been uploaded.</h2></p>";
                    
                if($comment <> '') {         
                $query = "INSERT INTO Comment (userID, comment, selection, imagename, imagedescription) VALUES (" . $_SESSION['userID'] . ", '$comment', '$selection', '$n', '$imagedescription')";
                mysqli_select_db($db_server, $db_database);
                mysqli_query($db_server, $query) or die("Insert failed: " . mysqli_error($db_server));
                $message3 = "Thanks for your comment!";
            
                }  
            }else{
                    echo "Please fill in a field";
                }
         }     
    }
    mysqli_select_db($db_server, $db_database);
    $query = "SELECT ID, cocktailname FROM Cocktails ORDER BY cocktailname";
    $result = mysqli_query($db_server, $query);
    if (!$result) die("Query failed: " . mysqli_error($db_server));
          
    while($row = mysqli_fetch_array($result)){
        $str_options .= "<option value='" . $row['ID'] . "'>"; 
        $str_options .=     $row['cocktailname'];
        $str_options .= "</option>"; 
    }
        mysqli_free_result($result); 
        
        $query = "SELECT Comment.commDate, Cocktails.cocktailname, Comment.ID, Comment.userID, Comment.comment, Comment.imagename, Comment.imagedescription, Users.username FROM Comment JOIN Cocktails ON Comment.selection = Cocktails.ID JOIN Users ON Comment.userID = Users.ID ORDER BY Comment.CommDate DESC";
        $result = mysqli_query($db_server, $query);
        if (!$result) die("Database access failed: " . mysqli_error($db_server)); 
        
        while($row = mysqli_fetch_array($result)){
            $comments .= "<li class='list-group-item'><p> <br /><br />" . $row['username'] . " &nbsp; <em> " . $row['commDate'] . "</em> <br /><h4>" . $row['cocktailname'] . " cocktail </h4>" . $row['comment'] . "<br /><br /><img src='" . $row['imagename'] . "' alt='" . $row['imagedescription'] . "'/> </p> </li>";
        
        if ($row['userID'] == $_SESSION['userID']){
            $comments .= "<a href='delete_post.php?pID=".$row['ID']."'>Delete</a>" . "</p>";
        }
    }
        mysqli_free_result($result);
    }  
?>  
<?php 
        echo $message3;
?>
      <br/>
      <ul class="list-group">
<?php
    echo $comments;
?>
      </ul>
    </div>
</div>


<!-- Container (COMMENT POSTING) -->
<div id="post" class="bg-1">
<div class="container">
    <h2 class="text-center" style="font-size:30px; font-family: 'Montserrat', sans-serif;">Add to the discussion and post your comment/image below</h2>
    <br/>
    <div class="col-md-12">
        <form action="home.php#form-anchor3" method="post" enctype="multipart/form-data">
            <h6> Please select the cocktail you wish to comment on </h6>
            <select name="cocktailname">
                <?php echo $str_options; ?>
            </select>
            <br/>
            <h6>Add a comment </h6>
            <textarea class="form-control" id="comments" name="comment" placeholder="Comment" rows="3" cols="30"></textarea>
            <h5>Upload your images here <br/>(they get uploaded to our <a href="gallery.php">gallery</a>!)</h5>
            <div id="fileselect">
                <h6> Select file to upload:&nbsp; </h6>
                <input type="file" id="filename" name="filename" size="10">
                <h6> Please add an image description </h6>
                <textarea class="form-control" rows="1" cols="30" placeholder="Image description" name="imagedescription"></textarea>
                <br/>
            </div>
            <input type="submit" id="submit3" name="submit3" value="Submit" />
        </form>
    </div>
    </div>
</div>


<!-- (FOOTER + CONNECT FROM DATABASE) -->
<?php 
    require_once "db_close.php";
    include_once("footer.html");
?>

<!-- (SCRIPT FOR GETHINT, CAROUSEL AND SCROLLING) -->
<script>
function showHint(str) {
  var xhttp;
  if (str.length == 0) { 
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "gethint.php?q="+str, true);
  xhttp.send();   
}
    
$(document).ready(function(){
  // Initialize Tooltip
  $('[data-toggle="tooltip"]').tooltip(); 
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
    // Prevent default anchor click behavior
    event.preventDefault();
    // Store hash
    var hash = this.hash;
// Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){
    // Add hash (#) to URL when done scrolling (default click behavior)
    window.location.hash = hash;
      });
    } 
  });
})
</script>