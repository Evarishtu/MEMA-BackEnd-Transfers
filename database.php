// sync test

<?php 
class Database{
    private $host = "locahost";
    private $db_nombre = "wordpress5";
    private $username = "wordpress5";
    private $password = "2ZNG53TdCa0oLpvp";
    public $conexion;

    public function connect(){
        $this->conexion = null;
        try{
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->db_nombre};charset=utf8",
                $this->username,
                $this->password
            );
        
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexión" . $e->getMessage();
        }
        return $this->conexion;
    }
}