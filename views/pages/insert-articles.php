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
                    <label for="article-name">Article name</label>
                    <input type="text" class="form-control" id="article-name" name="article-name" placeholder="Example: Running shoes..."/>
                </div>
                <div class="form-group">
                    <label for="article-tag">Article Tag</label>
                    <input type="text" class="form-control" id="article-tag" name="article-tag" placeholder="Example: New..."/>
                </div>
                <div class="form-check">
                    <label for="article-name">Choose a Category</label>
                    <select class="form-control" name="article-category-select" id="article-category-select">
                        <?php
                            foreach ($categories as $category) :
                        ?>
                        <option value="<?= $category->id?>"><?= $category->name ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group mb-d-flex-center">
                    <input type="submit" class="btn mb-btn-action" value="Add Article" name="btn-insert" id="btn-insert"/>
                </div>
                <div class="form-group mb-d-flex-center">
                    <p class="alert alert-info text-center" id="mb-insert-info">Here you can add a new article into the database.</p>
                </div>
            </form>
        </div>
    </div>
</div>