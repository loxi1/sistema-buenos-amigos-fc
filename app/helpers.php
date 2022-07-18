<?php

    function getmes($idorden = 0)
    {
        $mes = array("primero","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return ($idorden > 0 && !empty($mes[$idorden])) ? $mes[$idorden] : "";
    }