
<?php
$title = "admin";
include("functions.php");

if(isset($_GET['logout'])) {
    unset($_SESSION['admin']);
    header("Location:login.php");
    exit;
}

if(isset($_GET['del'])) {
  $sql = mysql_query("SELECT * FROM slides WHERE id = '".(int)$_GET['del']."'",spoj_s_db());

  if(mysql_num_rows($sql)!=0) {
    mysql_query("DELETE FROM slides WHERE id='".(int)$_GET['del']."'",spoj_s_db());
    header("Location:admin.php");
    exit;
  }
}

if(!isset($_SESSION["admin"]) || !$_SESSION["admin"])
{
    ?>
    <script language="javascript">
        window.location.href = "login.php"
    </script>   
    
    <?php
    die;
}
$_SESSION["add"] = isset($_POST['add']);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta ln="sk"> 
    <title><?php echo $title; ?></title>
    <link href="style.css" rel="stylesheet">
    <link href="features.css" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
    <script type="text/javascript">
      resizing = function(){
        document.querySelector("body").style.width = (window.innerWidth).toString() + "px";
    }

    window.addEventListener("resize", resizing);
    document.addEventListener("DOMContentLoaded", resizing);

    function getFile(){
        document.getElementById("fi1").click();
    }
    
    
</script>
</head>

<body>
    <?php
    if(isset($_POST['submit'])) pridaj();
    ?>
    <header>
        <p> Prehľad prednášok</p>
        <div id="user">
            <img src="user.png" height="35px" width="35px">
            <div id="pw">
            <a href="change_password.php" >zmena hesla</a>
            <a href="index.php" >prejsť na prednášku</a>
            <a href="admin.php?logout" >odhlásiť sa</a>
            </div>
        </div>
    </header>
    <section id="section">
        <?php
        vypis_prednasky();

        if(!$_SESSION["add"]){
            ?>
            <form class="add" method="post" action="" >
                <input class="submit" name="add" type="submit" value="Pridaj prednášku">
            </form>
            <?php }else{ ?>
            
            <form class="add"action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="files[]" multiple/>
                <input type="submit"/ name="submit">
            </form>
            <?php
        }?>

    </section>
    <footer>
        <p>vytvoril: Interactive lecture tIS team</p>
    </footer>
    <script type="text/javascript">
        $( document ).ready(function() {
            $(".toggle_act").click(function(){
                var slide=$(this).data("slide");
                var check=$(this).data("checked");
                if(check=="1"){
                   $.post("update_active.php", {
                    type: slide,
                    val1: "0"
                });
                   $(this).data("checked","0");
               }
               else {
                $.post("update_active.php", {
                    type: slide,
                    val1: "1"
                });
                 $(this).data("checked","1");
               }
               $("#section").load(document.URL+" #section>*","");
               });
        });

        $( document ).ready(function() {
            $(".del").click(function(){
                var slide=$(this).data("slide");
                $.post("delete_slide.php", {
                    type: slide,
                    val1: "0"
                });
        
               
               location.reload();
           });
        });
        
    </script>
</body>
</html>
