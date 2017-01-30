<?php

$dsn = "sqlite:blog.sqlite";
$db = new PDO($dsn);
$sql = "SELECT * FROM author WHERE login = 'admin'";
$pass;

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

foreach ($db->query($sql) as $row){
    $pass = $row['pass'];
}

if(isset($_POST["login"]) && isset($_POST["pass"])){
    if($_POST["login"] == "admin"){
        if($pass == $_POST["pass"]){
            setcookie("admin", 'true');
            $adminSignIn = true;
        }
    }
}

if(isset($_POST["title"]) && isset($_POST["content"]) && isset($_POST["preview"]) && isset($_POST["category"])){

    $title = htmlentities($_POST["title"]);
    $shortText = htmlentities($_POST["preview"]);
    $textPost = htmlentities($_POST["content"]);
    $dest = "pictures/no-image-available.jpg";
    $authorId = 1;
    $categoryId = $_POST["category"];
    $datePost = date("Y-m-d H:i:s");

    if(!empty($_FILES)){
        if(isset($_FILES['picture'])){
            if($_FILES['picture']['error'] == UPLOAD_ERR_OK){
                $src = $_FILES['picture']['tmp_name'];
                $fname = $_FILES['picture']['name'];
                $dest = "pictures/$fname";
                move_uploaded_file($src, $dest);
            }
        }
    }

    $sql = "INSERT INTO post(title, shortText, textPost, picture, authorId, categoryId, datePost)".
    "VALUES (:title, :shortText, :textPost, '$dest', '$authorId', '$categoryId', '$datePost')";

    $goodSQL = $db->prepare($sql);
    $goodSQL->bindParam(':title', $title);
    $goodSQL->bindParam(':shortText', $shortText);
    $goodSQL->bindParam(':textPost', $textPost);

    $goodSQL->execute();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add new Post</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/blog-post.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Home page</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Post Content Column -->
        <div class="col-lg-12">

            <?php
            if(isset($adminSignIn) || isset($_COOKIE["admin"]))
            {
                $sql = "SELECT * FROM category";
            ?>

            <!-- Blog Post -->

            <!-- Title -->
            <h1>Add new Post</h1>

            <hr>

            <!-- Blog Comments -->

            <!-- Comments Form -->
            <div class="well">

                <form method="post" enctype="multipart/form-data">
                    <h4>Post picture:</h4>
                    <div class="form-group">
                        <input type="file" class="form-control" name="picture">
                    </div>

                    <h4>Post category:</h4>
                    <div class="input-group">
                        <?php
                        foreach ($db->query($sql) as $row){
                        echo '<span class="input-group-addon">';
                            echo "<input name='category' type='radio' value=".$row['id'].">";
                        echo "</span>";
                            echo "<h5>".$row['name']."</h5>";
                        }
                        ?>

                    </div><!-- /input-group -->

                    <h4>Post title:</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" name="title">
                    </div>
                    <h4>Post content</h4>
                    <div class="form-group">
                        <textarea class="form-control" rows="10" name="content"></textarea>
                    </div>
                    <h4>Post preview</h4>
                    <div class="form-group">
                        <textarea class="form-control" rows="4" name="preview"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->

            <?php }?>


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-12">

            <?php
            if(!isset($adminSignIn) && !isset($_COOKIE["admin"]))
            {
            ?>

            <!-- Blog Search Well -->
            <div class="well">
                <h4>Sign in</h4>
                <div class="input-group">
                    <form method="post">
                        <span>Login (admin)</span>
                        <input name="login" type="text" class="form-control"><br>
                        Password (123)
                        <input name="pass" type="password" class="form-control"><br>
                        <button type="submit" class="btn btn-primary">Sign in</button>
                    </form>
                </div>
                <!-- /.input-group -->
            </div>

            <?php } ?>

        </div>

    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; Your Website 2014</p>
            </div>
        </div>
        <!-- /.row -->
    </footer>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
