<?php /** @var array $messages */ ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success mt-3" role="alert">
                <?php foreach($messages as $message) : ?>
                    <?php echo $message ?>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>