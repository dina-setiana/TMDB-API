<!DOCTYPE html>
<html>
<head>
	<title>Movies Result</title>
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script>
		function resetForm(){
			document.getElementById("t").value = "";
			document.getElementById("y").value = "";
			document.getElementById("ac").checked  = false;
		}
	</script>
</head>
<body>

	<?php include_once 'searchData.php';

	$title = urlencode($_GET['title']);
	$year = $_GET['year'];	

	if($year == '')
		$year = 'undefined';

	if(!isset($_GET['page']))
		$page = 1;
	else
		$page = $_GET['page'];

	if(isset($_GET['adultCont']))
		$adult = 'true';
	else
		$adult = 'false';
	print_r($json);
	$json = getSearchResult($key, $title, $page, $year, $adult);
	?>

	<div class="container">
		<div class="header">
			<div class="row text-center">
				<h1>SEARCH MOVIE DATABASE</h1>
			</div>
		</div>
		<hr>

		<form class="form-search" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div class="well">
				<div class="row">
					<fieldset>
						<legend>Search by:</legend>
					</fieldset>
					<div class="form-group col-sm-4">
						<div class="input-group">
							<label class="input-group-addon">Title</label>
							<input type="text" id="t" name="title" class="form-control" placeholder="title" value="<?php echo $_GET['title']; ?>" required>
						</div>
					</div>
					<div class="form-group col-sm-2">
						<div class="input-group">
							<label class="input-group-addon">Year</label>
							<input type="number" id="y" name="year" class="form-control" placeholder="year" value="<?php echo $_GET['year']; ?>">
						</div>
					</div>
					<div class="form group col-sm-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" id="ac" name="adultCont" value="1" <?php if(isset($_GET['adultCont'])) echo 'checked'; ?>> Adults Content
							</label>
						</div>
					</div>
					<div class="form-group col-sm-4">

						<button type="submit" class="btn btn-primary" id="search" value="search">Search</button>
						<button type="button" class="btn btn-default" id="reset" onclick="resetForm()">Reset</button>

					</div>
				</div>
			</div>
		</form>

		<div class="row">
			<fieldset>
				<legend>Result:</legend>
				<p>Total result : <?php echo $json->total_results; ?></p>
			</fieldset>
			<div class="col-sm-12">
				<table class="table table-striped">

					<?php 
					foreach ($json->results as $result)
					{
						echo '<tr>';
						echo '<td>';
						echo '<a href="movieDetail.php?id='.$result->id.'" target="_blank">';

						if($result->poster_path)
							echo '<img src="https://image.tmdb.org/t/p/w92/'.$result->poster_path.'" class="rounded float-xs-left img-sz-res" alt="Poster image">';
						else
							echo '<img src="img/null.png" class="rounded float-xs-left img-sz-res" alt="Poster image">';
						echo '<span>&nbsp;</span>';
						echo '<span>'.$result->title.'</span>';
						echo '<span>&nbsp; - &nbsp;</span>';
						if($result->release_date != "")
							echo '<span>'.substr($result->release_date, 0, 4).'</span>';
						else
							echo '<span>Unknown</span>';

						if($result->adult == true)
						{
							echo '<span>&nbsp; - &nbsp;</span>';
							echo '<span>Adult</span>';
						}
						echo '</a>';
						echo '</td>';
						echo '<td class="text-right text-info td-wd">';
						if($result->vote_average != 0)
							echo '&#32;'.$result->vote_average;
						else
							echo '&#32;Not Rated';
						echo '&#32;<span class="glyphicon glyphicon-star"></span>';
						echo '<br/>';
						if($result->release_date != "")
							echo '&#32;'.$result->release_date.'&#32;<span class="glyphicon glyphicon-calendar"></span>';
						else
							echo '&#32;Unknown&#32;<span class="glyphicon glyphicon-calendar"></span>';
						echo '</td>';
						echo '</tr>';
					}
					?>
				</table>	
			</div>	
		</div>

		<div class="row text-center">
			<div class="col-sm-12">
				<nav aria-label="...">
					<ul class="pager">
						<?php
						if($page > 1)
						{
							echo '<li class="previous">';
							echo '<a href="../movieResult.php?page='.($page-1).'&title='.$title.'&year='.$year;
							if(isset($_GET['adultCont']))
								echo '&adultCont=true';
							echo '"><span aria-hidden="true">&larr;</span> Previous</a>';
							echo '</li>';
						}
						else
						{
							echo '<li class="previous disabled">';
							echo '<a href="#"><span aria-hidden="true">&larr;</span> Previous</a>';
							echo '</li>';	
						}

						echo '<li><span>'.$page.' of '.$json->total_pages.'</span></li>';

						if($page < $json->total_pages)
						{
							echo '<li class="next">';
							echo '<a href="../movieResult.php?page='.($page+1).'&title='.$title.'&year='.$year;
							if(isset($_GET['adultCont']))
								echo '&adultCont=true';
							echo '">Next<span aria-hidden="true">&rarr;</span></a>';
							echo '</li>';
						}
						else
						{
							echo '<li class="next disabled">';
							echo '<a href="#">Next<span aria-hidden="true">&rarr;</span></a>';
							echo '</li>';	
						}
						?>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</body>
</html>
