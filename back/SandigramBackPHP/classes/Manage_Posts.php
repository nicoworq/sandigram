<?php

include_once 'Database.php';
include_once 'Errores.php';

class Manage_Posts {

    public function getPosts() {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();

        $sql_posts = "SELECT p.id, id_estado,id_tipo, p.nombre, texto, pregunta, respuesta_1, respuesta_2, pos_x, pos_y, fecha_publicacion, nombre_archivo,ruta_completa,es_imagen,user,password "
                . "FROM sandigram.publicaciones p "
                . "LEFT JOIN medios m ON m.id = p.id_medio "
                . "LEFT JOIN cuentas c on p.id_cuenta = c.id "
                . "WHERE p.id_estado = 1 ;";
        $result = $mysqli->query($sql_posts);
        $posts = array();

        if ($result) {
            while ($post = $result->fetch_object("Post")) {
                $posts[] = $post;
            }
        }
        return $posts;
    }
    
    public function getPostsWithError() {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();

        $sql_posts = "SELECT p.id, id_estado,id_tipo, p.nombre, texto, pregunta, respuesta_1, respuesta_2, pos_x, pos_y, fecha_publicacion, nombre_archivo,ruta_completa,es_imagen,user,password "
                . "FROM sandigram.publicaciones p "
                . "LEFT JOIN medios m ON m.id = p.id_medio "
                . "LEFT JOIN cuentas c on p.id_cuenta = c.id "
                . "WHERE p.id_estado = 3 ;";
        $result = $mysqli->query($sql_posts);
        $posts = array();

        if ($result) {
            while ($post = $result->fetch_object("Post")) {
                $posts[] = $post;
            }
        }
        return $posts;
    }

    public function updateServiceLastSeen() {
        echo "Actualizo Last seen.. \n\n";

        $db = Database::getInstance();
        $mysqli = $db->getConnection();

        $sql = "UPDATE servicio_back SET ultima_vez_visto = NOW() WHERE id = 1;";
        $result = $mysqli->query($sql);

        if ($result) {
            if ($mysqli->affected_rows) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function publishPost($post) {

        require 'vendor/autoload.php';

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
            $media = $this->prepareMedia($post);

            switch (intval($post->id_tipo)) {
                case 1:
                    echo "Es timeline \n\n";
                    $this->postTimeline($ig, $media, $post);
                    break;
                case 2:
                    echo "Es story \n\n";
                    $this->postStory($ig, $media, $post);
                    break;
                case 3:
                    echo "Es poll \n\n";
                    $this->postPoll($ig, $media, $post);
                    break;
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

    function postTimeline($ig, $media, $post) {
        if ($post->es_imagen) {
            var_dump($ig->timeline->uploadPhoto($media->getFile(), ['caption' => $post->getPostText()]));
        } else {
            var_dump($ig->timeline->uploadVideo($media->getFile(), ['caption' => $post->getPostText()]));
        }
    }

    function postStory($ig, $media, $post) {
        if ($post->es_imagen) {
            var_dump($ig->story->uploadPhoto($media->getFile()));
        } else {
            var_dump($ig->story->uploadVideo($media->getFile()));
        }
    }

    function postPoll($ig, $media, $post) {

        $metadata = [
            'story_polls' => [
                // Note that you can only do one story poll in this array.
                [
                    'question' => $post->pregunta, // Story poll question. You need to manually to draw it on top of your image.
                    'viewer_vote' => 0, // Don't change this value.
                    'viewer_can_vote' => true, // Don't change this value.
                    'tallies' => [
                        [
                            'text' => $post->respuesta_1, // Answer 1.
                            'count' => 0, // Don't change this value.
                            'font_size' => 24.5, // Range: 17.5 - 35.0.
                        ],
                        [
                            'text' => $post->respuesta_2, // Answer 2.
                            'count' => 0, // Don't change this value.
                            'font_size' => 24.5, // Range: 17.5 - 35.0.
                        ],
                    ],
                    'x' => doubleval($post->pos_x), // Range: 0.0 - 1.0. Note that x = 0.5 and y = 0.5 is center of screen.
                    'y' => doubleval($post->pos_y), // Also note that X/Y is setting the position of the CENTER of the clickable area.
                    'width' => 0.5661107, // Clickable area size, as percentage of image size: 0.0 - 1.0
                    'height' => 0.10647108, // ...
                    'rotation' => 0.0,
                    'is_sticker' => true, // Don't change this value.
                ],
            ],
        ];

        var_dump($ig->story->uploadPhoto($media->getFile(), $metadata));
    }

    public function prepareMedia($post) {

        $params = array();
        if (intval($post->id_tipo) !== 1) {
            $params = ['targetFeed' => \InstagramAPI\Constants::FEED_STORY];
        }

        if ($post->es_imagen) {
            //es foto
            echo "El post es imagen... \n\n";
            $media = new \InstagramAPI\Media\Photo\InstagramPhoto($post->ruta_completa, $params);
        } else {
            //es video
            echo "El post es video... \n\n";
            $media = new \InstagramAPI\Media\Video\InstagramVideo($post->ruta_completa, $params);
        }

        return $media;
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
