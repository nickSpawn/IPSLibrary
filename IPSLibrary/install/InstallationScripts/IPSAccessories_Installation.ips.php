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


	/**@defgroup ipsaccessories_install IPSAccessories Installation
	 * @ingroup ipsaccessories
	 * @{
	 *
	 * Script zur kompletten Installation der IPSAccessories Steuerung.
	 *
	 * Vor der Installation muß das File IPSAccessories_Configuration.inc.php an die persönlichen
	 * Bedürfnisse angepasst werden.
	 *
	 * @page rquirements_IPSAccessories Installations Voraussetzungen
	 * - IPS Kernel >= 2.50.1
	 * - IPSModuleManager >= 2.50.1
	 * - IPSLogger >= 2.50.1
	 * - IPSMessageHandler >= 2.50.1
	 *
	 * @page install_IPSAccessories Installations Schritte
	 * Folgende Schritte sind zur Installation der IPSAccessories Ansteuerung nötig:
	 * - Laden des Modules (siehe IPSModuleManager)
	 * - Konfiguration (Details siehe Konfiguration)
	 * - Installation (siehe IPSModuleManager)
	 *
	 * @file          IPSAccessories_Installation.ips.php
	 * @author        Günter Strassnigg
	 * @version
	 *  Version 1.00.1, 06.01.2014<br/>
	 *
	 */

	
	if (!isset($moduleManager)) {
		IPSUtils_Include ('IPSModuleManager.class.php', 'IPSLibrary::install::IPSModuleManager');

		echo 'ModuleManager Variable not set --> Create "default" ModuleManager';
		$moduleManager = new IPSModuleManager('IPSAccessories');
	}

	$moduleManager->VersionHandler()->CheckModuleVersion('IPS','2.50');
	$moduleManager->VersionHandler()->CheckModuleVersion('IPSModuleManager','2.50.1');
	$moduleManager->VersionHandler()->CheckModuleVersion('IPSLogger','2.50.1');
	$moduleManager->VersionHandler()->CheckModuleVersion('IPSComponent','2.50.1');
	$moduleManager->VersionHandler()->CheckModuleVersion('IPSMessageHandler','2.50.1');

	IPSUtils_Include("IPSInstaller.inc.php",         			  "IPSLibrary::install::IPSInstaller");
	IPSUtils_Include("IPSAccessories_Configuration.inc.php",		"IPSLibrary::config::modules::IPSAccessories");
	IPSUtils_Include("IPSAccessories_Custom.inc.php",				"IPSLibrary::config::modules::IPSAccessories");
	IPSUtils_Include("IPSAccessories_Constants.inc.php",			"IPSLibrary::app::modules::IPSAccessories");
	IPSUtils_Include("IPSAccessories.inc.php",						"IPSLibrary::config::modules::IPSAccessories");

 	$lang=IPSAccessories_GetLanguages();


	// ----------------------------------------------------------------------------------------------------------------------------
	// Program Installation
	// ----------------------------------------------------------------------------------------------------------------------------
	$CategoryIdApp      = $moduleManager->GetModuleCategoryID('app');
	$CategoryIdData     = $moduleManager->GetModuleCategoryID('data');

	//$categoryIdDevices = CreateCategory('Kalender', $CategoryIdData, 10);
	//$categoryIdDevices = CreateCategory('Wetterwerte', $CategoryIdData, 10);

	// Add Scripts
	$scriptIdActionScript  = IPS_GetScriptIDByName('IPSAccessories_ActionScript.ips.php', $CategoryIdApp);
	$scriptIdIncScript     = IPS_GetScriptIDByName('IPSAccessories.inc.php', $CategoryIdApp);
   
	// ----------------------------------------------------------------------------------------------------------------------------
	// Add IPSenhancedFHZ Devices
	// ----------------------------------------------------------------------------------------------------------------------------
	$IPSAccessoriesonfig = IPSAccessories_GetConfiguration();
	/*foreach ($IPSenhancedFHZonfig as $deviceHousecode=>$deviceData) {
		$deviceType = $deviceData[c_Property_eFHZ_Type];
		$deviceName = $deviceData[c_Property_eFHZ_Name];
		$deviceDescription = $deviceData[c_Property_eFHZ_Description];

		switch ($deviceType) {
			case c_Type_eFHZ_FHT80b:
				$VariableId = CreateVariable(c_control_eFHZ_actual_temperature_responce,  2 ,   $deviceId,   1, '~Temperature.FHT', null, 5.5,   'Temperature');
				$VariableId = RenameVariable(c_control_eFHZ_actual_temperature_responce, $deviceId, $lang);
        		break;
        		
			case c_Type_eFHZ_FS20Switch:
				trigger_error('IPSenhancedFHZ DeviceType '.$deviceType.' for '.$deviceName.' is not supported for now.');
				break;
				
			default:
				trigger_error('Unknown DeviceType '.$deviceType.' found for IPSenhancedFHZ-'.$deviceName);
		}
	}*/


?>