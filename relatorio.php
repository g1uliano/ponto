<?php
/* * ******************************************************************
 *  Sistema de Registro de Ponto
 *  Desenvolvido por: Giuliano Cardoso
 *  E-mail: giulianocf@gmail.com
 * ***************************************************************** */
//se o usuário não estiver autenticado, manda de volta para o lugar de onde ele veio, afinal, ele não foi convidado pra festa, foi?
session_start();

//url de acesso ao sistema.
$_SESSION['sca_url'] = 'http://' . $_SERVER['SERVER_ADDR'] . '' . $_SERVER["SCRIPT_NAME"];

if (!((isset($_SESSION['sca_id'])) && (isset($_SESSION['sca_grupo'])))) {
    Header("Location: ../sca/");
    exit;
}

function selectedItem($item) {
    if (date("n") == $item) {
        echo "selected=\"yes\"";
    }
}

function selectedItemA($item) {
    if ($item == date('Y')) {
        echo "selected=\"yes\"";
    }
}

function evento_tipo($tipo) {
    if ($tipo == 'E') {
        return 'Entrada';
    } else {
        return 'Saída';
    }
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
        <link rel="stylesheet" href="core/relatorio.css" type="text/css" />
        <script src="../sca/js/jquery-1.6.2.min.js"></script>
        <script src="../sca/js/gradient.js"></script>
        <script src="core/relatorio.js"></script>        
    </head>
    <body>          
        <p align="right">
            <input value="registrar ponto" class="registro_ponto" type="button"> &nbsp;
            <input value="sair" class="sair" type="button">
        </p>
        <div id="default">
            <div class="center">       
                <h1><b>Relatório de Frequência Mensal</b></h1>
                Mês <select name="mes_trabalhado">
                    <option <?php selectedItem(1); ?> value="1">Janeiro</option>
                    <option <?php selectedItem(2); ?> value="2">Fevereiro</option>
                    <option <?php selectedItem(3); ?> value="3">Março</option>
                    <option <?php selectedItem(4); ?> value="4">Abril</option>
                    <option <?php selectedItem(5); ?> value="5">Maio</option>
                    <option <?php selectedItem(6); ?> value="6">Junho</option>
                    <option <?php selectedItem(7); ?> value="7">Julho</option>
                    <option <?php selectedItem(8); ?> value="8">Agosto</option>
                    <option <?php selectedItem(9); ?> value="9">Setembro</option>
                    <option <?php selectedItem(10); ?> value="10">Outubro</option>
                    <option <?php selectedItem(11); ?> value="11">Novembro</option>
                    <option <?php selectedItem(12); ?> value="12">Dezembro</option>
                </select>
                &nbsp; Ano <select name="ano_trabalhado">
                    <option <?php selectedItemA(2011); ?> value="2011">2011</option>
                    <option <?php selectedItemA(2012); ?> value="2012">2012</option>
                    <option <?php selectedItemA(2013); ?> value="2013">2013</option>
                    <option <?php selectedItemA(2014); ?> value="2014">2014</option>
                    <option <?php selectedItemA(2015); ?> value="2015">2015</option>
                    <option <?php selectedItemA(2016); ?> value="2016">2016</option>
                    <option <?php selectedItemA(2017); ?> value="2017">2017</option>
                    <option <?php selectedItemA(2018); ?> value="2018">2018</option>
                    <option <?php selectedItemA(2019); ?> value="2019">2019</option>
                    <option <?php selectedItemA(2020); ?> value="2020">2020</option>
                </select>
                <?php
                if ($_SESSION['sca_grupo'] == 1) {
                    echo "&nbsp;Usuário ";
                    echo "<select name=\"usuario_t\">";
                    $sql = "select * from forasteiros;";
                    $row = $controle->local->QueryArray($sql, MYSQL_ASSOC);
                    for ($i = 0; $i < sizeof($row); $i++) {
                        echo "<option value=\"" . $row[$i]["Id"] . "\" ";
                        if ($_SESSION['sca_id'] == $row[$i]["exId"]) {
                            echo "selected=yes";
                        }
                        echo ">" . $row[$i]["fullname"] . "</option>";
                    }
                    echo "</select>";
                }
                ?>
                <br /><br />
                <div id="relatorios_table">
                </div>
            </div>
        </div>
    </body>
</html>
