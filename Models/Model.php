<?php
abstract class Model
{
    private $host = "localhost";
    private $user = "root";
    private $password = '1234';
    private $bd_name = 'db_cuponera';
    protected $conn;

    protected function open_db()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->bd_name;charset=utf8", $this->user, $this->password);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    protected function close_db()
    {
        $this->conn = null;
    }

    protected function get_query($query, $params = array())
    {
        try {
            $this->open_db();
            $stm = $this->conn->prepare($query);
            $stm->execute($params);
            while ($rows[] = $stm->fetch(PDO::FETCH_ASSOC)); //resultados como array asociativo
            array_pop($rows); //elimino el ultimo dato
            $this->close_db();
            return $rows;
        } 
        catch (PDOException $e) {
            $this->close_db();
            return [];
        }
    }
}
?>