<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-h1">Welcome,<?= $_SESSION['user']->first_name?>!</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center">Your name is <?= $_SESSION['user']->first_name?> <?= $_SESSION['user']->last_name?> and your email is <?= $_SESSION['user']->email?></h3>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-6 mx-auto">
            <form action="models/logout.php" method="POST" class="mb-d-flex-center">
                <input class="btn mb-btn-action" type="submit" id="mb-btn-logout" name="mb-btn-logout" value="Logout"/>
            </form>
        </div>
    </div>
</div>
