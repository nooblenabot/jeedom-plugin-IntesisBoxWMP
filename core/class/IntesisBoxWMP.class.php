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
		
		/* Do Nothing
		$cmd = $this->getCmd(null, 'RefreshAction');
        if (!is_object($cmd)) {
            $cmd = new IntesisBoxWMPCmd();
        }
        $cmd->setName(__('RefreshAction', __FILE__));
        $cmd->setEqLogic_id($this->id);
		$cmd->setLogicalId('RefreshAction');
        $cmd->setType('action');
        $cmd->setSubType('other');
       	$cmd->setIsVisible(1);
 				$cmd->setDisplay('icon', '<i class="fa fa-refresh"></i>');
 				$cmd->setDisplay('showOndashboard', 1);
 				$cmd->setDisplay('showNameOndashboard', 0);
        $cmd->save();
		*/
		
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
        }
        $cmd->setType('action');
        $cmd->setSubType('slider');
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
            $cmd->setIsVisible(1);
            $cmd->setName(__('Etat Ventil.', __FILE__));
        }
        $cmd->setType('info');
        $cmd->setSubType('string');
		$cmd->setDisplay('generic_type','GENERIC_INFO');
        $cmd->setConfiguration('OrdreFamille','FANSP');
		$cmd->setEqLogic_id($this->getId());
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
			$cmd->save();
			if($cmd->getValue()=='VANEUD') $cmd->setValue($Vane);
			$cmd->save();
		}
        */

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
		
/*
< [Tx]  GET,1:*
> [rx]  LIMITS:VANEUD,[AUTO,SWING,PULSE]
> [rx]  LIMITS:VANELR,[]
> [rx]  CHN,1:FANSP,1
> [rx]  CHN,1:VANEUD,AUTO
> [rx]  CHN,1:VANELR,AUTO
> [rx]  CHN,1:ERRSTATUS,OK
> [rx]  CHN,1:ERRCODE,0
*/

/* Fait perdre la connection
	$Date = date('d/m/Y H:i:s');
	$this->executeCommand('CFG:DATETIME,'.$Date);
	log::add('IntesisBoxWMP', 'debug', 'envoi date (' . $Date . ')');
	*/
	
	$AcNum = $this->getConfiguration('AcNum');
	if ($AcNum != ''){
		$this->executeCommand('GET,'.$AcNum.':*');
	}

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
	 
    /*     * **********************Getteur Setteur*************************** */

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
		
	public function executeCommand ($cmd = '') {
		log::add('IntesisBoxWMP', 'debug', 'BEGIN ' . __FUNCTION__ .' / $cmd = ' . $cmd);
		$ip = $this->getConfiguration('ip');
		$PortCom = $this->getConfiguration('portCom');
		$delay=500000; /*in usec*/
			
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if(socket_connect ($socket , $ip, $PortCom))
		{
			usleep($delay);
				log::add('IntesisBoxWMP', 'debug', 'CONNECTED, SENDING COMMAND (IP : ' . $ip . ', PORT : ' . $PortCom . ')');
				log::add('IntesisBoxWMP', 'debug', 'CONNECTED, SENDING COMMAND (' . $cmd . ')');
			socket_write ($socket ,$cmd . "\r\n");
				log::add('IntesisBoxWMP', 'debug', 'Commande ecrite');
			$buff = '';
          	socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO,array('sec' => 1, 'usec' => $delay));
         	$bytes = socket_recv($socket, $buff, 200,MSG_WAITALL);
				log::add('IntesisBoxWMP', 'debug', 'Octets reponse (' . $bytes . ')');
				log::add('IntesisBoxWMP', 'debug', 'Return reponse (' . $buff . ')');
				log::add('IntesisBoxWMP', 'debug', 'CLOSING CONNECTION');
			socket_close($socket);
				log::add('IntesisBoxWMP', 'debug', 'CLOSED');
			$this->updateInfo($buff);
			unset ($buff);
		}
		else{
		log::add('IntesisBoxWMP', 'debug', 'ERROR OPEN SOCKET : ' . $ip . ', PORT : ' . $PortCom . ')');
		return false;
		}
	}
	
	public function updateInfo ($return = '')
    {
		if(!empty($return))
          $AcNum = $this->getConfiguration('AcNum');
		{
		$result=explode("\r\n",$return);
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
                    		log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' VANEUD' );
                        }
                        else if(preg_match('#:VANELR,#', $reponse) == 1) {
                    		log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' VANELR' );
                        }
                        else if(preg_match('#:SETPTEMP,#', $reponse) == 1) {
                    		log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' SETPTEMP' );
							$info=strrchr($reponse,',');
                            $info = substr($info,1);
							log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' Temperature recue : '.$info );
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
							$info = $info/10;
                            log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' status : '.$info );
                            $comandeinfo = IntesisBoxWMPCmd::byEqLogicIdAndLogicalId($this->getId(),'AMBTEMP');
                          	$comandeinfo->event($info);
                      		$comandeinfo->save();
							unset ($comandeinfo);
                        }
                      	else if(preg_match('#:ERRSTATUS,#', $reponse) == 1) {
                    		log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' ERRSTATUS' );
							
                        }
                        else if(preg_match('#:ERRCODE,#', $reponse) == 1) {
                    		log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' ERRCODE' );
                        }
                      	else {
                          log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' ERR UNDOCUMENTED' );
                        }
					}
                  	else{
						log::add('IntesisBoxWMP', 'debug',__FUNCTION__.' Erreur de numero climatiseur' );
					}
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
		}			
    }
	
}

class IntesisBoxWMPCmd extends cmd {
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
		if ($_action == 'SETPTEMP.CFG') {
                $STtemp = $_options['slider'];
				$this->setConfiguration('Ordre',$STtemp);
		}
	/* surcharge pour choix Mode */
		if ($_action == 'MODE.CFG') {
                $SMode = $_options['select'];
				$this->setConfiguration('Ordre',$SMode);
		}
		/* marche pas
		if ($_action == 'RefreshAction') {
			log::add('IntesisBoxWMP', 'debug', 'Launch ' . __FUNCTION__ $_action);
			$eqLogic->CreateCommand('',action,*);
		}else{
		*/
			$Param = $this->getConfiguration('Ordre');
			$Action = $this->getType();
			$OrdreFamille=$this->getConfiguration('OrdreFamille');
			$eqLogic = $this->getEqLogic();
		  log::add('IntesisBoxWMP', 'debug', 'Launch ' . __FUNCTION__ .' / $Param = ' . $Param.'+'.$Action.'+'.$OrdreFamille);
			$eqLogic->CreateCommand($Param,$Action,$OrdreFamille);
		/*}*/
	}

}