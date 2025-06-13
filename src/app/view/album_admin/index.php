<?php use app\model\Album; ?>
<?php use app\model\User; ?>


<?php /** @var $albums Album[] */ ?>
<?php /** @var $user User */ ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <?php if (isset($_GET['delete'])) : ?>
                <?php if ($_GET['delete'] == 'success') : ?>
                    <div class="alert alert-success my-3">
                        Album sikeresen törölve.
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger my-3">
                        Album nem törölhető!
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h1>List of best-selling albums</h1>
        </div>
    </div>

    <table class="table table-striped">
        <?php foreach ($albums as $album) : ?>

        <tr>
            <td>
                <?= $album->getTitle(); ?>
            </td>
            <td>
                <?php if(User::currentUserCan('update.album')) : ?>
                        <a href="index.php?controller=albumAdmin&action=update&id=<?= $album->getId() ?>"
                           class="btn btn-info btn-block my-2">
                            <span class="oi oi-pencil"></span>&nbsp;Edit
                        </a>
                <?php endif; ?>
            </td>
            <td>
                <?php if(User::currentUserCan('delete.album')) : ?>

                        <a href="index.php?controller=albumAdmin&action=delete&id=<?= $album->getId() ?>"
                           class="btn btn-danger btn-block my-2"
                           onclick="return confirm('Biztos töröljük?');">
                            <span class="oi oi-minus"></span>&nbsp;Delete
                        </a>
                <?php endif; ?>
            </td>
        </tr>



        <?php endforeach; ?>

    </table>
</div>


<!--<script>-->
<!--    let deleteButtons = document.getElementsByClassName('.delete-album');-->
<!---->
<!--    for(let i = 0; i < deleteButtons.length; ++i)-->
<!--    {-->
<!--        deleteButtons[i].onclick = function()-->
<!--        {-->
<!---->
<!--        }-->
<!--    }-->
<!--</script>-->