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
                    <label for="category-name">Category name</label>
                    <input type="text" class="form-control" id="category-name" name="category-name"/>
                </div>
                <div class="form-group mb-d-flex-center">
                    <input type="submit" class="btn mb-btn-action" value="Add Category" name="btn-insert" id="btn-insert"/>
                </div>
                <div class="form-group mb-d-flex-center">
                    <p class="alert alert-info text-center" id="mb-insert-info">Here you can add a new category into the database.</p>
                </div>
            </form>
        </div>
    </div>
</div>