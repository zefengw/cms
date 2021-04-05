
<?php include "includes/admin_header.php";?>
<body>
    <div id="wrapper">
    <?php
        $session = session_id(); //catches all session tabs
        $time = time();
        $time_out_in_seconds = 60;
        $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session' ";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);

        if($count == NULL){
            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
        }else{
            mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
        }
        $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
        $count_user = mysqli_num_rows($users_online_query);


    ?>

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php";?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small><?php echo $_SESSION['username'];?></small>
                        </h1>
                        <h1>
                            <?php echo $count_user;?>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->



                <!-- /.row -->

<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                            $query = "SELECT * FROM posts";
                            $select_all_post = mysqli_query($connection, $query);
                            $post_counts = mysqli_num_rows($select_all_post);
                            echo "<div class='huge'>{$post_counts}</div>";
                        ?>


                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <?php
                            $query = "SELECT * FROM comments";
                            $select_all_comment = mysqli_query($connection, $query);
                            $comment_counts = mysqli_num_rows($select_all_comment);
                            echo "<div class='huge'>{$comment_counts}</div>";
                        ?>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <?php
                            $query = "SELECT * FROM users";
                            $select_all_user = mysqli_query($connection, $query);
                            $user_counts = mysqli_num_rows($select_all_user);
                            echo "<div class='huge'>{$user_counts}</div>";
                        ?>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <?php
                            $query = "SELECT * FROM category";
                            $select_all_category = mysqli_query($connection, $query);
                            $category_counts = mysqli_num_rows($select_all_category);
                            echo "<div class='huge'>{$category_counts}</div>";
                        ?>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
                <!-- /.row -->
                <?php
                    $query = "SELECT * FROM posts WHERE post_status = 'published' ";
                    $select_all_published_posts = mysqli_query($connection, $query);
                    $post_published_count = mysqli_num_rows($select_all_published_posts);

                    $query = "SELECT * FROM posts WHERE post_status = 'draft' ";
                    $select_all_draft_posts = mysqli_query($connection, $query);
                    $post_draft_count = mysqli_num_rows($select_all_draft_posts);

                    $query = "SELECT * FROM comments WHERE comment_status = 'unapproved' ";
                    $unapproved_comments_query = mysqli_query($connection, $query);
                    $unapproved_comments_count = mysqli_num_rows($unapproved_comments_query);

                    $query = "SELECT * FROM users WHERE user_role = 'subscriber' ";
                    $select_all_subscribers = mysqli_query($connection, $query);
                    $subscriber_count = mysqli_num_rows($select_all_subscribers);
                ?>
            <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['Data', 'Count'],
                        <?php
                            $elements_text = ['All Posts','Active Posts', 'Draft Posts', 'Comments','Pending Comments', 'Users', 'Subscribers', 'Categories'];
                            $elements_count = [$post_counts, $post_published_count, $post_draft_count, $comment_counts, $unapproved_comments_count, $user_counts, $subscriber_count, $category_counts];
                            for($i = 0; $i < count($elements_text); $i++){
                                echo "['{$elements_text[$i]}'" . "," . "{$elements_count[$i]}],";
                            }
                        ?>
                        // ['Posts', 1000],
                        ]);

                        var options = {
                        chart: {
                            title: '',
                            subtitle: '',
                        }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>
                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>

            </div>
        </div>
            <!-- /.container-fluid -->

    </div>
        <!-- /#page-wrapper -->
<?php include "includes/admin_footer.php";?>