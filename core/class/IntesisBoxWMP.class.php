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
		/*    
		$This->setConfiguration('portCom','3310');
		$This->setConfiguration('AcNum','1');
		*/
    }

    public function postUpdate() {
		
	/* Power on / off Status */
	
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
          //  $cmd->setValue('Etat');
            $cmd->setEqLogic_id($this->getId());
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
		//$cmd->setValue('Etat');
        $cmd->setEqLogic_id($this->getId());
        $cmd->save();
		
      /*
		$cmd = $this->getCmd(null,'ONOFF');
        if (!is_object($cmd)) {
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
      */
	 /* Mode Status */
	 
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
	  //  $cmd->setValue('Mode');
		$cmd->setEqLogic_id($this->getId());
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
		//$cmd->setValue('Mode');
        $cmd->setEqLogic_id($this->getId());
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
	  //  $cmd->setValue('Mode');
		$cmd->setEqLogic_id($this->getId());
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
		//$cmd->setValue('Mode');
        $cmd->setEqLogic_id($this->getId());
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
		//$cmd->setValue('Mode');
        $cmd->setEqLogic_id($this->getId());
        $cmd->save();
      /*
		$cmd = $this->getCmd(null,'MODE');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('MODE');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Etat', __FILE__));
        }
        $cmd->setType('info');
        $cmd->setSubType('numeric');
		$cmd->setDisplay('generic_type','GENERIC_INFO');
        $cmd->setConfiguration('OrdreFamille','MODE');
		$cmd->setEqLogic_id($this->getId());
        $cmd->save();
      */
	  
	  /* Ventilation Status */
	  
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
      */
	  
	  
	  
      /*
		if !(strpos($this->getConfiguration('IntesisBox_Type'),'IS-IR-WMP-1')) {
            $cmd = $this->getCmd(null,'AMBTEMP');
			if (!is_object($cmd)) {
				$cmd = new IntesisBoxWMPCmd();
				$cmd->setLogicalId('AMBTEMP');
				$cmd->setIsVisible(1);
				$cmd->setName(__('Temperature', __FILE__));
			}
			$cmd->setType('info');
			$cmd->setSubType('numeric');
			$cmd->setDisplay('generic_type','TEMPERATURE');
			$cmd->setConfiguration('OrdreFamille','AMBTEMP');
			$cmd->setUnite('°C');
			$cmd->setEqLogic_id($this->getId());
			$cmd->save();
		}
      */
		/*
		 if (strpos($this->getConfiguration('VANEUD'),'1')) {
            $cmd = $this->getCmd(null,'VANEUD');
			if (!is_object($cmd)) {
				$cmd = new IntesisBoxWMPCmd();
				$cmd->setLogicalId('VANEUD');
				$cmd->setIsVisible(1);
				$cmd->setName(__('Volet UP', __FILE__));
			}
			$cmd->setType('info');
			$cmd->setSubType('numeric');
			$cmd->setDisplay('generic_type','TEMPERATURE');
			$cmd->setConfiguration('OrdreFamille','AMBTEMP');
			$cmd->setUnite('°C');
			$cmd->setEqLogic_id($this->getId());
			$cmd->save();
		}
        */
/*

< [Tx]  LIMITS:*
> [rx]  LIMITS:ONOFF,[OFF,ON]
< [Tx]  CFG:*
< [Tx]  GET,1:*
> [rx]  LIMITS:MODE,[AUTO,HEAT,DRY,FAN,COOL]
> [rx]  LIMITS:FANSP,[AUTO,1,2,3,4]
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
	
	
	public function CreateCommand ($Ordre = '',$OrdreType='') {
		log::add('IntesisBoxWMP', 'debug', 'Construct ' . __FUNCTION__ .' / $Ordre = ' . $Ordre);
		$AcNum = $this->getConfiguration('AcNum');
      
       	$command = $OrdreType.','.$AcNum.':'.$Ordre;
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
        $ParamCmd = $this->getConfiguration('Ordre');
      	$TypeAction = $this->getType();
        $OrdreFamille=$this->getConfiguration('OrdreFamille');
        if($TypeAction == 'action' )
          {
              $Action = 'SET';
          }
        elseif($TypeAction == 'info' )
          {
              $Action = 'GET';
          }
        else
          {
          return false;
          }
        $Param = $OrdreFamille.','.$ParamCmd;
      	$eqLogic = $this->getEqLogic();
      log::add('IntesisBoxWMP', 'debug', 'Launch ' . __FUNCTION__ .' / $ParamCmd = ' . $ParamCmd);
		$eqLogic->CreateCommand($Param,$Action);
		}
    /*     * **********************Getteur Setteur*************************** */
}


