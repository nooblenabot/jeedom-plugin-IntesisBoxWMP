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
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

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
	
	public function VerifyCommand () {
		
	}
	
		public function CreateCommand () {
		
		
	}
	
	public function executeCommand ($cmd = '') {
		log::add('IntesisBoxWMP', 'debug', 'BEGIN ' . __FUNCTION__ .' / $cmd = ' . $cmd);
		
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		
		$ip = $eqLogic->getConfiguration('ip');
		$PortCom = $eqLogic->getConfiguration('PortCom');
		$acNum = $eqLogic->getConfiguration('acNum');
		$delay=500;
		/* $command = ('SET'$acNum':ONOFF,'$cmd); */
		$param = $eqLogic->getConfiguration('param');
		
		if(socket_connect ($socket , $ip, $port))
		{
			usleep($delay*1000);
		
			log::add('IntesisBoxWMP', 'debug', 'CONNECTED, SENDING COMMAND (IP : ' . $ip . ', PORT : ' . $port . ')');
			
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
        $command = $this->getConfiguration('ParamCmd');
		$eqLogic = $this->getEqLogic();
		$eqlogic->executeCommand($command);
		}
    
    /*     * **********************Getteur Setteur*************************** */
}


