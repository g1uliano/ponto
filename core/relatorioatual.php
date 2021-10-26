<?php
/* * ******************************************************************
 *  Sistema de Registro de Ponto
 *  Desenvolvido por: Giuliano Cardoso
 *  E-mail: giulianocf@gmail.com
 * ***************************************************************** */
//se o usuário não estiver autenticado, manda de volta para o lugar de onde ele veio, afinal, ele não foi convidado pra festa, foi?
session_start();

function evento_tipo($tipo) {
    if ($tipo == 'E') {
        return 'Entrada';
    } else {
        return 'Saída';
    }
}

include_once("../../sca/inc/mysql.class.php");
include_once("controlePonto.php");
$controle = new controlePonto();
$c = $controle->autoImportaUsuario();
$local = $controle->localGetUser($controle->sessionGetUserId());
$local = $local['Id'];
$dias_semana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');

if (@$_GET['mes']=='') {
     $_GET['mes'] = date('n');
} 
if (@$_GET['ano'] == '') {
     $_GET['ano'] = date('Y');
}
if ((@$_GET['id'] != '') && (@$_GET['id'] != 'undefined'))  {
    $local = @$_GET['id'];
}
$sql  = "SELECT * FROM folha_ponto WHERE Usuario = $local AND ";
$sql .= "(Dia >= '".$_GET['ano']."-".$_GET['mes']."-01' AND ";
$sql .= "Dia <= '".$_GET['ano']."-".$_GET['mes']."-31') ORDER by Id";

$row = $controle->local->QueryArray($sql, MYSQL_ASSOC);
if (!is_array($row)) {
    die("<center><b>Nenhum registro foi encontrado.</b></center>");
}
?>
<table border="1">
    <tr>
        <td><b>Data</b></td>
        <td><b>Dia</b></td>
        <td><b>Evento</b></td>
        <td><b>Hora</b></td> 
        <td><b>Evento</b></td>
        <td><b>Hora</b></td>   
    </tr>
    <?php    
    for ($i = 0; $i < sizeof($row); $i++) {
        if ($row[$i]['Evento'] == 'E') {
            echo "<tr>";
        }
        if ($row[$i]['Evento'] == 'E') {
            echo "<td>" . @date('d/m/Y', strtotime($row[$i]['Dia'])) . "</td>";
            echo "<td>" . $dias_semana[date("w", strtotime($row[$i]['Dia']))] . "</td>";
        }
        echo "<td>" . @evento_tipo($row[$i]['Evento']) . "</td>";
        echo "<td>" . @$row[$i]['Hora'] . "</td>";
        if ($row[$i]['Evento'] == 'S') {
            echo "</tr>";
        }
    }
    ?>                    
</table>
