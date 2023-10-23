<?php
    require_once "manejadorArchivos.php";
    class reserva{
        public $id;
        public $fechaDeEntrada;
        public $fechaDeSalida;
        public $tipoHabitacion;
        public $importeTotal;
        public $numeroCliente;
        public $tipoCliente;

        public function __construct()
        {
            
        }

        public function constructorParametros($id,$fechaDeEntrada,$fechaDeSalida,$tipoHabitacion,$importeTotal,$numeroCliente,$tipoCliente){
            $this->id = $id;
            $this->fechaDeEntrada = $fechaDeEntrada;
            $this->fechaDeSalida = $fechaDeSalida;
            $this->tipoHabitacion = $tipoHabitacion;
            $this->importeTotal = $importeTotal;
            $this->numeroCliente = $numeroCliente;
            $this->tipoCliente = $tipoCliente;
        }

        public static function acumuladorImporteHabitacionFecha($tipoHabitacion,$fecha){
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $data = $manejadorArchivos->leer();
            $acumuladorImporte = 0;
            foreach ($data as  $value) {
                if ($value["tipoHabitacion"] == $tipoHabitacion && $value["fechaDeEntrada"] == $fecha) {
                    $acumuladorImporte += $value["importeTotalReserva"];
                } 
            }
            
            return $acumuladorImporte;
        }

        public static function listadoReservasCliente($numeroCliente){
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $data = $manejadorArchivos->leer();
            $reservasFiltradas = [];
            foreach ($data as  $value) {
                if ($value["numeroCliente"] == $numeroCliente) {
                    $reservasFiltradas[] = $value;
                }
            }

            return json_encode($reservasFiltradas);
        }

        public static function listadoReservasTipoHabitacion($tipoHabitacion){
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $data = $manejadorArchivos->leer();
            $reservasFiltradas = [];
            
            foreach ($data as  $value) {
                if ($value["tipoHabitacion"] == $tipoHabitacion) {
                    $reservasFiltradas[] = $value;
                }
            }
            
            return json_encode($reservasFiltradas);
            
        }

        public static function listadoReservasFecha($fechaUno,$fechaDos){
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $data = $manejadorArchivos->leer();
            $reservasFiltradas = [];

            foreach ($data as  $value) {
                if ($value["fechaDeEntrada"] == $fechaUno || $value["fechaDeEntrada"] == $fechaDos) {
                    $reservasFiltradas[] = $value;
                }
            }

            return json_encode($reservasFiltradas);
        }

        public static function verificarReservaId($idReserva){
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $data = $manejadorArchivos->leer();
            $respuesta = false;
            foreach ($data as  $value) {
                if ($value["id"] == $idReserva) {
                    $respuesta = true;
                }
            }

            return $respuesta;
        }

        public static function eliminarReservaId($idReserva){
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $data = $manejadorArchivos->leer();

            $indice = reserva::retornarIndiceIdReserva($idReserva);
            unset($data[$indice]);
            $manejadorArchivos->guardar($data);
        }


        public static function retornarIndiceIdReserva($idReserva){
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $data = $manejadorArchivos->leer();
            foreach ($data as $index =>  $value) {
                if ($value["id"] == $idReserva) {
                    return $index;
                }
            }
        }
    }
?>