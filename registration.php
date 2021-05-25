<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
<?php
include "admin/functions.php";
//Setting Language Variables
    if(isset($_GET['lang']) && !empty($_GET['lang'])){

        $_SESSION['lang'] = $_GET['lang'];

        if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
            echo "<script type='text/javascript'> location.reload(); </script>";
        }
    }

    if(isset($_SESSION['lang'])){
        include "includes/languages/" . $_SESSION['lang'] . ".php";
    }else{
        include "includes/languages/en.php";
    }



    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!empty($username) && !empty($email) && !empty($password)){

            $username = mysqli_real_escape_string($connection, $username);
            $email = mysqli_real_escape_string($connection, $email);
            $password = mysqli_real_escape_string($connection, $password);

            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12) );

            // $query = "SELECT randSalt FROM users";
            // $select_randsalt_query = mysqli_query($connection, $query);

            // confirm($select_randsalt_query);

            // $row = mysqli_fetch_assoc($select_randsalt_query);
            // $salt = $row['randSalt'];

            // $hash_password = crypt($password, $salt);

            $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
            $query .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber' )";
            $register_user_query = mysqli_query($connection, $query);

            confirm($register_user_query);

            $message = "Your Registration has been submitted";
        }else{
            $message = "Fields cannot be empty";
        }
    }else{
        $message = "";
    }

?>

    <!-- Navigation -->

    <?php  include "includes/navigation.php"; ?>


    <!-- Page Content -->
    <div class="container">
    <form method="get" class="navbar-form navbar-right" action="" id="language_form">
        <div class="form-group">
            <select name="lang" id="" class="form-control" onchange="changeLanguage()" >
                <option value="en" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected";} ?> >English</option>
                <option value="cs" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'cs'){ echo "selected";} ?> >Simplified Chinese</option>
            </select>
        </div>
    </form>


<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1><?php echo _REGISTER;?></h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                    <h6 class="text-center"><?php echo $message;?></h6>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME;?>">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL;?>">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD;?>">
                        </div>

                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="<?php echo _REGISTER;?>">
                    </form>

                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>
<script>
    function changeLanguage(){
        document.getElementById("language_form").submit();
    }

</script>


<?php include "includes/footer.php";?>
