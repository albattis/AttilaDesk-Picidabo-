<?php
/** @var \app\model\Album[] $albums */
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Albumok</h1>
        </div>
    </div>
    <div class="row">
        <?php foreach ($albums as $album ) : ?>
            <div class="col-sm-4">
                <h2><?= $album->getTitle() ?></h2>
                <img src="<?= $album->getKep()?>" alt="<?= $album->getTitle()?>" title="<?= $album->getTitle()?>" class="img-thumbnail">

                <a href="index.php?controller=album&action=view&id=<?= $album->getId() ?>"
                   class="btn btn-primary btn-block my-2">Részletek</a>
            </div>
        <?php endforeach; ?>

    </div>
</div>

