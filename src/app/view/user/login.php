
<?php


    if (isset($_SESSION["user_id"])) {
        header("location:index.php?controller=User&action=index");

    }
?>


<div class="container-fluid container-login">
    <div class="row">
        <div class=" login-display" >
    <form action="index.php?controller=user&action=login" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username"><br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password"><br>
        <input type="submit" value="Log in">
    </form>
</div></div></div>