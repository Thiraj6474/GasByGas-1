<?php
// class DatabaseConn {
// 	public $host="localhost";
// 	protected $database= "gasdelivery";
// 	private   $user="root";
// 	private   $pass="";
// 	public    $conn;

// 	public function connection() {
// 		try {
// 			$dsn = "mysql:host=$this->host; dbname=$this->database";
// 			$this->conn = new PDO($dsn, $this->user, $this->pass);
// 			return $this->conn;
// 		} catch(PDOException $error) {
// 			echo "ERROR OCCURED ".$error->getMessage();
// 		}
// 	}
// }


class DatabaseConn {
    public $host = "LAPTOP-B5N7R5FI\SQLEXPRESS";  // Server name and instance
    protected $database = "gasdelivery";          // Database name
    private $user = "";                           // SQL username (leave blank if using Windows Authentication)
    private $pass = "";                           // SQL password (leave blank if using Windows Authentication)
    public $conn;

    public function connect() {
        // Use PDO to connect to SQL Server
        try {
            $dsn = "sqlsrv:Server=$this->host;Database=$this->database"; // DSN format for SQLSRV
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            
            // Set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully"; 
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}





// class DatabaseConn {
//     public $host = "LAPTOP-B5N7R5FI\SQLEXPRESS";  
//     protected $database = "gasdelivery";
//     private $user = "";  
//     private $pass = "";  
//     public $conn;

//     public function connection() {
//         try {
//             $dsn = "sqlsrv:Server=$this->host;Database=$this->database";
//             $this->conn = new PDO($dsn, $this->user, $this->pass);
//             $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//             return $this->conn;
//         } catch (PDOException $error) {
//             echo "ERROR OCCURRED: " . $error->getMessage();
//         }
//     }
// }

?>