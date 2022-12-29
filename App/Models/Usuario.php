<?php

namespace App\Models;
use MF\Model\Model;

class Usuario extends Model{

    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __get($atributo){
        return $this->$atributo;
    }

    public  function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    // Salvar
    public function salvar(){

        $query =  "INSERT INTO usuarios(nome, email, senha) VALUES (:nome, :email, :senha)";

        $stmp = $this->db->prepare($query);
        $stmp->bindValue(':nome', $this->__get('nome'));
        $stmp->bindValue(':email', $this->__get('email'));
        $stmp->bindValue(':senha', $this->__get('senha')); //md5()

        $stmp->execute();

        //Retornando o próprio objeto
        return $this;
    }

    //Validar se o cadastro pode ser feito
    public function validarCadastro(){
        $valido = true;

        if(strlen($this->__get('nome')) < 3){
            $valido = false;
        }

        if(strlen($this->__get('email')) < 3){
            $valido = false;
        }

        if(strlen($this->__get('senha')) < 3){
            $valido = false;
        }

        return $valido;
    }

    //recuperar um usuário por e-mail
    public function getUsuarioPorEmail(){

        $query = "SELECT nome, email FROM usuarios WHERE email = :email";

        $stmp = $this->db->prepare($query);
        $stmp->bindValue(':email', $this->__get('email'));
        $stmp->execute();

        return $stmp->fetchAll(\PDO::FETCH_ASSOC);
    }

    //Realizar a autenticação
    public function autenticar(){

        $query = "SELECT id, nome, email FROM usuarios WHERE email = :email and senha = :senha";

        $stmp = $this->db->prepare($query);
        $stmp->bindValue(':email', $this->__get('email'));
        $stmp->bindValue(':senha', $this->__get('senha'));
        $stmp->execute();

        $usuario = $stmp->fetch(\PDO::FETCH_ASSOC);

        if($usuario['id'] != '' && $usuario['nome'] != ''){
            //Setar no próprio objeto
            $this->__set('id', $usuario['id']);
            $this->__set('nome', $usuario['nome']);
        }

        return $this;
    }

    public function getAll(){

        $query =  "SELECT 
                        u.id, 
                        u.nome, 
                        u.email,
                        (
                            SELECT 
                                count(*)
                            FROM 
                                usuarios_seguidores AS us
                            WHERE 
                                us.id_usuario = :id_usuario AND us.id_usuario_seguindo = u.id
                        ) AS seguindo_sn
                    FROM 
                        usuarios AS u
                    WHERE 
                        nome LIKE :nome AND id != :id_usuario";

        $stmp = $this->db->prepare($query);
        $stmp->bindValue(':nome', '%'.$this->__get('nome').'%');
        $stmp->bindValue(':id_usuario', $this->__get('id'));
        $stmp->execute();

        return $stmp->fetchAll(\PDO::FETCH_ASSOC);
    }

    //Informações do Usuário
    public function getInfoUsuario(){

        $query = "SELECT nome FROM usuarios WHERE id = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    //Total de tweets
    public function getTotalTweets(){

        $query = "SELECT count(*) AS total_tweet FROM tweets WHERE id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    //Total de usuários que estamos seguindo
    public function getTotalSeguindo(){

        $query = "SELECT count(*) AS total_seguindo FROM usuarios_seguidores WHERE id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    //total de seguidores
    public function getTotalSeguidores(){

        $query = "SELECT count(*) AS total_seguidores FROM usuarios_seguidores WHERE id_usuario_seguindo = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
?>