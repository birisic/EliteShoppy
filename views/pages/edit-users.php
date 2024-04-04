<?php
isset($_GET['page']) ? $page = $_GET['page'] : $page = "";
isset($_GET['id']) ? $id = $_GET['id'] : $id = "";

$words = explode("-",$page);
$user = findRecord($words[1], $id);
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-capitalize text-center mb-h1"><?=$words[0] . " " . $words[1]?> page</h1>
            <h2 class="text-capitalize text-center mb-h1 text-muted">User: <?=$user->first_name . " " . $user->last_name?></h2>
        </div>
    </div>
</div>
<div class="container">
    <div class="row mb-d-flex-center">
        <div class="col-xs-12 col-sm-6">
            <form>
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" class="form-control" id="user-first-name" name="first-name" value="<?= $user->first_name ?>" placeholder="Example: Mika"/>
                </div>
                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" class="form-control" id="user-last-name" name="last-name" value="<?= $user->last_name ?>" placeholder="Example: Mikic"/>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="user-email" name="email" value="<?= $user->email ?>" placeholder="Example: example@gmail.com"/>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="user-password"/>
                </div>
                <div class="form-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" class="form-control" name="passwordConfirm" id="user-passwordConfirm"/>
                </div>
                <div class="form-group mb-d-flex-center">
                    <input type="submit" class="btn mb-btn-action" value="Edit User" name="btn-edit" id="btn-edit"/>
                </div>
                <div class="form-group mb-d-flex-center">
                    <p class="alert alert-info text-center" id="mb-edit-info">Here you can modify an existing user from the database.</p>
                </div>
            </form>
        </div>
    </div>
</div>
