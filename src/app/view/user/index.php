<?php


use app\model\task;
use app\model\User;

if(isset($_SESSION['user_id']))

{
    $user= User::findOneById($_SESSION['user_id']);
}



    ?>
<style>
    td
    {
        text-align: center;
    }
</style>
<div class="container-fluid">
<div class="row">
    <div class="col-md-3 col-sm-12 ">
        <?php if(isset($_SESSION['user_id'])){ ?>
        <h3 style="text-align: center"> Felvett feladatok:<?php echo("   ". task::taskUserCount($_SESSION['user_id'])); ?></h3>
</div>
    <div class="col-sm-12 col-lg-3">
        <h3 style="text-align: center">Aktuális feladatok: <?php echo("  ".task::AktualTask());?></h3>
    <?php } ?></div>
</div>
</div>
<?php require 'src/app/view/beosztas/beosztas.php'; ?>
