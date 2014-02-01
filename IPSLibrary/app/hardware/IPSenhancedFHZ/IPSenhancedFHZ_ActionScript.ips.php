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
    * @class IPSenhancedFHZ
    *
    * Definiert das IPSenhancedFHZ Object, das den Versand und Empfang über den IPSenhancedFHZ-Puffer verarbeitet.
    *
	 * @file          IPSenhancedFHZ_ActionScript.class.php
    * @author Günter Strassnigg
    * @version
	 *  Version 0.1.3, 19.01.2014<br/>
    */

	IPSUtils_Include ("IPSenhancedFHZ.inc.php","IPSLibrary::app::hardware::IPSenhancedFHZ");

	function Init($deviceID) {
		$device=new IPSenhancedFHZ($deviceID);
		echo ($device->ConnectionReady);
		echo ($device->sFHT_Init());
		echo chr(13);
	}

	switch ($_IPS['SENDER']) {
		case 'TimerEvent':
			$variableId   = $_IPS['EVENT'];
			$strpos  	= strrpos(IPS_GetName($variableId), '|', 0);
			$devicename = IPS_GetInstanceIDByName(substr(IPS_GetName($variableId),0, $strpos),);
			$deviceID	= @IPSUtil_ObjectIDByPath('Program.IPSLibrary.data.hardware.IPSenhancedFHZ.Devices.'.$devicename,true);
			$action		= substr(IPS_GetName($variableId), $strpos+1, strlen(IPS_GetName($variableId))-$strpos-1);
			if ($action=='UpdateTime') {
				$device=new IPSenhancedFHZ($deviceID);
				$device->sFHZ_SetDateAndTime();
			}
		break;
		
		case 'Variable':
			$variableId   = $_IPS['VARIABLE'];
			$value        = $_IPS['VALUE'];
		break;
		
		case 'RunScript':
			$deviceID	  = $_IPS['DEVICEID'];
			$action       = $_IPS['ACTION'];
			if ($action=='Init') {
				$device=new IPSenhancedFHZ($deviceID);
				$device->sFHT_Init();
			}
		break;
		
		case 'Execute':
			$deviceID	  = 16780;
			$action       = 'Init';
			if ($action=='Init') {
				$device=new IPSenhancedFHZ($deviceID);
				$device->sFHT_Init();
			}
		break;
		
		default:
			IPSLogger_Err(__file__, 'Unknown Sender '.$_IPS['SENDER']);
		break;		
	}


	/** @}*/

?>
