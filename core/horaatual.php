<?php
include_once("../../sca/inc/mysql.class.php");
include_once("controlePonto.php");
error_reporting(0);
session_start();
$naoExibe = false;
$controle = new controlePonto();
$c = $controle->autoImportaUsuario();
$lEvent = $controle->getLastPontoEvent();
if ($lEvent == FALSE) {
    $texto = 'Entrada';
} else if ($lEvent == 'E') {
    $texto = 'Saida';
} else {
    $naoExibe = true;
}
?>
<div class="center">
    <center>
        SiRF - Sistema de Registro de Frequência<br /><br />    
        <font size="70">
<?php
if (!$naoExibe) {
?>
        <?php
        echo $texto;
        ?>
        : <?php
        date_default_timezone_set('America/Manaus');
        echo date('H:i:s');
        ?> h
    </center>
    </font>
</div>
 <?php
} else { ?>
  Ponto Fechado.      
<?php } ?>
       
