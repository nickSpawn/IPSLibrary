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


	/**@defgroup ipsenhancedfhz_install IPSLight Installation
	 * @ingroup ipsenhancedfhz
	 * @{
	 *
	 * Script zur kompletten Installation der IPSenhancedFHZ Steuerung.
	 *
	 * Vor der Installation mu� das File IPSenhancedFHZ_Configuration.inc.php an die pers�nlichen
	 * Bed�rfnisse angepasst werden.
	 *
	 * @page rquirements_IPSenhancedFHZ Installations Voraussetzungen
	 * - IPS Kernel >= 2.50
	 * - IPSModuleManager >= 2.50.2
	 * - IPSLogger >= 2.50.2
	 *
	 * @page install_IPSenhancedFHZ Installations Schritte
	 * Folgende Schritte sind zur Installation der IPSenhancedFHZ Ansteuerung n�tig:
	 * - Laden des Modules (siehe IPSModuleManager)
	 * - Konfiguration (Details siehe Konfiguration)
	 * - Installation (siehe IPSModuleManager)
	 *
	 * @file          IPSenhancedFHZ_Installation.ips.php
	 * @author        G�nter Strassnigg
	 * @version
	 *  Version 0.1.3, 19.01.2014<br/>
	 *
	 */


   function GetFTDIInstance($SearchedID) {
		foreach(IPS_GetInstanceList() as $id) {
			$Instance = IPS_GetInstance($id);
			if ($Instance['ModuleInfo']['ModuleID']=='{C1D478E9-2A3E-4344-BCC4-37C892F58751}') {
				if ($Instance['InstanceID']==$SearchedID) {
					return true;
				}
			}
		}
		return false;
	}

	function RenameVariable($Name, $ParentId, $lang) {
		$VariableId = @IPS_GetObjectIDByIdent(Get_IdentByName($Name), $ParentId);
		if ($VariableId) {
			if (IPS_GetName($VariableId)!=$lang['c_control_eFHZ_'.$Name]) {
				IPS_SetName($VariableId, $lang['c_control_eFHZ_'.$Name]);
			}		
			return $VariableId;
		} else {
			return false;
		}
	}
	
	if (!isset($moduleManager)) {
		IPSUtils_Include ('IPSModuleManager.class.php', 'IPSLibrary::install::IPSModuleManager');

		echo 'ModuleManager Variable not set --> Create "default" ModuleManager';
		$moduleManager = new IPSModuleManager('IPSenhancedFHZ');
	}

	$moduleManager->VersionHandler()->CheckModuleVersion('IPS','2.50');
	$moduleManager->VersionHandler()->CheckModuleVersion('IPSModuleManager','2.50.2');
	$moduleManager->VersionHandler()->CheckModuleVersion('IPSLogger','2.50.2');

	IPSUtils_Include ("IPSInstaller.inc.php",         			  "IPSLibrary::install::IPSInstaller");
	IPSUtils_Include ("IPSenhancedFHZ.inc.php",                "IPSLibrary::app::hardware::IPSenhancedFHZ");

	if (GetFTDIInstance(c_eFHZ_FTDIfhzID)===false) {
		throw new Exception('FTDI Device could NOT be found! You have to install MANUAL a FHZ Device and a FTDI I/O Instance.', E_USER_ERROR);
	}

 	$lang=IPSenhancedFHZ_GetLanguages();


	// ----------------------------------------------------------------------------------------------------------------------------
	// Program Installation
	// ----------------------------------------------------------------------------------------------------------------------------
	$CategoryIdApp      = $moduleManager->GetModuleCategoryID('app');
	$CategoryIdData     = $moduleManager->GetModuleCategoryID('data');

	$categoryIdDevices = CreateCategory('Devices', $CategoryIdData, 10);

	// Add Scripts
	$scriptIdReceiveScript = IPS_GetScriptIDByName('IPSenhancedFHZ_Receive', $CategoryIdApp);
	$scriptIdRegVarScript  = IPS_GetScriptIDByName('IPSenhancedFHZ_RegVar', $CategoryIdApp);
	$scriptIdActionScript  = IPS_GetScriptIDByName('IPSenhancedFHZ_ActionScript', $CategoryIdApp);

	// Profiles
	$IPSenhancedFHZ_eFHZDriveControl = array(
				0      => $lang['c_profile_eFHZ_drivecontrol_normal'],
				1      => $lang['c_profile_eFHZ_drivecontrol_valvedrive'],
				2      => $lang['c_profile_eFHZ_drivecontrol_testmode'],
				3      => $lang['c_profile_eFHZ_drivecontrol_syncing']
	);

	CreateProfile_Associations ('eFHZDriveControl', $IPSenhancedFHZ_eFHZDriveControl);
   
	// ----------------------------------------------------------------------------------------------------------------------------
	// Add IPSenhancedFHZ Receiving Buffer
	// ----------------------------------------------------------------------------------------------------------------------------
   $InstanceId = CreateRegisterVariable('IPSenhancedFHZ_Buffer', $CategoryIdApp, $scriptIdRegVarScript, c_eFHZ_FTDIfhzID, 0); 
   
	// ----------------------------------------------------------------------------------------------------------------------------
	// Add IPSenhancedFHZ Devices
	// ----------------------------------------------------------------------------------------------------------------------------
	$IPSenhancedFHZonfig = IPSenhancedFHZ_GetFHZConfiguration();
	foreach ($IPSenhancedFHZonfig as $deviceHousecode=>$deviceData) {
		$deviceType 			= $deviceData[c_Property_eFHZ_Type];
		$deviceName 			= $deviceData[c_Property_eFHZ_Name];
		$deviceDescription 	= $deviceData[c_Property_eFHZ_Description];

		switch ($deviceType) {
			case c_Type_eFHZ_FHT80b:
				$deviceId   = CreateDummyInstance($deviceName, $categoryIdDevices,0);

				$VariableId = CreateVariable(c_control_eFHZ_actual_temperature_responce,  2 /*Float*/,   $deviceId,   1, '~Temperature.FHT', null, 5.5,   'Temperature');
				$VariableId = CreateVariable(c_control_eFHZ_position,                     2 /*Float*/,   $deviceId,   2, '~Valve.F',         null, 0.0,   'Gauge');
				$VariableId = CreateVariable(c_control_eFHZ_battery,                      0 /*Boolean*/, $deviceId,   3, '~Battery',         null, false, 'Battery');
				$VariableId = CreateVariable(c_control_eFHZ_windowopen,                   0 /*Boolean*/, $deviceId,   4, '~Window',          null, false, 'Window');
				$VariableId = CreateVariable(c_control_eFHZ_target_temperature_request,   2 /*Float*/,   $deviceId,   5, '~Temperature.FHT', null, 5.5,   '');
				$VariableId = CreateVariable(c_control_eFHZ_target_temperature_responce,  2 /*Float*/,   $deviceId,   6, '~Temperature.FHT', null, 5.5,   'Temperature');
				$VariableId = CreateVariable(c_control_eFHZ_mode_request,                 1 /*Integer*/, $deviceId,   7, '~Mode.FHT',        null, 0,     '');
				$VariableId = CreateVariable(c_control_eFHZ_mode_responce,                1 /*Integer*/, $deviceId,   8, '~Mode.FHT',        null, 0,     'ArrowRight');
				$VariableId = CreateVariable(c_control_eFHZ_suntemp_request,              2 /*Float*/,   $deviceId,   9, '~Temperature.FHT', null, 5.5,   '');
				$VariableId = CreateVariable(c_control_eFHZ_suntemp_responce,             2 /*Float*/,   $deviceId,  10, '~Temperature.FHT', null, 5.5,   'Temperature');
				$VariableId = CreateVariable(c_control_eFHZ_lunatemp_request,             2 /*Float*/,   $deviceId,  11, '~Temperature.FHT', null, 5.5,   '');
				$VariableId = CreateVariable(c_control_eFHZ_lunatemp_responce,            2 /*Float*/,   $deviceId,  12, '~Temperature.FHT', null, 5.5,   'Temperature');
				$VariableId = CreateVariable(c_control_eFHZ_windowtemp_request,           2 /*Float*/,   $deviceId,  13, '~Temperature.FHT', null, 5.5,   '');
				$VariableId = CreateVariable(c_control_eFHZ_windowtemp_responce,          2 /*Float*/,   $deviceId,  14, '~Temperature.FHT', null, 5.5,   'Temperature');
				$VariableId = CreateVariable(c_control_eFHZ_partytime_request,            3 /*String*/,  $deviceId,  15, '~String',          null, '',    'Clock');
				$VariableId = CreateVariable(c_control_eFHZ_partytime_responce,           3 /*String*/,  $deviceId,  16, '~String',          null, '',    'Clock');
				$VariableId = CreateVariable(c_control_eFHZ_weekprogram_request,          3 /*String*/,  $deviceId,  17, '~String',          null, '',    'Calendar');
				$VariableId = CreateVariable(c_control_eFHZ_weekprogram_responce,         3 /*String*/,  $deviceId,  18, '~String',          null, '',    'Calendar');
				$VariableId = CreateVariable(c_control_eFHZ_drivecontrol,                 1 /*Integer*/, $deviceId,  20, 'eFHZDriveControl', null, 0,     'Repeat');
				$VariableId = CreateVariable(c_control_eFHZ_drivecontrol_timer,           1 /*Integer*/, $deviceId,  21, '',                 null, 0,     '');

				$VariableId = RenameVariable(c_control_eFHZ_actual_temperature_responce, $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_position,                    $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_battery,                     $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_windowopen,                  $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_target_temperature_request,  $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_target_temperature_responce, $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_mode_request,                $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_mode_responce,               $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_suntemp_request,             $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_suntemp_responce,            $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_lunatemp_request,            $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_lunatemp_responce,           $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_windowtemp_request,          $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_windowtemp_responce,         $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_partytime_request,           $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_partytime_responce,          $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_weekprogram_request,         $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_weekprogram_responce,        $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_drivecontrol,                $deviceId, $lang);
				$VariableId = RenameVariable(c_control_eFHZ_drivecontrol_timer,          $deviceId, $lang);

				if ($deviceWindowEmulate = $deviceData[c_Property_eFHZ_windowemulate]) {
					$deviceWindowSensors = $deviceData[c_Property_eFHZ_windowsensors];			
					while (list($sensor, $reverse) = each($deviceWindowSensors)) {
					   if (IPS_VariableExists($sensor)) {
							$triggerid = CreateEvent($deviceName.'|SetWindowTemp|Sensor_'.(string)$sensor, $sensor, $scriptIdActionScript, 1);
							IPS_SetParent($triggerid,$scriptIdActionScript);
						}
					}
				}		
        		break;
        		
			case c_Type_eFHZ_FS20Switch:
				trigger_error('IPSenhancedFHZ DeviceType '.$deviceType.' for '.$deviceName.' is not supported for now.');
				break;
				
			default:
				trigger_error('Unknown DeviceType '.$deviceType.' found for IPSenhancedFHZ-'.$deviceName);
		}
	}


?>