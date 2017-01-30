<?php


try{
    $dsn = "sqlite:blog.sqlite";
    $db = new PDO($dsn);

    echo "Подключение успешно";
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $createCategory = "CREATE TABLE category
                        (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        name VARCHAR (100) NOT NULL                        
                        )";

    $createAuthor = "CREATE TABLE author 
                      (
                      id INTEGER PRIMARY KEY AUTOINCREMENT,
                      login VARCHAR (50) NOT NULL,
                      pass VARCHAR (50) NOT NULL
                      )";

    $createPost = "CREATE TABLE post
                    (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title TEXT NOT NULL,
                    shortText TEXT,
                    textPost TEXT,
                    picture VARCHAR (200),
                    authorId INTEGER NOT NULL,
                    categoryId INTEGER NOT NULL,
                    datePost TEXT
                    )";

    $createComment = "CREATE TABLE comment
                      (
                      id INTEGER PRIMARY KEY AUTOINCREMENT,
                      postId INTEGER NOT NULL,
                      authorId INTEGER NOT NULL,
                      mainCommentId INTEGER,
                      textComment TEXT,
                      datePost TEXT
                      )";

     $db->exec($createCategory);
     $db->exec($createAuthor);
     $db->exec($createPost);
     $db->exec($createComment);

     $addCategory = ["PHP", ".NET", "C++", "HTML"];

     foreach ($addCategory as $value){
        $sql = "INSERT INTO category(name) VALUES ('$value')";
        $db->exec($sql);
    } 

    $addAuthor = [["admin", "123"], ["user", "123"], ["guest", ""]];

    foreach ($addAuthor as $value){
        $sql = "INSERT INTO author(login,pass) VALUES ('$value[0]', '$value[1]')";
        $db->exec($sql);
    }

    

}
catch (Exception $ex){
    echo $ex->getMessage();
}