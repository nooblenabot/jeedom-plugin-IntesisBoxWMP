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

  /* Fonction exécutée automatiquement toutes les 5 minutes par Jeedom */
  public static function cron5() {
		foreach (eqLogic::byType('IntesisBoxWMP',true) as $IntesisBoxWMP) {
				$AcNum = $IntesisBoxWMP->getConfiguration('AcNum');
				$IntesisBoxWMP->executeCommand('GET,'.$AcNum.':AMBTEMP');
		}		
    }

  /* Fonction exécutée automatiquement toutes les 15 minutes par Jeedom */
  public static function cron15() {
		foreach (eqLogic::byType('IntesisBoxWMP',true) as $IntesisBoxWMP) {
			$AcNum = $IntesisBoxWMP->getConfiguration('AcNum');
			$IntesisBoxWMP->executeCommand('GET,'.$AcNum.':*');
		}
    }

  /*     * *********************Méthodes d'instance************************* */

  // Fonction exécutée automatiquement avant la création de l'équipement
  public function preInsert() {
  }

  // Fonction exécutée automatiquement après la création de l'équipement
  public function postInsert() {
  }

  // Fonction exécutée automatiquement avant la mise à jour de l'équipement
    // Fonction exécutée automatiquement avant la sauvegarde (création ou mise à jour) de l'équipement
  public function preSave() {
  }
  public function preUpdate() {
		
        if ($this->getConfiguration('ip') == '') {
			throw new Exception(__('Le champs IP ne peut etre vide', __FILE__));
		}
		
		if ($this->getConfiguration('portCom') == '') {
			$this->setConfiguration('portCom','3310');
		}		

		if ($this->getConfiguration('AcNum') == '') {
			$this->setConfiguration('AcNum','1');
		}
		
  }

  // Fonction exécutée automatiquement après la mise à jour de l'équipement
  public function postUpdate() {
		
	/* Power on / off Status */
	
	 	$cmd = $this->getCmd(null,'ONOFF');
        if (!is_object($cmd)) {
			$cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('ONOFF');
            $cmd->setIsVisible(0);
            $cmd->setName(__('Etat', __FILE__));
        }
		
        $cmd->setType('info');
        $cmd->setSubType('binary');
		$cmd->setDisplay('generic_type','GENERIC_INFO');
        $cmd->setConfiguration('OrdreFamille','ONOFF');
		$cmd->setEqLogic_id($this->getId());
		$cmd->setIsVisible(1);
		$cmd->setTemplate('dashboard', 'toggle');
		$cmd->setTemplate('mobile', 'toggle');
		if ($cmd->getName() == 'Etat' || $cmd->getName() == __('Etat', __FILE__)) {
			$cmd->setName(__('Marche', __FILE__));
		}
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
			$cmd->setTemplate('dashboard','circle');
		}
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->setConfiguration('OrdreFamille','ONOFF');
		$cmd->setConfiguration('Ordre','ON');
		$cmd->setValue('ONOFF');
		$cmd->setEqLogic_id($this->getId());
		if ($cmd->getTemplate('dashboard') == '' || $cmd->getTemplate('dashboard') == 'circle') {
			$cmd->setTemplate('dashboard', 'binarySwitch');
			$cmd->setTemplate('mobile', 'binarySwitch');
		}
		$cmd->save();
		if($cmd->getValue()=='ONOFF') $cmd->setValue($EtatStatusId);
		$cmd->save();
		
      	$cmd = $this->getCmd(null,'ONOFF.OFF');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('ONOFF.OFF');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Off', __FILE__));
			$cmd->setTemplate('dashboard','circle');
        }
        $cmd->setType('action');
        $cmd->setSubType('other');
        $cmd->setConfiguration('OrdreFamille','ONOFF');
		$cmd->setConfiguration('Ordre','OFF');
		$cmd->setValue('ONOFF');
		$cmd->setEqLogic_id($this->getId());
		if ($cmd->getTemplate('dashboard') == '' || $cmd->getTemplate('dashboard') == 'circle') {
			$cmd->setTemplate('dashboard', 'binarySwitch');
			$cmd->setTemplate('mobile', 'binarySwitch');
		}
        $cmd->save();
		if($cmd->getValue()=='ONOFF') $cmd->setValue($EtatStatusId);
		$cmd->save();
		
	 /* Mode Status */
	 
		$cmd = $this->getCmd(null,'MODE');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('MODE');
            $cmd->setIsVisible(0);
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
	 
		$cmd = $this->getCmd(null,'MODE.CFG');
		if (!is_object($cmd)) {
			$cmd = new IntesisBoxWMPCmd();
			$cmd->setLogicalId('MODE.CFG');
			$cmd->setIsVisible(1);
			$cmd->setName(__('Mode Fonctionnement', __FILE__));
		}
		$cmd->setType('action');
		$cmd->setSubType('select');
		$cmd->setConfiguration('OrdreFamille','MODE');
		$cmd->setConfiguration('Ordre','');
		$cmd->setValue('MODE');
		$cmd->setConfiguration('listValue','AUTO|Auto;HEAT|Chauffage;DRY|Deshumidification;FAN|Ventilation;COOL|refroidissement');
		$cmd->setEqLogic_id($this->getId());
		$cmd->save();
		if($cmd->getValue()=='MODE') $cmd->setValue($EtatModeId);
		$cmd->save();
		
	/* Temperature de consigne */	
		
		$cmd = $this->getCmd(null,'SETPTEMP');
		if (!is_object($cmd)) {
			$cmd = new IntesisBoxWMPCmd();
			$cmd->setLogicalId('SETPTEMP');
			$cmd->setIsVisible(0);
			$cmd->setName(__('Temprature Consigne', __FILE__));
		}
		$cmd->setType('info');
		$cmd->setSubType('numeric');
		$cmd->setDisplay('generic_type','THERMOSTAT_SETPOINT');
		$cmd->setConfiguration('OrdreFamille','SETPTEMP');
		$cmd->setUnite('°C');
		$cmd->setConfiguration('minValue',16);
		$cmd->setConfiguration('maxValue',30);
		$cmd->setEqLogic_id($this->getId());
		$cmd->save();
		$CTemp='';
		$state_id = $cmd->getId();
		if ($cmd ->getLogicalId()=='SETPTEMP') $Ctemp = $state_id;
		$cmd->save();
			
		$cmd = $this->getCmd(null,'SETPTEMP.CFG');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('SETPTEMP.CFG');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Consigne', __FILE__));
			$cmd->setTemplate('dashboard','button');
			$cmd->setSubType('slider');
        }
        $cmd->setType('action');
        $cmd->setConfiguration('OrdreFamille','SETPTEMP');
		$cmd->setConfiguration('Ordre','');
		$cmd->setDisplay('generic_type','THERMOSTAT_SET_SETPOINT');
		$cmd->setValue('SETPTEMP');
		$cmd->setConfiguration('minValue', 16);
		$cmd->setConfiguration('maxValue', 30);
        $cmd->setEqLogic_id($this->getId());
        $cmd->save();
		if($cmd->getValue()=='SETPTEMP') $cmd->setValue($Ctemp);
		$cmd->save();
			 	  
	  /* Ventilation Status */
	  
		$cmd = $this->getCmd(null,'FANSP');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('FANSP');
            $cmd->setIsVisible(0);
            $cmd->setName(__('Etat Ventil.', __FILE__));
        }
        $cmd->setType('info');
        $cmd->setSubType('string');
		$cmd->setDisplay('generic_type','GENERIC_INFO');
        $cmd->setConfiguration('OrdreFamille','FANSP');
		$cmd->setEqLogic_id($this->getId());
        $cmd->save();
		$FanSP='';
		$state_id = $cmd->getId();
		if ($cmd ->getLogicalId()=='FANSP') $FanSP = $state_id;
		$cmd->save();
      
	  	$cmd = $this->getCmd(null,'FANSP.CFG');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
            $cmd->setLogicalId('FANSP.CFG');
            $cmd->setIsVisible(1);
            $cmd->setName(__('Ventilation', __FILE__));
        }
        $cmd->setType('action');
        $cmd->setSubType('select');
        $cmd->setConfiguration('OrdreFamille','FANSP');
		$cmd->setConfiguration('Ordre','');
		$cmd->setConfiguration('listValue','AUTO|Auto;1|Silent;2|Faible;3|Moyen;4|Fort');
		$cmd->setValue('FANSP');
        $cmd->setEqLogic_id($this->getId());
        $cmd->save();
		if($cmd->getValue()=='FANSP') $cmd->setValue($FanSP);
		$cmd->save();

/* Recuperation de temperature ambiante + retour erreurs si non infra-rouge */
 
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
		
		if ($this->getConfiguration('IntesisBox_Type')!='IS-IR-WMP-1') {
            $cmd = $this->getCmd(null,'ERRSTATUS');
			if (!is_object($cmd)) {
				$cmd = new IntesisBoxWMPCmd();
				$cmd->setLogicalId('ERRSTATUS');
				$cmd->setIsVisible(1);
				$cmd->setName(__('Sante', __FILE__));
			}
			$cmd->setType('info');
			$cmd->setSubType('string');
		$cmd->setDisplay('generic_type','GENERIC_INFO');
        $cmd->setConfiguration('OrdreFamille','ERRSTATUS');
		$cmd->setEqLogic_id($this->getId());
        $cmd->save();
		$EtatErrorId='';
		$state_id = $cmd->getId();
		if ($cmd ->getLogicalId()=='ERRSTATUS') $EtatErrorId = $state_id;
		$cmd->save();
		}

		if ($this->getConfiguration('IntesisBox_Type')!='IS-IR-WMP-1') {
            $cmd = $this->getCmd(null,'ERRCODE');
			if (!is_object($cmd)) {
				$cmd = new IntesisBoxWMPCmd();
				$cmd->setLogicalId('ERRCODE');
				$cmd->setIsVisible(1);
				$cmd->setName(__('ErrCode', __FILE__));
			}
			$cmd->setType('info');
			$cmd->setSubType('string');
		$cmd->setDisplay('generic_type','GENERIC_INFO');
        $cmd->setConfiguration('OrdreFamille','ERRCODE');
		$cmd->setEqLogic_id($this->getId());
        $cmd->save();
		$EtatErrorId='';
		$state_id = $cmd->getId();
		if ($cmd ->getLogicalId()=='ERRCODE') $EtatErrorId = $state_id;
		$cmd->save();
		}
		
/*
> [rx]  LIMITS:VANEUD,[AUTO,SWING,PULSE]
> [rx]  LIMITS:VANELR,[]
> [rx]  CHN,1:FANSP,1
> [rx]  CHN,1:VANEUD,AUTO
> [rx]  CHN,1:VANELR,AUTO
> [rx]  CHN,1:ERRCODE,0
*/

	$Date = date('d/m/Y H:i:s');
	$this->executeCommand('CFG:DATETIME,'.$Date);
	log::add('IntesisBoxWMP', 'debug', 'envoi date (' . $Date . ')');
	foreach (array('FANSP', 'MODE', 'SETPTEMP', 'VANEUD', 'VANELR') as $function) {
		$this->executeCommand('LIMITS:' . $function);
	}
		
	$AcNum = $this->getConfiguration('AcNum');
	if ($AcNum != ''){
		$this->executeCommand('GET,'.$AcNum.':*');
	}

  }


  // Fonction exécutée automatiquement après la sauvegarde (création ou mise à jour) de l'équipement
  public function postSave() {
  }

  // Fonction exécutée automatiquement avant la suppression de l'équipement
  public function preRemove() {
  }

  // Fonction exécutée automatiquement après la suppression de l'équipement
  public function postRemove() {
  }

  /*
  * Permet de crypter/décrypter automatiquement des champs de configuration des équipements
  * Exemple avec le champ "Mot de passe" (password)
  public function decrypt() {
    $this->setConfiguration('password', utils::decrypt($this->getConfiguration('password')));
  }
  public function encrypt() {
    $this->setConfiguration('password', utils::encrypt($this->getConfiguration('password')));
  }
  */

  /*
  * Permet de modifier l'affichage du widget (également utilisable par les commandes)
  public function toHtml($_version = 'dashboard') {}
  */

  /*
  * Permet de déclencher une action avant modification d'une variable de configuration du plugin
  * Exemple avec la variable "param3"
  public static function preConfig_param3( $value ) {
    // do some checks or modify on $value
    return $value;
  }
  */

  /*
  * Permet de déclencher une action après modification d'une variable de configuration du plugin
  * Exemple avec la variable "param3"
  public static function postConfig_param3($value) {
    // no return value
  }
  */

  /*     * **********************Getteur Setteur*************************** */


  /*     * *************************Attributs****************************** */

  /* construction de la commande */
	public function CreateCommand ($ParamCmd = '',$OrdreType='',$ParamFamille='') {
	/* Constantes */
		log::add('IntesisBoxWMP', 'debug', 'Construct ' . __FUNCTION__ .' / $Ordre = ' . $ParamCmd);
		$AcNum = $this->getConfiguration('AcNum');
		
	/* recuperation temperature consigne + passage en non decimal */
		if ($ParamFamille == 'SETPTEMP' and $OrdreType== 'action'){
          log::add('IntesisBoxWMP', 'debug', 'Temperature consigne passée');
          $ParamCmd = $ParamCmd *10;
		}
		
	/* action ou info ? */
		if($OrdreType == 'action' and $ParamFamille !='*'  )
          {
            $Action = 'SET';
			$Ordre = $ParamFamille.','.$ParamCmd;
          }
        elseif($OrdreType == 'info' )
          {
            $Action = 'GET';
			$Ordre = $ParamFamille;
          }
          elseif($ParamFamille =='*')
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
		
  /* ouverture du port de communication */
	public function executeCommand ($cmd = '') {
		log::add('IntesisBoxWMP', 'debug', 'BEGIN ' . __FUNCTION__ .' / $cmd = ' . $cmd);
		$ip = $this->getConfiguration('ip');
		$PortCom = $this->getConfiguration('portCom');
		$delay=500000; /*in usec*/

		for ($try = 0; $try < 2; $try++) {
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if (!@socket_connect($socket, $ip, $PortCom)) {
				log::add('IntesisBoxWMP', 'warning', 'ERROR OPEN SOCKET : ' . $ip . ', PORT : ' . $PortCom . ')');
				socket_close($socket);
				return false;
			}
			usleep($delay);
			log::add('IntesisBoxWMP', 'debug', 'CONNECTED, SENDING COMMAND (IP : ' . $ip . ', PORT : ' . $PortCom . ')');
			log::add('IntesisBoxWMP', 'debug', 'CONNECTED, SENDING COMMAND (' . $cmd . ')');
			socket_write($socket, $cmd . "\r");
			$buff = '';
			$chunk = '';
			socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 2, 'usec' => 0));
			while (($bytes = @socket_recv($socket, $chunk, 512, 0)) > 0) {
				$buff .= $chunk;
			}
			log::add('IntesisBoxWMP', 'debug', 'Return reponse (' . trim($buff) . ')');
			socket_close($socket);
			if ($try == 0 && strpos($buff, 'CLOSE:MAXCONN') !== false) {
				log::add('IntesisBoxWMP', 'warning', 'CLOSE:MAXCONN ' . $ip . ', nouvel essai');
				sleep(1);
				continue;
			}
			$this->updateInfo($buff);
			// Le boîtier ACK tout de suite. L'état ne suit qu'après quelques secondes.
			if (preg_match('/^SET,(\d+):([A-Z]+),/', $cmd, $m)) {
				sleep(3);
				$this->executeCommand('GET,' . $m[1] . ':' . $m[2]);
			}
			return true;
		}
		return false;
	}
	
	/* Récupération des informations */
	public function updateInfo ($return = '')
    {
		if(!empty($return))
          $AcNum = $this->getConfiguration('AcNum');
		{
		$result=preg_split("/\r\n|\n|\r/", $return);
		log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' L'.__LINE__.' '. 'Nbre RE : '.count($result) );
		foreach($result as $reponse)
			{
          		$reponse= trim($reponse);
				log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' L'.__LINE__.' '. ' RE Commande : '.$reponse );
          		if ($reponse == 'ACK') {
					log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' L'.__LINE__.' '. ' RE : '.$reponse );
				}
				else if (preg_match('#^CHN,#i', $reponse) == 1) {
					//log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' L'.__LINE__.' '. ' RE : '.$reponse );
               		if (preg_match('#,'.$AcNum.':#', $reponse) == 1) {
                     //log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' RE : '.$comandeinfo );
                 		if (preg_match('#:ONOFF,#', $reponse) == 1) {
                    		log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' ONOFF' );
                            $info=strrchr($reponse,',');
                            $info = substr($info,1);
                         	$info = $info=='ON' ? 1 : 0 ;
                            log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' status : '.$info );
                            $comandeinfo = IntesisBoxWMPCmd::byEqLogicIdAndLogicalId($this->getId(),'ONOFF');
                          	$comandeinfo->event($info);
                      		$comandeinfo->save();
                          	unset ($comandeinfo);
                        }
                      	else if(preg_match('#:MODE,#', $reponse) == 1) {
                    		log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' MODE' );
                            $info=strrchr($reponse,',');
                            $info = substr($info,1);
                            log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' status : '.$info );
                            $comandeinfo = IntesisBoxWMPCmd::byEqLogicIdAndLogicalId($this->getId(),'MODE');
                          	$comandeinfo->event($info);
                      		$comandeinfo->save();
							unset ($comandeinfo);
                        }
                      	else if(preg_match('#:FANSP,#', $reponse) == 1) {
                    		log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' FANSP' );
							$info=strrchr($reponse,',');
                            $info = substr($info,1);
                            log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' status : '.$info );
                            $comandeinfo = IntesisBoxWMPCmd::byEqLogicIdAndLogicalId($this->getId(),'FANSP');
                          	$comandeinfo->event($info);
                      		$comandeinfo->save();
							unset ($comandeinfo);
                        }
          				else if(preg_match('#:VANEUD,#', $reponse) == 1) {
							$this->eventVane('VANEUD', $reponse);
                        }
                        else if(preg_match('#:VANELR,#', $reponse) == 1) {
							$this->eventVane('VANELR', $reponse);
                        }
                        else if(preg_match('#:SETPTEMP,#', $reponse) == 1) {
                    		log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' SETPTEMP' );
							$info=strrchr($reponse,',');
                            $info = substr($info,1);
							log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' Temperature recue : '.$info );
							if ($info === '32768' || $info === '-32768') {
								continue;
							}
							$info = $info/10;
                            log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' status : '.$info );
                            $comandeinfo = IntesisBoxWMPCmd::byEqLogicIdAndLogicalId($this->getId(),'SETPTEMP');
                          	$comandeinfo->event($info);
                      		$comandeinfo->save();
							unset ($comandeinfo);
                        }
                        else if(preg_match('#:AMBTEMP,#', $reponse) == 1) {
                    		log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' AMBTEMP' );
							$info=strrchr($reponse,',');
                            $info = substr($info,1);
							if ($info === '32768' || $info === '-32768') {
								continue;
							}
							$info = $info/10;
                            log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' status : '.$info );
                            $comandeinfo = IntesisBoxWMPCmd::byEqLogicIdAndLogicalId($this->getId(),'AMBTEMP');
                          	$comandeinfo->event($info);
                      		$comandeinfo->save();
							unset ($comandeinfo);
                        }
                      	else if(preg_match('#:ERRSTATUS,#', $reponse) == 1) {
							log::add('IntesisBoxWMP', 'info',__FUNCTION__.' ERRSTATUS' );
							$info=strrchr($reponse,',');
							$info = substr($info,1);
							log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' status : '.$info );
							$comandeinfo = IntesisBoxWMPCmd::byEqLogicIdAndLogicalId($this->getId(),'ERRSTATUS');
							$comandeinfo->event($info);
							$comandeinfo->save();
						  	unset ($comandeinfo); 
							
                        }
                        else if(preg_match('#:ERRCODE,#', $reponse) == 1) {
                    		log::add('IntesisBoxWMP', 'info',__FUNCTION__.' ERRCODE' );
							$info=strrchr($reponse,',');
							$info = substr($info,1);
							log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' status : '.$info );
							$comandeinfo = IntesisBoxWMPCmd::byEqLogicIdAndLogicalId($this->getId(),'ERRCODE');
							$comandeinfo->event($info);
							$comandeinfo->save();
						  	unset ($comandeinfo);
                        }
                      	else {
                          log::add('IntesisBoxWMP', 'info',__FUNCTION__.' ERR UNDOCUMENTED' );
                        }
					}
                  	else{
						log::add('IntesisBoxWMP', 'error',__FUNCTION__.' Erreur de numero climatiseur, vérifier dans la configuration' );
					}
				}
				else if (preg_match('#^LIMITS:#i', $reponse) == 1) {
					$this->applyLimits($reponse);
				}
				else {
               		if ($reponse == '') {
						/* do noting */
                       /* EOF ou commande inchangee*/
					}
					else {
						/* gestion des erreurs et commandes non prise*/
					log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' L'.__LINE__.' '. ' RE : '.$reponse );
					return false;
					}
                }
			}
			log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' RE : FIN');
		}			
    }

	public function applyLimits($reponse) {
		if (!preg_match('/^LIMITS:([A-Z0-9]+),\[(.*)\]$/', trim($reponse), $m)) {
			return;
		}
		$function = $m[1];
		$raw = trim($m[2]);
		$values = ($raw === '') ? array() : array_values(array_filter(array_map('trim', explode(',', $raw)), 'strlen'));
		if ($function == 'FANSP') {
			$this->setListFromLimits('FANSP.CFG', $values, array(
				'AUTO' => 'Auto',
				'1' => 'Faible',
				'2' => 'Moyen',
				'3' => 'Fort',
				'4' => 'Très fort',
			));
		} else if ($function == 'MODE') {
			$this->setListFromLimits('MODE.CFG', $values, array(
				'AUTO' => 'Auto',
				'HEAT' => 'Chauffage',
				'DRY' => 'Deshumidification',
				'FAN' => 'Ventilation',
				'COOL' => 'refroidissement',
			));
		} else if ($function == 'SETPTEMP' && count($values) == 2 && is_numeric($values[0]) && is_numeric($values[1])) {
			$min = $values[0] / 10;
			$max = $values[1] / 10;
			foreach (array('SETPTEMP', 'SETPTEMP.CFG') as $logicalId) {
				$cmd = $this->getCmd(null, $logicalId);
				if (!is_object($cmd)) {
					continue;
				}
				$cmd->setConfiguration('minValue', $min);
				$cmd->setConfiguration('maxValue', $max);
				$cmd->save();
			}
		} else if ($function == 'VANEUD' || $function == 'VANELR') {
			$this->ensureVane($function, $values);
		}
	}

	public function setListFromLimits($logicalId, $values, $labels) {
		if (count($values) == 0) {
			return;
		}
		$parts = array();
		foreach ($values as $value) {
			$label = isset($labels[$value]) ? $labels[$value] : $value;
			$parts[] = $value . '|' . $label;
		}
		$cmd = $this->getCmd(null, $logicalId);
		if (!is_object($cmd)) {
			return;
		}
		$cmd->setConfiguration('listValue', implode(';', $parts));
		$cmd->save();
	}

	public function ensureVane($function, $values) {
		if (count($values) == 0) {
			return;
		}
		$returnvotletname = ($function == 'VANEUD') ? __('Etat Volet vertical', __FILE__) : __('Etat Volet horizontal', __FILE__);
		$info = $this->getCmd(null, $function);
		if (!is_object($info)) {
			$info = new IntesisBoxWMPCmd();
			$info->setLogicalId($function);
			$info->setEqLogic_id($this->getId());
			$info->setName($returnvotletname);
		}
		$info->setType('info');
		$info->setSubType('string');
		$info->setIsVisible(0);
		$info->setConfiguration('OrdreFamille', $function);
		$info->setEqLogic_id($this->getId());
		$info->save();

		$logicalId = $function . ".CFG";
		$commandvoletname = ($function == 'VANEUD') ? __('Cmd Volet vertical', __FILE__) : __('Cmd Volet horizontal', __FILE__);
		$action = $this->getCmd(null, $logicalId);
		if (!is_object($action)) {
			$action = new IntesisBoxWMPCmd();
			$action->setLogicalId($logicalId);
			$action->setEqLogic_id($this->getId());
			$action->setName($commandvoletname);
		}
		$action->setType('action');
		$action->setSubType('select');
		$action->setIsVisible(1);
		$action->setConfiguration('OrdreFamille', $function);
		$action->setValue($info->getId());
		$action->setEqLogic_id($this->getId());
		$action->save();
		$this->setListFromLimits($logicalId, $values, array(
			'AUTO' => 'Auto',
			'SWING' => 'Balayage',
			'PULSE' => 'Impulsion',
		));
	}

	public function eventVane($logicalId, $reponse) {
		$info = substr(strrchr($reponse, ','), 1);
		$cmd = IntesisBoxWMPCmd::byEqLogicIdAndLogicalId($this->getId(), $logicalId);
		if (!is_object($cmd) || $info === '') {
			return;
		}
		log::add('IntesisBoxWMP', 'debug', __FUNCTION__ . ' ' . $logicalId . ' ' . $info);
		$cmd->event($info);
		$cmd->save();
	}
	



  /*     * ***********************Methode static*************************** */
  public static $_widgetPossibility = array('custom' => true);

  /*     * *********************Methode d'instance************************* */

  /*
  * Permet d'empêcher la suppression des commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
  public function dontRemoveCmd() {
    return true;
  }
  */

}

class IntesisBoxWMPCmd extends cmd {
  // Exécution d'une commande
  public function execute($_options = array()) {
		$_action = $this->getLogicalId();
		
	/* surcharge pour consigne temperature */
		if ($_action == 'SETPTEMP.CFG') {
                $STtemp = $_options['slider'];
				$this->setConfiguration('Ordre',$STtemp);
		}
	/* surcharge pour choix Mode */
		if ($_action == 'MODE.CFG') {
                $SMode = $_options['select'];
				$this->setConfiguration('Ordre',$SMode);
		}
	/* surcharge pour choix Ventilation */
		if ($_action == 'FANSP.CFG') {
                $SFan = $_options['select'];
				$this->setConfiguration('Ordre',$SFan);
		}
		if ($_action == 'VANEUD.CFG' || $_action == 'VANELR.CFG') {
				$this->setConfiguration('Ordre', $_options['select']);
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
