<?php 

require_once('pdo_class.php');


try {
        
    $pdo = PDO2::getInstance();	

    $req = $pdo->prepare("SELECT * FROM doupoils_wordpress.wp_appointment");

    $req->execute();

    $events = array();

    while($res = $req->fetch(PDO::FETCH_ASSOC))
    {
        $events[] = array("start" => $res['APPOINTMENT_START'],
                        "title" => "Lorem Ipsum");
    }

    return json_encode($events);
}
catch (PDOException $e)
{
        echo $e->getMessage();
}


?>