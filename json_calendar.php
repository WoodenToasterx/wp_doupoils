<?php 

class PDO2 extends PDO 
{
	private static $SQL_DNS = 'mysql:dbname=doupoils_wordpress;host=127.0.0.1';
    private static $SQL_USERNAME = 'root';
    private static $SQL_PASSWORD = '';
    
    private static $instance;
    public function __construct() { }

    public static function getInstance()
    {
        if(!isset(self::$instance)){
            try{
                self::$instance = new \PDO(
                    self::$SQL_DNS,
                    self::$SQL_USERNAME,
                    self::$SQL_PASSWORD);
            }
            catch (Exception $e){
                $fp = fopen("pdoError.txt", 'a');
                $errorString = "[" . date("Y-m-d H:i:s") . "] [" . $_SERVER['REMOTE_ADDR'] . "] [" . gethostbyaddr($_SERVER['REMOTE_ADDR']) . "] [" . $_SERVER['PHP_SELF'] . " ] " . $e->getMessage() . "\n";
                fwrite($fp, $errorString);
                fclose($fp);
                die('HTTP/1.0 500 Internal Server Error');
            }
        }
        return self::$instance;
    }

}
try {
        
    $pdo = PDO2::getInstance();	

    $req = $pdo->prepare("SELECT * FROM doupoils_wordpress.wp_appointment");

    $req->execute();

    $events = array();

    while($res = $req->fetch(PDO::FETCH_ASSOC))
    {

        $dateDebut = new \DateTime($res['APPOINTMENT_START']);

        $heureDebut = $dateDebut->format('H:i:s');
        
        $heuredeFin = HeureDeFinEstimee($res['APPOINTMENT_DURATION'],$heureDebut);

        $date = $dateDebut->format('Y-m-d');

        $end = $date." ".$heuredeFin;

        $events[] = array("start" => $res['APPOINTMENT_START'],
                         "title" => "Rendez-vous",
                         "end" => $end);
    }

    echo json_encode($events);
}
catch (PDOException $e)
{
        echo $e->getMessage();
}

function HeureDeFinEstimee($tempsPrestation, $heureDebut)
{
    $minutePrestation = $tempsPrestation % 60;
    $hourPrestation = floor($tempsPrestation/60);

    $heureCalcul = explode(":", $heureDebut);

    $heureFinale = $hourPrestation + intval($heureCalcul[0]);
    $minuteFinale = $minutePrestation + intval($heureCalcul[1]);

    $heureFinale = floor($minuteFinale/60) + $heureFinale;
    $minuteFinale = $minuteFinale%60;

    
    if(strlen($heureFinale) < 2)
        $heureFinale = "0{$heureFinale}";

    if(strlen($minuteFinale) < 2)
        $minuteFinale = "0{$minuteFinale}";

    // if(strlen($second) < 2)
    //     $second = "0{$second}";

    return $heureFinale.":".$minuteFinale.":00";
}
?>