<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Buenos_Aires');

include_once './classes/Post.php';
include_once './classes/Manage_Posts.php';



$manage = new Manage_Posts();

while (TRUE) {

    echo "TRAIGO POSTS:\n";
    $posts = $manage->getPosts();

    if (empty($posts)) {
        echo "No hay publicaciones \n\n";
    }

    foreach ($posts as $post) {
        echo $post->fecha_publicacion . "\n";
        if ($post->isPostToPublish()) {
            echo "publicoo \n\n";
            $manage->publishPost($post);
        }
    }
    echo "=================\n\n";
    sleep(30);
}


 



