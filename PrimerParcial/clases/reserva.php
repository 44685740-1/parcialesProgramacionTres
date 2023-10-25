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
        public $estado;
        public function __construct()
        {
            
        }

        public function constructorParametros($id,$fechaDeEntrada,$fechaDeSalida,$tipoHabitacion,$importeTotal,$numeroCliente,$tipoCliente,$estado){
            $this->id = $id;
            $this->fechaDeEntrada = $fechaDeEntrada;
            $this->fechaDeSalida = $fechaDeSalida;
            $this->tipoHabitacion = $tipoHabitacion;
            $this->importeTotal = $importeTotal;
            $this->numeroCliente = $numeroCliente;
            $this->tipoCliente = $tipoCliente;
            $this->estado = $estado;
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

        public function insertarReserva($reserva){
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $data = $manejadorArchivos->leer();
            $nuevaReserva = ['id' => $reserva->id,'fechaDeEntrada' => $reserva->fechaDeEntrada, 'fehcaDeSalida' => $reserva->fechaDeSalida, 'tipoHabitacion' => $reserva->tipoHabitacion, 'importeTotalReserva' => $reserva->importeTotal, 'numeroCliente' => $reserva->numeroCliente, 'tipoCliente' => $reserva->tipoCliente, 'estado' => $reserva->estado];
            $data[] = $nuevaReserva;
            $manejadorArchivos->guardar($data);
            $guardarImagen = new guardarImagen();
            $guardarImagen->guardarImagenReserva($reserva);
        }

        public static function cambiarEstadoReserva($idReserva,$nuevoEstado){
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $data = $manejadorArchivos->leer();
            $respuesta = false;
            foreach ($data as $index => $value) {
                if ($value["id"] == $idReserva) {
                    $respuesta = true;
                    $data[$index]["estado"] = $nuevoEstado;
                }
            }
            $manejadorArchivos->guardar($data);
            return $respuesta;
        }

        public static function cambiarImporteReserva($idReserva,$nuevoImporte){
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $data = $manejadorArchivos->leer();
            $respuesta = false;
            foreach ($data as $index => $value) {
                if ($value["id"] == $idReserva) {
                    $respuesta = true;
                    $data[$index]["importeTotalReserva"] = $nuevoImporte;
                }
            }
            $manejadorArchivos->guardar($data);
            return $respuesta;
        }

        public static function insertarAjusteReserva($idReserva,$motivo,$nuevoImporte){
            $manejadorArchivos = new ManejadorArchivos("ajustes.json");
            $data = $manejadorArchivos->leer();
            $nuevoAjuste = ['numeroReserva' => $idReserva, 'motivo' => $motivo, 'nuevoImporte' => $nuevoImporte];
            $data[] = $nuevoAjuste;
            $manejadorArchivos->guardar($data);
        }

        public static function acumuladorImporteCancelado($fecha,$tipoCliente){
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $data = $manejadorArchivos->leer();
            $acumuladorImporteCancelado = 0;
            foreach ($data as  $value) {
                if ($value["fechaDeEntrada"] == $fecha && $value["tipoCliente"] == $tipoCliente && $value["estado"] == "cancelada") {
                    $acumuladorImporteCancelado += $value["importeTotalReserva"];
                }
            }

            return $acumuladorImporteCancelado;
        }

        public static function listadoReservasCanceladasNumeroCliente($numeroCliente){
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $data = $manejadorArchivos->leer();
            $reservasFiltradas = [];

            foreach ($data as  $value) {
                if ($value["numeroCliente"] == $numeroCliente && $value["estado"] == "cancelada") {
                    $reservasFiltradas[] = $value;
                }
            }

            return json_encode($reservasFiltradas);
        }

        public static function listadoReservasCanceladasTipoCliente($tipoCliente){
            $manejadorArchivos = new ManejadorArchivos("reservas.json");
            $data = $manejadorArchivos->leer();
            $reservasFiltradas = [];

            foreach ($data as  $value) {
                if ($value["tipoCliente"] == $tipoCliente && $value["estado"] == "cancelada") {
                    $reservasFiltradas[] = $value;
                }
            }

            return json_encode($reservasFiltradas);
        }

        public static function listadoReservasCancelaciones($numeroCliente){
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


    }
?>