<?php
$dsn = "sqlite:blog.sqlite";
$db = new PDO($dsn);
$postsSQL = "SELECT * FROM post";

if(isset($_GET["findText"])){
    $find = htmlentities($_GET["findText"]);
    $postsSQL .= " WHERE title like '%$find%'";
}

if(isset($_GET["categoryId"])){
    $categoryId = $_GET["categoryId"];
    $postsSQL .= " WHERE categoryId = '$categoryId'";
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

    <title>Blog Home - PHP with SQLite</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/blog-home.css" rel="stylesheet">

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

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                foreach ($db->query($postsSQL) as $row){
                    $postTitle = $row["title"];
                    $postDate = $row["datePost"];
                    $picturePath = $row["picture"];
                    $preview = $row["shortText"];
                    $postId = $row["id"];
                    
                    echo "<h2><a href='post.php?id=$postId'>$postTitle</a></h2>";
                    echo "<p><span class='glyphicon glyphicon-time'></span> Posted on $postDate</p><hr>";
                    echo "<img class='img-responsive' src='$picturePath' alt=''><hr>";
                    echo "<p>$preview</p>";
                    echo "<a class='btn btn-primary' href='post.php?id=$postId'>Read More <span 
                          class='glyphicon glyphicon-chevron-right'></span></a>";
                }
                ?>

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <script>
                    function find() {
                        var findText = document.getElementById("findText").value;
                        window.location.href = 'index.php?findText=' + findText;
                    }
                </script>

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input id="findText" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="find()">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                <?php
                                $sql = "SELECT * FROM category";
                                foreach ($db->query($sql) as $row){
                                    $id = $row['id'];
                                    $name = $row['name'];

                                    echo "<li><a href='index.php?categoryId=$id'>$name</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>

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
                <!-- /.col-lg-12 -->
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
