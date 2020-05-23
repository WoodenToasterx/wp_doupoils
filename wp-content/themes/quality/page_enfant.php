<?php 
/**
 * Template name: prestation
 */
get_header();
quality_breadcrumbs();
require_once('pdo_class.php');

?>
<section id="section-block" class="site-content">
	<div class="container">
		<div class="row">	

			<h2> POIL RAS </h2>
			<div class="row">	

			<?php 
				$pdo = PDO2::getInstance();	

				$req = $pdo->prepare("SELECT
					PRESTATIONTEMPLATE_HAIR
					,PRESTATIONTEMPLATE_SIZE
					,PRESTATIONTEMPLATE_VERSION
					,PRESTATIONTEMPLATE_HYGIENE
					,PRESTATIONTEMPLATE_DISENTANGLING
					,PRESTATIONTEMPLATE_SHAMPOO
					,PRESTATIONTEMPLATE_DRYING
					,PRESTATIONTEMPLATE_PRICE
				FROM
					wp_prestationtemplate
				WHERE
					PRESTATIONTEMPLATE_HAIR = 'RAS'"); 

				$req->execute();

				while($res = $req->fetch(PDO::FETCH_ASSOC))
				{
				?>

				<div class="prestation col">
					<div class="card bg-light mb-3 custom-card-border">
						<div class="card-header text-center custom-card-header"> 
							<?php 
								switch ($res['PRESTATIONTEMPLATE_SIZE'])
								{
									case 'TPETIT': 
										echo 'Très petit';
										break;
									case 'PETIT':
										echo 'Petit';
										break;
									case 'MOYEN':
										echo 'Moyen';
										break;
									case 'GRAND':
										echo 'Grand';
										break;
									case 'TGRAND':
										echo 'Très grand';
										break;
								} 
							?>
						</div>
						<div class="card-body">
							<p class="card-text">Hygiène : <?php echo $res['PRESTATIONTEMPLATE_HYGIENE'] ?> mn<br/>
							Shampoing : <?php echo $res['PRESTATIONTEMPLATE_SHAMPOO'] ?> mn<br />
							Séchage : <?php echo $res['PRESTATIONTEMPLATE_DRYING'] ?> mn<br />
							</p>
						</div>
						<div class="card-footer text-muted custom-card-footer">
							<?php echo $res['PRESTATIONTEMPLATE_PRICE'].' €' ?>
						</div>
					</div>
				</div>

				<?php
				}
				?>

			</div>

			<br />
			<hr class="featurette-divider separator-prestation">
			<br />
			<h2> POIL MI-LONG </h2>
			<div class="row">	

			<?php 
				$pdo = PDO2::getInstance();	

				$req = $pdo->prepare("SELECT
					PRESTATIONTEMPLATE_HAIR
					,PRESTATIONTEMPLATE_SIZE
					,PRESTATIONTEMPLATE_VERSION
					,PRESTATIONTEMPLATE_HYGIENE
					,PRESTATIONTEMPLATE_DISENTANGLING
					,PRESTATIONTEMPLATE_SHAMPOO
					,PRESTATIONTEMPLATE_DRYING
					,PRESTATIONTEMPLATE_PRICE
				FROM
					wp_prestationtemplate
				WHERE
					PRESTATIONTEMPLATE_HAIR = 'MILONG'"); 

				$req->execute();

				while($res = $req->fetch(PDO::FETCH_ASSOC))
				{
				?>

				<div class="prestation col">
					<div class="card bg-light mb-3 custom-card-border">
						<div class="card-header text-center custom-card-header"> 
							<?php 
								switch ($res['PRESTATIONTEMPLATE_SIZE'])
								{
									case 'TPETIT': 
										echo 'Très petit';
										break;
									case 'PETIT':
										echo 'Petit';
										break;
									case 'MOYEN':
										echo 'Moyen';
										break;
									case 'GRAND':
										echo 'Grand';
										break;
									case 'TGRAND':
										echo 'Très grand';
										break;
								} 
							?>
						</div>
						<div class="card-body">
							<p class="card-text">Hygiène : <?php echo $res['PRESTATIONTEMPLATE_HYGIENE'] ?> mn<br/>
							Shampoing : <?php echo $res['PRESTATIONTEMPLATE_SHAMPOO'] ?> mn<br />
							Séchage : <?php echo $res['PRESTATIONTEMPLATE_DRYING'] ?> mn<br />
							</p>
						</div>
						<div class="card-footer text-muted custom-card-footer">
							<?php echo $res['PRESTATIONTEMPLATE_PRICE'].' €' ?>
						</div>
					</div>
				</div>

				<?php
				}
				?>

			</div>

			<br />
			<hr class="featurette-divider separator-prestation">
			<br />
			<h2> POIL LONG </h2>
			<div class="row">	

			<?php 
				$pdo = PDO2::getInstance();	

				$req = $pdo->prepare("SELECT
					PRESTATIONTEMPLATE_HAIR
					,PRESTATIONTEMPLATE_SIZE
					,PRESTATIONTEMPLATE_VERSION
					,PRESTATIONTEMPLATE_HYGIENE
					,PRESTATIONTEMPLATE_DISENTANGLING
					,PRESTATIONTEMPLATE_SHAMPOO
					,PRESTATIONTEMPLATE_DRYING
					,PRESTATIONTEMPLATE_PRICE
				FROM
					wp_prestationtemplate
				WHERE
					PRESTATIONTEMPLATE_HAIR = 'LONG'"); 

				$req->execute();

				while($res = $req->fetch(PDO::FETCH_ASSOC))
				{
				?>

				<div class="prestation col">
					<div class="card bg-light mb-3 custom-card-border">
						<div class="card-header text-center custom-card-header"> 
							<?php 
								switch ($res['PRESTATIONTEMPLATE_SIZE'])
								{
									case 'TPETIT': 
										echo 'Très petit';
										break;
									case 'PETIT':
										echo 'Petit';
										break;
									case 'MOYEN':
										echo 'Moyen';
										break;
									case 'GRAND':
										echo 'Grand';
										break;
									case 'TGRAND':
										echo 'Très grand';
										break;
								} 
							?>
						</div>
						<div class="card-body">
							<p class="card-text">Hygiène : <?php echo $res['PRESTATIONTEMPLATE_HYGIENE'] ?> mn<br/>
							Shampoing : <?php echo $res['PRESTATIONTEMPLATE_SHAMPOO'] ?> mn<br />
							Séchage : <?php echo $res['PRESTATIONTEMPLATE_DRYING'] ?> mn<br />
							</p>
						</div>
						<div class="card-footer text-muted custom-card-footer">
							<?php echo $res['PRESTATIONTEMPLATE_PRICE'].' €' ?>
						</div>
					</div>
				</div>

				<?php
				}
				?>

			</div>


		</div>
			
			
			<!--/Blog Section-->
		
	</div>
</section>
		
<?php
get_footer();
?>