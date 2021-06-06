<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
<?php
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


    // the message
    // $msg = "First line of text\nSecond line of text";

    // use wordwrap() if lines are longer than 70 characters
    // $msg = wordwrap($msg,70);

    // send email
    // mail("ze.feng.wang@ocsbstudent.ca","My subject",$msg);


    // if(isset($_POST['submit'])){
    //     $to = "ze.feng.wang@ocsbstudent.ca";
    //     $subject = $_POST['subject'];
    //     $body = $_POST['body'];


    // }

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
                <h1>Contact</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">

                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your Subject">
                        </div>
                         <div class="form-group">
                            <textarea class="form-control" name="body" id="body" cols="50" rows="10"></textarea>
                        </div>

                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
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
