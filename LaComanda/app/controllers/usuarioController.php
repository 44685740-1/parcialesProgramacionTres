<?php
    require_once "./models/usuario.php";

    class usuarioController{

        public function InsertarUsuario($nombre,$apellido,$dni,$estadoLaboral,$edad,$sector,$clave,$mail){
            $usuario = new Usuario();
            $usuario->nombre = $nombre;
            $usuario->apellido = $apellido;
            $usuario->dni = $dni;
            $usuario->estadoLaboral = $estadoLaboral;
            $usuario->edad = $edad;
            $usuario->sector = $sector;
            $usuario->clave = $clave;
            $usuario->mail = $mail;

            return $usuario->insertarUsuarioParametros();
        }

        public function modificarUsuario($id,$nombre,$apellido,$dni,$estadoLaboral,$edad,$sector,$clave,$mail){
            $usuario = new Usuario();
            $usuario->id = $id;
            $usuario->nombre = $nombre;
            $usuario->apellido = $apellido;
            $usuario->dni = $dni;
            $usuario->estadoLaboral = $estadoLaboral;
            $usuario->edad = $edad;
            $usuario->sector = $sector;
            $usuario->clave = $clave;
            $usuario->mail = $mail;            
            return $usuario->modificarUsuarioParametros();
        }

        public function borrarUsuario($id){
            $usuario = new Usuario();
            $usuario->id = $id;
            return $usuario->borrarUsuario();
        }

        public function listarUsuarios(){
            return usuario::traerTodosLosUsuarios();
        }

        public function buscarUsuarioPorId($id){
            $retorno = usuario::TraerUnUsuario($id);
            if($retorno === false) { // Validamos que exista y si no mostramos un error
                $retorno =  ['error' => 'No existe ese id'];
            }
            return $retorno;
        }

        //abm de usuarios directo con las request de slim

        public function CrearUsuario($request, $response){
            $data = $request->getParsedBody();
            $nombre = $data['nombre'];
            $apellido = $data['apellido'];
            $dni = $data['dni'];
            $estadoLaboral = $data['estadoLaboral'];
            $edad = $data['edad'];
            $sector = $data['sector'];
            $clave = $data['clave'];
            $mail = $data['mail'];
            $usuario = new usuario();
            $usuario->constructorParametros($nombre,$apellido,$dni,$estadoLaboral,$edad,$sector,$clave,$mail);
        
            $usuarioController = new usuarioController();
            $respuesta = $usuarioController->InsertarUsuario($nombre,$apellido,$dni,$estadoLaboral,$edad,$sector,$clave,$mail);
            //retorno el id del usuario Ingresado
            $respuestaJson = json_encode(['resultado' => $respuesta]);
            $payload = json_encode($respuestaJson);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function traerUsuarios($request, $response){
            $usuarioController = new usuarioController();
            $listaUsuarios = $usuarioController->listarUsuarios();
            $payload = json_encode($listaUsuarios);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function traerUnUsuario($request, $response,array $args){
            $id = $args['id'];
            $usuario = usuario::TraerUnUsuario($id);
            if ($usuario != false) {
                $payload = json_encode($usuario);
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json');
            } else {
                $mensajeError = json_encode(array('Error' => 'Usuario No encontrado'));
                $response->getBody()->write($mensajeError);
                return $response->withHeader('Content-Type', 'application/json');
            }
        }

        public function modificarUnUsuario($request, $response,array $args){
            $data = $request->getParsedBody();
            $id = $args['id'];
            $nombre = $data['nombre'];
            $apellido = $data['apellido'];
            $dni = $data['dni'];
            $estadoLaboral = $data['estadoLaboral'];
            $edad = $data['edad'];
            $sector = $data['sector'];
            $clave = $data['clave'];
            $mail = $data['mail'];
        
            $usuario = usuario::TraerUnUsuario($id);
            if ($usuario != false) {
                $usuarioController = new usuarioController();
                $resultado = $usuarioController->modificarUsuario($id,$nombre,$apellido,$dni,$estadoLaboral,$edad,$sector,$clave,$mail);
                $payload = json_encode(array("Resultado Modificar" => $resultado));
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json');
            } else {
                $mensajeError = json_encode(array('Error' => 'Usuario No encontrado'));
                $response->getBody()->write($mensajeError);
                return $response->withHeader('Content-Type', 'application/json');
            }
        }

        public function eliminarUnUsuario($request, $response,array $args){
            $id = $args['id'];
            $usuarioController = new usuarioController();
            $retorno = $usuarioController->borrarUsuario($id);
            $payload = json_encode(array('Respuesta Eliminar' => "$retorno"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>