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
			catch (Exception $e)
			{
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

?>