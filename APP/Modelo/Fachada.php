<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require 'dto/AnimalDTO.php';
require 'Dao/DaoAnimal.php';
require 'Dao/DaoMedicamento.php';
require 'dto/VacaEstadoDTO.php';
require 'Dao/DaoVacaEstado.php';
require 'dto/DietaDTO.php';
require 'Dao/DaoDieta.php';
require 'Dao/DaoUsuario.php';
require 'dto/UsuarioDTO.php';
require 'dto/ReporteMedicamentoDTO.php';
require 'Dao/DaoReporteMedicamento.php';
require 'Dao/DaoReporteDieta.php';
require 'dto/ReporteDietaDTO.php';
require 'Dao/DaoReproduccion.php';
require 'dto/ReproduccionDTO.php';
require 'dto/ReporteGeneralDTO.php';
require 'Dao/DaoReporteGeneral.php';
require 'Dao/DaoReporteGeneralAnimal.php';
require 'dto/ReporteGeneralAnimalDTO.php';
require 'dto/ReporteTipoDTO.php';
require 'Dao/DaoReporteTipo.php';
require 'Dao/DaoReporteAnimal.php';
require 'dto/ReporteAnimalDTO.php';

/**
 * Description of Fachada
 * la clase fachada tiene como funcion el manejo de los subsistemas del modelo del negocio.
 * @author carlos
 */
class Fachada {

    /**
     * inicia sesion en el sistema
     * @param type $usuario
     * @param type $password
     * @return type
     */
    public function iniciarSesion($usuario, $password) {
        $daoU = new DaoUsuario();
        $dtoU = new UsuarioDTO();
        $dtoU->setUsuario($usuario);
        $dtoU->setPassword($password);
        return $daoU->iniciarSesion($dtoU);
    }

    /**
     * consulta todas las vacas que hay registradas en el sistema
     * @return type
     */
    public function consultarVaca() {
        $daoA = new DaoAnimal();
        $daoE = new DaoVacaEstado();
        $total = array();
        $vacas = $this->consultarAnimal('vaca');
        $i = 0;
        foreach ($vacas as $r) {
            $dto = new VacaEstadoDTO($r['id'], '');
            $estado = $daoE->consultarEstado($dto);
            $v = $estado[0];
            $total[$i] = array($r, $v);
            $i++;
        }
        return $total;
    }

    /**
     * consulta los reportes realizados a los animales
     * @param type $tipo
     * @param type $fechaI
     * @param type $fechaF
     * @return string
     */
    public function consultarReporteAnimal($tipo, $fechaI, $fechaF) {

        $dtoG1 = new ReporteTipoDTO('', $fechaI, $tipo, '');
        $dtoG2 = new ReporteTipoDTO('', $fechaF, $tipo, '');
        $daoG = new DaoReporteTipo();
        $daoA = new DaoReporteAnimal();
        $reportesTipo = $daoG->consultarReporteTipo($dtoG1, $dtoG2);

        $total = array();
        $i = 0;
        if (empty($reportesTipo)) {

            return '';
        }
        foreach ($reportesTipo as $r) {

            $dtoRA = new ReporteAnimalDTO('', $r['ID'], '', '');

            $adjunto = $daoA->consultarReporteAnimalAdjunto($dtoRA);

            $total[$i] = array($r, $adjunto);
            $i++;
        }



        return $total;
    }

    /**
     * registra un reporte de un animal enn especifico.
     * @param type $tipo
     * @param type $descripcion
     * @param type $adjunto
     * @return type
     */
    public function registrarReporteAnimal($tipo, $descripcion, $adjunto) {
        $fecha = date("Y") . "-" . date("m") . "-" . date("d");

        $idReporte = $tipo . "-" . $fecha;
        $dtoR = new ReporteTipoDTO($idReporte, $fecha, $tipo, $descripcion);
        $daoR = new DaoReporteTipo();
        $valor = $daoR->registrarReporteTipo($dtoR);

        if ($valor) {
            $daoA = new DaoReporteAnimal();
            $daoAN = new DaoAnimal();
            foreach ($adjunto as $data) {
                $dtoA = new ReporteAnimalDTO($data[0], $idReporte, $data[2], $data[1]);
                $valor = $daoA->registrarReporteAnimalAdjunto($dtoA);

                if ($valor == false) {
                    return;
                }
            }
        }
        return $valor;
    }

    /**
     * consulta los reportes generales el cual consiste en realizar un simple conteo de animales
     * 
     * @param type $fechaI
     * @param type $fechaF
     * @return type
     */
    public function consultarReporteGeneral($fechaI, $fechaF) {
        $dtoG1 = new ReporteGeneralDTO($fechaI, '');
        $dtoG2 = new ReporteGeneralDTO($fechaF, '');
        $daoG = new DaoReporteGeneral();
        $daoA = new DaoReporteGeneralAnimal();
        $reportesGenerales = $daoG->consultarReporteGeneral($dtoG1, $dtoG2);
        $total = array();
        $i = 0;

        if (empty($reportesGenerales)) {

            return '';
        }
        foreach ($reportesGenerales as $r) {
            $dtoRA = new ReporteGeneralAnimalDTO($r['PK_FECHA'], '', '');
            $adjunto = $daoA->consultarReporteGeneral($dtoRA);
            $total[$i] = array($r, $adjunto);
            $i++;
        }

        return $total;
    }

    /**
     * registra reportes generales en la base de datos
     * @param type $total
     * @param type $observacion
     * @return boolean
     */
    public function registrarReporteGeneral($total, $observacion) {
        $dtoG = new ReporteGeneralDTO('', $observacion);
        $daoG = new DaoReporteGeneral();
        $valor = $daoG->registrarReporteGeneral($dtoG);
        $daoR = new DaoReporteGeneralAnimal();

        if ($valor) {
            foreach ($total as $data) {
                $dtoR = new ReporteGeneralAnimalDTO('', $data[0], $data[1]);
                $valor = $daoR->adjuntarReporteGeneral($dtoR);
                if ($valor == false) {
                    return false;
                }
            }
        }
        return $valor;
    }

    /**
     * carga los reportes generales que hay registrados en la base de datos
     * @return type
     */
    public function cargarReporteGeneral() {
        $dao = new DaoAnimal();
        $valor = $dao->consultarTipoAnimal();
        return $valor;
    }

    /**
     * consulta un reporte dieta por nombre de dieta y rango de fechas
     * @param type $dieta  nombre de dieta
     * @param type $desde  fecha inicial
     * @param type $hasta  fecha final
     * @return type
     */
    public function consultarReporteDieta($dieta, $desde, $hasta) {
        $dao = new DaoReporteDieta();
        $dtoI = new ReporteDietaDTO($dieta, '', $desde);
        $dtoF = new ReporteDietaDTO($dieta, '', $hasta);
        return $dao->consultarReporteDieta($dtoI, $dtoF);
    }

    /**
     * consulta las fechas del proceso de reproduccion de una vaca.
     */
    public function consultarProceso($id) {
        $daoR = new DaoReproduccion();
        $dtoR = new ReproduccionDTO($id, '', '', '', '');
        return $daoR->consultarFechas($dtoR);
    }

    /**
     * actualiza el estado de una vaca y acomoda sus  tiempos.
     * @param type $nombre
     * @param type $etapa
     * @return type
     */
    public function actualizarEstado($nombre, $etapa) {
        $daoE = new DaoVacaEstado();
        $dtoE = new VacaEstadoDTO($nombre, $etapa);
        //actualiza el estado en la tabla vaca_estado
        $valor = $daoE->actualizarEstado($dtoE);
        if ($valor) {
            $daoR = new DaoReproduccion();
            $dtoR = new ReproduccionDTO($nombre, '', '', '', '');
            $valor = $daoR->actualizarFecha($dtoR, $dtoE);
        }
        return $valor;
    }

    /**
     * carga la etapa proxima en el proceso de reproduccin de una vaca
     * ejemplo si la vaca esta en estado de gestacion se cargaria la etapa de produccion
     * 
     */
    public function cargarEtapaProximaVaca($nombre) {
        $dto = new VacaEstadoDTO($nombre, '');
        $dao = new DaoVacaEstado();
        $valor = $dao->consultarVacaEstadoProximo($dto);
        return $valor;
    }

    /**
     * carga las vacas que no tienen como estado de no reproduccion ninguno
     * @return type
     */
    public function cargarVacaNoEstadoNinguno() {

        $dao = new DaoVacaEstado();
        $valor = $dao->cargarVacaNoEstadoNinguno();
        return $valor;
    }

    /**
     * ingresa vaca en el proceso de reproduccion bovino
     * etapa de gestacion
     * @param type $vaca
     * @return type
     */
    public function ingresarProceso($vaca) {
        //registra historial de reproduccion
        $daoR = new DaoReproduccion();
        $dto = new ReproduccionDTO($vaca, '', '', '', '');
        $valor = $daoR->ingresarReproduccion($dto);
        if ($valor) {
            //actualiza el estado de la vaca
            $daoE = new DaoVacaEstado();
            $dto = new VacaEstadoDTO($vaca, 'gestacion');
            $valor = $daoE->actualizarEstado($dto);
            if ($valor) {
                $valor = 1;
            } else {
                $valor = 3;
            }
        } else {
            $valor = 2;
        }
        return $valor;
    }

    /**
     * carga el nombre de las vacas que estan en estado ninguno dentro de su proceso de reproduccion
     * @return type
     */
    public function cargarVacaEstadoNinguno() {


        $dao = new DaoVacaEstado();
        $valor = $dao->cargarVacaEstadoNinguno();

        return $valor;
    }

    /**
     * realiza un reporte de dieta donde se guarda la fecha en el que una dieta
     * se le ha dado a una especie de animal
     * @param type $total
     * @return boolean
     */
    public function registrarReporteDieta($tipo, $dieta) {
        $dao = new DaoReporteDieta();
        $dto = new ReporteDietaDTO($dieta, $tipo, '');
        return $dao->registrarReporteDieta($dto);
    }

    /**
     * consulta todas las dietas registradas en la base de datos
     * @return type
     */
    public function consultarDietaGeneral() {

        $dao = new DaoDieta();
        $valor = $dao->consultarDietaGeneral();
        return $valor;
    }

    /**
     * modifica una dieta en la base de datos
     * @param type $nombre
     * @param type $descripcion
     * @return type
     */
    public function modificarDieta($nombre, $descripcion) {
        $dao = new DaoDieta();
        $dto = new DietaDTO($nombre, $descripcion);
        $valor = $dao->modificarDieta($dto);
        return $valor;
    }

    /**
     * consulta reportes de medicamento segunn unn rango de fecha
     * @param type $nombre
     * @param type $fechaI
     * @param type $fechaF
     * @return type
     */
    public function consultarReporteMedicamento($nombre, $fechaI, $fechaF) {

        $dtoI = new ReporteMedicamentoDTO($nombre, $fechaI, '', '');
        $dtoF = new ReporteMedicamentoDTO($nombre, $fechaF, '', '');
        $dao = new DaoReporteMedicamento();
        $valor = $dao->consultarReporteMedicamento($dtoI, $dtoF);
        return $valor;
    }

    /**
     * genera un reporte medicamento donde se indica el gasto. actualiza la tabla medicamento con el nuevo valor en gasto. 
     * @param type $nombre
     * @param type $cantidadU
     * @param type $responsable
     * @return type
     */
    public function gastarMedicamento($nombre, $cantidadU, $responsable) {
        $dto = new MedicamentoDTO($nombre, 0, $cantidadU, '');
        $dao = new DaoMedicamento();
        $valor = $dao->validarGasto($dto);
        if ($valor) {
            $dtoR = new ReporteMedicamentoDTO($nombre, '', $responsable, $cantidadU);
            $daoR = new DaoReporteMedicamento();
            $valor = $daoR->registrarReporteMedicamento($dtoR);
            echo $valor;
        }

        return $valor;
    }

    /**
     * ingresa una determinada cantidad de medicametos de un tipo a la base de datos
     * @param type $nombre
     * @param type $ingreso
     * @return type
     */
    public function ingresarMedicamento($nombre, $ingreso) {
        $dto = new MedicamentoDTO($nombre, $ingreso, 0, '');
        $dao = new DaoMedicamento();
        $valor = $dao->ingresarMedicamento($dto);
        return $valor;
    }

    /**
     * elimina un medicamento de la base de datos
     * @param type $nombre
     * @return type
     */
    public function eliminarMedicamento($nombre) {

        $dtoA = new AnimalDTO('', '', '', '', '', $nombre);
        $daoA = new DaoAnimal();
        // quita el medicamento de todos los animales
        $daoA->quitarMedicamentoAnimal($dtoA);

        $dto = new ReporteMedicamentoDTO($nombre, '', '', '');
        $daoR = new DaoReporteMedicamento();
        // elimina el reporte medicamento
        $daoR->eliminarReporteMedicamento($dto);

        $dtoM = new MedicamentoDTO($nombre, 0, 0, '');
        $daoM = new DaoMedicamento();
        //elimina el medicamento
        $valor = $daoM->eliminarMedicamento($dtoM);
        return $valor;
    }

    /**
     * modifica un medicamento enn especifico
     * @param type $nombre
     * @param type $CantidadE
     * @param type $CantidadU
     * @param type $Nomenclatura
     */
    public function modificarMedicamento($nombre, $CantidadE, $CantidadU, $Nomenclatura) {
        $dto = new MedicamentoDTO($nombre, $CantidadE, $CantidadU, $Nomenclatura);
        $dao = new DaoMedicamento();
        $valor = $dao->modificarMedicamento($dto);
        return $valor;
    }

    /**
     * consulta un medicamento de manera especifica en la base de datos 
     * @param type $nombre valor identificado del medicamento
     * @return type
     */
    public function consultarMedicamentoEspecifico($nombre) {
        $dto = new MedicamentoDTO($nombre, 0, 0, '');
        $dao = new DaoMedicamento();
        $valor = $dao->consultarMedicamentoEspecifico($dto);
        return $valor;
    }

    /**
     * consulta un medicamento de manera general en la base de datos
     * @return type
     */
    public function consultarMedicamentoGeneral() {

        $dao = new DaoMedicamento();
        $valor = $dao->consultarMedicamentoGeneral();
        return $valor;
    }

    /**
     * registra medicamentos en la base de datos
     * @param type $nombre
     * @param type $Cantdidad
     * @param type $Nomenclatura
     * @return type
     */
    public function registrarMedicamento($nombre, $Cantidad, $Nomenclatura) {
        $dto = new MedicamentoDTO($nombre, $Cantidad, 0, $Nomenclatura);
        $dao = new DaoMedicamento();


        return $dao->registrarMedicamento($dto);
    }

    /**
     * busca dieta segun su nombre en la base de datos
     * @param type $nombre
     * @return type
     */
    public function buscarDieta($nombre) {
        $dao = new DaoDieta();
        $dto = new DietaDTO($nombre, '');
        $valor = $dao->buscarDieta($dto);
        return $valor;
    }

    /**
     * carga el nombre de las dietas
     * @return type
     */
    public function cargarNombreDieta() {
        $dao = new DaoDieta();
        $valor = $dao->cargarNombreDieta();
        return $valor;
    }

    /**
     * elimina dieta de la base de datos
     * @param type $Id
     * @return type
     */
    public function eliminarDieta($Id) {

        $dtoD = new DietaDTO($Id, '');
        $dao = new DaoDieta();
        $dtoR = new ReporteDietaDTO($Id, '', '');
        $daoR = new DaoReporteDieta();
        $valor = $daoR->eliminarReporteDieta($dtoR);
        if ($valor) {
            $valor = $dao->eliminarDieta($dtoD);
        }
        return $valor;
    }

    /**
     * 
     * @param type $Id
     * @param type $Descripcion
     * @return type true registro exitoso false error al registrar
     */
    public function registrarDieta($Id, $Descripcion) {

        $dao = new DaoDieta();
        $dto = new DietaDTO($Id, $Descripcion);
        $valor = $dao->registrarDieta($dto);
        return $valor;
    }

    /**
     * consulta un animal de manera especifica
     * @param type $Tipo
     * @param type $Id
     * @return type
     */
    public function BuscarAnimal($Tipo, $Id) {

        $dao = new DaoAnimal();
        $dto = new AnimalDTO($Id, $Tipo, '', '', '', '');
        $valor = $dao->consultarAnimalEspecifico($dto);

        return $valor;
    }

    /**
     * consulta todos los animales segun su tipo en la base de datos
     * @param type $Tipo
     * @return type
     */
    public function consultarAnimal($Tipo) {

        $daoA = new DaoAnimal();
        $dto = new AnimalDTO('', $Tipo, '', '', '', '');

        $valor = $daoA->consultarAnimalGeneral($dto);
        return $valor;
    }

    /**
     * 
      modifca animales en la base de datos
     * @param type $Id identificador del animal
     * @param type $Tipo tipo de animal
     * @param type $Tamano tamaño ddel animaml
     * @param type $Peso peso del animal
     * @param type $Sexo sexo del animal
     * @param type $Medicamento medicamento que se le esta aplicando al animal actualmente
     * @return type retorna  verdadero: registro exitoso, falso: error en el registro
     */
    public function modificarAnimal($Id, $Tamano, $Peso, $Sexo, $Medicamento) {
        $dto = new AnimalDTO($Id, '', $Tamano, $Peso, $Sexo, $Medicamento);
        $dao = new DaoAnimal();
        return $dao->modificarAnimal($dto);
    }

    /**
     * elimina un animal de la base de datos
     * @param type $Id identificador del animal
     * @param type $Tipo especie del animal
     * @return type retorna  verdadero: registro exitoso, falso: error en el registro
     */
    public function eliminarAnimal($Id) {

        $dto = new AnimalDTO($Id, '', '', '', '', '');
        $dao = new DaoAnimal();

        list ($Tipo, $id) = explode("-", $Id);

        if ($Tipo == "vaca") {
            $valor = $this->eliminarReproducion($Id);
            if ($valor) {
                $this->eliminarVacaEstado($Id);
            }
        }
        $valor = $this->eliminarReporte($Id);
        if ($valor) {
            $valor = $dao->eliminarAnimal($dto);
        }
        return $valor;
    }

    /**
     * elimina el animal del reporte adjunto
     * @param type $Id
     * @return type
     */
    private function eliminarReporte($Id) {
        $dto = new ReporteAnimalDTO($Id, '', '', '');
        $dao = new DaoReporteAnimal();
        return $dao->eliminarReporteAdjuntoEspecifico($dto);
    }

    /**
     * elimina el historial de reproduccion de una vaca
     * @param type $id el identificado de la vaca
     * @return type
     */
    public function eliminarReproducion($id) {
        $dto = new ReproduccionDTO($id, '', '', '', '');
        $dao = new DaoReproduccion();
        $valor = $dao->eliminarReproduccion($dto);
        return $valor;
    }

    /**
     * elimina una vaca de la tabla vaca_estado
     * @param type $id
     */
    private function eliminarVacaEstado($id) {

        $dto = new VacaEstadoDTO($id, '');
        $dao = new DaoVacaEstado();
        $dao->eliminarVacaEstado($dto);
    }

    /**

      /**
     * 
      registra animales en la base de datos
     * @param type $Id identificador del animal
     * @param type $Tipo tipo de animal
     * @param type $Tamano tamaño ddel animaml
     * @param type $Peso peso del animal
     * @param type $Sexo sexo del animal
     * @param type $Medicamento medicamento que se le esta aplicando al animal actualmente
     * @return type retorna  verdadero: registro exitoso, falso: error en el registro
     */
    public function registrarAnimal($Id, $Tipo, $Tamano, $Peso, $Sexo, $Medicamento) {

        $dto = new AnimalDTO($Id, $Tipo, $Tamano, $Peso, $Sexo, $Medicamento);
        $dao = new DaoAnimal();
        $valor = $dao->registrarAnimal($dto);
        return $valor;
    }

    /**
     * retorna tipos de animal
     * @return type array con tipos de animal
     */
    public function cargarTiposAnimal() {

        $dao = new DaoAnimal();
        return $dao->consultarTipoAnimal();
    }

    /**
     * carga los nobmres de los medicamentos registrados en la base de datos
     * @return type
     */
    public function cargarNombreMedicamento() {

        $dao = new DaoMedicamento();
        return $dao->consultarNombreMedicamento();
    }

}
