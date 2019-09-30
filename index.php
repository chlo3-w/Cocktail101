<?php  
require_once('checklog2.php'); //SEES IF USER IS LOGGED IN - REDIRECTS TO LOGIN PAGE IF NOT
include('header.html'); //NAV BAR FOR USERS
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
        <img src="cocktail22.png" alt="Cocktail1Carousel" width="1200" height="700"/>
        <div class="carousel-caption">
            <h3 class="text-center" style="font-size:60px; font-family: 'Unica One', sans-serif">Cocktail 101</h3>
          <p>Fancy a cocktail and need to know the ingredients?</p>
        </div>      
      </div>
    <!-- SLIDE 2 -->
      <div class="item">
        <img src="cocktail11.png" alt="Cocktail2Carousel" width="1200" height="700"/>
        <div class="carousel-caption">
          <h3 style="font-size:45px; font-family: 'Unica One', sans-serif">Alcohol Search Tool</h3>
          <p>Find out what cocktails you can make with what alcohol here.</p>
        </div>      
      </div>
    <!-- SLIDE 3 -->
      <div class="item">
        <img src="cocktail33.png" alt="Cocktail3Carousel" width="1200" height="700"/>
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



<!-- Container (COCKTAIL Selection) -->
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
                $captcha = $_POST['g-recaptcha-response'];
                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $secretkey = "6Le4CAETAAAAAGQftFiDise1KTxFd6qTsowFR-TL";
                $response = file_get_contents($url."?secret=".$secretkey."&response=".$captcha);
                $data = json_decode($response);
                if (isset($data->success) AND $data->success==true) {           
                    $cocktailname = clean_string($db_server, $_POST['cocktailname']);
                    $query = "SELECT ID, cocktailname, typeofdrink, ingredient1, ingredient2, ingredient3, ingredient4, ingredient5, ingredient6, garnish FROM Cocktails WHERE ID=$cocktailname";
                    mysqli_select_db($db_server, $db_database);
                    $result = mysqli_query($db_server, $query);
                    if (!$result) die ("Database access failed: " . mysqli_error($db_server));

                    while($row = mysqli_fetch_array($result)) {
                        $output = '<p><h3>' . $row['cocktailname'] . ' is a ' . $row['typeofdrink'] . ' and contains <br/><br/> <ul style="list-style-type:none;"><li>' . $row ['ingredient1'] . '</li><li>' . $row ['ingredient2'] . '</li><li>' . $row ['ingredient3'] . '</li><li>' . $row ['ingredient4'] . '</li><li>' . $row ['ingredient5'] . '</li><li>' . $row ['ingredient6'] . '</li><br/><li>' . $row ['garnish'] . '</li></ul></h3></div>';
                        
                    }
                    mysqli_free_result($result);

                }else{
                    $message = "reCAPTCHA failed. (<em>error message</em>: " . $data->{'error-codes'}[0] . ")"; 
                }
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

<form action="index.php#form-anchor1" method="post">
    <h1 style="font-size:30px; font-family: 'Montserrat', sans-serif"> Please select a cocktail </h1><br>
    <select name="cocktailname">
    <?php echo $str_options; ?><br/>
    </select>
      <div align=center class="g-recaptcha"
data-sitekey="6Le4CAETAAAAAJ58ZxBrDGRawcYuHhjxIXJoZ45g"></div><br/> <input type="submit" id="submit" name="submit" value="Submit" />
</form>     
<br/>
</div>
<?php 
        echo $output;
        echo $message;
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
          <img src="drink.png" height="200px" alt="cocktailicon"/>
      </div>
      <div class="col-sm-8">
          <br/>
          <h5 class="text-center" style="font-family: 'Montserrat', sans-serif;">Search for an alcohol</h5>
          <form action="index.php#form-anchor2" id="form-anchor2" method="post" style="text-align:center;"><input type="text" name="ingredient1" onkeyup="showHint(this.value)" size="30" />
              <br/>
              <input type="submit" id="submit2" name="submit2" value="Submit" />
          </form>
          <p>Suggestions- <span id="txtHint"></span></p>
      </div>
      <br/>

<?php
    echo $message2;
    echo $message22;
    echo $message222;
    echo $output2;
?>
    </div>
</div>
    

 
<!-- Container (COMMENTS Section) -->
<div id="comments" class="bg-2">
  <div class="container">
      <h1 style="font-size:30px; font-family: 'Montserrat', sans-serif; text-align:center">Comments</h1>
      <h5 class="text-center">Please <a href="login.php">login</a> to view/add comments </h5>
    </div>
</div>
    
    
<!-- (FOOTER) -->  
<?php 
    require_once "db_close.php";
    include_once("footer.html");
?>

    
<!-- (SCRIPT) -->   
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
