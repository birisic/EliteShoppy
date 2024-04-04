<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-h1">Welcome, <?= $_SESSION['user']->first_name?>!</h1>
            <h4  class="text-center text-muted mb-h1">You're currently viewing the <span class='mb-table-span' id='mb-table-span'>$table</span> table</h4>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-6 mx-auto">
            <form action="models/logout.php" method="POST" class="mb-d-flex-center">
                <a class="btn mb-btn-action" href="#" id="mb-btn-insert">Insert row</a>
                <input class="btn mb-btn-action" type="submit" id="mb-btn-logout" name="mb-btn-logout" value="Logout"/>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-2 mb-d-flex-center">
            <div class="dropdown-menu mb-dropdown stay-open">
                <h5 class="text-start table-header text-muted">Choose a table</h5>
                <a href="#" class="table-link" data-table="users">Display <span class="mb-table-span">Users</span> Table</a>
                <a href="#" class="table-link" data-table="articles">Display <span class="mb-table-span">Articles</span> Table</a>
                <a href="#" class="table-link" data-table="genders">Display <span class="mb-table-span">Genders</span> Table</a>
                <a href="#" class="table-link" data-table="categories">Display <span class="mb-table-span">Categories</span> Table</a>
                <a href="#" class="table-link" data-table="articles_genders">Display <span class="mb-table-span">Articles_genders</span> Table</a>

            </div>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-10 table-responsive">
            <p class="alert alert-info text-center" id="mb-table-info">Choose a table from the sidemenu.</p>
            <table class="table table-striped table-bordered table-hover" id="mb-table">

            </table>
            <p class="alert alert-danger mb-d-none text-center" id="mb-table-message"></p>
        </div>
        <div class="clearfix"></div>
    </div>
</div>


