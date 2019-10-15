<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once __DIR__ . '/../../../../core/php/core.inc.php';

class IntesisBoxWMP extends eqLogic {
	
    /*     * *************************Attributs****************************** */

    /*     * ***********************Methode static*************************** */

    /*
     * Fonction exécutée automatiquement toutes les minutes par Jeedom
      public static function cron() {
		  
		  
      }
     */


     /* Fonction exécutée automatiquement toutes les 15 minutes par Jeedom */
     /* public static function cron15() {
      }

    /*
     * Fonction exécutée automatiquement toutes les heures par Jeedom
      public static function cronHourly() {
      }
     */

    /*
     * Fonction exécutée automatiquement tous les jours par Jeedom
      public static function cronDaily() {
      }
     */



    /*     * *********************Méthodes d'instance************************* */

    public function preInsert() {
		/*$this->setCategory('wellness', 1);
        */
    }

    public function postInsert() {
        
    }

    public function preSave() {
        
    }

    public function postSave() {
				
    }

    public function preUpdate() {
		
        if ($this->getConfiguration('ip') == '') {
			throw new Exception(__('Le champs IP ne peut etre vide', __FILE__));
		}
		    
		$this->setConfiguration('portCom','3310');
		$this->setConfiguration('AcNum','1');
		
	}

    public function postUpdate() {
		
	/* Power on / off Status */
	
	 	$cmd = $this->getCmd(null,'ONOFF');
        if (!is_object($cmd)) {
			log::add('IntesisBoxWMP', 'debug', 'Command n\'existe pas , creation (' . $cmd . ')');
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('ONOFF');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Etat', __FILE__));
        }
		
        $cmd->setType('info');
        $cmd->setSubType('binary');
		$cmd->setDisplay('generic_type','GENERIC_INFO');
        $cmd->setConfiguration('OrdreFamille','ONOFF');
		$cmd->setEqLogic_id($this->getId());
        $cmd->save();
		$EtatStatusId='';
		$state_id = $cmd->getId();
		if ($cmd ->getLogicalId()=='ONOFF') $EtatStatusId = $state_id;
		$cmd->save();
    	
		$cmd = $this->getCmd(null,'ONOFF.ON');
		if (!is_object($cmd)) {
			$cmd = new IntesisBoxWMPCmd();
			$cmd->setLogicalId('ONOFF.ON');
			$cmd->setIsVisible(1);
			$cmd->setName(__('On', __FILE__));
		}
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setConfiguration('OrdreFamille','ONOFF');
		$cmd->setConfiguration('Ordre','ON');
		$cmd->setValue('ONOFF');
		$cmd->setEqLogic_id($this->getId());
		$cmd->save();
		if($cmd->getValue()=='ONOFF') $cmd->setValue($EtatStatusId);
		$cmd->save();
		
      
      	$cmd = $this->getCmd(null,'ONOFF.OFF');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('ONOFF.OFF');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Off', __FILE__));
        }
        $cmd->setType('action');
        $cmd->setSubType('other');
        $cmd->setConfiguration('OrdreFamille','ONOFF');
		$cmd->setConfiguration('Ordre','OFF');
		$cmd->setValue('ONOFF');
        $cmd->setEqLogic_id($this->getId());
        $cmd->save();
		if($cmd->getValue()=='ONOFF') $cmd->setValue($EtatStatusId);
		$cmd->save();
		
	 /* Mode Status */
	 
		$cmd = $this->getCmd(null,'MODE');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('MODE');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Mode', __FILE__));
        }
        $cmd->setType('info');
        $cmd->setSubType('string');
		$cmd->setDisplay('generic_type','GENERIC_INFO');
        $cmd->setConfiguration('OrdreFamille','MODE');
		$cmd->setEqLogic_id($this->getId());
        $cmd->save();
		$EtatModeId='';
		$state_id = $cmd->getId();
		if ($cmd ->getLogicalId()=='MODE') $EtatModeId = $state_id;
		$cmd->save();
	 
		$cmd = $this->getCmd(null,'MODE.AUTO');
		if (!is_object($cmd)) {
			$cmd = new IntesisBoxWMPCmd();
			$cmd->setLogicalId('MODE.AUTO');
			$cmd->setIsVisible(1);
			$cmd->setName(__('Mode Auto', __FILE__));
		}
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setConfiguration('OrdreFamille','MODE');
		$cmd->setConfiguration('Ordre','AUTO');
	  $cmd->setValue('MODE');
		$cmd->setEqLogic_id($this->getId());
		$cmd->save();
		if($cmd->getValue()=='MODE') $cmd->setValue($EtatModeId);
		$cmd->save();
      
      	$cmd = $this->getCmd(null,'MODE.HEAT');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('MODE.HEAT');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Chaud', __FILE__));
        }
        $cmd->setType('action');
        $cmd->setSubType('other');
        $cmd->setConfiguration('OrdreFamille','MODE');
		$cmd->setConfiguration('Ordre','HEAT');
		$cmd->setDisplay('icon', '<i class="fa fa-power-off"></i>');
		$cmd->setValue('MODE');
        $cmd->setEqLogic_id($this->getId());
        $cmd->save();
		if($cmd->getValue()=='MODE') $cmd->setValue($EtatModeId);
		$cmd->save();
		
		$cmd = $this->getCmd(null,'MODE.DRY');
		if (!is_object($cmd)) {
			$cmd = new IntesisBoxWMPCmd();
			$cmd->setLogicalId('MODE.DRY');
			$cmd->setIsVisible(1);
			$cmd->setName(__('Deshum', __FILE__));
		}
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setConfiguration('OrdreFamille','MODE');
		$cmd->setConfiguration('Ordre','DRY');
	 $cmd->setValue('MODE');
		$cmd->setEqLogic_id($this->getId());
		$cmd->save();
		if($cmd->getValue()=='MODE') $cmd->setValue($EtatModeId);
		$cmd->save();
      
      	$cmd = $this->getCmd(null,'MODE.FAN');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('MODE.FAN');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Ventil', __FILE__));
        }
        $cmd->setType('action');
        $cmd->setSubType('other');
        $cmd->setConfiguration('OrdreFamille','MODE');
		$cmd->setConfiguration('Ordre','FAN');
		$cmd->setValue('MODE');
        $cmd->setEqLogic_id($this->getId());
        $cmd->save();
		if($cmd->getValue()=='MODE') $cmd->setValue($EtatModeId);
		$cmd->save();
		
		$cmd = $this->getCmd(null,'MODE.COOL');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('MODE.COOL');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Froid', __FILE__));
        }
        $cmd->setType('action');
        $cmd->setSubType('other');
        $cmd->setConfiguration('OrdreFamille','MODE');
		$cmd->setConfiguration('Ordre','COOL');
		$cmd->setValue('MODE');
        $cmd->setEqLogic_id($this->getId());
        $cmd->save();
		if($cmd->getValue()=='MODE') $cmd->setValue($EtatModeId);
		$cmd->save();
		
	/* Temperature de consigne */	
		
		
		$cmd = $this->getCmd(null,'SETPTEMP');
		if (!is_object($cmd)) {
			$cmd = new IntesisBoxWMPCmd();
			$cmd->setLogicalId('SETPTEMP');
			$cmd->setIsVisible(1);
			$cmd->setName(__('Temprature Consigne', __FILE__));
		}
		$cmd->setType('info');
		$cmd->setSubType('numeric');
		$cmd->setDisplay('generic_type','THERMOSTAT_SETPOINT');
		$cmd->setConfiguration('OrdreFamille','SETPTEMP');
		$cmd->setUnite('°C');
		$cmd->setConfiguration('minValue','16');
		$cmd->setConfiguration('setmaxValue','30');
		$cmd->setEqLogic_id($this->getId());
		$cmd->save();
		$CTemp='';
		$state_id = $cmd->getId();
		if ($cmd ->getLogicalId()=='SETPTEMP') $Ctemp = $state_id;
		$cmd->save();
			
		$cmd = $this->getCmd(null,'SETPTEMP.Act');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('SETPTEMP.Act');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Consigne', __FILE__));
        }
        $cmd->setType('action');
        $cmd->setSubType('slider');
        $cmd->setConfiguration('OrdreFamille','SETPTEMP');
		$cmd->setConfiguration('Ordre','');
		$cmd->setDisplay('generic_type','THERMOSTAT_SET_SETPOINT');
		$cmd->setValue('SETPTEMP');
		$cmd->setConfiguration('minValue', 16);
		$cmd->setConfiguration('maxValue', 30);
		$cmd->setTemplate('dashboard','button');
        $cmd->setEqLogic_id($this->getId());
        $cmd->save();
		if($cmd->getValue()=='SETPTEMP') $cmd->setValue($Ctemp);
		$cmd->save();
			
        
     	  
	  /* Ventilation Status */
	  
	        /*
		$cmd = $this->getCmd(null,'FANSP');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('FANSP');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Etat', __FILE__));
        }
        $cmd->setType('info');
        $cmd->setSubType('numeric');
		$cmd->setDisplay('generic_type','GENERIC_INFO');
        $cmd->setConfiguration('OrdreFamille','FANSP');
		$cmd->setEqLogic_id($this->getId());
        $cmd->save();
      
	  	  
		$cmd = $this->getCmd(null,'FANSP.AUTO');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('FANSP.AUTO');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Fan Auto', __FILE__));
        }
        $cmd->setType('action');
        $cmd->setSubType('other');
        $cmd->setConfiguration('OrdreFamille','FANSP');
		$cmd->setConfiguration('Ordre','AUTO');
		//$cmd->setValue('Mode');
        $cmd->setEqLogic_id($this->getId());
        $cmd->save();
	  
		$cmd = $this->getCmd(null,'FANSP.1');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('FANSP.1');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Fan Silent', __FILE__));
        }
        $cmd->setType('action');
        $cmd->setSubType('other');
        $cmd->setConfiguration('OrdreFamille','FANSP');
		$cmd->setConfiguration('Ordre','1');
		//$cmd->setValue('Mode');
        $cmd->setEqLogic_id($this->getId());
        $cmd->save();
		
		$cmd = $this->getCmd(null,'FANSP.2');
		if (!is_object($cmd)) {
			$cmd = new IntesisBoxWMPCmd();
			$cmd->setLogicalId('FANSP.2');
			$cmd->setIsVisible(1);
			$cmd->setName(__('Fan 1', __FILE__));
		}
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setConfiguration('OrdreFamille','FANSP');
		$cmd->setConfiguration('Ordre','2');
	  //  $cmd->setValue('Mode');
		$cmd->setEqLogic_id($this->getId());
		$cmd->save();
      
      	$cmd = $this->getCmd(null,'FANSP.3');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('FANSP.3');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Fan 2', __FILE__));
        }
        $cmd->setType('action');
        $cmd->setSubType('other');
        $cmd->setConfiguration('OrdreFamille','FANSP');
		$cmd->setConfiguration('Ordre','3');
		//$cmd->setValue('Mode');
        $cmd->setEqLogic_id($this->getId());
        $cmd->save();
		
		$cmd = $this->getCmd(null,'FANSP.4');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('FANSP.4');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Fan 3', __FILE__));
        }
        $cmd->setType('action');
        $cmd->setSubType('other');
        $cmd->setConfiguration('OrdreFamille','FANSP');
		$cmd->setConfiguration('Ordre','4');
		//$cmd->setValue('Mode');
        $cmd->setEqLogic_id($this->getId());
        $cmd->save();
	  */


/* Creation commandes si presence des volets Horizontaux / Verticaux */
/*
		if ($this->getConfiguration('VANEUD')=='1') {
            $cmd = $this->getCmd(null,'VANEUD');
			if (!is_object($cmd)) {
				$cmd = new IntesisBoxWMPCmd();
				$cmd->setLogicalId('VANEUD');
				$cmd->setIsVisible(1);
				$cmd->setName(__('Volet Horizontal', __FILE__));
			}
			$cmd->setType('info');
			$cmd->setSubType('string');
			$cmd->setDisplay('generic_type','GENERIC_INFO');
			$cmd->setConfiguration('OrdreFamille','VANEUD');
			$cmd->setEqLogic_id($this->getId());
			$cmd->save();
		$Vane='';
		$state_id = $cmd->getId();
		if ($cmd ->getLogicalId()=='VANEUD') $Vane = $state_id;
		$cmd->save();
			
		$cmd = $this->getCmd(null,'VANEUD.4');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('VANEUD.4');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Volet Auto', __FILE__));
        }
        $cmd->setType('action');
        $cmd->setSubType('other');
        $cmd->setConfiguration('OrdreFamille','VANEUD');
		$cmd->setConfiguration('Ordre','4');
		$cmd->setValue('VANEUD');
        $cmd->setEqLogic_id($this->getId());
		//$cmd->setConfiguration('listValue','5|Arrêt;6|Hors-Gel;4|Eco;8|Confort -2;7|Confort -1;3|Confort');
        $cmd->save();
		if($cmd->getValue()=='VANEUD') $cmd->setValue($Vane);
		$cmd->save();
			
		}
        */

/* Recuperation de temperature ambiante + retour erreurs si non infra-rouge */
    /*  
		if ($this->getConfiguration('IntesisBox_Type')!='IS-IR-WMP-1') {
            $cmd = $this->getCmd(null,'AMBTEMP');
			if (!is_object($cmd)) {
				$cmd = new IntesisBoxWMPCmd();
				$cmd->setLogicalId('AMBTEMP');
				$cmd->setIsVisible(1);
				$cmd->setName(__('Temperature', __FILE__));
			}
			$cmd->setType('info');
			$cmd->setSubType('numeric');
			$cmd->setDisplay('generic_type','THERMOSTAT_TEMPERATURE');
			$cmd->setConfiguration('OrdreFamille','AMBTEMP');
			$cmd->setUnite('°C');
			$cmd->setEqLogic_id($this->getId());
			$cmd->save();
			
			
		}
		*/
/*


< [Tx]  GET,1:*
> [rx]  LIMITS:VANEUD,[AUTO,SWING,PULSE]
> [rx]  LIMITS:VANELR,[]
> [rx]  LIMITS:SETPTEMP,[160,300]
> [rx]  CHN,1:ONOFF,OFF
> [rx]  CHN,1:MODE,HEAT
> [rx]  CHN,1:FANSP,1
> [rx]  CHN,1:VANEUD,AUTO
> [rx]  CHN,1:VANELR,AUTO
> [rx]  CHN,1:SETPTEMP,210
> [rx]  CHN,1:AMBTEMP,285
> [rx]  CHN,1:ERRSTATUS,OK
> [rx]  CHN,1:ERRCODE,0
*/

		
        
    }

    public function preRemove() {
        
    }

    public function postRemove() {
        
    }

    /*
     * Non obligatoire mais permet de modifier l'affichage du widget si vous en avez besoin
      public function toHtml($_version = 'dashboard') {

      }
     */

    /*
     * Non obligatoire mais ca permet de déclencher une action après modification de variable de configuration
    public static function postConfig_<Variable>() {
    }
     */

    /*
     * Non obligatoire mais ca permet de déclencher une action avant modification de variable de configuration
    public static function preConfig_<Variable>() {
    }
     */

    /*     * **********************Getteur Setteur*************************** */
	
	
	public function CreateCommand ($ParamCmd = '',$OrdreType='',$ParamFamille='') {
		/* Constantes */
		log::add('IntesisBoxWMP', 'debug', 'Construct ' . __FUNCTION__ .' / $Ordre = ' . $Ordre);
		$AcNum = $this->getConfiguration('AcNum');
		
/* recuperation temperature consigne + passage en non decimal */
		if ($ParamFamille == 'SETPTEMP' and $OrdreType== 'action'){
          log::add('IntesisBoxWMP', 'debug', 'coucou');
         /* $cmd = $this->getCmd(null,'FANSP.4');
          if ($cmd ->getLogicalId()=='VANEUD') $Vane = $state_id;
   			$encTemp = getLogicalId()==;
          log::add('IntesisBoxWMP', 'debug', 'Temp ' . $encTemp);
			$encTemp->setConfiguration('Ordre',$STtemp);
          */
           $ParamCmd = $ParamCmd *10;
		}
		
		/* action ou info ? */
		if($OrdreType == 'action' )
          {
              $Action = 'SET';
			  $Ordre = $ParamFamille.','.$ParamCmd;
          }
        elseif($OrdreType == 'info' )
          {
              $Action = 'GET';
			  $Ordre = $ParamFamille;
          }
        else
          {
          return false;
          }
        
        $command = $Action.','.$AcNum.':'.$Ordre;
		log::add('IntesisBoxWMP', 'debug', 'EndCreate ' . __FUNCTION__ .' / $command = ' . $command);
		$this->executeCommand($command);
		}
		
	public function executeCommand ($cmd = '') {
		log::add('IntesisBoxWMP', 'debug', 'BEGIN ' . __FUNCTION__ .' / $cmd = ' . $cmd);
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		
		$ip = $this->getConfiguration('ip');
		$PortCom = $this->getConfiguration('portCom');
		$delay=500;
		
		if(socket_connect ($socket , $ip, $PortCom))
		{
			usleep($delay*1000);
		
			log::add('IntesisBoxWMP', 'debug', 'CONNECTED, SENDING COMMAND (IP : ' . $ip . ', PORT : ' . $PortCom . ')');
			
			log::add('IntesisBoxWMP', 'debug', 'CONNECTED, SENDING COMMAND (' . $cmd . ')');
			socket_write ($socket ,$cmd . "\r\n");
			
			usleep(500000);
			log::add('IntesisBoxWMP', 'debug', 'CLOSING CONNECTION');
			socket_close($socket);
			log::add('IntesisBoxWMP', 'debug', 'CLOSED');
			
		}
		return false;
	}
	
	public function returnCommand ()
	{
		
	}
	
}

class IntesisBoxWMPCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    /*
     * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
      public function dontRemoveCmd() {
      return true;
      }
     */
 
    public function execute($_options = array()) {
		$_action = $this->getLogicalId();
/* surcharge pour consigne temperature */
		if ($_action == 'SETPTEMP.Act') {
                $STtemp = $_options['slider'];
				$this->setConfiguration('Ordre',$STtemp);
		}
		
        $Param = $this->getConfiguration('Ordre');
      	$Action = $this->getType();
        $OrdreFamille=$this->getConfiguration('OrdreFamille');
        $eqLogic = $this->getEqLogic();
      log::add('IntesisBoxWMP', 'debug', 'Launch ' . __FUNCTION__ .' / $Param = ' . $Param.'+'.$Action.'+'.$OrdreFamille);
		$eqLogic->CreateCommand($Param,$Action,$OrdreFamille);
		}
    /*     * **********************Getteur Setteur*************************** */
}


