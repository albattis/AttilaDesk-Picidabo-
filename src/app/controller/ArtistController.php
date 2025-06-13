<?php

namespace app\controller;

use app\model\Artist;

class ArtistController extends MainController
{

    protected $controllerName = 'artist';


    /**
     * Kilistázza az előadókat.
     * @return string
     */
    public function actionIndex()
    {
        $artists = Artist::findAll();

        $this->title = 'Albums';

        return $this->render('index', [
            'artists' => $artists,

        ]);
    }


    /**
     * A megadott $id alapján kiválasztott előadó atatait jeleníti meg.
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $artist = Artist::findOneById($id);

        return $this->render('view', [
            'artist' => $artist,
        ]);
    }

    public function actionCreate()
    {
        $artist = new Artist();

        $this->title = 'Új előadó';



        if (isset($_POST['artist'])) {
            
            $artist->load($_POST['artist']);
            $error = false;
            if (!$artist->insert()) {
                $error = true;
            }

            

            if(isset($_GET['js']) && $_GET['js'] == 'true')
            {
                if(!$error)
                {
                    echo json_encode([
                        "success" => !$error,
                        "data" => [
                            "id" => $artist->getId(),
                            "name" => $artist->getName()
                        ]
                    ]);
                    exit();
                }
                else {
                    echo json_encode([
                        "success" => $error,
                        "data" => [ ]
                    ]);
                    exit();
                }
                
            }
            else {
                if(!$error)
                {
                    header("Location: index.php?controller=album&action=view&id={$artist->getId()}&create=success");
                    exit();
                }
                
            }
            
        }

        return $this->render('create', [
            'artist' => $artist,
        ]);
    }
}