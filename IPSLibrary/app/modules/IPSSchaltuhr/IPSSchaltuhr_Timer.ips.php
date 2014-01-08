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

	/**@addtogroup IPSSchaltuhr
	 * @{
	 *
	 * @file          IPSSchaltuhr_Timer.ips.php
	 * @author        Andr� Czwalina
	 * @version
	* Version 1.00.0, 28.04.2012<br/>
	 *
	 *
	 */


	include_once "IPSSchaltuhr.inc.php";
  

	function IPSSchaltuhr_TimerStart($CircleName,$EventMode) { 
		$CircleId 	= get_CirclyIdByCircleIdent($CircleName, ZSU_ID_ZSUZEITEN);
		$Properts   = get_ZSUConfiguration()[$CircleName];
		$Name = $Properts[c_Property_IPSSchaltuhrName];
			
		if (function_exists($CircleName)) {
			//IPSLogger_Dbg(__file__, 'Zeitschaltuhr CallBack Funktion '.$Name.' Existiert in IPSSchaltuhr_Custom.');
			//IPSSchaltuhr_Log('Zeitschaltuhr gestartet:  '.$Name.', Aktion: '.$EventMode);

			if ($EventMode=='Start') {
				$resultstart = 0;
				$StartAktiv =  explode(',', get_ControlValue(c_Control_StartAktiv, $CircleId));
				$i=1;
				//STARTSENSOREN �BERPR�FEN
				foreach ($Properts[c_Property_StartSensoren] as $PropName=>$PropData) {
					$SensorName = $PropData[c_Property_IPSSchaltuhrName];
					$SensorID 	= $PropData[c_Property_SensorID];
					$SensorCo 	= $PropData[c_Property_Condition];
					$Value 		= $PropData[c_Property_Value];

					if ((bool)$StartAktiv[$i] == true) {
						switch ($SensorCo){
							case '>':
								if (GetValue($SensorID) > $Value) $resultstart++;
							break;
							case '=':
								if (GetValue($SensorID) == $Value) $resultstart++;
							break;
							case '<':
								if (GetValue($SensorID) < $Value) $resultstart++;
							break;
						}
					} else {
						$resultstart++;
					}
					$i++;
				}

				//RUNSENSOREN �BERPR�FEN
				$resultrun = 0;
				$RunAktiv =  explode(',', get_ControlValue(c_Control_RunAktiv, $CircleId));
				$i=1;
				foreach ($Properts[c_Property_RunSensoren] as $PropName=>$PropData) {
					$SensorName = $PropData[c_Property_IPSSchaltuhrName];
					$SensorID 	= $PropData[c_Property_SensorID];
					$SensorCo 	= $PropData[c_Property_Condition];
					$Value 		= $PropData[c_Property_Value];

					if ((bool)$RunAktiv[$i] == true) {
							switch ($SensorCo) {
								case '>':
									if (GetValue($SensorID) > $Value) $resultrun++;
								break;
								case '=':
									if (GetValue($SensorID) == $Value) $resultrun++;
								break;
								case '<':
									if (GetValue($SensorID) < $Value) $resultrun++;
								break;
							}
					} else {
							$resultrun++;
					}
					$i++;
				}


	            IPSSchaltuhr_CustomCheckAndUpdateEndtime($CircleId,$CircleName,$Name);
				if (count($Properts[c_Property_StartSensoren]) == $resultstart) {
					// --------------- Aktion -------------------
					set_ControlValue(c_Control_SollAusgang, $CircleId, true);
					IPSSchaltuhr_Log('Zeitschaltuhr: '.$EventMode.' ('.$Name.')');
					IPSLogger_Inf(__file__, 'Zeitschaltuhr: '.$Name.', Mode: '.$EventMode);
					if (count($Properts[c_Property_RunSensoren]) == $resultrun) {
						set_ControlValue(c_Control_IstAusgang, $CircleId, true);
						IPSLogger_Inf(__file__, 'Zeitschaltuhr Callback Aktion f�r:  '.$Name.', Mode: SensorStart');
						IPSSchaltuhr_Log($Name.', Mode: SensorStart');
						$CircleName($CircleId, $EventMode);
					} else {
						set_ControlValue(c_Control_IstAusgang, $CircleId, false);
						IPSLogger_Inf(__file__, 'Zeitschaltuhr Callback Aktion f�r:  '.$Name.', Mode: SensorStop');
						IPSSchaltuhr_Log($Name.', Mode: SensorStop');
						$CircleName($CircleId, "Stop");
					}
				} else {
					set_ControlValue(c_Control_SollAusgang, $CircleId, false);
					IPSSchaltuhr_Log('Zeitschaltuhr: Stop ('.$Name.')');
					IPSLogger_Inf(__file__, 'Zeitschaltuhr: '.$Name.', Mode: Stop');
					set_ControlValue(c_Control_IstAusgang, $CircleId, false);
					$CircleName($CircleId, "Stop");
				}
            	set_Overview($CircleId);
			}

			if ($EventMode=='Stop') {
				$result = 0;
				$StopAktiv =  explode(',', get_ControlValue(c_Control_StopAktiv, $CircleId));
				$i=1;
				foreach ($Properts[c_Property_StopSensoren] as $PropName=>$PropData) {
					$SensorName = $PropData[c_Property_IPSSchaltuhrName];
					$SensorID 	= $PropData[c_Property_SensorID];
					$SensorCo 	= $PropData[c_Property_Condition];
					$Value 		= $PropData[c_Property_Value];

					if ((bool)$StopAktiv[$i] == true) {
							switch ($SensorCo){
								case '>':
									if (GetValue($SensorID) > $Value) $result++;
								break;
								case '=':
									if (GetValue($SensorID) == $Value) $result++;
								break;
								case '<':
									if (GetValue($SensorID) < $Value) $result++;
								break;
							}
					} else {
						$result++;
					}
					$i++;
				}

				if (count($Properts[c_Property_StopSensoren]) == $result) {
					// --------------- Aktion -------------------
					IPSSchaltuhr_Log('Zeitschaltuhr: '.$EventMode.' ('.$Name.')');
					set_ControlValue(c_Control_SollAusgang, $CircleId, false);
					set_ControlValue(c_Control_IstAusgang, $CircleId, false);
					IPSLogger_Inf(__file__, 'Zeitschaltuhr: '.$Name.', Mode: '.$EventMode);
					$CircleName($CircleId, $EventMode);
				} else {
					//IPSLogger_Inf(__file__, 'Zeitschaltuhr: '.$Name.', Mode: '.$EventMode.' Sensorenbedingungen nicht erf�llt');
					//IPSSchaltuhr_Log('Zeitschaltuhr: '.$EventMode.' ('.$Name.')');
					//set_ControlValue(c_Control_SollAusgang, $CircleId, false);
					//set_ControlValue(c_Control_IstAusgang, $CircleId, false);
					//$CircleName($CircleId, $EventMode);
				}
         		set_Overview($CircleId);
			}
		} else {
				IPSLogger_Err(__file__, "Zeitschaltuhr CallBack Funktion $CircleName in IPSSchaltuhr_Custom existiert nicht. Schaltuhr: ".$Name);
		}
	}

	switch ($_IPS['SENDER']) {
		case 'TimerEvent':
			$eventId 	=  $_IPS['EVENT'];
			$strpos  	= strrpos(IPS_GetName($eventId), '-', 0);
			$CircleName = substr(IPS_GetName($eventId),0, $strpos);
			$EventMode 	= substr(IPS_GetName($eventId), $strpos+1, strlen(IPS_GetName($eventId))-$strpos-1);
			IPSSchaltuhr_TimerStart($CircleName,$EventMode);
		break;
		
		case 'WebFront':
		break;
		
		case 'RunScript':
		case 'Execute':
			$eventId=ZSU_ID_ZSUZEITEN;
			$Circle_IDs=(IPS_GetChildrenIDs($eventId));
			foreach ($Circle_IDs as $Circle_ID) {
				$CircleName=IPS_GetName($Circle_ID);
				if (IPS_HasChildren($Circle_ID)) {
					$ValueStart=GetValue(IPS_GetObjectIDByName ("StartZeit", $Circle_ID));
					$ValueStop=GetValue(IPS_GetObjectIDByName ("StopZeit", $Circle_ID));				
					$NowTime=time();					
					$ValueStart=strftime("%Y-%m-%d",$NowTime)." ".$ValueStart;
					$TimeStart=strtotime($ValueStart);
					$ValueStop=strftime("%Y-%m-%d",$NowTime)." ".$ValueStop;
					$TimeStop=strtotime($ValueStop);
					if ($TimeStop<$TimeStart) {
						$TimeStop+=86400;
					}
					if ($NowTime>=$TimeStart && $NowTime<$TimeStop) {
						IPSSchaltuhr_TimerStart($CircleName,'Start');
					} else {
						IPSSchaltuhr_TimerStart($CircleName,'Stop');
					}
				}
			}		
		break;
		
		case 'Variable':
			$eventId 	=  $_IPS['EVENT'];
			$strpos  	= strrpos(IPS_GetName($eventId), '-', 0);
			$CircleName = substr(IPS_GetName($eventId),0, $strpos);
			
			$Circle_ID=IPS_GetObjectIDByName ($CircleName, ZSU_ID_ZSUZEITEN);
			if (IPS_HasChildren($Circle_ID)) {
				$ValueStart=GetValue(IPS_GetObjectIDByName ("StartZeit", $Circle_ID));
				$ValueStop=GetValue(IPS_GetObjectIDByName ("StopZeit", $Circle_ID));
				
				$NowTime=time();
				
				$ValueStart=strftime("%Y-%m-%d",$NowTime)." ".$ValueStart;
				$TimeStart=strtotime($ValueStart);
				$ValueStop=strftime("%Y-%m-%d",$NowTime)." ".$ValueStop;
				$TimeStop=strtotime($ValueStop);
				if ($TimeStop<$TimeStart) {
					$TimeStop+=86400;
				}
				if ($NowTime>=$TimeStart && $NowTime<=$TimeStop) {
					IPSSchaltuhr_TimerStart($CircleName,'Start');
				} else {
					IPSSchaltuhr_TimerStart($CircleName,'Stop');
				}
			}
		break;
		
		default:
			IPSLogger_Err(__file__, 'Unknown Sender '.$_IPS['SENDER']);
		break;		
	}


	/** @}*/
?>