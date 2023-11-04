<?php
    require_once "usuario.php";

    class usuarioController{
        
        public function __construct()
        {
            
        }
        public function InsertarUsuario($nombre, $salario, $sector){
            $usuario = new usuario();
            $usuario->nombre = $nombre;
            $usuario->salario = $salario;
            $usuario->sector = $sector;

            return $usuario->insertarUsuarioParametros();
        }

        public function modificarUsuario($nombre, $salario, $sector, $operacion){
            $usuario = new usuario();
            $usuario->nombre = $nombre;
            $usuario->salario = $salario;
            $usuario->sector = $sector;
            return $usuario->modificarUsuarioParametros();
        }

        public function borrarUsuario($id){
            $usuario = new usuario();
            $usuario->id = $id;
            return $usuario->borrarUsuario();
        }

        public function listarUsuarios(){
            return usuario::TraerTodosLosUsuarios();
        }

        public function buscarUsuariosPorId($id){
            $retorno = usuario::TraerUnUsuario($id);
            if($retorno === false) { // Validamos que exista y si no mostramos un error
                $retorno =  ['error' => 'No existe ese id'];
            }
            return $retorno;
        }
    }
    
?>