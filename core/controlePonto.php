<?php

class controlePonto {

    public $sca = NULL;
    public $local = NULL;

    public function __construct() {
        $this->sca = new MySQL();
        $this->local = new MySQL(true, 'sisrf', '127.0.0.1', 'root', '');
    }

    public function __destruct() {
        $this->sca->Close();
        $this->local->Close();
    }

    public function scaGetUser($exId) {        
        return $this->sca->QuerySingleRowArray("SELECT * from usuarios WHERE id = $exId", MYSQL_ASSOC);
    }

    public function sessionGetUserId() {
        if (isset($_SESSION)) {
            return $_SESSION['sca_id'];
        } else {
            return FALSE;
        }
    }

    public function localGetUser($exId) {
        $sql = "SELECT * from forasteiros WHERE exId = $exId";
        if ($this->local->IsConnected()) {
            return $this->local->QuerySingleRowArray($sql, MYSQL_ASSOC);
        }
    }

    public function criaUsuario($exId, $fullname) {
        return $this->local->Query("INSERT INTO `forasteiros` (`exId`, `fullname`) VALUES ($exId, '$fullname');");
    }

    public function autoImportaUsuario() {
        $local = $this->sessionGetUserId();
        if ($this->localGetUser($local)==FALSE) {
            $row = $this->scaGetUser($local);
            $this->criaUsuario($row['id'],$row['fullname']);
        }        
    }
    
    public function getLastPontoEvent($data = null) {
         date_default_timezone_set('America/Manaus');
         if (is_null($data)) {
             $data = date('Y-m-d');
         }
         $local = $this->localGetUser($this->sessionGetUserId());
         $local = $local['Id'];
         $sql = "SELECT * FROM `folha_ponto` WHERE `dia` = '$data' AND Usuario = ".$local." order by ID DESC;";
         $retorno = $this->local->QuerySingleRowArray($sql, MYSQL_ASSOC);
         if ($retorno==FALSE) {
             return $retorno;
         } else {
             return $retorno['Evento'];
         }
    }
    
    public function insereEvento($Id,$Evento) {
        date_default_timezone_set('America/Manaus');
        $data = date('Y-m-d');
        $hora = date('H:i:s');
        $sql = "INSERT INTO `folha_ponto` (`Dia`, `Hora`, `Evento`, `Usuario`)".                
               " VALUES ('$data', '$hora', '$Evento', $Id);";    
        return $this->local->Query($sql);
    }
    
    public function registraPonto() {
        $local = $this->localGetUser($this->sessionGetUserId());
        $local = $local['Id'];
        $lEvent = $this->getLastPontoEvent();        
        if ($lEvent==FALSE) {
            return $this->insereEvento($local,'E');                
        } else if ($lEvent=='E') {
            
            return $this->insereEvento($local,'S');                
        } else {
            return FALSE;
        }            
    }

}

?>
