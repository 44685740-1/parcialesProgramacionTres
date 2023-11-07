<?php
    include_once "./db/accesoDatos.php";

    class pedido{
        public $id;
        public $codigoMesa;
        public $dniMozo;
        public $estado;
        public $tiempoOrden;
        public $tiempoMaximo;
        public $tiempoEntrega;


        public function __construct()
        {
            
        }

        public function constructorParametros($codigoMesa,$dniMozo,$estado,$tiempoOrden,$tiempoMaximo,$tiempoEntrega){
            $this->codigoMesa = $codigoMesa;
            $this->dniMozo = $dniMozo;
            $this->estado = $estado;
            $this->tiempoOrden = $tiempoOrden;
            $this->tiempoMaximo = $tiempoMaximo;
            $this->tiempoEntrega = $tiempoEntrega;
        }

        public function MostrarDatos()
        {
            return "Id {$this->id}<br>Codgo Mesa {$this->codigoMesa}<br>Dni Mozo {$this->dniMozo}<br>Estado {$this->estado}<br>Tiempo Orden {$this->tiempoOrden}<br>Tiempo Maximo {$this->tiempoMaximo}<br>Tiempo Entrega {$this->tiempoEntrega}";
        }

        public function InsertarPedido(){
            $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccsesoDatos->RetornarConsulta("INSERT INTO `pedidos`(`codigo_mesa`, `dni_mozo`, `estado`, `tiempo_orden`, `tiempo_maximo`, `tiempo_entrega`) 
            VALUES ('$this->codigoMesa','$this->dniMozo','$this->estado','$this->tiempoEntrega','$this->tiempoMaximo','$this->tiempoEntrega')");
            $consulta->execute();
            return $objetoAccsesoDatos->RetornarUltimoIdInsertado();
        }

        public function insertarPedidoParametros(){
            $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccsesoDatos->RetornarConsulta("INSERT INTO `pedidos`(`codigo_mesa`, `dni_mozo`, `estado`, `tiempo_orden`, `tiempo_maximo`, `tiempo_entrega`) 
            VALUES (:codigoMesa, :dniMozo,:estado, :tiempoEntrega, :tiempoMaximo, :tiempoEntrega)");
            $consulta->bindValue(':codigoMesa',$this->codigoMesa,PDO::PARAM_INT);
            $consulta->bindValue(':dniMozo',$this->dniMozo,PDO::PARAM_INT);
            $consulta->bindValue(':estado',$this->estado,PDO::PARAM_STR);
            $consulta->bindValue(':tiempoEntrag',$this->tiempoEntrega,PDO::PARAM_STR);
            $consulta->bindValue(':tiempoMaximo',$this->tiempoMaximo,PDO::PARAM_STR);
            $consulta->bindValue(':tiempoEntrega',$this->tiempoEntrega,PDO::PARAM_STR);
            $consulta->execute();
            return $objetoAccsesoDatos->RetornarUltimoIdInsertado();
        }

        public static function traerTodosLosPedidos(){
            $objetoAccsesoDatos = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccsesoDatos->RetornarConsulta("SELECT `id`, `codigo_mesa` AS 'codigoMesa', `dni_mozo` AS 'dniMozo', `estado`, `tiempo_orden` AS 'tiempoOrden', `tiempo_maximo` AS 'tiempoMaximo', `tiempo_entrega` AS 'tiempoEntrega' 
            FROM `pedidos` ");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS,"pedido");
        }

        public static function TraerUnPedido($id){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT `id`, `codigo_mesa` AS 'codigoMesa', `dni_mozo` AS 'dniMozo', `estado`, `tiempo_orden` AS 'tiempoOrden', `tiempo_maximo` AS 'tiempoMaximo', `tiempo_entrega` AS 'tiempoEntrega' 
            FROM `pedidos` 
            WHERE id = $id");
            $consulta->execute();
            $usuarioBuscado = $consulta->fetchObject("pedido");
            return $usuarioBuscado;
        }

        public function modificarPedido(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE `pedidos` 
            SET `codigo_mesa`= '$this->codigoMesa',`dni_mozo`= '$this->dniMozo',`estado`='$this->estado',`tiempo_orden`='$this->tiempoOrden',`tiempo_maximo`='$this->tiempoMaximo',`tiempo_entrega`='$this->tiempoEntrega' 
            WHERE id = '$this->id'");
            return $consulta->execute();
        }

        public function modificarPedidosParametros(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE `pedidos` 
            SET `codigo_mesa`= :codigoMesa,`dni_mozo`= :dniMozo,`estado`= :estado,`tiempo_orden`= :tiempoOrden,`tiempo_maximo`= :tiempoMaximo,`tiempo_entrega`= :tiempoEntrega 
            WHERE id = :id");
    
            $consulta->bindValue(':id',$this->id,PDO::PARAM_INT);
            $consulta->bindValue(':codigoMesa',$this->codigoMesa,PDO::PARAM_INT);
            $consulta->bindValue(':dniMozo',$this->dniMozo,PDO::PARAM_INT);
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