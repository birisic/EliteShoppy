<?php
isset($_GET['page']) ? $page = $_GET['page'] : $page = "";
$words = explode("-",$page);

$categories = getAll("categories");
$articles = getAll("articles");
$genders = getAll("genders");
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
                <div class="form-check">
                    <label for="ag-article">Choose an Article</label>
                    <select class="form-control" name="ag-article" id="ag-article">
                        <?php
                        foreach ($articles as $article) :
                            ?>
                            <option value="<?= $article->id?>"><?= $article->name ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-check">
                    <label for="ag-gender">Choose a Gender</label>
                    <select class="form-control" name="ag-gender" id="ag-gender">
                        <?php
                        foreach ($genders as $gender) :
                            ?>
                            <option value="<?= $gender->id?>"><?= $gender->name ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ag-new-price">Active price</label>
                    <input type="number" class="form-control" min="0" id="ag-new-price" name="ag-new-price"/>
                </div>
                <div class="form-group">
                    <label for="ag-old-price">Old price (optional)</label>
                    <input type="number" class="form-control" min="0" id="ag-old-price" name="ag-old-price"/>
                </div>
                <div class="form-group">
                    <label for="ag-desc">Description</label>
                    <textarea class="form-control" name="ag-desc" id="ag-desc" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label for="ag-img">Image path</label>
                    <textarea class="form-control" name="ag-img" id="ag-img" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group mb-d-flex-center">
                    <input type="submit" class="btn mb-btn-action" value="Add Article Data" name="btn-insert" id="btn-insert"/>
                </div>
                <div class="form-group mb-d-flex-center">
                    <p class="alert alert-info text-center" id="mb-insert-info">Here you can add additional article data into the database.</p>
                </div>
            </form>
        </div>
    </div>
</div>