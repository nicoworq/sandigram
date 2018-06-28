<?php

date_default_timezone_set('America/Buenos_Aires');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");
error_log("Loading Sandigrameee");



include_once 'classes/Post.php';
include_once 'classes/Manage_Posts.php';

$manage = new Manage_Posts();

while (TRUE) {

    $manage->updateServiceLastSeen();

    echo "\n\nTRAIGO POSTS:\n\n";
    $posts = $manage->getPosts();

    if (empty($posts)) {
        echo "No hay publicaciones \n\n";
    }
    foreach ($posts as $post) {

        echo $post->user . " |  ";
        echo $post->fecha_publicacion . " | ";
        if ($post->isPostToPublish()) {
            echo "publicoo \n\n";
            $manage->publishPost($post);
        } else {
            $post->showPostMinutesToPublish();

            if ($post->isWeekend()) {
                echo " post programado para el finde";
            }
        }
        echo "\n\n";
    }

    $postError = $manage->getPostsWithError();

    if (count($postError)) {
        echo "Hay publicaciones con error!!! \n\n";
    }

    foreach ($postError as $post) {
        echo $post->user . " |  ";
        echo $post->fecha_publicacion . " | ";
        echo "\n\n";
    }

    echo "=================\n\n";
    sleep(300);
}


 



