<?php
    isset($_GET['page']) ? $page = $_GET['page'] : $page = "";
    $words = explode("-",$page);

    $categories = getAll("categories");
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-capitalize text-center mb-h1"><?=$words[0] . " " . $words[1]?> page</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="row mb-d-flex-center">
        <div class="col-xs-12 col-sm-6">
            <form>
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" class="form-control" id="user-first-name" name="first-name" placeholder="Example: Mika"/>
                </div>
                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" class="form-control" id="user-last-name" name="last-name" placeholder="Example: Mikic"/>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="user-email" name="email" placeholder="Example: example@gmail.com"/>
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
                    <input type="submit" class="btn mb-btn-action" value="Add User" name="btn-insert" id="btn-insert"/>
                </div>
                <div class="form-group mb-d-flex-center">
                    <p class="alert alert-info text-center" id="mb-insert-info">Here you can add a new user into the database.</p>
                </div>
            </form>
        </div>
    </div>
</div>
