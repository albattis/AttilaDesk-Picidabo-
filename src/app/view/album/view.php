<?php use app\model\Album;
use app\model\Artist;
use app\model\Track;

?>
<?php ?>
<?php ?>

<?php /** @var $album Album */ ?>
<?php /** @var $artist Artist */ ?>
<?php /** @var $tracks Track[] */ ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="my-2">
                <?= $artist->getName(); ?> -
                <?= $album->getTitle(); ?>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">

            <img src="<?= $album->getKep() ?>" alt="<?= $album->getTitle(); ?> cover"
                 class="img-thumbnail mb-3">

            <div class="my-3">
                <ul>
                    <li>
                        <b>Released</b>: <?= $album->getReleased() ?>

                    </li>

                    <li>
                        <b>Genre</b>: <?= $album->getGenre() ?>
                    </li>

                    <li>
                        <b>Total certified copies</b>: <br> <?= $album->getTcc() ?> millions
                    </li>

                    <li>
                        <b>Sales</b>: <?= $album->getSales() ?> millions
                    </li>

                </ul>
            </div>

        </div>

        <div class="col-md-9">
            <?php if (count($tracks) > 0) : ?>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Length</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($tracks as $track) : ?>
                        <tr>
                            <td><?= $track->getNo(); ?></td>
                            <td><?= $track->getTitle(); ?></td>
                            <td><?= $track->getLength(); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert alert-warning" role="alert">
                    Sajnos a keresett album számai még nincsenek feltöltve.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>