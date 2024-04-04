<?php
isset($_GET['page']) ? $page = $_GET['page'] : $page = "";
isset($_GET['id']) ? $id = $_GET['id'] : $id = "";

$words = explode("-",$page);
$category = findRecord($words[1], $id);
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-capitalize text-center mb-h1"><?=$words[0] . " " . $words[1]?> page</h1>
            <h2 class="text-capitalize text-center mb-h1 text-muted">Category: <?=$category->name?></h2>
        </div>
    </div>
</div>
<div class="container">
    <div class="row mb-d-flex-center">
        <div class="col-xs-12 col-sm-6">
            <form>
                <div class="form-group">
                    <label for="category-name">Category name</label>
                    <input type="text" class="form-control" id="category-name" name="category-name" value="<?= $category->name?>"/>
                </div>
                <div class="form-group mb-d-flex-center">
                    <input type="submit" class="btn mb-btn-action" value="Edit Category" name="btn-edit" id="btn-edit"/>
                </div>
                <div class="form-group mb-d-flex-center">
                    <p class="alert alert-info text-center" id="mb-edit-info">Here you can modify an existing category from the database.</p>
                </div>
            </form>
        </div>
    </div>
</div>