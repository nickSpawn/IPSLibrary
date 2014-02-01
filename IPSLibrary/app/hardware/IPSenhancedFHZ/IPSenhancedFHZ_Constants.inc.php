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
	 * @file          IPSenhancedFHZ_Constants.inc.php
	 * @author        Günter Strassnigg
	 * @version
	 *  Version 0.1.3, 04.01.2014<br/>
	 *
	 * Definition der Konstanten IPSenhancedFHZ
	 *
	 */

	// Confguration Device Property Definition 
	define ('c_control_eFHZ_battery',								"battery");
	define ('c_control_eFHZ_windowopen',							"windowopen");
	define ('c_control_eFHZ_position',								"position");
	define ('c_control_eFHZ_drivecontrol',							"drivecontrol");
	define ('c_control_eFHZ_drivecontrol_timer',					"drivecontrol_timer");
	define ('c_control_eFHZ_target_temperature_request',		"target_temperature_request");
	define ('c_control_eFHZ_target_temperature_responce',		"target_temperature_responce");
	define ('c_control_eFHZ_actual_temperature_responce',		"actual_temperature_responce");
	define ('c_control_eFHZ_suntemp_request',						"suntemp_request");
	define ('c_control_eFHZ_suntemp_responce',					"suntemp_responce");
	define ('c_control_eFHZ_lunatemp_request',					"lunatemp_request");
	define ('c_control_eFHZ_lunatemp_responce',					"lunatemp_responce");
	define ('c_control_eFHZ_weekprogram_request',				"weekprogram_request");
	define ('c_control_eFHZ_weekprogram_responce',				"weekprogram_responce");
	define ('c_control_eFHZ_windowtemp_request',					"windowtemp_request");
	define ('c_control_eFHZ_windowtemp_responce',				"windowtemp_responce");
	define ('c_control_eFHZ_mode_request',							"mode_request");
	define ('c_control_eFHZ_mode_responce',						"mode_responce");
	define ('c_control_eFHZ_partytime_request',					"partytime_request");
	define ('c_control_eFHZ_partytime_responce',					"partytime_responce");
  
	define ('c_Type_eFHZ_FHT80b',										"FHT80b");
	define ('c_Type_eFHZ_FS20Switch',								"FS20-Schalter");
	
	define ('c_Property_eFHZ_Type',									"Geraet");
	define ('c_Property_eFHZ_Name',									"Name");
	define ('c_Property_eFHZ_Description',							"Beschreibung");
	define ('c_Property_eFHZ_HouseCode',							"Hauscode");
	define ('c_Property_eFHZ_Address',								"Adresse");
	define ('c_Property_eFHZ_Leap',									"Schaltjahrberichtigung");
	define ('c_Property_eFHZ_windowemulate',						"Fenstertemperaturemulierung");
	define ('c_Property_eFHZ_windowsensors',						"Fenstermelder");
	//define ('c_Property_eFHZ_timesyncTime',						"Zeitsynchronisation-Zeit");
	//define ('c_Property_eFHZ_timesyncWeekdays',					"Zeitsynchronisation-Wochentage");
   
	define ('c_profile_eFHZ_drivecontrol_normal',				"drivecontrol_normal");
	define ('c_profile_eFHZ_drivecontrol_valvedrive',			"drivecontrol_valvedrive");
	define ('c_profile_eFHZ_drivecontrol_testmode',				"drivecontrol_testmode");
	define ('c_profile_eFHZ_drivecontrol_syncing',				"drivecontrol_syncing");

	// Do not change
	if (!(defined('c_eFHZ_language'))) {
		define ('c_eFHZ_language',										"DE");
	}
	IPSUtils_Include("IPSenhancedFHZ_Language_".c_eFHZ_language.".inc.php",							"IPSLibrary::app::hardware::IPSenhancedFHZ");

	/** @}*/
?>