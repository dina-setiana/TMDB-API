<!DOCTYPE html>
<html>
<head>
	<title>Movie Detail</title>
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>

	<?php include_once 'searchData.php';

	$id = $_GET['id'];
	$json = getSearchDetail($key, $id);

	if($json === false)
	{
		header('Location: ../error.php');
		die();
	}
	?>

	<div class="container">
		<div class="well row">
			<div class="col-sm-3">
				<?php 
				if(isset($json->poster_path))
					echo '<img src="https://image.tmdb.org/t/p/w342/'.$json->poster_path.'" class="rounded float-xs-left img-sz-poster" alt="Poster">';
				else
					echo '<img src="img/posterNull.png" class="rounded float-xs-left img-sz-poster" alt="Poster">';
				?>
			</div>
			<div class="col-sm-9">
				<div class="row">
					<div class="col-sm-12">
						<h1><?php echo $json->title ?>
							<small><?php echo substr($json->release_date, 0, 4) ?>
								<span class=" badge glyphicon glyphicon-star">
									<?php 
									if($json->vote_average != 0)
										echo $json->vote_average;
									else
										echo 'NR';
									?>
								</span>
							</small>
						</h1>
						<p class="small">
							<?php 
							if(isset($json->runtime))
								echo '<kbd>'.$json->runtime.' mins</kbd>';;
							if($json->release_date != "")
								echo '<strong> | </strong><kbd>'.$json->release_date.'</kbd>';
							if(sizeof($json->genres)  != 0)
							{
								echo '<strong> | </strong><kbd>';
								$flag = false;
								foreach ($json->genres as $genre)
								{
									if($flag)
										echo ', ';
									echo $genre->name;
									$flag = true;
								}
								echo '</kbd>';
							}
							?>
						</p>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<h4 class="text-primary">Overview</h4>
						<p class="text-justify">
							<?php 
							if(isset($json->overview))
							{
								$ov = $json->overview;
								if (strlen($ov) > 200)
								{
									$ovCut = substr($ov, 0, 200);
									$ov = substr($ovCut, 0, strrpos($ovCut, ' ')).'... <a href="#" class="text-primary" data-toggle="modal" data-target="#myModal">Read More</a>'; 
								}
								echo $ov;
							}

							else
								echo 'No info';
							?>
						</p>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<h4 class="text-primary">Top Cast</h4>

						<?php 
						if(sizeof($json->credits->cast) != 0)
						{
							$count = 0;
							foreach ($json->credits->cast as $actor)
							{
								$count++;
								if($count < 7)
								{
									echo '<div class="col-sm-2">';
									if($actor->profile_path)
										echo '<img src="https://image.tmdb.org/t/p/w92/'.$actor->profile_path;
									else
										echo '<img src="img/null.png"';
									echo '" class="img-thumbnail img-sz-cast center-block" alt="Cast">';
									echo '<p class="text-center"><small>'.$actor->name.'<br/> '.$actor->character.'</small></p>';
									echo '</div>';
								}
								else
									break;
							}
						}
						else
							echo '<p>No cast info</p>';
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<fieldset >
					<legend class="text-primary">Movie Info</legend>
				</fieldset>

				<?php
				if(isset($json->original_title))
				{
					echo '<dl class="dl-horizontal">';
					echo '<dt><strong>Original Title</strong></dt>';
					echo '<dd>';
					echo $json->original_title;
					echo '</dd>';
					echo '</dl>';
				}


				if(isset($json->original_language))
				{
					echo '<dl class="dl-horizontal">';
					echo '<dt><strong>Original Language</strong></dt>';
					echo '<dd>';
					echo strtoupper($json->original_language);
					echo '</dd>';
					echo '</dl>';
				}

				if(sizeof($json->spoken_languages) != 0)
				{
					echo '<dl class="dl-horizontal">';
					echo '<dt><strong>Spoken Language</strong></dt>';
					echo '<dd>';

					$flag = false; 
					foreach($json->spoken_languages as $lang)
					{
						if($flag)
							echo ', ';
						echo $lang->name; 
						$flag = true;
					}

					echo '</dd>';
					echo '</dl>';
				}

				if(isset($json->status))
				{
					echo '<dl class="dl-horizontal">';
					echo '<dt><strong>Status</strong></dt>';
					echo '<dd>';
					echo $json->status;
					echo '</dd>';
					echo '</dl>';
				}

				if(isset($json->popularity))
				{
					echo '<dl class="dl-horizontal">';
					echo '	<dt><strong>Popularity</strong></dt>';
					echo '	<dd>';
					echo $json->popularity;
					echo '</dd>';
					echo '</dl>';
				}

				if($json->budget != 0)
				{
					echo '<dl class="dl-horizontal">';
					echo '	<dt><strong>Budget</strong></dt>';
					echo '	<dd>';
					echo number_format($json->budget, 2, ',', '.');
					echo '</dd>';
					echo '</dl>';
				}

				if($json->revenue != 0)
				{
					echo '<dl class="dl-horizontal">';
					echo '	<dt><strong>Revenue</strong></dt>';
					echo '	<dd>';
					echo number_format($json->revenue, 2, ',', '.');
					echo '</dd>';
					echo '</dl>';
				}

				if($json->homepage != "")
				{
					echo '<dl class="dl-horizontal">';
					echo '	<dt><strong>Homepage</strong></dt>';
					echo '	<dd><a href="';
					echo $json->homepage;
					echo '">';
					echo $json->homepage;
					echo '</a></dd>';
					echo '</dl>';
				}

				if(sizeof($json->production_companies) != 0)
				{
					echo '<dl class="dl-horizontal">';
					echo '	<dt><strong>Production Company</strong></dt>';

					foreach($json->production_companies as $company)
					{
						echo '<dd>';
						echo $company->name;
						echo '</dd>';
					}
					echo '</dl>';
				}

				if(sizeof($json->production_countries) != 0)
				{

					echo '<dl class="dl-horizontal">';
					echo '<dt><strong>Prodcution Country</strong></dt>';

					foreach($json->production_countries as $country)
					{
						echo '<dd>';
						echo $country->name; 
						echo '</dd>';
					}
					echo '</dl>';
				}


				?>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Overview</h4>
				</div>
				<div class="modal-body">
					<p class="text-justify"><?php echo $json->overview; ?></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
	<!-- End -->
</body>
</html>
