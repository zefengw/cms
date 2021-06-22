
<?php include "includes/admin_header.php";
    include "../includes/db.php"; //dot dot operator means another folder
    if(!is_admin()){
        header("Location: index.php");
    }
?>
<body>
    <div id="wrapper">

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
                        <div class="col-xs-6">
                                <?php
                                    insert_categories();
                                ?>

                            <form action="" method="post">
                                <div class="form-group">
                                <label for="cat-title">Add Category</label>
                                    <input class="form-control" type="text" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                                </div>

                            </form>
                                    <?php //Update and Include Query
                                        if(isset($_GET['edit'])){
                                            $cat_id = $_GET['edit'];
                                            include "includes/update_categories.php";
                                        }

                                    ?>

                        </div>
                        <div class="col-xs-6">

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php //Find All Categories Query
                                        findAllCategories();
                            ?>
                            <?php //Delete Query
                                deleteCategories();
                            ?>
                                </tbody>
                            </table>


                        </div>



                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include "includes/admin_footer.php";?>