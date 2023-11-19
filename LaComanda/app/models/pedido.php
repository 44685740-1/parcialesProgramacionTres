<?php
    include_once "./db/accesoDatos.php";

    class pedido{
        public $id;
        public $codigoPedido;
        public $productoId;
        public $mesaId;
        public $usuarioId;
        public $estado;
        public $tiempoOrden;
        public $tiempoMaximo;
        public $tiempoEntrega;


        public function __construct()
        {
            
        }

        public function constructorParametros($codigoPedido,$productoId,$mesaId, $usuarioId,$estado,$tiempoOrden,$tiempoEntrega,$tiempoMaximo){
            $this->codigoPedido = $codigoPedido;
            $this->productoId = $productoId;
            $this->mesaId = $mesaId;
            $this->usuarioId = $usuarioId;
            $this->estado = $estado;
            $this->tiempoOrden = $tiempoOrden;
            $this->tiempoMaximo = $tiempoMaximo;
            $this->tiempoEntrega = $tiempoEntrega;
        }

        public function MostrarDatos()
        {
            return "Id {$this->id}<br>Codigo Pedido {$this->codigoPedido}<br>Producto Id {$this->productoId}<br>Mesa Id {$this->mesaId}<br>Usuario Id {$this->usuarioId}<br>Estado {$this->estado}<br>Tiempo Orden {$this->tiempoOrden}<br>Tiempo Maximo {$this->tiempoMaximo}<br>Tiempo Entrega {$this->tiempoEntrega}";
        }

        public function InsertarPedido(){
            $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccsesoDatos->RetornarConsulta("INSERT INTO `pedidos`(`codigo_pedido`, `id_producto`, `id_mesa`, `id_usuario`, `estado`, `tiempo_orden`, `tiempo_entrega`, `tiempo_maximo`) 
            VALUES ('$this->codigoPedido','$this->productoId','$this->mesaId','$this->usuarioId','$this->estado','$this->tiempoOrden','$this->tiempoMaximo','$this->tiempoEntrega')");
            $consulta->execute();
            return $objetoAccsesoDatos->RetornarUltimoIdInsertado();
        }

        public function insertarPedidoParametros(){
            $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccsesoDatos->RetornarConsulta("INSERT INTO `pedidos`(`codigo_pedido`, `id_producto`, `id_mesa`, `id_usuario`, `estado`, `tiempo_orden`, `tiempo_entrega`, `tiempo_maximo`) 
            VALUES (:codigoPedido,:productoId, :mesaId,:usuarioId,:estado,:tiempoOrden,:tiempoMaximo,:tiempoEntrega)");
            $consulta->bindValue(':codigoPedido',$this->codigoPedido,PDO::PARAM_INT);
            $consulta->bindValue(':productoId',$this->productoId,PDO::PARAM_INT);
            $consulta->bindValue(':mesaId',$this->mesaId,PDO::PARAM_INT);
            $consulta->bindValue(':usuarioId',$this->usuarioId,PDO::PARAM_INT);
            $consulta->bindValue(':estado',$this->estado,PDO::PARAM_STR);
            $consulta->bindValue(':tiempoOrden',$this->tiempoOrden,PDO::PARAM_STR);
            $consulta->bindValue(':tiempoMaximo',$this->tiempoMaximo,PDO::PARAM_STR);
            $consulta->bindValue(':tiempoEntrega',$this->tiempoEntrega,PDO::PARAM_STR);
            $consulta->execute();
            return $objetoAccsesoDatos->RetornarUltimoIdInsertado();
        }

        public static function traerTodosLosPedidos(){
            $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccsesoDatos->RetornarConsulta("SELECT `id`, `codigo_pedido` AS 'codigoPedido', `id_producto` AS 'productoId', `id_mesa` AS 'mesaId', `id_usuario` AS 'usuarioId', `estado`, `tiempo_orden` AS 'tiempoOrden', `tiempo_entrega` AS 'tiempoEntrega', `tiempo_maximo` AS 'tiempoMaximo' 
            FROM `pedidos`");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS,"pedido");
        }

        public static function TraerUnPedido($id){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT `id`, `codigo_pedido` AS 'codigoPedido', `id_producto` AS 'productoId', `id_mesa` AS 'mesaId', `id_usuario` AS 'usuarioId', `estado`, `tiempo_orden` AS 'tiempoOrden', `tiempo_entrega` AS 'tiempoEntrega', `tiempo_maximo` AS 'tiempoMaximo' 
            FROM `pedidos`
            WHERE id = $id");
            $consulta->execute();
            $usuarioBuscado = $consulta->fetchObject("pedido");
            return $usuarioBuscado;
        }

        public function modificarPedido(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE `pedidos` 
            SET `codigo_pedido`= '$this->codigoPedido',`id_producto`= '$this->productoId',`id_mesa`= '$this->mesaId',`id_usuario`= '$this->usuarioId',`estado`='$this->estado',`tiempo_orden`='$this->tiempoOrden',`tiempo_entrega`= '$this->tiempoEntrega',`tiempo_maximo`='$this->tiempoMaximo' 
            WHERE id = '$this->id'");
            return $consulta->execute();
        }

        public function modificarPedidosParametros(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE `pedidos` 
            SET `codigo_pedido`= :codigoPedido,`id_producto`= :productoId,`id_mesa`= :mesaId,`id_usuario`= :usuarioId,`estado`= :estado,`tiempo_orden`= :tiempoOrden,`tiempo_entrega`= :tiempoEntrega,`tiempo_maximo`= :tiempoMaximo 
            WHERE id = :id");
    
            $consulta->bindValue(':id',$this->id,PDO::PARAM_INT);
            $consulta->bindValue(':codigoPedido',$this->codigoPedido,PDO::PARAM_INT);
            $consulta->bindValue(':productoId',$this->productoId,PDO::PARAM_INT);
            $consulta->bindValue(':mesaId',$this->mesaId,PDO::PARAM_INT);
            $consulta->bindValue(':usuarioId',$this->usuarioId,PDO::PARAM_INT);
            $consulta->bindValue(':estado',$this->estado,PDO::PARAM_STR);  
            $consulta->bindValue(':tiempoOrden',$this->tiempoOrden,PDO::PARAM_STR);
            $consulta->bindValue(':tiempoMaximo',$this->tiempoMaximo,PDO::PARAM_STR);
            $consulta->bindValue(':tiempoEntrega',$this->tiempoEntrega,PDO::PARAM_STR);
            return $consulta->execute();
        }

        public function borrarPedido(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM `pedidos` 
            WHERE id = :id");
    
            $consulta->bindValue(':id',$this->id,PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->rowCount();
        }
    }

?>