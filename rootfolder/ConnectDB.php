 <?php

  class Database{
    private $host = 'localhost';
    private $db_name = 'project_db';
    private $dbusername = 'root';
    private $dbpassword = 'AchillesHeel';
    private $con;

    public function connect(){
      $this -> con = null;

      try{
        $this->con = new PDO('mysql:host=' .$this->host . ';dbname=' . $this->db_name, $this->dbusername, $this->dbpassword);
        $this->con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch(PDOException $e){
        echo 'Connection Error: ' . $e->getMessage();
      }
      return $this->con;
    }
  }
   
?>