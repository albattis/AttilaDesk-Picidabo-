<?php

use app\model\Ugyfel;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $ugyfel=new Ugyfel();

    $ugyfel->setFirstname($_POST["firstname"]);
    $ugyfel->setLastname($_POST["lastname"]);
    $ugyfel->setZip($_POST["zip"]);
    $ugyfel->setCountry($_POST["country"]);
    $ugyfel->setStreet($_POST["street"]);
    $ugyfel->setPhonenumber($_POST["phone"]);
    $ugyfel->setEmail($_POST["email"]);

    if($ugyfel->save()) {
    ?>
<script>alert("Az ügyfél sikeresen felvéve")</script><?php
        header("Location: index.php?controller=User&action=index");
    }else
        {
            ?>
<script>alert("Az ügyfél nem került be az adatbázisba");</script>
<?php        }


}

?>

<style>

    .container-fluid-form {
        max-width: 800px;
        margin: auto;
    }



    .form-control, .form-select {
        border: 2px solid #0d47a1; /* Sötétkék keret */
        border-radius: 8px;
        padding: 10px;
        background-color: #f0f0f0; /* Halvány szürke háttér */
        transition: border-color 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    }

    .form-control:focus, .form-select:focus, .form-control:active, .form-select:active {
        background-color: #dcdcdc;
        border-color: #2196f3;
        box-shadow: 0 0 10px rgba(33, 150, 243, 0.5);
    }

    .btn-primary, .btn-info, .btn-secondary {
        background: linear-gradient(45deg, #1e88e5, #42a5f5); /* Világosabb kék */
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        color: #ffffff;
        font-weight: bold;
        transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
    }

    .btn-primary:hover, .btn-info:hover, .btn-secondary:hover {
        background: linear-gradient(45deg, #42a5f5, #1e88e5);
        box-shadow: 0 4px 8px rgba(33, 150, 243, 0.5), 0 0 10px rgba(33, 150, 243, 0.7);
        transform: scale(1.05); /* Finom nagyítás hover hatásra */
    }

    .btn-glow {
        background: linear-gradient(45deg, #1e88e5, #42a5f5); /* Világosabb kék */
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        color: #ffffff;
        font-weight: bold;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3), 0 0 15px rgba(0, 123, 255, 0.5);
        transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-glow:hover {
        background: linear-gradient(45deg, #42a5f5, #1e88e5);
        box-shadow: 0 4px 8px rgba(33, 150, 243, 0.5), 0 0 20px rgba(33, 150, 243, 0.7);
        transform: scale(1.05);
    }

    .form-container {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb, #90caf9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1.text-center {
        color: #0d47a1;
        font-weight: bold;


    }

    input[type="text"], input[type="number"]
    {
        width:100%;
        margin:10px;
    }
</style>

<div class="container-fluid-form mt-3 form-container">
    <form action="index.php?controller=ugyfel&action=insert" method="post">
    <div class="row">
        <div class="col-12">
            <h1>Ügyfél felvétele</h1>
        </div>
    </div>
    <div class="row">

        <div class="col-6">
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Ügyfél vezetékneve" required>
        </div>
        <div class="col-6">
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Ügyfél keresztneve" required>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <input type="number" class="form-control" id="zip" name="zip" placeholder="Irányitószám">
        </div>
        <div class="col-4">
            <input type="text" class="form-control" id="country" name="country" placeholder="Város">
        </div>
        <div class="col-4">
            <input type="text" class="form-control" id="street" name="street" placeholder="Utca, házszám">
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Telefonszám">
        </div>
        <div class="col-6">
            <input type="email" class="form-control" name="email" id="email" placeholder="E-mail">
        </div>
<div class="row">
    <div class="col-12 mt-2">
        <button type="submit" style="display:block; margin-left: auto;margin-right: auto;"class="btn btn-primary btn-glow">Ügyfél felvitele</button>
    </div>
</div>
    </form>
    </div>
</div>
