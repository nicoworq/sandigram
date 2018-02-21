<?php

include_once 'Database.php';
include_once 'Errores.php';

class Manage_Posts {

    public function getPosts() {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();

        $sql_posts = "SELECT p.id, id_estado,id_tipo, p.nombre, texto, fecha_publicacion, nombre_archivo,ruta_completa,es_imagen,user,password "
                . "FROM sandigram.publicaciones p "
                . "LEFT JOIN medios m ON m.id = p.id_medio "
                . "LEFT JOIN cuentas c on p.id_cuenta = c.id "
                . "WHERE p.id_estado = 1 AND p.id_cuenta = 14;";
        $result = $mysqli->query($sql_posts);
        $posts = array();

        if ($result) {
            while ($post = $result->fetch_object("Post")) {
                $posts[] = $post;
            }
        }
        return $posts;
    }

    public function publishPost($post) {

        require_once 'vendor/autoload.php';

        \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;

        $ig = new \InstagramAPI\Instagram();

        $Errores = new Errores();

        try {
            echo "Iniciando sesion... \n\n";
            $ig->login($post->user, $post->password);
        } catch (\Exception $e) {
            $Errores->logError($post->id, FALSE, "Error al loguear || " . $e->getMessage());
            echo 'Error al loguear: ' . $e->getMessage() . "\n";
            exit(0);
        }
        try {
            echo "Publicando post... \n\n";


            if ($post->es_imagen) {

                //post es imagen
                echo "El post es imagen... \n\n";
                if (intval($post->id_tipo) === 1) {

                    //es tipo timeline
                    echo "El post es timeline... \n\n";
                    $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($post->ruta_completa);
                    var_dump($ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $post->getPostText()]));
                } else {

                    //es tipo story
                    echo "El post es story... \n\n";
                    $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($post->ruta_completa, ['targetFeed' => \InstagramAPI\Constants::FEED_STORY]);

                    $metadata = [
                        'story_polls' => [
                            // Note that you can only do one story poll in this array.
                            [
                                'question' => 'Is this API great?', // Story poll question. You need to manually to draw it on top of your image.
                                'viewer_vote' => 0, // Don't change this value.
                                'viewer_can_vote' => true, // Don't change this value.
                                'tallies' => [
                                    [
                                        'text' => 'Best API!', // Answer 1.
                                        'count' => 0, // Don't change this value.
                                        'font_size' => 35.0, // Range: 17.5 - 35.0.
                                    ],
                                    [
                                        'text' => 'The doubt offends', // Answer 2.
                                        'count' => 0, // Don't change this value.
                                        'font_size' => 27.5, // Range: 17.5 - 35.0.
                                    ],
                                ],
                                'x' => 0.5, // Range: 0.0 - 1.0. Note that x = 0.5 and y = 0.5 is center of screen.
                                'y' => 0.5, // Also note that X/Y is setting the position of the CENTER of the clickable area.
                                'width' => 0.5661107, // Clickable area size, as percentage of image size: 0.0 - 1.0
                                'height' => 0.10647108, // ...
                                'rotation' => 0.0,
                                'is_sticker' => true, // Don't change this value.
                            ],
                        ],
                    ];

                    var_dump($ig->story->uploadPhoto($photo->getFile(), $metadata));
                }
            } else {

                //post es video                
                echo "El post es video... \n\n";

                if (intval($post->id_tipo) === 1) {

                    //es tipo timeline
                    echo "El post es timeline... \n\n";
                    $video = new \InstagramAPI\Media\Video\InstagramVideo($post->ruta_completa);
                    var_dump($ig->timeline->uploadVideo($video->getFile(), ['caption' => $post->getPostText()]));
                } else {
                    //es tipo story

                    $video = new \InstagramAPI\Media\Video\InstagramVideo($post->ruta_completa, ['targetFeed' => \InstagramAPI\Constants::FEED_STORY]);

                    var_dump($ig->story->uploadVideo($video->getFile(), ['caption' => $post->getPostText()]));
                }
            }

            $this->updatePostStatus($post, 2);
        } catch (\Exception $e) {
            echo "Error al publicar \n\n";

            $Errores->logError($post->id, FALSE, "Error al publicar || " . $e->getMessage());

            $this->updatePostStatus($post, 3);

            echo 'Error al publicar: ' . $e->getMessage() . "\n";

            exit(0);
        }
    }

    public function updatePostStatus($post, $status) {
        echo "Actualizo estado post \n";
        $db = Database::getInstance();
        $mysqli = $db->getConnection();

        $sqlUpdate = "UPDATE publicaciones SET id_estado = {$status} WHERE id = {$post->id };";
        $result = $mysqli->query($sqlUpdate);

        if ($result) {
            if ($mysqli->affected_rows) {
                return TRUE;
            }
        }
        return FALSE;
    }

}
