<?php


class Bd {



     

private static ?Bd $instance = null;

    
     

private ?PDO $pdo;

     

  private function __construct(){
    $dsn = 'mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=eclemence001_bd;charset=utf8';
    $username = 'eclemence001_bd';
    $password = 'eclemence001_bd';
      try {$this->pdo = new PDO($dsn, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);}
      catch(PDOException $e){

            die('Connexion à la base de données échouée : ' . $e->getMessage());
        }
    }


     


public function getConnexion(): PDO{
    return $this->pdo;}


     
    public static function getInstance(): Bd{
        if (self::$instance == null){
            self::$instance = new Bd();
        }
        return self::$instance;
    }

public function __wakeup(){
    throw new Exception("Un singleton ne doit pas être deserialisé");}

}

