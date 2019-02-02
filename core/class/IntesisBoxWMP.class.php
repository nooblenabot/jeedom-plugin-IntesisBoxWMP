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
require_once __DIR__  . '/../../../../core/php/core.inc.php';

class IntesisBoxWMP extends eqLogic {
	
    /*     * *************************Attributs****************************** */

    /*     * ***********************Methode static*************************** */

    /*
     * Fonction exécutée automatiquement toutes les minutes par Jeedom
      public static function cron() {
      }
     */


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
		$this->setCategory('wellness', 1);
        
    }

    public function postInsert() {
        
    }

    public function preSave() {
        
    }

    public function postSave() {
		$AcON = $this->getCmd(null, 'AcON');
		if (!is_object($AcON)) {
			$AcON = new IntesisBoxWMPCmd();
			$AcON->setName(__('ON', __FILE__));
			$AcON->setLogicalId('AcON');
			$AcON->setIsVisible(1);
			$AcON->setTemplate('dashboard', 'prise');
		}
		$AcON->setType('action');
		$AcON->setSubType('other');
		$AcON->setEqLogic_id($this->getId());
		$AcON->setDisplay('generic_type', 'ENERGY_ON')
		$AcON->setValue($power_state_id);
		$AcON->save();
		
		$AcOFF = $this->getCmd(null, 'AcOFF');
		if (!is_object($AcOFF)) {
			$AcOFF = new IntesisBoxWMPCmd();
			$AcOFF->setName(__('OFF', __FILE__));
			$AcOFF->setLogicalId('AcOFF');
			$AcOFF->setIsVisible(1);
			$AcOFF->setTemplate('dashboard', 'prise');
		}
		$AcOFF->setType('action');
		$AcOFF->setSubType('other');
		$AcOFF->setEqLogic_id($this->getId());
		$AcOFF->setDisplay('generic_type', 'ENERGY_OFF')
		$AcOFF->setValue($power_state_id);
		$AcOFF->save();
		
		if ($this->getConfiguration('IntesisBox_Type') != 'IS-IR-WMP-1') {
			$AmbTemp = $this->getCmd(null, 'Ambient_Temp');
				if (!is_object($AmbTemp)) {
					$AmbTemp = new IntesisBoxWMPCmd();
					$AmbTemp->setLogicalId('Ambient_Temp');
					$AmbTemp->setIsVisible(1);
					$AmbTemp->setName(__('Temperature Ambiante', __FILE__));
				}
				$AmbTemp->setType('info');
				$AmbTemp->setSubType('string');
				$AmbTemp->setEqLogic_id($this->getId());
				$AmbTemp->setDisplay('generic_type', 'GENERIC');
				$AmbTemp->save();
		}
		
		if ($this->getConfiguration('IntesisBox_Type') != 'IS-IR-WMP-1') {
			$ErrSt = $this->getCmd(null, 'Error_Status');
				if (!is_object($ErrSt)) {
					$ErrSt = new IntesisBoxWMPCmd();
					$ErrSt->setLogicalId('Error_Status');
					$ErrSt->setIsVisible(1);
					$ErrSt->setName(__('Statut', __FILE__));
				}
				$ErrSt->setType('info');
				$ErrSt->setSubType('string');
				$ErrSt->setEqLogic_id($this->getId());
				$ErrSt->setDisplay('generic_type', 'GENERIC');
				$ErrSt->save();
		}
		
		if ($this->getConfiguration('IntesisBox_Type') != 'IS-IR-WMP-1') {
			$ErrCode = $this->getCmd(null, 'Error_Code');
				if (!is_object($ErrCode)) {
					$ErrCode = new IntesisBoxWMPCmd();
					$ErrCode->setLogicalId('Error_Code');
					$ErrCode->setIsVisible(1);
					$ErrCode->setName(__('Code Erreur', __FILE__));
				}
				$ErrCode->setType('info');
				$ErrCode->setSubType('string');
				$ErrCode->setEqLogic_id($this->getId());
				$ErrCode->setDisplay('generic_type', 'GENERIC');
				$ErrCode->save();
		}
		
		$refresh = $this->getCmd(null, 'refresh');
		if (!is_object($refresh)) {
			$refresh = new IntesisBoxWMPCmd();
			$refresh->setName(__('Rafraichir', __FILE__));
		}
		$refresh->setEqLogic_id($this->getId());
		$refresh->setLogicalId('refresh');
		$refresh->setType('action');
		$refresh->setSubType('other');
		$refresh->save();
    }

    public function preUpdate() {
        		if ($this->getConfiguration('ip') == '') {
			throw new Exception(__('Le champs IP ne peut etre vide', __FILE__));
		}

    }

    public function postUpdate() {
        
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
        $eqLogic = $this->getEqLogic();
		$IP = $eqLogic->getConfiguration('ip');
		$PortComm = $eqLogic->getConfiguration('PortComm')
		$acNum = $eqLogic->getConfiguration('acNum')'';
		$type = $this->getType();
		$cmds = $this->getLogicalId();
		switch ($this->getSubType()) {
			case 'slider':
				$cmds = trim(str_replace('#slider#', $_options['slider'], $cmds));
				break;
			case 'select':
				$cmds = trim(str_replace('#listValue#', $_options['select'], $cmds));
				break;
			case 'message':
				$cmds = trim(str_replace('#message#', $_options['message'], $cmds));
				$cmds = trim(str_replace('#title#', $_options['title'], $cmds));
				break;
		}
		$cmds = explode(',', $cmds);
		$index=0;
		$delay=0;
		foreach ($cmds as $cmd) {
			$cmd = trim($cmd);
			$index++;
			if ($type == 'action') {
				if ($cmd == 'AcON') {
					$command = 'SET'$acNum':ONOFF,ON';
					$request_tcp=fsockopen($IP,$PortComm,,,):$command;
					$this->$request_tcp;
					$delay=2;
					$This->fclose($request_tcp)
				} else if ($cmd == 'off') {
					if ($eqLogic->getConfiguration('volumedefault')>0) {
						$request_http = new com_http('http://' . $IP . self::URL_POST . '?'.(($zone=='')?'MV':$zone) .str_pad( $eqLogic->getConfiguration('volumedefault'), 2, "0", STR_PAD_LEFT ));
						$this->http_exec_wrapper($request_http, 2);
						sleep(1);
					}
					$request_http = new com_http('http://' . $IP . self::URL_POST . '?'.(($zone=='')?'PWSTANDBY':$zone.'OFF'));
					$ret = $this->http_exec_wrapper($request_http, 4);
					if ($ret) $delay=5;
				} else if ($cmd == 'volume_set') {
					$request_http = new com_http('http://' . $IP . self::URL_POST . '?'.(($zone=='')?'MV':$zone) .str_pad( min($_options['slider'],$eqLogic->getConfiguration('volumemax')), 2, "0", STR_PAD_LEFT ));
					$request_http->exec();
				} else if ( strpos($cmd, 'volume_set_') === 0) {
					$request_http = new com_http('http://' . $IP . self::URL_POST . '?'.(($zone=='')?'MV':$zone) .str_pad( min(substr($cmd, -1),$eqLogic->getConfiguration('volumemax')), 2, "0", STR_PAD_LEFT ));
					$request_http->exec();
				} else if ($cmd == 'volume_up') {
					$request_http = new com_http('http://' . $IP . self::URL_POST . '?'.(($zone=='')?'MV':$zone).'UP');
					for ($i = 0; $i <= $eqLogic->getConfiguration('volumestep',1); $i++) {
						$request_http->exec();
						usleep(250000);
					}
				} else if ($cmd == 'volume_down') {
					$request_http = new com_http('http://' . $IP . self::URL_POST . '?'.(($zone=='')?'MV':$zone).'DOWN');
					for ($i = 0; $i <= $eqLogic->getConfiguration('volumestep',1); $i++) {
						$request_http->exec();
						usleep(250000);
					}
				} else if ($cmd == 'mute_on') {

				} else if ( strpos($cmd, 'fav_') === 0) {	// is a fav call
					$request_http = new com_http('http://' . $IP . self::URL_CALLFAVORITE . '?0' . substr($cmd, -1) );
					$ret = $this->http_exec_wrapper($request_http, 2);
					if ($ret===false) {	// alternative way of calling favorites (eg: for AVR)
						$request_http = new com_http('http://' . $IP . self::URL_POST . '?'.(($zone=='')?'ZM':$zone).'FAVORITE'.substr($cmd, -1));
						$request_http->exec();
					}
				} else if ($cmd == 'sleep') {
					
				} else if ($cmd == 'refresh' || $cmd == 'reachable') {
					// do nothing
				} else {	// other commands
					$request_http = new com_http('http://' . $IP . self::URL_POST . '?' . urlencode(strtoupper($cmd)) );
					$request_http->exec();
				}
				if ( $index==count($cmds) ) {	// update on last cmd
					sleep(1+$delay);
					$eqLogic->updateInfo();
				}
			}
			else {		// if 'info'
				$eqLogic->updateInfo();
			}
		}
    }

    /*     * **********************Getteur Setteur*************************** */
	
		function http_exec_wrapper($request_http, $timeout=2) {
		try {
			$request_http->exec($timeout);
			return true;
		} catch (Exception $e) {
			if ($this->getConfiguration('canBeShutdown') == 1) {
				return false;
			} else {
				throw new $e;
			}
		}
	}
}


