<!DOCTYPE html>
<html>
<head>
	<title>Search Movies</title>
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
		<div class="header">
			<div class="row text-center">
				<h1>SEARCH MOVIE DATABASE</h1>
			</div>
		</div>
		<hr>
		<form class="form-search" method="GET" action="movieResult.php">
			<div class="well">
				<div class="row">
					<fieldset>
						<legend>Search by:</legend>
					</fieldset>
					<div class="form-group col-sm-4">
						<div class="input-group">
							<label class="input-group-addon">Title</label>
							<input type="text" id="t" name="title" class="form-control" placeholder="title" value="" required>
						</div>
					</div>
					<div class="form-group col-sm-2">
						<div class="input-group">
							<label class="input-group-addon">Year</label>
							<input type="number" id="y" name="year" class="form-control" min="1000" max="3000" placeholder="year">
						</div>
					</div>
					<div class="form group col-sm-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="adultCont" value="1"> Adults Content
							</label>
						</div>
					</div>
					<div class="form-group col-sm-4">
						<button type="submit" class="btn btn-primary" id="search" value="search">Search</button>
						<button type="reset" class="btn btn-default" id="reset">Reset</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</body>
</html>
