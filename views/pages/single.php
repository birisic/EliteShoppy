<?php
	isset($_GET['page']) ? $page = $_GET['page'] : $page = "";
	isset($_GET['id']) ? $id = $_GET['id'] : $id = "";

	$words = explode("-",$page);
	$sql = "SELECT a.id, a.name AS 'article_name', a.IDcat, a.tag, g.id AS 'IDgender', g.name AS 'gender', CONCAT('$', ag.priceNew) AS 'active_price',
            CONCAT('$', ag.priceOld) AS 'old_price', ag.description, ag.image
            FROM articles_genders ag
            JOIN articles a ON ag.IDarticle = a.id
            JOIN genders g ON ag.IDgender = g.id
            WHERE ag.id = :id";

	$query = $conn->prepare($sql);
	$query->bindParam(":id", $id);
	$query->execute();

	$row = $query->fetch();
?>
<div class="page-head_agile_info_w3l">
		<div class="container">
			<h3>Single <span>Page </span></h3>
			<!--/w3_short-->
				 <div class="services-breadcrumb">
						<div class="agile_inner_breadcrumb">

						   <ul class="w3_short">
								<li><a href="index.php">Home</a><i>|</i></li>
								<li>Single Page</li>
							</ul>
						 </div>
				</div>
	   <!--//w3_short-->
	</div>
</div>
<div class="container">
	<div class="row mb-d-flex-center">
		<div class="col-xs-12 col-sm-4">
			<img src="images/<?= $row->image ?>" alt="<?= $row->article_name ?>" class="img-responsive" width="250" height="250"/>
		</div>
		<div class="col-xs-12 col-sm-4">
			<h2><?= $row->article_name?> <span class="mb-table-span"><?=$row->tag?></span></h2>
			<span class="mb-bold mb-fs"><?= $row->active_price ?></span>
			<del class="mb-fs"><?= $row->old_price ?></del>
			<span class="mb-fs">Gender: <?= $row->gender ?></span>
			<p><?= $row->description ?></p>
			<form>
				<input type="submit" name="submit" value="Add to cart" class="btn mb-btn-action" />
			</form>
		</div>
	</div>
</div>

