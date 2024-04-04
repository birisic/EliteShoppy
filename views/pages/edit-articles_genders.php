<?php
isset($_GET['page']) ? $page = $_GET['page'] : $page = "";
isset($_GET['id']) ? $id = $_GET['id'] : $id = "";

$words = explode("-",$page);
$article_gender = findRecord($words[1], $id);

$categories = getAll("categories");
$articles = getAll("articles");
$genders = getAll("genders");
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-capitalize text-center mb-h1"><?=$words[0] . " " . $words[1]?> page</h1>
            <h2 class="text-capitalize text-center mb-h1 text-muted">Additional info for article:
                <?php
                foreach ($articles as $article) :
                    ?>
                        <?= $article->id == $article_gender->IDarticle ? $article->name : ""?>
                <?php endforeach;?>
            </h2>
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
                            <option value="<?= $article->id?>" <?= $article->id == $article_gender->IDarticle ? "selected='selected'" : ""?>><?= $article->name ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-check">
                    <label for="ag-gender">Choose a Gender</label>
                    <select class="form-control" name="ag-gender" id="ag-gender">
                        <?php
                        foreach ($genders as $gender) :
                            ?>
                            <option value="<?= $gender->id?>" <?= $gender->id == $article_gender->IDgender ? "selected='selected'" : ""?>><?= $gender->name ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ag-new-price">Active price</label>
                    <input type="number" class="form-control" min="0" id="ag-new-price" name="ag-new-price" value="<?= $article_gender->priceNew?>"/>
                </div>
                <div class="form-group">
                    <label for="ag-old-price">Old price (optional)</label>
                    <input type="number" class="form-control" min="0" id="ag-old-price" name="ag-old-price" value="<?= $article_gender->priceOld?>"/>
                </div>
                <div class="form-group">
                    <label for="ag-desc">Description</label>
                    <textarea class="form-control" name="ag-desc" id="ag-desc" cols="30" rows="10"><?= $article_gender->description ?></textarea>
                </div>
                <div class="form-group">
                    <label for="ag-img">Image path</label>
                    <textarea class="form-control" name="ag-img" id="ag-img" cols="30" rows="5"><?= $article_gender->image?></textarea>
                </div>
                <div class="form-group mb-d-flex-center">
                    <input type="submit" class="btn mb-btn-action" value="Edit Article Data" name="btn-edit" id="btn-edit"/>
                </div>
                <div class="form-group mb-d-flex-center">
                    <p class="alert alert-info text-center" id="mb-edit-info">Here you can modify additional article data from the database.</p>
                </div>
            </form>
        </div>
    </div>
</div>