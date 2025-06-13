<?php use app\model\Artist; ?>
<?php /** @var $artists Artist[] */ ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Artists</h1>
        </div>
    </div>

    <div class="row">
        <?php foreach ($artists as $artist) : ?>
            <div class="col-sm-6 col-md-4 col-lg-3 my-3">
                <img src="img/<?= $artist->getImage() ?>" alt="<?= $artist->getName() ?>" class="img-thumbnail">
                <h2><?= $artist->getName() ?></h2>

            </div>
        <?php endforeach; ?>
    </div>
</div>
