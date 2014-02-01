<?
	/*
	 * This file is part of the IPSLibrary.
	 *
	 * The IPSLibrary is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published
	 * by the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 *
	 * The IPSLibrary is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with the IPSLibrary. If not, see http://www.gnu.org/licenses/gpl.txt.
	 */

	/**@ingroup ipsenhancedfhz
	 * @{
	 *
	 * @file          IPSenhancedFHZ_Receive.ips.php
	 * @author        Günter Strassnigg
	 * @version
	 *  Version 0.1.3, 19.01.2014<br/>
	 *
	 * Verarbeitung der Protokolle der Register Variabler im Empfangspuffer IPSenhancedFHZ
	 *
	 */

	IPSUtils_Include("IPSLogger.inc.php",								"IPSLibrary::app::core::IPSLogger");
	IPSUtils_Include("IPSenhancedFHZ_Configuration.inc.php",		"IPSLibrary::config::hardware::IPSenhancedFHZ");
	IPSUtils_Include("IPSenhancedFHZ_Constants.inc.php",			"IPSLibrary::app::hardware::IPSenhancedFHZ");
	IPSUtils_Include("IPSenhancedFHZ_Functions.class.php",			"IPSLibrary::app::hardware::IPSenhancedFHZ");

   /**
    * @class CheckFHZ
    *
    * Definiert das IPSenhancedFHZ Object, das den Empfang über den IPSenhancedFHZ-Puffer verarbeitet.
    *
    * @author Günter Strassnigg
    */
	class CheckFHZ extends eFHZ_Base {
	
		public function __construct($ReceivedString,$deviceID,$config) {
			$ActionScriptID=IPSUtil_ObjectIDByPath('Program.IPSLibrary.app.hardware.IPSenhancedFHZ.IPSenhancedFHZ_ActionScript');
			$lang=IPSenhancedFHZ_GetLanguages();
			$rcv=$ReceivedString;
			
			$known_protocol=(ord(substr($rcv,4,1))<<8)+ord(substr($rcv,5,1));
			$housecode=(ord(substr($rcv,8,1))*100)+ord(substr($rcv,9,1));

			$answers=array();
			$answers[0]=ord(substr($rcv,4,1));
			$answers[1]=ord(substr($rcv,5,1));
			$answers[2]=ord(substr($rcv,6,1));
			$answers[3]=ord(substr($rcv,7,1));

			if ($answers[0]==0x09 && $answers[1]==0x09 && $answers[2]==0xa0 && $answers[3]==0x01) {
			//FHT Funktionen
				$function = ord(substr($rcv,10,1));
				$value = ord(substr($rcv,($known_protocol==2313 ? 13 : 11),1));
				
				if ($known_protocol==2313&&$function<9) {
					$status=ord(substr($rcv,12,1));
					$drivecontrol_mode=0;
					if ((($status&0xf)==0x06) || (($status&0xf)==0x00) || (($status&0xf)==0x0a)) {
						$this->SetIdentValue(c_control_eFHZ_position,$value/2.55,$deviceID);
					}
					else {
						if (($status&0xef)==0x2a) $drivecontrol_mode=1;
						if (($status&0xef)==0x2e) $drivecontrol_mode=2;
						if (($status&0xef)==0x2c) $drivecontrol_mode=3;
						$this->SetIdentValue(c_control_eFHZ_drivecontrol_timer,$value/2,$deviceID);
					}
					if ($drivecontrol_mode!=$this->GetIdentValue(c_control_eFHZ_drivecontrol,$deviceID)) {
						$this->SetIdentValue(c_control_eFHZ_drivecontrol,$drivecontrol_mode,$deviceID);
						if ($drivecontrol_mode==0) {
							$this->SetIdentValue(c_control_eFHZ_drivecontrol_timer,0,$deviceID);
						}
					}
				}
				elseif ($function>=0x14 && $function<=0x2f) {
					if (!is_array($wp=unserialize($this->GetIdentValue(c_control_eFHZ_weekprogram_responce,$deviceID)))) $wp=array_fill(0,28,144);
					$wp[$function-20]=$value;
					$this->SetIdentValue(c_control_eFHZ_weekprogram_responce,serialize($wp),$deviceID);
				}
				elseif ($function==0x3e) {
					$this->SetIdentValue(c_control_eFHZ_mode_responce,$value,$deviceID);
					if ($value==0) {
						$this->SetIdentValue(c_control_eFHZ_partytime_responce,'',$deviceID);
						$tmp=$this->GetTemperatureBasedOnWeeklyProgram($this->GetIdentValue(c_control_eFHZ_weekprogram_responce,$deviceID),time(),$deviceID);
						if ($this->GetIdentValue(c_control_eFHZ_weekprogram_responce,$deviceID)!=$tmp) {
							$this->SetIdentValue(c_control_eFHZ_target_temperature_responce,$tmp/2,$deviceID);
						}
					}
					elseif ($value==1) {
						$this->SetIdentValue(c_control_eFHZ_partytime_responce,'',$deviceID);
					}
					elseif ($value==2) {
						if (is_array($ti=unserialize($this->GetIdentValue(c_control_eFHZ_partytime_responce,$deviceID)))) {
							$tn=mktime(0,0,0,$ti[1],$ti[0]);if ($tn<time()) $tn=mktime(0,0,0,$ti[1],$ti[0],date("Y")+1);
							$this->SetIdentValue(c_control_eFHZ_partytime_responce,date("d.m.Y",$tn),$deviceID);
						} else {
							$this->SetIdentValue(c_control_eFHZ_partytime_responce,serialize(array(2=>$value)),$deviceID);
						}
					}
					elseif ($value==3) {
						if (is_array($ti=unserialize($this->GetIdentValue(c_control_eFHZ_partytime_responce,$deviceID)))) {
							$t=$ti[0]/6;$h=(int)$t;$m=($t-$h)*60;$to=mktime($h,$m);
							$tn=$to+($ti[1]!=(int)date("d",$to) ? 1 : 0)*86400;
							$this->SetIdentValue(c_control_eFHZ_partytime_responce,date("H:i:s d.m.Y",$tn),$deviceID);
						} else {
							$this->SetIdentValue(c_control_eFHZ_partytime_responce,serialize(array(2=>$value)),$deviceID);
						}
					}
				}
				elseif ($function==0x3f) {
					if (!is_array($ti=unserialize($this->GetIdentValue(c_control_eFHZ_partytime_responce,$deviceID)))) {
						$this->SetIdentValue(c_control_eFHZ_partytime_responce,serialize(array($value,0)),$deviceID);
					}
					elseif (isset($ti[0]) && isset($ti[1]) && isset($ti[2])) {
						if ($ti[2]=2) {
							$tn=mktime(0,0,0,$ti[1],$ti[0]);if ($tn<time()) $tn=mktime(0,0,0,$ti[1],$ti[0],date("Y")+1);
							$this->SetIdentValue(c_control_eFHZ_partytime_responce,date("d.m.Y",$tn),$deviceID);
						} elseif ($ti[2]=3) {
							$t=$ti[0]/6;$h=(int)$t;$m=($t-$h)*60;$to=mktime($h,$m);
							$tn=$to+($ti[1]!=(int)date("d",$to) ? 1 : 0)*86400;
							$this->SetIdentValue(c_control_eFHZ_partytime_responce,date("H:i:s d.m.Y",$tn),$deviceID);
			         }
					}
					else {
						$ti[0]=$value;
						$this->SetIdentValue(c_control_eFHZ_partytime_responce,serialize($ti),$deviceID);
					}
				}
				elseif ($function==0x40) {
					if (!is_array($ti=unserialize($this->GetIdentValue(c_control_eFHZ_partytime_responce,$deviceID)))) {
						$this->SetIdentValue(c_control_eFHZ_partytime_responce,serialize(array(0,$value)),$deviceID);
					}
					elseif (isset($ti[0]) && isset($ti[1]) && isset($ti[2])) {
						if ($ti[2]=2) {
							$tn=mktime(0,0,0,$ti[1],$ti[0]);if ($tn<time()) $tn=mktime(0,0,0,$ti[1],$ti[0],date("Y")+1);
							$this->SetIdentValue(c_control_eFHZ_partytime_responce,date("d.m.Y",$tn),$deviceID);
						}
						elseif ($ti[2]=3) {
							$t=$ti[0]/6;$h=(int)$t;$m=($t-$h)*60;$to=mktime($h,$m);
							$tn=$to+($ti[1]!=(int)date("d",$to) ? 1 : 0)*86400;
							$this->SetIdentValue(c_control_eFHZ_partytime_responce,date("H:i:s d.m.Y",$tn),$deviceID);
						}
					}
					else {
						$ti[1]=$value;
						$this->SetIdentValue(c_control_eFHZ_partytime_responce,serialize($ti),$deviceID);
					}
				}
				elseif ($function==0x41) {
					$this->SetIdentValue(c_control_eFHZ_target_temperature_responce,$value/2,$deviceID);
				}
				elseif ($function==0x42) {
					$variableId = @IPS_GetObjectIDByIdent(c_control_eFHZ_actual_temperature_responce.'_flag', $deviceID);
					if ($variableId===false) {
						$variableId = IPS_CreateVariable(2);
						IPS_SetName($variableId, c_control_eFHZ_actual_temperature_responce.'_flag');
						IPS_SetIdent($variableId, c_control_eFHZ_actual_temperature_responce.'_flag');
						IPS_SetParent($variableId, $deviceID);
						IPS_SetHidden($variableId, true);
					}
					SetValueFloat($variableId,$value/10);
				}
				elseif ($function==0x43) {
					$variableId = @IPS_GetObjectIDByIdent(c_control_eFHZ_actual_temperature_responce.'_flag', $deviceID);
					if ($variableId) {
						$tmp_low=$this->GetIdentValue(c_control_eFHZ_actual_temperature_responce.'_flag',$deviceID);
						IPS_DeleteVariable($variableId);
						$this->SetIdentValue(c_control_eFHZ_actual_temperature_responce,$tmp_low+$value*25.5,$deviceID);
						if (c_eFHZ_trace_logging) {IPSLogger_Trc(__file__, $this->eFHZLogValue(c_control_eFHZ_target_temperature_responce,$tmp_low+$value*25.5,$deviceID,$lang));}
					}
				}
				elseif ($function==0x44) {
					$this->SetIdentValue(c_control_eFHZ_battery,$this->isBit($value,1),$deviceID);
					if (c_eFHZ_trace_logging) {IPSLogger_Trc(__file__, $this->eFHZLogValue(c_control_eFHZ_battery,$value,$deviceID,$lang,true));}
					if ($config[(string)$housecode][c_Property_eFHZ_windowemulate]) {
						$sensors=$config[(string)$housecode][c_Property_eFHZ_windowsensors];
						$summarysensors=false;
						$oldsensorvalue=$this->GetIdentValue(c_control_eFHZ_windowopen,$deviceID);
						while (list($sensor, $reverse) = each($sensors)) {
						   if (IPS_VariableExists($sensor)) {
							   $value=GetValue($sensor);
								$summarysensors=$summarysensors|($reverse ? !$value : $value);
								if ($summarysensors!=$oldsensorvalue) {  
									IPS_RunScriptEx($ActionScriptID, Array("DEVICEID" => $deviceID,"ACTION" => "SetWindowTemp","VALUE" => $summarysensors));
								}
							} else {
							   echo "Sensorvariable not exists!";
							}
						}
						$this->SetIdentValue(c_control_eFHZ_windowopen,$summarysensors,$deviceID);
					} else {
						$this->SetIdentValue(c_control_eFHZ_windowopen,$this->isBit($value,6),$deviceID);
						if (c_eFHZ_trace_logging) {IPSLogger_Trc(__file__, $this->eFHZLogValue(c_control_eFHZ_windowopen,$value,$deviceID,$lang,true));}
					}
				}
				elseif ($function==0x54&&c_eFHZ_autoinit==true) {
					IPS_RunScriptEx($ActionScriptID, Array("DEVICEID" => $deviceID,"ACTION" => "Init"));
				}
				elseif ($function==0x82) {
					$this->SetIdentValue(c_control_eFHZ_suntemp_responce,$value/2,$deviceID);
					if (c_eFHZ_trace_logging) {IPSLogger_Trc(__file__, $this->eFHZLogValue(c_control_eFHZ_suntemp_responce,$value/2,$deviceID,$lang));}
				}
				elseif ($function==0x84) {
					$this->SetIdentValue(c_control_eFHZ_lunatemp_responce,$value/2,$deviceID);
					if (c_eFHZ_trace_logging) {IPSLogger_Trc(__file__, $this->eFHZLogValue(c_control_eFHZ_lunatemp_responce,$value/2,$deviceID,$lang));}
				}
				elseif ($function==0x8a) {
					$this->SetIdentValue(c_control_eFHZ_windowtemp_responce,$value/2,$deviceID);
					if (c_eFHZ_trace_logging) {IPSLogger_Trc(__file__, $this->eFHZLogValue(c_control_eFHZ_windowtemp_responce,$value/2,$deviceID,$lang));}
				}
			}
			
			elseif ($answers[0]==0x83 && $answers[1]==0x09 && $answers[2]==0x83 && $answers[3]==0x01) {
			//FHT Antworten
				$function = ord(substr($rcv,10,1));
				if ($function==0x60) {
					//if (c_eFHZ_trace_logging) {IPSLogger_Trc(__file__, $this->eFHZLogOtherValue('c_LogMess_eFHZ_new_time_is_set',$deviceID,$lang));}
				}	
				if ($function>=0x14 && $function>=0x2f) {
					if (c_eFHZ_trace_logging) {
					//$lang['c_LogMess_eFHZ_which_day']=							array("Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag","Sonntag");
					//		$lang['c_LogMess_eFHZ_new_weekprogram_is_set']=			"Das Wochenprogramm '%Value%'' und %Device% wurde geändert.";
						//IPSLogger_Trc(__file__, $this->eFHZLogOtherValue('c_LogMess_eFHZ_new_time_is_set',$deviceID,$lang));
					}
				}	
			} 
		return true;	
		}
	}	

	$config=IPSenhancedFHZ_GetFHZConfiguration();
	$rcv = $_IPS['RECEIVE'];

	// Debugging : Output - Hexdump 
	$l='';
	for ($j=0; $j<strlen($rcv); $j++) {
		$z=ord(substr($rcv,$j,1));
		$t=dechex($z);
		if ($z<16) {$t='0'.$t;}
		$l.=$t;
	}
	echo "$l \n";

	$housecode=(ord(substr($rcv,8,1))*100)+ord(substr($rcv,9,1));
   
	if (array_key_exists($housecode, $config)) {
		$device=$config[(string)$housecode][c_Property_eFHZ_Name];
		$deviceID=@IPSUtil_ObjectIDByPath('Program.IPSLibrary.data.hardware.IPSenhancedFHZ.Devices.'.$device,true);
		if ($deviceID) {$DoReceive = new CheckFHZ($rcv,$deviceID,$config);}
	}
	
	
	/** @}*/

?>
	