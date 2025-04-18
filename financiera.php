<?php 

class Financiera{
    private $denominacion;
    private $direccion;
    private $colPrestamo = [];

    //metodo constructor
    public function __construct($denominacion,  $direccion)
    {$this->denominacion = $denominacion;$this->direccion = $direccion;}
	
    //metodos de acceso(getters)
    public function getDenominacion() {return $this->denominacion;}

	public function getDireccion() {return $this->direccion;}

	public function getColPrestamo() {return $this->colPrestamo;}

    //metodos de acceso (setters)
	public function setDenominacion( $denominacion): void {$this->denominacion = $denominacion;}

	public function setDireccion( $direccion): void {$this->direccion = $direccion;}

	public function setColPrestamo($colPrestamo): void {$this->colPrestamo = $colPrestamo;}

	public function incorporarPrestamo($newPrestamo){
        $this->colPrestamo [] = $newPrestamo; //Añadimos el prestamo al array
    }

    public function otorgarPrestamoSiCalifica(){
        foreach($this->colPrestamo as $newPrestamo){ 
            if(count($newPrestamo->getColeccionCuotas()) == 0){ //Validamos que el array este vacio
                $monto = $newPrestamo->getMonto();
                $cantidadCuotas = $newPrestamo->getCantidadCuotas();
                $persona = $newPrestamo->getRefPersona();
                $valorCuota = $monto / $cantidadCuotas; //Calculo el valor de la cuota.
                $neto = $persona->getNeto(); //Obtengo el sueldo neto de la persona.
                $neto40 = $monto * 0.4; //Calculo el 40% del sueldo neto.
                if($valorCuota < $neto40){ //Si es menor al 40% otorgo el prestamo.
                    $newPrestamo->otorgarPrestamo();
                }
            }
        }
    }
    public function informarCuotaPagar($idPrestamo){
        $encontrado = false;
        $cantidadCol = count($this->colPrestamo);
        $coutaPagar = null;
        $i = 0;
        $coleccionPrestamoVar = $this->getColPrestamo();
        while($encontrado == false && $i < $cantidadCol){
            if($coleccionPrestamoVar[$i]->getIdentificacion() == $idPrestamo){
                $coutaPagar = $coleccionPrestamoVar[$i]->darSiguienteCuotaPagar();
                $encontrado = true;
            }
        $i++;
        }
    return $coutaPagar;
    }
    public function __toString(){
        return 
        "Denominacion: " . $this->getDenominacion() . "\n" .
        "Direccion: " . $this->getDireccion() . "\n" . 
        "Prestamos Otorgados: " . count($this->getColPrestamo()) . "\n";
    }
}