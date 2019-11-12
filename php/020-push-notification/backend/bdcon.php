<?php


class DBConnection{
  private $pdo;
  
  public function connect(){
    if($this->pdo == null){
      try{
        $this->pdo = new \PDO("sqlite:db.db");
      } catch (\PDOException $e) {
        // handle the exception here
        $this->pdo = "PDOException - {$e->getMessage()}";
     }
      
    }
    
    return $this->pdo;
  }
  
  public function close(){
    $this->pdo = null;
  }
}