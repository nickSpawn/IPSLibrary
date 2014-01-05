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
	 *  Version 1.00.1, 31.03.2013<br/>
	 *
	 * Verarbeitung der Protokolle der Register Variabler im Empfangspuffer IPSenhancedFHZ
	 *
	 */

	IPSUtils_Include("IPSLogger.inc.php",								"IPSLibrary::app::core::IPSLogger");
	IPSUtils_Include("IPSenhancedFHZ_Constants.inc.php",			"IPSLibrary::app::hardware::IPSenhancedFHZ");
	IPSUtils_Include("IPSenhancedFHZ_Configuration.inc.php",		"IPSLibrary::config::hardware::IPSenhancedFHZ");

	// ----------------------------------------------------------------------------------------------------------------------------
	function IsKnownReceivingProtocol($cmd) {
	   $sending_cmd=(ord(substr($cmd,4,1))<<8)+ord(substr($cmd,5,1));
		return (($sending_cmd==258)||($sending_cmd==2313)||($sending_cmd==33545));
	}

	// ----------------------------------------------------------------------------------------------------------------------------
	function GetFHTHousecodeByProtocol($cmd) {
		return (ord(substr($cmd,8,1))*100)+ord(substr($cmd,9,1));
	}

	// ----------------------------------------------------------------------------------------------------------------------------
	function GetFHTInstanceByHouseCode($housecode) {
		$fht_guid='{A89F8DFA-A439-4BF1-B7CB-43D047208DDD}';
		foreach(IPS_GetInstanceList() as $id) {
			$Instance = IPS_GetInstance($id);
			if ($Instance['ModuleInfo']['ModuleID']==$fht_guid) {
				if($housecode==FHT_GetAddress ($Instance['InstanceID'])) {
					return $Instance['InstanceID'];
				}
			}
		}
		return false;
	}

	// ----------------------------------------------------------------------------------------------------------------------------
	function isBit($bitField,$n) {
		return ((($bitField & (0x01 << ($n-1))))>0);
	}
	
	// ----------------------------------------------------------------------------------------------------------------------------
	function setBit(&$bitField,$n) {
		if(($n < 0) or ($n > 32)) return false;
		$bitField |= (0x01 << ($n-1));
		return true;
	}
	
	// ----------------------------------------------------------------------------------------------------------------------------
	function clearBit(&$bitField,$n) {
		$bitField &= ~(0x01 << ($n-1));
		return true;
	}

	// ----------------------------------------------------------------------------------------------------------------------------
	function GetIdentValue($variableIdent,$deviceID) {
		$variableId = IPS_GetObjectIDByIdent($variableIdent, $deviceID);
		if ($variableId === false) {
			throw new Exception('Variable '.$variableIdent.' could NOT be found for DeviceId='.$this->deviceId);
		}
		return GetValue($variableId);
	}
	
	// ----------------------------------------------------------------------------------------------------------------------------
	function SetIdentValue($variableIdent, $value,$deviceID) {
		$variableId = IPS_GetObjectIDByIdent($variableIdent, $deviceID);
		if ($variableId === false) {
			throw new Exception('Variable '.$variableIdent.' could NOT be found for DeviceId='.$this->deviceId);
		}
		SetValue($variableId, $value);
	}
	
	// ----------------------------------------------------------------------------------------------------------------------------
	function eFHZLogValue($variableIdent,$Value,$deviceID,$lang,$Key=false) {
		$name=IPS_GetName($deviceID);
		if ($Key===false)   {
			$logmessage=str_replace("%Device%",$name,$lang["c_LogMess_eFHZ_".$variableIdent]);
			$logmessage=str_replace("%Value%",$Value,$logmessage);
		} else {
			$logmessage=str_replace("%Device%",$name,$lang["c_LogMess_eFHZ_".$variableIdent][$Value]);
		}
		return $logmessage;
	}

	$lang=IPSenhancedFHZ_GetLanguages();
	$config=IPSenhancedFHZ_GetFHZConfiguration();
	$rcv = $_IPS['RECEIVE'];

	// Debugging : Ausgabe Hexzeile
	if (c_eFHZ_debug==true) {
		$ReceivingDebugBuffer=IPSUtil_ObjectIDByPath('Program.IPSLibrary.app.hardware.IPSenhancedFHZ.IPSenhancedFHZ_Buffer.Debug');
		$l='';
		for ($j=0; $j<strlen($rcv); $j++) {
			$z=ord(substr($rcv,$j,1));
			$t=dechex($z);
			if ($z<16) {$t='0'.$t;}
			$l.=$t;
		}
		SetValueString($ReceivingDebugBuffer,$l);
		echo "$l \n";
	}

	$known_protocol=(ord(substr($rcv,4,1))<<8)+ord(substr($rcv,5,1));
	$housecode=(ord(substr($rcv,8,1))*100)+ord(substr($rcv,9,1));
   
	if (array_key_exists($housecode, $config)) {
		$device=$config[(string)$housecode][c_Property_eFHZ_Name];
		$deviceID=@IPSUtil_ObjectIDByPath('Program.IPSLibrary.data.hardware.IPSenhancedFHZ.Devices.'.$device);
		if ($deviceID) {
			$function = ord(substr($rcv,10,1));
			$value = ord(substr($rcv,($known_protocol==2313 ? 13 : 11),1));

			if ($known_protocol==2313&&$function<9) {
				$status=ord(substr($rcv,12,1));
				$drivecontrol_mode=0;
				if ((($status&0xf)==0x06) || (($status&0xf)==0x00)) {
					SetIdentValue(c_control_eFHZ_position,$value/2.55,$deviceID);
				}
				else {
					if (($status&0xef)==0x2a) $drivecontrol_mode=1;
					if (($status&0xef)==0x2e) $drivecontrol_mode=2;
					if (($status&0xef)==0x2c) $drivecontrol_mode=3;
					SetIdentValue(c_control_eFHZ_drivecontrol_timer,$value/2,$deviceID);
				}
				if ($drivecontrol_mode!=GetIdentValue(c_control_eFHZ_drivecontrol,$deviceID)) {
					SetIdentValue(c_control_eFHZ_drivecontrol,$drivecontrol_mode,$deviceID);
				}
			}
			elseif ($function>=0x14 && $function<=0x2f) {
				if (!is_array($wp=unserialize(GetIdentValue(c_control_eFHZ_weekprogram_responce,$deviceID)))) $wp=array_fill(0,28,144);
				$wp[$function-20]=$value;SetIdentValue(c_control_eFHZ_weekprogram_responce,serialize($wp),$deviceID);
			}
			elseif ($function==0x3e) {
				SetIdentValue(c_control_eFHZ_mode_responce,$value,$deviceID);
				if ($value==0) {
					SetIdentValue(c_control_eFHZ_partytime_responce,'',$deviceID);
					$tmp=GetTemperatureBasedOnWeeklyProgram(GetIdentValue(c_control_eFHZ_weekprogram_responce,$deviceID),time(),$deviceID);
					if (GetIdentValue(c_control_eFHZ_weekprogram_responce,$deviceID)!=$tmp) {
						SetIdentValue(c_control_eFHZ_target_temperature_responce,$tmp/2,$deviceID);
					}
				}
				elseif ($value==1) {
					SetIdentValue(c_control_eFHZ_partytime_responce,'',$deviceID);
				}
				elseif ($value==2) {
					if (is_array($ti=unserialize(GetIdentValue(c_control_eFHZ_partytime_responce,$deviceID)))) {
						$tn=mktime(0,0,0,$ti[1],$ti[0]);if ($tn<time()) $tn=mktime(0,0,0,$ti[1],$ti[0],date("Y")+1);
						SetIdentValue(c_control_eFHZ_partytime_responce,date("d.m.Y",$tn),$deviceID);
					} else {
						SetIdentValue(c_control_eFHZ_partytime_responce,serialize(array(2=>$value)),$deviceID);
					}
				}
				elseif ($value==3) {
					if (is_array($ti=unserialize(GetIdentValue(c_control_eFHZ_partytime_responce,$deviceID)))) {
						$t=$ti[0]/6;$h=(int)$t;$m=($t-$h)*60;$to=mktime($h,$m);
						$tn=$to+($ti[1]!=(int)date("d",$to) ? 1 : 0)*86400;
						SetIdentValue(c_control_eFHZ_partytime_responce,date("H:i:s d.m.Y",$tn),$deviceID);
					} else {
						SetIdentValue(c_control_eFHZ_partytime_responce,serialize(array(2=>$value)),$deviceID);
					}
				}
			}
			elseif ($function==0x3f) {
				if (!is_array($ti=unserialize(GetIdentValue(c_control_eFHZ_partytime_responce,$deviceID)))) {
					SetIdentValue(c_control_eFHZ_partytime_responce,serialize(array($value,0)),$deviceID);
				}
				elseif (isset($ti[0]) && isset($ti[1]) && isset($ti[2])) {
					if ($ti[2]=2) {
						$tn=mktime(0,0,0,$ti[1],$ti[0]);if ($tn<time()) $tn=mktime(0,0,0,$ti[1],$ti[0],date("Y")+1);
						SetIdentValue(c_control_eFHZ_partytime_responce,date("d.m.Y",$tn),$deviceID);
					}
		            elseif ($ti[2]=3) {
						$t=$ti[0]/6;$h=(int)$t;$m=($t-$h)*60;$to=mktime($h,$m);
						$tn=$to+($ti[1]!=(int)date("d",$to) ? 1 : 0)*86400;
						SetIdentValue(c_control_eFHZ_partytime_responce,date("H:i:s d.m.Y",$tn),$deviceID);
		         }
				}
				else {
					$ti[0]=$value;
					SetIdentValue(c_control_eFHZ_partytime_responce,serialize($ti),$deviceID);
				}
			}
			elseif ($function==0x40) {
				if (!is_array($ti=unserialize(GetIdentValue(c_control_eFHZ_partytime_responce,$deviceID)))) {
					SetIdentValue(c_control_eFHZ_partytime_responce,serialize(array(0,$value)),$deviceID);
				}
				elseif (isset($ti[0]) && isset($ti[1]) && isset($ti[2])) {
					if ($ti[2]=2) {
						$tn=mktime(0,0,0,$ti[1],$ti[0]);if ($tn<time()) $tn=mktime(0,0,0,$ti[1],$ti[0],date("Y")+1);
						SetIdentValue(c_control_eFHZ_partytime_responce,date("d.m.Y",$tn),$deviceID);
					}
					elseif ($ti[2]=3) {
						$t=$ti[0]/6;$h=(int)$t;$m=($t-$h)*60;$to=mktime($h,$m);
						$tn=$to+($ti[1]!=(int)date("d",$to) ? 1 : 0)*86400;
						SetIdentValue(c_control_eFHZ_partytime_responce,date("H:i:s d.m.Y",$tn),$deviceID);
					}
				}
				else {
					$ti[1]=$value;
					SetIdentValue(c_control_eFHZ_partytime_responce,serialize($ti),$deviceID);
				}
			}
			elseif ($function==0x41) {
				SetIdentValue(c_control_eFHZ_target_temperature_responce,$value/2,$deviceID);
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
					$tmp_low=GetIdentValue(c_control_eFHZ_actual_temperature_responce.'_flag',$deviceID);
					IPS_DeleteVariable($variableId);
					SetIdentValue(c_control_eFHZ_actual_temperature_responce,$tmp_low+$value*25.5,$deviceID);
					if (c_eFHZ_trace_logging) {IPSLogger_Trc(__file__, eFHZLogValue(c_control_eFHZ_target_temperature_responce,$value/2,$deviceID,$lang));}
				}
			}
			elseif ($function==0x44) {
				SetIdentValue(c_control_eFHZ_battery,isbit($value,1),$deviceID);
				if (c_eFHZ_trace_logging) {IPSLogger_Trc(__file__, eFHZLogValue(c_control_eFHZ_battery,$value,$deviceID,$lang,true));}
				SetIdentValue(c_control_eFHZ_windowopen,isbit($value,6),$deviceID);
				if (c_eFHZ_trace_logging) {IPSLogger_Trc(__file__, eFHZLogValue(c_control_eFHZ_windowopen,$value,$deviceID,$lang,true));}
			}
			elseif ($function==0x54&&GetIdentValue(c_control_eFHZ_autoinit,$deviceID)) {
				/*
				include_once(IPS_GetKernelDir()."bricks\eFHZ\class.eFHZ.php");
				eFHZ::Begin();
				$buf=array();$buf[0x65]=0xff;$buf[0x66]=0xff;
				$str=eFHZ::xbuildsndstr(array(4=>2,5=>1,6=>0x83),$buf);
				$str[7]=ord(substr($cmd,8,1));$str[8]=ord(substr($cmd,9,1));
				$str=eFHZ::xstrBC($str);$str[2]=4;
				IPS_LogMessage("eFHT-Brick","AutoInit started. (FHT ".$HC2.")");
				eFHZ::xsndstr($str);
				*/
			}
			elseif ($function==0x82) {
				SetIdentValue(c_control_eFHZ_suntemp_responce,$value/2,$deviceID);
				if (c_eFHZ_trace_logging) {IPSLogger_Trc(__file__, eFHZLogValue(c_control_eFHZ_suntemp_responce,$value/2,$deviceID,$lang));}
			}
			elseif ($function==0x84) {
				SetIdentValue(c_control_eFHZ_lunatemp_responce,$value/2,$deviceID);
				if (c_eFHZ_trace_logging) {IPSLogger_Trc(__file__, eFHZLogValue(c_control_eFHZ_lunatemp_responce,$value/2,$deviceID,$lang));}
			}
			elseif ($function==0x8a) {
				SetIdentValue(c_control_eFHZ_windowtemp_responce,$value/2,$deviceID);
				if (c_eFHZ_trace_logging) {IPSLogger_Trc(__file__, eFHZLogValue(c_control_eFHZ_windowtemp_responce,$value/2,$deviceID,$lang));}
			}
		}
	}
	
	
	/** @}*/

?>
	