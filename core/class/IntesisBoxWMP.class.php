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


