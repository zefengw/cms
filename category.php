<?php
    include "includes/db.php";
    include "includes/header.php";

?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php
            #statements and post requests make your website more secure
            if(isset($_GET['category'])){
                $post_category_id = $_GET['category'];
                if(is_admin($_SESSION['username'])){
                    #Preparing the two statements and assign them to their variable
                    $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");

                }else{
                    $stmt2 = mysqli_prepare($connection,"SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?");
                    $published = 'published';
                }
                if(isset($stmt1)){
                    #Bind statement and variable, "i" stands for integer and is the type we are receiving
                    mysqli_stmt_bind_param($stmt1, "i", $post_category_id);
                    #Executes it
                    mysqli_stmt_execute($stmt1);
                    #Binds the result of execution to the variables that retrieve
                    mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    #stores the result in the statement before assigning it to the finished statement
                    mysqli_stmt_store_result($stmt1);
                    $stmt = $stmt1;
                }else if (isset($stmt2)){
                    #Integer then string
                    #only takes variable, so we define $published instead of directly passing it in as a string
                    mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    mysqli_stmt_store_result($stmt2);
                    $stmt = $stmt2;
                }

                if(mysqli_stmt_num_rows($stmt) === 0){
                   echo "<h1 class='text-center'>No Available Categories</h1>";
                }
                  while(mysqli_stmt_fetch($stmt)):


                    ?>
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="/cms/post/<?php echo $post_id;?>"><?php echo $post_title?></a>
                </h2>
                <p class="lead">
                    by <a href="/cms/index"><?php echo $post_author?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date?></p>
                <hr>
                <a href="/cms/post/<?php echo $post_id?>"><img class="img-responsive" src="images/<?php echo imagePlaceholder($post_image);?>" alt=""></a>
                <hr>
                <p><?php echo $post_content?></p>
                <a class="btn btn-primary" href="/cms/post/<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                <?php
                   endwhile;
                   mysqli_stmt_close($stmt);

            }else{
                header("Location: index.php");
                } ?>



            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

    <?php include "includes/footer.php"; ?>
