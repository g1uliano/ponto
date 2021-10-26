<?php
/* * ******************************************************************
 *  Sistema de Registro de Ponto
 *  Desenvolvido por: Giuliano Cardoso
 *  E-mail: giulianocf@gmail.com
 * ***************************************************************** */
//se o usuário não estiver autenticado, manda de volta para o lugar de onde ele veio, afinal, ele não foi convidado pra festa, foi?
session_start();

//url de acesso ao sistema.
$_SESSION['sca_url'] = 'http://'.$_SERVER['SERVER_ADDR'].''.$_SERVER["SCRIPT_NAME"];

if (!((isset($_SESSION['sca_id'])) && (isset($_SESSION['sca_grupo'])))) {
    Header("Location: ../sca/");
    exit;
} 
include_once("../sca/inc/mysql.class.php");
include_once("core/controlePonto.php");
$controle = new controlePonto();
$c = $controle->autoImportaUsuario();
?>
<!DOCTYPE html>
<html lang="en">
      <head>
        <meta charset=utf-8 />
        <title> SiRF - Sistema de Registro de Frequência  </title>
        <link rel="stylesheet" href="core/ponto.css" type="text/css" />
        <script src="../sca/js/jquery-1.6.2.min.js"></script>
        <script src="../sca/js/gradient.js"></script>
        <script src="core/core.js"></script>        
      </head>
      <body>          
          <p align="right">
          <input value="relatório" class="relatorios" type="button"> &nbsp;
          <input value="sair" class="sair" type="button">
          </p>
           <div id="default">
            <div class="center">       
                <span id="horario">
                </span>
                <br />
            <?php 
            if ($controle->getLastPontoEvent() != 'S') {
            ?>
            <input value="registrar ponto" id="registrar_ponto" type="button"> <br />            
            <?php } ?>
            
            </div>
           </div>
      </body>
</html>
