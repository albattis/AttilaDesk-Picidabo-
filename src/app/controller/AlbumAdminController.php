<?php

namespace app\controller;

use app\model\Album;
use app\model\Artist;
use app\model\User;
use helper\Alert;
use helper\Redirect;

class AlbumAdminController extends MainController
{

    protected $controllerName = 'album_admin';


    /**
     * Albumok listázása
     * @return string
     */
    public function actionIndex()
    {
        if(!User::currentUserCan('list.album'))
        {
            //header("HTTP/1.1 403 Forbidden");
            header("Location: index.php?controller=error&action=403");
            exit();
        }
        $albums = Album::findAll();

        $this->title = 'Albums';

        return $this->render('index', [
            'albums' => $albums,
            "user" => $user = User::getCurrentUser(),
        ]);
    }

    /**
     * A megadott $id alapján megkeresi az albumot és kilistázza az adatait
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        if(!is_numeric($id)  || $id < 1)
        {
            header("Location: index.php?controller=site&action=404");
            exit();
        }

        $album = Album::findOneById($id);

        if (!($album))
        {
            header("Location: index.php?controller=site&action=404");
            exit();
        }
        $tracks = $album->getTracks();
        $artist = $album->getArtist();

        $this->title = $artist->getName() . ' - ' . $album->getTitle();

        return $this->render('view', [
            'album' => $album,
            'tracks' => $tracks,
            'artist' => $artist,
        ]);
    }

    public function actionDelete($id)
    {
        $album = Album::findOneById($id);

        if (!($album))
        {
            header("Location: index.php?controller=site&action=404");
            exit();
        }


        if ($album->delete()) {
            header("Location: index.php?controller=albumAdmin&action=index&delete=success");
        } else {
            header("Location: index.php?controller=albumAdmin&action=index&delete=error");
        }
        exit();
    }

    /**
     * Új album létrehozása
     * @return string
     */
    public function actionCreate()
    {
        $this->title = 'Új album létrehozása';

        $artists = Artist::findAll();

        $album = new Album();

        $this->js[]="albumadmin.js";

        

        if (isset($_POST['album'])) {
            $album->load($_POST['album']);
            if ($album->insert()) {
                header("Location: index.php?controller=album&action=view&id={$album->getId()}&create=success");
                exit();
            }
        }

        return $this->render('create', [
            'album' => $album,
            'artists' => $artists,
            'tracks' => [],
        ]);
    }

    public function actionUpdate($id)
    {
        Redirect::withMessage(
            !User::currentUserCan('update.album'),
            "warning",
            "Az oldal eléréséhez be kell jelentkezni.",
            "index.php?controller=user&action=login"
        );

        $album = Album::findOneById($id);

        if (!$album) {
            Redirect::go("Location: index.php?controller=album&action=index");
        }

        $this->title = 'Album módosítása: ' . $album->getTitle();

        $artists = Artist::findAll();

        if (isset($_POST['album'])) {
            $album->load($_POST['album']);
            if ($album->update()) {
                Alert::addMessage("success","Album sikeresen módosítva.");
                Redirect::go("index.php?controller=albumAdmin&action=index");
            }
        }

        return $this->render('update', [
            'album' => $album,
            'artists' => $artists,
            'tracks' => $album->getTracks(),
        ]);
    }
}