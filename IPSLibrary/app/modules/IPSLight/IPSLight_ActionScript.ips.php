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

	/**@ingroup ipslight
	 * @{
	 *
	 * @file          IPSLight_ActionScript.inc.php
	 * @author        Andreas Brauneis
	 * @version
	 *  Version 2.50.1, 26.07.2012<br/>
	 *
	 * IPSLight ActionScript 
	 *
	 */

	include_once "IPSLight.inc.php";
	
	
	// ----------------------------------------------------------------------------------------------------------------------------
	if ($_IPS['SENDER']=='WebFront') {
		$variableId   = $_IPS['VARIABLE'];
		$value        = $_IPS['VALUE'];
		$categoryName = IPS_GetName(IPS_GetParent($_IPS['VARIABLE']));
		switch ($categoryName) {
			case 'Switches':
				IPSLight_SetValue($variableId, $value);
				break;
			case 'Groups':
				IPSLight_SetGroup($variableId, $value);
				break;
			case 'Programs':
				IPSLight_SetProgram($variableId, $value);
				break;
			default:
				trigger_error('Unknown Category '.$categoryName);
		}

	// ----------------------------------------------------------------------------------------------------------------------------
	} elseif ($_IPS['SENDER']=='TimerEvent') {
		$variableId   = $_IPS['EVENT'];
		$varname			= IPS_GetName($variableId);
		$strpos1			= strpos($varname, '|');
		$strpos2			= strrpos($varname, '|', 0);
		$categoryName	= substr($varname,0, $strpos1);
		$action			= (int)substr($varname, $strpos1+1, $strpos2-$strpos1-1);
	   $deviceID		= (int)substr($varname, $strpos2+1, strlen($varname)-$strpos2-1);
		$value			= !(GetValue((int)$deviceID));
		switch ($categoryName) {
			case 'Switches':
				IPSLight_SetValue($deviceID, $value);
				break;
			default:
				trigger_error('Unknown Category '.$categoryName);
		}
	}
                      
    /** @}*/
?>