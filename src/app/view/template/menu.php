<?php
$decoded = null;
use app\model\User;

if (isset($_SESSION['jwt']))
{
    $decoded = User::validateToken($_SESSION['jwt']);

}
$userRole = $decoded ? $decoded['role'] : 'guest';

?>


<style>
    .navbar-custom {
        background: linear-gradient(45deg, #1a237e, #0d47a1); /* Sötétebb kék színátmenetes háttér */
        padding: 10px 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link {
        color: #ffffff;
        font-weight: bold;
        transition: color 0.3s ease, transform 0.3s ease, background 0.3s ease;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .navbar-custom .navbar-brand:hover,
    .navbar-custom .nav-link:hover {
        color: #0d47a1;
        background: #b0e57c; /* Fakó zöld háttér */
        transform: scale(1.1); /* Finom nagyítás */
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=UTF8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='#ffffff' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    .btn-glow {
        display: inline-block;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: bold;
        color: #ffffff;
        text-align: center;
        text-decoration: none;
        background: linear-gradient(45deg, #007bff, #0056b3); /* Színátmenetes kék */
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3), 0 0 15px rgba(0, 123, 255, 0.5);
        transition: background 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-glow:hover {
        background: linear-gradient(45deg, #0056b3, #007bff); /* Színátmenet váltás */
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.5), 0 0 20px rgba(0, 123, 255, 0.7);
    }

    .navbar-nav {
        margin-left: auto;
        margin-right: auto;
    }

    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link {
        position: relative;
        animation: slide-in 0.5s forwards;
    }

    @keyframes slide-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-custom">
    <a class="navbar-brand mr-5 ml-3" href="index.php?controller=user&action=index">Főoldal</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <?php
            if(User::currentUserCan()) : ?>
                <li class="nav-item mr-5">
                    <a class="nav-link" href="../insert/index.php" target="_blank">Gépeink</a>
                </li>
            <?php endif;?>
            <li class="nav-item mr-5">
                <a class="nav-link" href="index.php?controller=task&action=index" tabindex="-1">Feladatok</a>
            </li>
            <li class="nav-item mr-5">
                <a class="nav-link" href="../insert" tabindex="-1">Gépeink</a>
            </li>
            <li class="nav-item mr-5">
                <a class="nav-link" href="index.php?controller=ugyfel&action=index" tabindex="-1">Ügyfeleink</a>
            </li>
        </ul>
        <?php if( isset($_SESSION['user_id'])) : ?>
            <a href="index.php?controller=user&action=logout" class="btn glow-button ml-2">Logout</a> <!-- Eredeti gomb -->
        <?php else : ?>
            <a href="index.php?controller=user&action=login" class="btn glow-button ml-2">Login</a>
        <?php endif;?>
    </div>
</nav>

<br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-sm-12">
                <?php if ($userRole === 'boss'): ?>
                    <a class="btn btn-gradient-glow" href="#" data-toggle="modal" data-target="#addUserModal">Új Felhasználó Hozzáadása</a>
                      <?php endif; ?>

            </div>
            <div class="col-md-2 col-sm-12">
                <a href="https://www.compmarket.hu" target="_blank" class="btn btn-gradient-glow">Compmarket</a>
            </div>
            <div class="col-md-2 col-sm-12">
                <a href="https://admin.packeta.com" target="_blank" class="btn btn-gradient-glow">Packeta</a>
            </div>
            <div class="col-md-2 col-sm-12">
                <a href="index.php?controller=task&action=insert" class="btn btn-gradient-glow" >Új feladat</a>
            </div>
            <div class="col-md-2 col-sm-12">
                <a href="https://szerviz.picishop.hu/index.php" target="_blank" class="btn btn-gradient-glow">Pici Szerviz</a>
            </div>
            <div class="col-md-2 col-sm-12">
                <a href="index.php?controller=Ugyfel&action=insert" target="_blank" class="btn btn-gradient-glow">Új ügyfél</a>
            </div>
        </div>
        <div class="row m-2">
            <div class="col-md-2 m-2 col-sm-12">
                <button type="button" class="btn btn-gradient-glow" data-toggle="modal" data-target="#szabadsagModal">Szabadság Felvétele</button>
            </div>
            <div class="col-md-2 col-sm-12">
                <a href="index.php?controller=szabadsag&action=index" class="btn btn-gradient-glow">Szabadságok megjelintése</a>
            </div>
            <div class="col-md-2 col-sm-12">
                <a href="https://picishop.hu/__app/ugyfel_rendeles/rendeles_lista.php?jelszo=PiCi" target="_blank" class="btn btn-gradient-glow">Rendelések</a>
            </div>
        </div>
        <div class="row">
          <div class="col-12"><br> <?php
            if(!empty($_SESSION["user_id"])) {
            $user = \app\model\User::findOneById($_SESSION['user_id']);?>
                <h2 class="nev"><?=$user->getFirstname()." ". $user->getLastname()?></h2><br>

          </div>
        </div>
        <br>
        <br>
    </div>

<?php }?>





<!-- Modál szerkezete -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Új Felhasználó Hozzáadása</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" action="index.php?controller=user&action=addUser" method="POST">
                    <div class="form-group">
                        <label for="firstname">Vezetéknév:</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Keresztnév:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Nickname:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Jelszó:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Szerepkör:</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="employee">Employee</option>
                            <option value="boss">Boss</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Felhasználó Hozzáadása</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modális ablak szabadság-->
<div class="modal fade" id="szabadsagModal" tabindex="-1" aria-labelledby="szabadsagModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="szabadsagModalLabel">Szabadság Felvétele</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="src/app/controller/add_szabadsag.php" method="post">
                    <div class="form-group">
                        <label for="user">Felhasználó:</label>
                        <select name="user_id" id="user" class="form-control">
                            <?php
                            // Felhasználók listájának lekérdezése az adatbázisból
                            $users = User::findAll();
                            foreach ($users as $user) {
                                echo "<option value=\"{$user->getId()}\">{$user->getFirstname()}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Nap:</label>
                        <input type="date" name="nap" id="date" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Szabadság Beírása</button>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
document.getElementById('addUserForm').addEventListener('submit', async function(event) {
event.preventDefault();

let formData = new FormData(this);
let data = Object.fromEntries(formData.entries());

    console.log('Form Data:', data); // Logoljuk a form adatait
    console.log('JSON Stringify:', JSON.stringify(data)); // Próbáljuk meg stringifikálni és logoljuk az eredményt

try {
let response = await fetch(this.action, {
method: 'POST',
headers: {
'Content-Type': 'application/json'
},
body: JSON.stringify(data)
});

// Ellenőrizd, hogy a válasz JSON formátumú-e
if (response.headers.get('content-type')?.includes('application/json'))
{
    let result = await response.json();

    if (result.success)
    {
        $('#addUserModal').modal('hide');
            alert('Új felhasználó sikeresen hozzáadva!');
    }
    else
        {
            alert('Hiba történt: ' + result.message);
        }
    }
    else {
            let errorText = await response.text();
            console.error('Unexpected response format:', errorText);
            alert('Hiba történt: A szerver válasza nem megfelelő formátumú.');
            }
}catch (error) {
console.error('Error:', error);
alert('Hiba történt: ' + error.message);
}
});


</script>