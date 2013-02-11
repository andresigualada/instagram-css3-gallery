<?php
	require_once('configuration.php');
	require('InstagramUser.php');
	
	if(isset($_GET['username']) && !empty($_GET['username']))
		$username = $_SESSION['username'] = $_GET['username'];
	elseif(isset($_SESSION['username']) && !empty($_SESSION['username']))
		$username = $_SESSION['username'];
	else
		$username = 'instagram';
	
	if(isset($_GET['pics']) && ((int)$_GET['pics'] !== 0))
		$pics = $_SESSION['pics'] = (int)$_GET['pics'];
	elseif(isset($_SESSION['pics']) && ((int)$_SESSION['pics'] !== 0))
		$pics = (int)$_SESSION['pics'];
	else
		$pics = 12;
		
	if(isset($_GET["ppr"]) && (int)$_GET['ppr'] != 0) {
		$ppr = round((100 / (int)$_GET['ppr']), 3);
		$ppr_display = $_SESSION['ppr'] = (int)$_GET['ppr'];
	}
	elseif(isset($_SESSION["ppr"]) && (int)$_SESSION['ppr'] != 0) {
		$ppr = round((100 / (int)$_SESSION['ppr']), 3);
		$ppr_display = (int)$_SESSION['ppr'];
	}
	else {
		$ppr = 25;
		$ppr_display = 4;
	}

	$user = new InstagramUser($username, $pics, $ppr_display);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>@<?php echo $user->name; ?> CSS3 Test Gallery</title>
		<meta charset="UTF-8" />
		
		<!--[if lte IE 8]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="stylesheet" href="css/reset.css" />
		<link rel="stylesheet" href="css/style.css" />
		<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>-->
		<style type="text/css">
			div.gallery > dl {
				width: <?php echo $ppr; ?>% !important;
			}
			<?php if($ppr_display == 1): ?>
			.gallery .thumb .caption {
				font-size: 20px !important;
				margin-top: 88%;
				margin-bottom: 2%;
			}
			<?php endif; ?>
		</style>
		
		<?php require_once('analytics.php'); ?>
	</head>
	
	<body>
	
		<header>
			<div class="user">
				<form action="index.php" method="get">
					<div class="input_wrapper">
						<h1>@</h1><input id="username" name="username" type="text" value="<?php echo $user->name; ?>" onfocus="if(this.value == '<?php echo $username;?>') this.value = '';" onblur="if(this.value == '') this.value = '<?php echo $username;?>';" />
					</div>
					<div class="input_wrapper">
						<h1>#Pics</h1><input name="pics" type="text" value="<?php echo $user->pics; ?>" onfocus="if(this.value == '<?php echo $user->pics;?>') this.value = '';" onblur="if(this.value == '') this.value = '<?php echo $user->pics;?>';" />
					</div>
					<div class="input_wrapper">
						<h1>#Pics|Row</h1><input name="ppr" type="text" value="<?php echo $ppr_display; ?>" onfocus="if(this.value == '<?php echo $ppr_display;?>') this.value = '';" onblur="if(this.value == '') this.value = '<?php echo $ppr_display;?>';" />
					</div>
					
					<div class="input_wrapper"><button>Search!</button></div>
				</form>
			</div>
		</header>
		
		<div id="main" class="wrapper">
			<div class="gallery">
				
				<?php
				
				$instagram = $user->images;
				
				foreach ($instagram as $img) {
					if($ppr_display == 1)
						$foto = $img->img;
					else
						$foto = $img->low;
					echo "<dl>";
						echo "<div class='thumb'>";
							echo "<div class='page right'>";
								echo "<img src='".$img->prev->low."' alt='' />";
							echo "</div>";
							
							echo "<div class='page left'>";
								echo "<img src='".$img->next->low."' alt='' />";
							echo "</div>";
							
							echo "<div class='page principal'>";
								echo "<a href='".$img->img."' target='_blank'><img src='".$foto."' alt='' /></a>";
							echo "</div>";
							
							$caption = (strlen($img->caption) > 30) ? substr($img->caption,0,27).'...' : $img->caption;
							
							echo "<span class='caption bold' title='".$img->caption."'>".$caption."</span>";
							echo "<br />";
							echo "<span class='caption date italic'>".$img->time."</span>";
						echo "</div>";
					echo "</dl>";
				}
				
				?>
				
			</div>
		</div>
		
		<footer>
			<h2>@<?php echo $user->name; ?></h2>
		</footer>
	
	</body>
</html>