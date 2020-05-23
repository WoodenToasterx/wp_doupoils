<?php 
/**
 * Template name: calendar
 */
get_header();
quality_breadcrumbs();
require_once('pdo_class.php');
?>

<?php 

$pdo = PDO2::getInstance();

$req = $pdo->prepare("SELECT
FEATURE_ID
,FEATURE_LIB
FROM doupoils_wordpress.wp_feature");

$req->execute();

$features = $req->fetchAll(PDO::FETCH_ASSOC);

$req = $pdo->prepare("SELECT
DISTINCT(PRESTATIONTEMPLATE_HAIR)
FROM doupoils_wordpress.wp_prestationtemplate");

$req->execute();

$hairs = $req->fetchAll(PDO::FETCH_ASSOC);

$req = $pdo->prepare("SELECT
DISTINCT(PRESTATIONTEMPLATE_SIZE)
FROM doupoils_wordpress.wp_prestationtemplate");

$req->execute();

$sizes = $req->fetchAll(PDO::FETCH_ASSOC);

?>

<head>
	<link href='../packages_fullcalendar/core/main.css' rel='stylesheet' />
	<link href='../packages_fullcalendar/daygrid/main.css' rel='stylesheet' />
	<link href='../packages_fullcalendar/timegrid/main.css' rel='stylesheet' />
	<link href='../packages_fullcalendar/interaction/main.css' rel='stylesheet' />

	<script src='../packages_fullcalendar/core/main.js'></script>
	<script src='../packages_fullcalendar/daygrid/main.js'></script>
	<script src='../packages_fullcalendar/timegrid/main.js'></script>
	<script src='../packages_fullcalendar/interaction/main.js'></script>
	<script src='../packages_fullcalendar/core/locales/fr.js'></script>
</head>


<script>
document.addEventListener('DOMContentLoaded', function() {

        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
			plugins: [ 'interaction', 'timeGrid'],
			locale: 'fr',
			firstDay: 1,
			timeFormat: 'H(:mm)',
			displayEventEnd: true,
			allDaySlot: false,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'timeGridWeek'
			},
			businessHours: {
				daysOfWeek: [ 1, 2, 3, 4, 5, 6 ], // Monday - Thursday
				startTime: '08:00', // a start time (10am in this example)
				endTime: '18:00', // an end time (6pm in this example)
			},
			minTime: '07:00',
			maxTime: '20:00',
			dateClick: function(info) {

				var dateSelected = new Date(info.dateStr);

				var date = new Date(dateSelected);

				if(date.getDay() != 0)
				{
					if(date.getHours() >= 08 && date.getHours() < 18)
					{	
						jQuery('#inputDate').val(dateSelected.toLocaleDateString("fr-FR"));
						jQuery('#inputTime').val(dateSelected.toLocaleTimeString("fr-FR"));
						jQuery('#exampleModal').modal('show');
					}
					else
					{
						alert('Désolé, veuillez selectionner un rendez-vous pendant les horaires douvertures');
					}
				}
				else
				{
					alert('Désolé, veuillez selectionner un rendez-vous pendant les horaires douvertures');
				}
				
			},
			eventSources: [{
				url: '../json_calendar.php',
				method: 'POST',
				failure: function() {
					alert('there was an error while fetching events!');
				}
			}],
			eventTimeFormat: { // like '14:30:00'
				hour: '2-digit',
				minute: '2-digit',
				meridiem: false
			},
			eventColor: '#42bb11',
        });

        calendar.render();
      });
</script>

<section id="section-block" class="site-content">
	<div class="container">
		<div class="row">	
			<!--Blog Section-->

			<div id='calendar'></div>
			
			<div class="reserver">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Réserver !</button>
			</div>

		<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">

						<div class="modal-header">

							<h5 class="modal-title" id="exampleModalLabel">Prendre Rendez-vous</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body">

							<form method="post">

								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="inputName">Nom</label>
										<input type="text" class="form-control" id="inputName" name="inputName" placeholder="nom" required>
									</div>

									<div class="form-group col-md-6">
										<label for="inputFirstName">Prénom</label>
										<input type="text" class="form-control" id="inputFirstName" name="inputFirstName" placeholder="prénom" required>
									</div>
								</div>

								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="inputEmail">E-mail</label>
										<input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="exemple@exemple.com" required>
									</div>

									<div class="form-group col-md-6">
										<label for="inputPhone">Téléphone</label>
										<input type="text" class="form-control" id="inputPhone" name="inputPhone" placeholder="00 00 00 00 00" required>
									</div>
								</div>

								<br />
								<hr/> 
	  						

								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="inputDate">Date</label>
										<input type="text" class="form-control" id="inputDate" name="inputDate" placeholder="date du rdv (jj/mm/yyyy)" required>
									</div>

									<div class="form-group col-md-6">
										<label for="inputTime">Heure</label>
										<input type="text" class="form-control" id="inputTime" name="inputTime" placeholder="heure du rdv (hh:mm)" required>
									</div>
								</div>

								<div class="form-row">
									<div class="form-group col-md-6">
									<label for="inputSize">Taille du chien</label>
										<select id="inputSize" name="inputSize" class="form-control" required>
										<?php
											foreach($sizes as $size)
											{
												echo '<option value="'.$size['PRESTATIONTEMPLATE_SIZE'].'">'.$size['PRESTATIONTEMPLATE_SIZE'].'</option>';
											}
										?>
										</select>
									</div>

									<div class="form-group col-md-6">
									<label for="inputHair">Type de poil</label>
										<select id="inputHair" name="inputHair" class="form-control" required>
										<?php 
											foreach($hairs as $hair)
											{
												echo '<option value="'.$hair['PRESTATIONTEMPLATE_HAIR'].'">'.$hair['PRESTATIONTEMPLATE_HAIR'].'</option>';
											}
										?>
										</select>
									</div>
								</div>

								<div class="form-row">
									<div class="form-check form-check-inline" style="text-align: center;">

									<?php 
										foreach($features as $feature)
										{
											echo '<input class="form-check-input" type="checkbox" id="inputPuce" name="inputCheckboxes[]" value="'.$feature['FEATURE_ID'].'">';
											echo '<label class="form-check-label" for="inputPuce" style="margin-right:10px;">'.$feature['FEATURE_LIB'].'</label>';
										}
									?>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" id="submit" name="submit" class="btn btn-primary">Save changes</button>
								</div>

							</form>

						</div>

					</div>
				</div>
			</div>
			
			<!--/Blog Section-->
		</div>
	</div>
</section>
		
<?php
if(isset($_POST['submit']))
{
	$pdo->beginTransaction();

	$name = $_POST['inputName'];
	$firstname = $_POST['inputFirstName'];
	$email = $_POST['inputEmail'];
	$phone = $_POST['inputPhone'];
	$size = $_POST['inputSize'];
	$hair = $_POST['inputHair'];
	$checkboxes = $_POST['inputCheckboxes'];
	$date = $_POST['inputDate'];
	$time = $_POST['inputTime'];

	$dateTime = $date.' '.$time;

	$dateTime = str_replace("/","-",$dateTime);
	$startDate = new DateTime($dateTime);
	$startDate = $startDate->format('Y-m-d H:i:s');

	$req = $pdo->prepare("SELECT 
	 PRESTATIONTEMPLATE_HAIR
	,PRESTATIONTEMPLATE_SIZE  
	,SUM(PRESTATIONTEMPLATE_HYGIENE + PRESTATIONTEMPLATE_SHAMPOO + PRESTATIONTEMPLATE_DRYING + PRESTATIONTEMPLATE_DISENTANGLING) AS NBMINUTE
	,PRESTATIONTEMPLATE_PRICE
	FROM doupoils_wordpress.wp_prestationtemplate
	WHERE PRESTATIONTEMPLATE_SIZE = :SIZE
	AND PRESTATIONTEMPLATE_HAIR = :HAIR");

	$req->bindValue(":SIZE", $size);
	$req->bindValue(":HAIR", $hair);

	$req->execute();

	$prestation = $req->fetch(PDO::FETCH_ASSOC);

	//calcul duré + prix

	$query = "SELECT 
	SUM(FEATURETEMPLATE_DURATION) as duration
	,SUM(FEATURETEMPLATE_PRICE) as price
	FROM doupoils_wordpress.wp_featuretemplate
	WHERE FEATURE_ID IN (";

	foreach($checkboxes as $checkbox)
	{
		$query .= '?,';
	}
	$query = substr($query, 0, -1);
	$query.= ")";

	$req = $pdo->prepare($query);

	$i = 1;

	foreach($checkboxes as $checkbox)
	{
		$req->bindValue($i, $checkbox);
		$i++;
	}

	$req->execute();

	$feature = $req->fetch(PDO::FETCH_ASSOC);

	$price = $prestation['PRESTATIONTEMPLATE_PRICE'] + $feature['price'];

	$time = $prestation['NBMINUTE'] + $feature['duration'];

	$req = $pdo->prepare("SELECT MEMBER_ID 
	from doupoils_wordpress.wp_member
	WHERE MEMBER_MAIL = :MAIL");

	$req->bindValue(":MAIL", $email);
	$req->execute();

	$memberId = 0;

	try
	{
		if($req->rowCount() == 0)
		{
			$req2 = $pdo->prepare("INSERT INTO doupoils_wordpress.wp_member
			(MEMBER_NAME
			,MEMBER_FIRSTNAME
			,MEMBER_MAIL)
			VALUES
			(:MEMBER_NAME
			,:MEMBER_FIRSTNAME
			,:MEMBER_MAIL)");

			$req2->bindValue(":MEMBER_NAME", $name);
			$req2->bindValue(":MEMBER_FIRSTNAME", $firstname);
			$req2->bindValue(":MEMBER_MAIL", $email);

			$req2->execute();

			$memberId = $pdo->lastInsertId();
		}
		else
		{
			$memberId = $req->fetch(PDO::FETCH_COLUMN);
		}

		$req = $pdo->prepare("INSERT INTO doupoils_wordpress.wp_appointment
		(APPOINTMENT_START
		,APPOINTMENT_DURATION
		,APPOINTMENT_PRICE
		,MEMBER_ID
		,PRESTATIONTEMPLATE_HAIR
		,PRESTATIONTEMPLATE_SIZE
		,PRESTATIONTEMPLATE_VERSION)
		VALUES
		(:APPOINTMENT_START
		,:APPOINTMENT_DURATION
		,:APPOINTMENT_PRICE
		,:MEMBER_ID
		,:PRESTATIONTEMPLATE_HAIR
		,:PRESTATIONTEMPLATE_SIZE
		,1)");

		$req->bindValue(":APPOINTMENT_START", $startDate);
		$req->bindValue(":APPOINTMENT_DURATION", $time);
		$req->bindValue(":APPOINTMENT_PRICE", $price);
		$req->bindValue(":MEMBER_ID", $memberId);
		$req->bindValue(":PRESTATIONTEMPLATE_HAIR", $hair);
		$req->bindValue(":PRESTATIONTEMPLATE_SIZE", $size);

		$req->execute();

		$lastAppointment = $pdo->lastInsertId();

		foreach($checkboxes as $checkbox)
		{
			$req = $pdo->prepare("INSERT INTO doupoils_wordpress.wp_have
			(APPOINTMENT_ID
			,FEATURE_ID
			,FEATURETEMPLATE_VERSION)
			VALUES
			(:APPOINTMENT_ID
			,:FEATURE_ID
			,1)");

			$req->bindValue(":APPOINTMENT_ID", $lastAppointment);
			$req->bindValue(":FEATURE_ID", $checkbox);
			$req->execute();
		}

		$pdo->commit();
	}
	catch(PDOException $e)
	{
		if($pdo->inTransaction())
		{
			$pdo->rollback();
		}

		$fp = fopen("pdoError.txt", 'a');
		$errorString = $e;
		fwrite($fp, $errorString);
		fclose($fp);
	}
}
get_footer();
?>