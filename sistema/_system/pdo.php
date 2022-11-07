<?php
/////////////////////////////////////////////////////////////////////////////////////////////////
// Classe de conexao com o banco de dados

// $id = '';
// $PDO = new DB();
// $exec = $PDO->comando("SELECT * FROM layout_paginas WHERE id=:id ORDER BY id asc");
// $exec->bindValue(":id",$id);
// $exec->execute();
// while($data = $exec->fetch(PDO::FETCH_ASSOC)){
//  echo $data['id']."<br>";
// }

Class DB{
    
    private $connection = NULL;
    private static $_instance = NULL;
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    private function __clone(){

    }
    public function getConnection($db_host, $db_name, $db_user, $db_pass)
    {
        $con_name = $db_host . "_" . $db_name;
        try {
            if (!isset($this->connection[$con_name])) {
                $this->connection[$con_name] = new PDO("mysql:host=" . $db_host . ";dbname=" . $db_name . ";charset=utf8", $db_user, $db_pass, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_TIMEOUT => 5));
                $this->connection[$con_name]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (PDOException $e) {
            if (debugEnabled()) {
                exit("Erro de conexão: " . $e->getMessage());
            }
            return NULL;
        } catch (Exception $d) {
            if (debugEnabled()) {
                exit("Erro de conexão: " . $d->getMessage());
            }
            return NULL;
        }
        return $this->connection[$con_name];
    }
    public function comando($sql){
        $exec = $this->getInstance()->getConnection(SERVIDOR, BANCO, USUARIO, SENHA);
        return $exec->prepare($sql);
    } 
}