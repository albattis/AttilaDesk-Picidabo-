<?php


namespace app\controller;


use app\model\Album;

class AlbumController extends MainController
{
    protected $controllerName = 'album';

    public function actionIndex()
    {
        $albums = Album::findAll();

        return $this->render('index',[
            "albums" => $albums
        ]);
    }

    public function actionView($id)
    {

        $album = Album::findOneById($id);

        $artist = $album->getArtist();


        $this->title = $artist->getName() ." ". $album->getTitle();

        return $this->render('view',[
            "album" => $album,
            "artist" => $artist,
            "tracks" => $album->getTracks(),
        ]);

    }
}