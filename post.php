<?php
$dsn = "sqlite:blog.sqlite";
$db = new PDO($dsn);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$postTitle = '';
$postDate = '';
$picturePath = '';
$postText = '';
$postPreview = '';
$postId = '';


if(isset($_GET['id'])) {
    $postId = $_GET['id'];
}
if(isset($_GET['newComment'])) {

    $cText = htmlentities($_GET['newComment']);
    $dateC = date("Y-m-d H:i:s");
    $sql = $db->prepare("INSERT INTO comment(postId, authorId, textComment, datePost) VALUES ('$postId', '3', :cText, '$dateC')");

    $sql->execute(['cText'=>"$cText"]);
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

    <title>Blog Post - Start Bootstrap Template</title>

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

    <?php



    $postsSQL = "SELECT * FROM post WHERE id = '$postId'";
    foreach ($db->query($postsSQL) as $row) {

        $postTitle = $row["title"];
        $postDate = $row["datePost"];
        $picturePath = $row["picture"];
        $postText = $row["textPost"];
        $postPreview = $row["shortText"];

    }

    ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?php echo "$postTitle" ?></h1>

                <!-- Author -->

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo "$postDate" ?></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="<?php echo "$picturePath" ?>" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead"><?php echo "$postPreview" ?></p>
                <p><?php echo "$postText" ?></p>

                <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form">
                        <div class="form-group">
                            <textarea name="newComment" class="form-control" rows="3"></textarea>
                            <input type="text", value="<?php echo "$postId" ?>", name="id" hidden>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php
                $sql = "SELECT * FROM comment WHERE postId = '$postId'";

                foreach ($db->query($sql) as $row){
                    $pDate = $row["datePost"];
                    $pText = $row["textComment"];

                    echo "<div class='media'>";
                    echo "<a class='pull-left'>";
                    echo "<img class='media-object' src='guest.png' alt=''style='width: 64px; height: 64px;'>";
                    echo "</a><div class='media-body'>";
                    echo "<h4 class='media-heading'>Guest";
                    echo "<small>$pDate</small></h4>$pText";
                    echo "</div></div>";
                }
                ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">



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


