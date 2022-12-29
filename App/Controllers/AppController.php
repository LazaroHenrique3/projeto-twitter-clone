<?php

namespace App\Controllers;

//Recursos do Mini Framework

use App\Models\Tweet;
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action
{

    public function timeline()
    {
        $this->validaAutenticacao();
        //Recuperação dos Tweets
        $tweet = Container::getModel('Tweet');
        $tweet->__set('id_usuario', $_SESSION['id']);
 
        //Variáveis de paginação
        $total_registros_pagina = 10;
        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        $deslocamento = ($pagina - 1) * $total_registros_pagina;

        $tweets = $tweet->getPorPagina($total_registros_pagina, $deslocamento);
        $total_tweets = $tweet->getTotalTweet();
        $this->view->total_de_paginas = ceil($total_tweets['total'] / $total_registros_pagina);
        $this->view->pagina_ativa = $pagina;

        $this->view->tweets = $tweets;

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        $this->view->info_usuario = $usuario->getInfoUsuario();
        $this->view->total_tweets = $usuario->getTotalTweets();
        $this->view->total_seguindo = $usuario->getTotalSeguindo();
        $this->view->total_seguidores = $usuario->getTotalSeguidores();

        $this->render('timeline');
    }

    public function tweet()
    {
        $this->validaAutenticacao();
        $tweet = Container::getModel('tweet');

        $tweet->__set('tweet', $_POST['tweet']);
        $tweet->__set('id_usuario', $_SESSION['id']);

        $tweet->salvar();

        header('Location: /timeline');
    }

    public function validaAutenticacao()
    {
        session_start();

        if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] = '') {
            header('Location: /login=erro');
        }
    }

    public function quemSeguir(){

        $this->validaAutenticacao();

        $pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

        $usuarios = array();

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        if($pesquisarPor != ''){
            $usuario->__set('nome', $pesquisarPor);

            $usuarios = $usuario->getAll();
        }

        $this->view->usuarios = $usuarios;

        $this->view->info_usuario = $usuario->getInfoUsuario();
        $this->view->total_tweets = $usuario->getTotalTweets();
        $this->view->total_seguindo = $usuario->getTotalSeguindo();
        $this->view->total_seguidores = $usuario->getTotalSeguidores();

        $this->render('quemSeguir');
    }

    public function acao(){

        $this->validaAutenticacao();

        $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
        $id_usuario = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';

        $usuarioSeguidores = Container::getModel('UsuarioSeguidores');
        $usuarioSeguidores->__set('id_usuario', $_SESSION['id']);
        $usuarioSeguidores->__set('id_usuario_seguindo', $id_usuario);

        if($acao == 'seguir'){
            $usuarioSeguidores->seguirUsuario();
        } else if($acao == 'deixar_de_seguir'){
            $usuarioSeguidores->deixarSeguirUsuario();
        }

        header('Location: /quem_seguir');
    }

    public function removerTweet(){

        $this->validaAutenticacao();

        $idTweet = isset($_POST['idTweet']) ? $_POST['idTweet'] : '';

        if($idTweet != ''){

            $tweet = Container::getModel('Tweet');
            $tweet->__set('id', $idTweet);

            $tweet->remover();
        }

        header('Location: /timeline');
    }
}
