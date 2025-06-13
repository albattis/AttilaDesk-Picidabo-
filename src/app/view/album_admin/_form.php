<?php /** @var \app\model\Album $album */ ?>
<?php /** @var \app\model\Artist $artists */ ?>

<div class="form-row">

    <div class="form-group col-md-4">
        <label for="album_artist_id">Artist</label>
        <select name="album[artist_id]" id="album_artist_id" class="form-control">
            <?php foreach ($artists as $artist) : ?>
                <option value="<?= $artist->getId() ?>" <?php echo ($artist->getId() == $album->getArtistId()) ? 'selected' : ''; ?> ><?= $artist->getName() ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-2">
                <button id="ujszerzo" class="btn btn-primary mt-4" type="button" data-toggle="modal" data-target="#ujszerzoModal">Új szerző</button>
    </div>

    <div class="form-group col-md-3">
        <label for="album_title">Title</label>
        <input type="text" name="album[title]"
               class="form-control" id="album_title"
               placeholder="Title"
               value="<?= $album->getTitle() ?>">
    </div>

    <div class="form-group col-md-3">
        <label for="album_genre">Genre</label>
        <input type="text" name="album[genre]" class="form-control" id="album_genre" placeholder="Genre"
               value="<?= $album->getGenre() ?>">
    </div>
</div>
<div class="form-row">

    <div class="form-group col-md-2">
        <label for="album_released">Released</label>
        <input type="number" step="0.01" name="album[released]" class="form-control" id="album_released"
               placeholder="Year" value="<?= $album->getReleased() ?>" required>
    </div>

    <div class="form-group col-md-2">
        <label for="album_tcc">Total certified copies</label>
        <input type="number" step="0.01" name="album[tcc]" class="form-control" id="album_tcc" placeholder="TCC"
               value="<?= $album->getTcc() ?>">
    </div>

    <div class="form-group col-md-2">
        <label for="album_sales">Claimed sales</label>
        <input type="number" step="0.01" name="album[sales]" class="form-control" id="album_sales" placeholder="Sales"
               value="<?= $album->getSales() ?>" required>
    </div>

    <div class="form-group col-md-6">
        <label for="album_image">Cover</label>
        <input type="text" name="album[image]" class="form-control" id="album_image" placeholder="Cover image link"
               value="<?= $album->getImage() ?>">
    </div>

</div>


