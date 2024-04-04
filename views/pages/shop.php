<?php
    isset($_GET['page']) ? $page = $_GET['page'] : $page = "";
    isset($_GET['category']) ? $cat = $_GET['category'] : $cat = "";

    $categories = getAll("categories");
?>
<!-- /banner_bottom_agile_info -->
<div class="page-head_agile_info_w3l">
    <div class="container">
        <h3><span>The right place for </span>shopping.</h3>
        <!--/w3_short-->
        <div class="services-breadcrumb">
            <div class="agile_inner_breadcrumb">

                <ul class="w3_short">
                    <li><a href="index.php">Home</a><i>|</i></li>
                    <li>Shop</li>
                </ul>
            </div>
        </div>
        <!--//w3_short-->
    </div>
</div>

<!-- banner-bootom-w3-agileits -->
<div class="banner-bootom-w3-agileits">
    <div class="container">
        <!-- mens -->
        <form>
            <div class="col-md-4 products-left">
                <div class="filter-price">
                    <h3>Filter By <span>Price</span></h3>
                    <input type="range" min="10" max="1000" name="range-price" id="range-price"/>
                    <span id="range-span" class="text-center mb-d-block"></span>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-8 products-right">
                <h5>Filter by <span>category</span> or <span>gender</span> and sort <span>products</span></h5>
                <div class="sort-grid">
                    <div class="sorting">
                        <h6>Sort By:</h6>
                        <select id="input-select-sort" name="input-select-sort" class="form-control">
                            <option value="1">Name(A - Z)</option>
                            <option value="2">Name(Z - A)</option>
                            <option value="3">Price(High - Low)</option>
                            <option value="4">Price(Low - High)</option>
                        </select>
                        <div class="clearfix"></div>
                    </div>
                    <div class="sorting">
                        <h6>Choose a category:</h6>
                        <select class="form-control" name="input-select-category" id="input-select-category"><!--id="country2" onchange="change_country(this.value)"-->
                            <?php
                            foreach ($categories as $category) {
                            ?>
                                <option value='<?=$category->id?>' <?= isset($cat) && strtolower($category->name) == $cat ? "selected='selected'" : ""?>><?=$category->name?></option>";
                            <?php }?>
                        </select>
                        <div class="clearfix"></div>
                    </div>
                    <div class="sorting">
                        <h6>Gender:</h6>
                        <input type="radio" id="gender1" name="gender" class="mb-checkbox-gender" value="1"/>
                        <label for="gender1">Male</label>
                        <input type="radio" id="gender2" name="gender" class="mb-checkbox-gender" value="2"/>
                        <label for="gender2">Female</label>

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </form>

        <div class="clearfix"></div>

        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div id="messageBoxShop" class="alert alert-info text-center mb-d-none"></div>
                </div>
            </div>
        </div>

        <div class="single-pro" id="articles-container">
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- //mens -->