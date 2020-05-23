<?php 
/**
 * Template name: calendar_admin
 */
get_header();
quality_breadcrumbs();
require_once('pdo_class.php');

?>

<!-- <script>

jQuery(document).ready(function(){
    jQuery('.export').click(function(){
        var clickbtn = jQuery(this).val();
        var ajaxurl = '../export_calendar.php', data = {'action': clickbtn};
        jQuery.post(ajaxurl, data, function(response)
        {
            alert('Tout est ok');
        });
    });
});

</script> -->

<section id="section-block" class="site-content">
	<div class="container">
		<div class="row">	
			<!--Blog Section-->

            <form method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputStartDate">Date de début </label>
                        <input type="date" class="form-control" id="inputStartDate" name="inputStartDate">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEndDate">Date de fin</label>
                        <input type="date" class="form-control" id="inputEndDate" name="inputEndDate">
                    </div>
                </div>

                <div class="export" style="text-align:center;">
                    <button type="submit" class="btn btn-primary" id="submit" name="submit">Export</button>
                </div>
            </form>
            <br />

            <?php 

            $pdo = PDO2::getInstance();

            $req = $pdo->prepare("SELECT * from doupoils_wordpress.wp_appointment
            ORDER BY APPOINTMENT_START");

            $req->execute();

            //$appointments = $req->fetchAll(PDO::FETCH_ASSOC);

            while($res = $req->fetch(PDO::FETCH_ASSOC))
            {

            ?>

            <div class="prestation col">
                <div class="card bg-light mb-3">
                    <div class="card-header text-center"> 
                        <?php echo $res['APPOINTMENT_START'] ?>
                    </div>
                        <div class="card-body">
                            <p class="card-text">Durée : <?php echo $res['APPOINTMENT_DURATION'] ?> mn<br/>
                                Prix : <?php echo $res['APPOINTMENT_PRICE'] ?>€<br />
                            </p>
                        </div>
                </div>
            </div>

            <?php
            }
            ?>

			<!--/Blog Section-->
		</div>
	</div>
</section>
		
 <?php

 if(isset($_POST['submit']))
 {
     var_dump($_POST['inputStartDate']);
     var_dump(empty($_POST['inputEndDate']));

    $query = "SELECT
     APPOINTMENT_START as startdate
    ,APPOINTMENT_DURATION as duration
    ,APPOINTMENT_PRICE as price
    ,PRESTATIONTEMPLATE_SIZE as size
    ,PRESTATIONTEMPLATE_HAIR as hair
    ,MEMBER_NAME as name
    ,MEMBER_FIRSTNAME as firstname
    ,MEMBER_MAIL as mail
    ,GROUP_CONCAT(FEATURE_LIB SEPARATOR ',') as features
    FROM doupoils_wordpress.wp_appointment
    LEFT JOIN doupoils_wordpress.wp_have
    ON wp_appointment.APPOINTMENT_ID = wp_have.APPOINTMENT_ID
    LEFT JOIN doupoils_wordpress.wp_featuretemplate
    ON wp_have.FEATURE_ID = wp_featuretemplate.FEATURE_ID
    LEFT JOIN doupoils_wordpress.wp_feature
    ON wp_featuretemplate.FEATURE_ID = wp_feature.FEATURE_ID
    LEFT JOIN doupoils_wordpress.wp_member
    ON wp_appointment.MEMBER_ID = wp_member.MEMBER_ID";

    if(isset($_POST['inputStartDate']) && !empty($_POST['inputStartDate']) && isset($_POST['inputEndDate']) && !empty($_POST['inputEndDate']))
    {
        $query .= " WHERE APPOINTMENT_START > :STARTDATE AND APPOINTMENT_START < :ENDDATE";
    }
    else if(isset($_POST['inputStartDate']) && !empty($_POST['inputStartDate']) && empty($_POST['inputEndDate']))
    {
        $query .= " WHERE APPOINTMENT_START > :STARTDATE";
    }
    else if(isset($_POST['inputEndDate']) && !empty($_POST['inputEndDate']) && empty($_POST['inputStartDate']))
    {
        $query .= " WHERE APPOINTMENT_START < :ENDDATE";
    }
     
    $query .= " GROUP BY APPOINTMENT_START";
    
    $pdo = PDO2::getInstance();

    $req = $pdo->prepare($query);

    if(isset($_POST['inputStartDate']) && !empty($_POST['inputStartDate']) && isset($_POST['inputEndDate']) && !empty($_POST['inputEndDate']))
    {
        $req->bindValue(":STARTDATE", $_POST['inputStartDate']);
        $req->bindValue(":ENDDATE", $_POST['inputEndDate']);
    }
    else if(isset($_POST['inputStartDate']) && !empty($_POST['inputStartDate']) && empty($_POST['inputEndDate']))
    {
        $req->bindValue(":STARTDATE", $_POST['inputStartDate']);
    }
    else if(isset($_POST['inputEndDate']) && !empty($_POST['inputEndDate']) && empty($_POST['inputStartDate']))
    {
        $req->bindValue(":ENDDATE", $_POST['inputEndDate']);
    }

    $req->execute();

    $appointments = $req->fetchAll(PDO::FETCH_ASSOC);

    
    $fp = fopen('rendezvous.csv', 'w');
    $headers = array('Subject','Start date', 'Start time', 'End date', 'End time', 'Description');

    fputcsv($fp, $headers);

    foreach($appointments as $appointment)
    {
        $dateTime = new DateTime($appointment['startdate']);
        $date = $dateTime->format('m/d/Y');
        $time = $dateTime->format('g:i A');

        $dateTime->add(new DateInterval('PT'.$appointment['duration'].'M'));

        $description = $appointment['name'].' '.$appointment['firstname'].' '.$appointment['mail'].' ['.$appointment['hair'].' - '.$appointment['size'].' - '.$appointment['features'].' ]';

        $endTime = $dateTime->format('g:i A');

        $value = array('Rendez-Vous', $date, $time, $date, $endTime, $description);
        
        fputcsv($fp, $value);
        
    }

    fclose($fp);
 }

get_footer();
?>