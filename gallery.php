<?php
    require_once('checklog3.php'); //DIFFERENT NAV BARS FOR LOGGED IN USERS
    require_once "db_connect.php"; //CONNECTS TO DATABASE
    require "functions.php"; //CLEAN STRING FUNCTION AND ENCRYPTION
?>

<div class="imagegallery" style="margin-top:50px;">
    <?php
    $folder_path = 'uploaded_images/'; //image's folder path
    $num_files = glob($folder_path . "*.{JPG,jpg,gif,png,bmp}", GLOB_BRACE);
    $folder = opendir($folder_path);
    if($num_files > 0){
        while(false !== ($file = readdir($folder))){
            $file_path = $folder_path.$file;
            $extension = strtolower(pathinfo($file ,PATHINFO_EXTENSION));
            if($extension=='jpg' || $extension =='png'){
    ?>
    <a href="<?php echo $file_path; ?>"><img src="<?php echo $file_path; ?>"  height="250" /></a>
    <?php
            }
        }
    }else{
        echo "the folder was empty !";
    }
    closedir($folder);
?>
</div>
<?php 
    include_once("footer.html");
?>