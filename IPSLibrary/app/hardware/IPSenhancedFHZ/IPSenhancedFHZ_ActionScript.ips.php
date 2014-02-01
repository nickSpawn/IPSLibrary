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

   /**
    * @ingroup IPSenhancedFHZ
    *
    * Definiert das IPSenhancedFHZ Object, das den Versand und Empfang über den IPSenhancedFHZ-Puffer verarbeitet.
    *
	 * @file          IPSenhancedFHZ_ActionScript.class.php
    * @author Günter Strassnigg
    * @version
	 *  Version 0.1.3, 19.01.2014<br/>
    */

	IPSUtils_Include ("IPSenhancedFHZ.inc.php","IPSLibrary::app::hardware::IPSenhancedFHZ");

	switch ($_IPS['SENDER']) {
		case 'TimerEvent':
			$variableId   = $_IPS['EVENT'];
			$varname		= IPS_GetName($variableId);
			$strpos1  	= strpos($varname, '|');
			$strpos2  	= strrpos($varname, '|', 0);
			$strpos3  	= strrpos($varname, '_', 0);
			$devicename = IPS_GetInstanceIDByName(substr($varname,0, $strpos1));
			$deviceID	= @IPSUtil_ObjectIDByPath('Program.IPSLibrary.data.hardware.IPSenhancedFHZ.Devices.'.$devicename,true);
			$action		= substr($varname, $strpos1+1, $strpos2-$strpos1-1);
		   $sensor  	= substr($varname, $strpos3+1, strlen($varname)-$strpos2-1);
			if ($action=='UpdateTime') {
				$device=new IPSenhancedFHZ($deviceID);
				$device->sFHZ_SetDateAndTime();
			}
		break;
		
		case 'Variable':
			$variableId   = $_IPS['VARIABLE'];
			$value        = $_IPS['VALUE'];
			$varname		= IPS_GetName($variableId);
			$strpos1  	= strpos($varname, '|');
			$strpos2  	= strrpos($varname, '|', 0);
			$strpos3  	= strrpos($varname, '_', 0);
			$devicename = IPS_GetInstanceIDByName(substr($varname,0, $strpos1));
			$deviceID	= @IPSUtil_ObjectIDByPath('Program.IPSLibrary.data.hardware.IPSenhancedFHZ.Devices.'.$devicename,true);
			$action		= substr($varname, $strpos1+1, $strpos2-$strpos1-1);
		   $sensor  	= substr($varname, $strpos3+1, strlen($varname)-$strpos2-1);
			if ($action=='SetWindowTemp') {
				$device=new IPSenhancedFHZ($deviceID);
				$device->bFHT_SetTemperatureByWindowMode($value);
				$device->bFHT_SendTo();
			}
		break;
		
		case 'RunScript':
			$deviceID	  = $_IPS['DEVICEID'];
			$action       = $_IPS['ACTION'];
			if ($action=='Init') {
				if (IPS_SemaphoreEnter("eFHZInitWait", 500)) {
					$device=new IPSenhancedFHZ($deviceID);
					$device->sFHT_Init();
					IPS_SemaphoreLeave("eFHZInitWait"); 
				}
			}
			elseif ($action=='SetWindowTemp') {
				$value       = $_IPS['VALUE'];
				$device=new IPSenhancedFHZ($deviceID);
				$device->bFHT_SetTemperatureByWindowMode($value);
				$device->bFHT_SendTo();
			}
		break;
				
		default:
			IPSLogger_Err(__file__, 'Unknown Sender '.$_IPS['SENDER']);
		break;		
	}

	/** @}*/

?>
