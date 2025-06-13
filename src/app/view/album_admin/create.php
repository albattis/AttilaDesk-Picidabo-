<?php /** @var \app\model\Album $album */ ?>
<?php /** @var \app\model\Artist $artists */ ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Új album hozzáadása</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="index.php?controller=albumAdmin&action=create" method="post">

                <?php include("_form.php"); ?>

                <div class="form-row">
                    <div class="col-6 offset-3">
                        <button type="submit" class="btn btn-primary btn-block">Save</button>
                    </div>
                </div>
            </form>

            
    <?php include("_artist_modal.php") ?>
        </div>
    </div>
</div>