<?php
//Database helper functions
function query($query){
    global $connection;
    $result = mysqli_query($connection, $query);
    confirm($result);
    return $result;
}
function redirect($location){
    return header("Location: " . $location);
}
function fetchRecords($result){
    return mysqli_fetch_array($result);
}
function count_records($result){
    return mysqli_num_rows($result);
}

//End


//Authentication Helper
//Unecessary default value
function is_admin(){
    global $connection;
    if(isLoggedIn()){
        $result = query("SELECT user_role FROM users WHERE user_id = " . $_SESSION['user_id']."");
        $row = fetchRecords($result);
        return $row['user_role'] === 'admin';
    }
    return false;
}
//End

//General Helpers
function get_user_name(){
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}
//End

//User Specific Helpers
function get_all_user_posts(){
    //Inner join is joining tables by overlapping the matching values of posts.post_user and users.username
    return query("SELECT * FROM posts INNER JOIN users ON posts.post_user = users.username WHERE users.user_id=" . loggedInUserId() . "");
}

function get_all_posts_user_comments(){
    //Left join is joining tables side-by-side
    return query("SELECT * FROM posts INNER JOIN comments LEFT JOIN users ON posts.post_id=comments.comment_post_id WHERE users.user_id =" . loggedInUserId() . "");
}

function get_all_user_categories(){
    return query("SELECT * FROM posts INNER JOIN category ON posts.post_category_id=category.cat_id LEFT JOIN users ON posts.post_user=users.username WHERE users.user_id=" .loggedInUserId() ."");
}

function get_all_user_published_posts(){
    return query("SELECT * FROM posts INNER JOIN users ON posts.post_user = users.username WHERE users.user_id=" . loggedInUserId() . " AND posts.post_status='published'");
}
function get_all_user_draft_posts(){
    return query("SELECT * FROM posts INNER JOIN users ON posts.post_user = users.username WHERE users.user_id=" . loggedInUserId() . " AND posts.post_status='draft'");
}

function get_all_user_unapproved_comments(){
    return query("SELECT * FROM posts INNER JOIN comments LEFT JOIN users ON posts.post_id=comments.comment_post_id WHERE users.user_id =" . loggedInUserId() . " AND comments.comment_status='unapproved'");
}
function get_all_user_approved_comments(){
    return query("SELECT * FROM posts INNER JOIN comments LEFT JOIN users ON posts.post_id=comments.comment_post_id WHERE users.user_id =" . loggedInUserId() . " AND comments.comment_status='approved'");
}

//end
    function users_online() {
        if(isset($_GET['onlineusers'])) {
            global $connection;
            if(!$connection) {
                session_start();
                include "../includes/db.php";
                $session = session_id();
                $time = time();
                $time_out_in_seconds = 3;
                $time_out = $time - $time_out_in_seconds;
                $query = "SELECT * FROM users_online WHERE session = '$session'";
                $send_query = mysqli_query($connection, $query);
                $count = mysqli_num_rows($send_query);
                if($count == NULL) {
                    mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
                }
                else {
                    mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
                }
                $users_online_query =  mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
                echo mysqli_num_rows($users_online_query);
            }
        } // get request isset()
    }
    users_online();


    function escape($string){
        global $connection;
        return mysqli_real_escape_string($connection, trim($string));
    }

    function confirm($result){
        global $connection;
        if(!$result){
            die("QUERY FAILED " . mysqli_error($connection));
        }
    }
    function insert_categories(){
        global $connection;
        if(isset($_POST['submit'])){
            $cat_title = $_POST['cat_title'];
            if($cat_title == "" || empty($cat_title)){
                echo "this field should not be empty";
            }else{
                $stmt = mysqli_prepare($connection, "INSERT INTO category(cat_title) VALUE(?)");
                mysqli_stmt_bind_param($stmt, "s", $cat_title);
                mysqli_stmt_execute($stmt);
                if(!$stmt){
                    die('QUERY FAILED ' . mysqli_error($connection));
                }
                mysqli_stmt_close($stmt);

            }

        }
    }

    function findAllCategories(){
        global $connection;
        $query = "SELECT * FROM category";
        $select_categories = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_categories)){
        $cat_id =$row['cat_id'];
        $cat_title =$row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
        }
    }


    function deleteCategories(){
        global $connection;
        if(isset($_GET['delete'])){
            $the_cat_id = $_GET['delete'];
            $query = "DELETE FROM category WHERE cat_id = {$the_cat_id} ";
            $delete_query = mysqli_query($connection, $query);
            header("Location: categories.php");
        }
    }

function recordCount($table){
    global $connection;
    $select_all_post = query("SELECT * FROM " . $table . "");
    confirm($select_all_post);
    return mysqli_num_rows($select_all_post);

}

function checkStatus($table, $column, $status){
    global $connection;
    $query = "SELECT * FROM $table WHERE $column = '$status' ";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);
}

function checkUserRole($table, $column, $role){
    global $connection;
    $query = "SELECT * FROM $table WHERE $column = '$role' ";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);

}


function username_exists($username){
    global $connection;
    $query = "SELECT username FROM users WHERE username ='$username' ";
    $result = mysqli_query($connection, $query);
    confirm($result);
    return mysqli_num_rows($result) > 0;
}
function email_exists($email){
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email ='$email' ";
    $result = mysqli_query($connection, $query);
    confirm($result);
    return mysqli_num_rows($result) > 0;
}
function register_user($username, $email, $password){
    global $connection;
    // if(username_exists($username)){
    //     $message = "User Already Exists";
    // }elseif(email_exists($email)){
    //     $message = "Email Already Exists";
    // }else{
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
}

function login_user($username, $password){
    global $connection;

    $username = trim(mysqli_real_escape_string($connection, $username));
    $password = trim(mysqli_real_escape_string($connection, $password));
    //Prevent SQL Injection
    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    if(!$select_user_query){
        die("QUERY FAILED" . mysqli_error($connection));
    }
    while($row = mysqli_fetch_array($select_user_query)){
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];

        if(password_verify($password, $db_user_password)){
            $_SESSION['user_id'] = $db_user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
            redirect("/cms/admin");
        }else{
            return false;
        }
    }
    return true;
    // $password = crypt($password, $db_user_password);
}
function ifItIsMethod($method=null){
    return $_SERVER['REQUEST_METHOD'] == strtoupper($method);
}

function currentUser(){
    return isset($_SESSION['username']) ? $_SESSION['username'] : false;
}

function isLoggedIn(){
    return isset($_SESSION['user_role']);
}

function imagePlaceholder($image=''){
    return !$image ? "IMG_20210227_112407.jpg" : $image;
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
}

function loggedInUserId(){
    if(isLoggedIn()){
        $result = query("SELECT * FROM users WHERE username='". $_SESSION['username'] . "'");
        confirm($result);
        $users = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? $users['user_id'] : false;
    }
    return false;
}

function userLiked($post_id = ''){
    $result = query("SELECT * FROM likes WHERE user_id=" . loggedInUserId() . " AND post_id={$post_id}");
    return mysqli_num_rows($result) >= 1;
}

function getPostLikes($post_id){
    $result = query("SELECT * FROM likes WHERE post_id=$post_id");
    confirm($result);
    echo mysqli_num_rows($result);
}

?>