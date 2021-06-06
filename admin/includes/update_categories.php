                            <form action="" method="post">
                                <div class="form-group">
                                <label for="cat-title">Edit Category</label>

                                <?php

                                if(isset($_GET['edit'])){
                                    $cat_id = $_GET['edit'];

                                    $query = "SELECT * FROM category WHERE cat_id = $cat_id ";
                                    $edit_categories = mysqli_query($connection, $query);

                                    while($row = mysqli_fetch_assoc($edit_categories)){
                                    $cat_id =$row['cat_id'];
                                    $cat_title =$row['cat_title'];
                                     ?>

                                    <input value="<?php if(isset($cat_title)){echo $cat_title;}?>" class="form-control" type="text" name="cat_title">

                                   <?php
                                   }
                                }
                                ?>
                                <?php //Update Query

                                if(isset($_POST['update'])){
                                    $the_cat_title = $_POST['cat_title'];
                                    $stmt = mysqli_prepare($connection, "UPDATE category SET cat_title = ? WHERE cat_id = ? ");
                                    mysqli_stmt_bind_param($stmt, "si", $the_cat_title, $cat_id);
                                    mysqli_stmt_execute($stmt);
                                    if(!$stmt){
                                        die("QUERY FAILED " . mysqli_error($connection));
                                    }
                                    redirect("categories.php");
                                }
                                mysqli_stmt_close($stmt);
                                ?>

                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="update" value="Update">
                                </div>

                            </form>