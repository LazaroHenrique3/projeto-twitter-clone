<?php

namespace App\Models;
use MF\Model\Model;

class Tweet extends Model{

    private $id;
    private $id_usuario;
    private $tweet;
    private $data;

    public function __get($atributo){
        return $this->$atributo;
    }

    public  function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    //Salvar 
    public function salvar(){

        $query = "INSERT INTO tweets(id_usuario, tweet) VALUES (:id_usuario, :tweet)";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':tweet', $this->__get('tweet'));
        $stmt->execute();

        return $this;
    }

    //Remover
    public function remover(){

        $query = "DELETE FROM tweets WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();

        return true;
    }

    //Recuperar
    public function getAll(){

        $query = "SELECT 
                    t.id, 
                    u.nome, 
                    t.id_usuario, 
                    t.tweet, DATE_FORMAT(t.data, '%d/%m/%y %H:%i') AS data
                FROM 
                    tweets as t
                    LEFT JOIN usuarios u ON (t.id_usuario = u.id)
                WHERE 
                    t.id_usuario = :id_usuario
                    OR t.id_usuario IN 
                    (
                        SELECT id_usuario_seguindo FROM usuarios_seguidores WHERE id_usuario = :id_usuario
                    )
                ORDER BY 
                    t.data DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue('id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //Recuperar por paginação
    public function getPorPagina($limit, $offset){

        $query = "SELECT 
                    t.id, 
                    u.nome, 
                    t.id_usuario, 
                    t.tweet, DATE_FORMAT(t.data, '%d/%m/%y %H:%i') AS data
                FROM 
                    tweets as t
                    LEFT JOIN usuarios u ON (t.id_usuario = u.id)
                WHERE 
                    t.id_usuario = :id_usuario
                    OR t.id_usuario IN 
                    (
                        SELECT id_usuario_seguindo FROM usuarios_seguidores WHERE id_usuario = :id_usuario
                    )
                ORDER BY 
                    t.data DESC
                LIMIT
                    $limit
                OFFSET
                    $offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue('id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalTweet(){

        $query = "SELECT 
                    count(*) as total
                FROM 
                    tweets as t
                    LEFT JOIN usuarios u ON (t.id_usuario = u.id)
                WHERE 
                    t.id_usuario = :id_usuario
                    OR t.id_usuario IN 
                    (
                        SELECT id_usuario_seguindo FROM usuarios_seguidores WHERE id_usuario = :id_usuario
                    )
                ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue('id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}