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

	/**@addtogroup ipsaccessories
	 * @{
	 *
	 * @file          IPSAccessories_ActionScript.ips.php
	 * @author        Günter Strassnigg
	 * @version
	 *   Version 1.0.0, 05.01.2014<br/>
	 *
	 * IPSAccessories ActionScript 
	 */
	IPSUtils_Include("IPSLogger.inc.php",								"IPSLibrary::app::core::IPSLogger");
	IPSUtils_Include("IPSAccessories_Configuration.inc.php",		"IPSLibrary::config::modules::IPSAccessories");
	IPSUtils_Include("IPSAccessories_Custom.inc.php",				"IPSLibrary::config::modules::IPSAccessories");
	IPSUtils_Include("IPSAccessories_Constants.inc.php",			"IPSLibrary::app::modules::IPSAccessories");
	IPSUtils_Include("IPSAccessories.inc.php",						"IPSLibrary::config::modules::IPSAccessories");


	
	$variableId   = $_IPS['VARIABLE'];
	$value        = $_IPS['VALUE'];
	$categoryName = IPS_GetName(IPS_GetParent($_IPS['VARIABLE']));
	
	// ----------------------------------------------------------------------------------------------------------------------------
	if ($_IPS['SENDER']=='WebFront') {
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
	} else {
	}

    /** @}*/
?>