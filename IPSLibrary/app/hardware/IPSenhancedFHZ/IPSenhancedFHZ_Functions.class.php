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
	 * @file          IPSenhancedFHZ.inc.php
	 * @author        Günter Strassnigg
	 * @version
	 *  Version 0.1.2, 05.01.2014<br/>
	 *
	 */

   /**
    * @class eFHZ_Base
    *
    * Definiert das IPSenhancedFHZ Object, das den Empfang über den IPSenhancedFHZ-Puffer verarbeitet.
    *
    * @author Günter Strassnigg
    * @version
    *   Version 1.0.1, 04.01.2014<br/>
    */
	class eFHZ_Base {

		// ----------------------------------------------------------------------------------------------------------------------------
		protected function isBit($bitField,$n) {
			return ((($bitField & (0x01 << ($n-1))))>0);
		}
		
		// ----------------------------------------------------------------------------------------------------------------------------
		protected function setBit(&$bitField,$n) {
			if(($n < 0) or ($n > 32)) return false;
			$bitField |= (0x01 << ($n-1));
			return true;
		}
		
		// ----------------------------------------------------------------------------------------------------------------------------
		protected function clearBit(&$bitField,$n) {
			$bitField &= ~(0x01 << ($n-1));
			return true;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		protected function GetIdentValue($variableIdent,$deviceID) {
			$variableId = IPS_GetObjectIDByIdent($variableIdent, $deviceID);
			if ($variableId === false) {
				throw new Exception('Variable '.$variableIdent.' could NOT be found for DeviceId='.$this->deviceId);
			}
			return GetValue($variableId);
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		protected function SetIdentValue($variableIdent, $value,$deviceID) {
			$variableId = IPS_GetObjectIDByIdent($variableIdent, $deviceID);
			if ($variableId === false) {
				throw new Exception('Variable '.$variableIdent.' could NOT be found for DeviceId='.$this->deviceId);
			}
			SetValue($variableId, $value);
		}
		
		// ----------------------------------------------------------------------------------------------------------------------------
		protected function eFHZLogValue($variableIdent,$Value,$deviceID,$lang,$Key=false) {
			$name=IPS_GetName($deviceID);
			if ($Key===false)   {
				$logmessage=str_replace("%Device%",$name,$lang["c_LogMess_eFHZ_".$variableIdent]);
				$logmessage=str_replace("%Value%",$Value,$logmessage);
			} else {
				$logmessage=str_replace("%Device%",$name,$lang["c_LogMess_eFHZ_".$variableIdent][$Value]);
			}
			return $logmessage;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		protected function eFHZLogOtherValue($Identifier,$deviceID,$lang) {
			$name=IPS_GetName($deviceID);
			$logmessage=str_replace("%Device%",$name,$lang[$Identifier]);
			return $logmessage;
		}
		// ----------------------------------------------------------------------------------------------------------------------------
		protected function GetModeBasedOnWeeklyProgram ($weekprogram,$timestamp) {
			if (!is_array($wp=unserialize($weekprogram))) return 0;
			$Day=(int)date("w",$timestamp);$Day=($Day==0) ? 6 : $Day-1;
			$Time=(((float)(date("H",$timestamp)))+((float)(date("i",$timestamp))/60))*6;
			$x1on=$Day*4;$x1off=$x1on+1;$x2on=$x1off+1;$x2off=$x2on+1;$Value=2;
			if ($wp[$x1on]!=144 && $wp[$x1off]!=144 && $wp[$x1on]!=$wp[$x1off]) {
				if (($wp[$x1on]<$wp[$x1off])&&($Time>=$wp[$x1on] && $Time<$wp[$x1off])) return 3;
				if (($wp[$x1on]>$wp[$x1off])&&($Time>=$wp[$x1on] || $Time<$wp[$x1off])) return 3;
			}
			elseif ($wp[$x1on]==144 && $wp[$x1off]==144) $Value=1;
			if ($wp[$x2on]!=144 && $wp[$x2off]!=144 && $wp[$x2on]!=$wp[$x2off]) {
				if (($wp[$x2on]<$wp[$x2off])&&($Time>=$wp[$x2on] && $Time<$wp[$x2off])) return 3;
				if (($wp[$x2on]>$wp[$x2off])&&($Time>=$wp[$x2on] || $Time<$wp[$x2off])) return 3;
			}
			return $Value;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		protected function GetTemperatureBasedOnWeeklyProgram($weekprogram,$timestamp,$deviceID) {
			$Value=$this->GetModeBasedOnWeeklyProgram($weekprogram,$timestamp);
			if ($Value==3) return ($this->GetIdentValue(c_control_eFHZ_suntemp_responce,$deviceID));
			if ($Value==2) return ($this->GetIdentValue(c_control_eFHZ_lunatemp_responce,$deviceID));
			return 17;
		}
	}	

	/** @}*/


?>