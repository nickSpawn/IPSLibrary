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
	 * @file          IPSenhancedFHZ_Language_EN.inc.php
	 * @author        Günter Strassnigg
	 * @version
	 *  Version 1.0.1, 04.01.2014<br/>
	 *
	 * Definition der Konstanten IPSenhancedFHZ
	 *
	 */

	// Language Definitions:  ENGLISH Translation
	
	
	function IPSenhancedFHZ_GetLanguages() {

		$lang=array();		
		$lang['c_control_eFHZ_autoinit']=							"auto init";
		$lang['c_control_eFHZ_battery']=								"battery state";
		$lang['c_control_eFHZ_windowopen']=							"window opened";
		$lang['c_control_eFHZ_position']=							"position";
		$lang['c_control_eFHZ_drivecontrol']=						"drivecontrol";
		$lang['c_control_eFHZ_drivecontrol_timer']=				"drivecontrol (Timer)";
		$lang['c_control_eFHZ_target_temperature_request']=	"target temperature (request)";
		$lang['c_control_eFHZ_target_temperature_responce']=	"target temperature";
		$lang['c_control_eFHZ_actual_temperature_request']=	"actual temperature (request)";
		$lang['c_control_eFHZ_actual_temperature_responce']=	"actual temperature";
		$lang['c_control_eFHZ_suntemp_request']=					"comfort temperature (request)";
		$lang['c_control_eFHZ_suntemp_responce']=					"comfort temperature";
		$lang['c_control_eFHZ_lunatemp_request']=					"reduced temperature (request)";
		$lang['c_control_eFHZ_lunatemp_responce']=				"reduced temperature";
		$lang['c_control_eFHZ_weekprogram_request']=				"weekprogram (request)";
		$lang['c_control_eFHZ_weekprogram_responce']=			"weekprogram";
		$lang['c_control_eFHZ_windowtemp_request']=				"window temperature (request)";
		$lang['c_control_eFHZ_windowtemp_responce']=				"window temperature";
		$lang['c_control_eFHZ_mode_request']=						"target mode (request)";
		$lang['c_control_eFHZ_mode_responce']=						"target mode";
		$lang['c_control_eFHZ_partytime_request']=				"Party-/Urlaubsmodus (request)";
		$lang['c_control_eFHZ_partytime_responce']=				"Party-/Urlaubsmodus";
	
		$lang['c_LogMess_eFHZ_target_temperature_request']=	"The target temperature for %device% was set to %value%°C.";
		$lang['c_LogMess_eFHZ_suntemp_request']=					"The comfort temperature for %device% was set to %value%°C.";
		$lang['c_LogMess_eFHZ_lunatemp_request']=					"The reduced temperature for %device% was set to %value%°C.";
		$lang['c_LogMess_eFHZ_windowtemp_request']=				"The window temperature for %device% was set to %value%°C.";
		$lang['c_LogMess_eFHZ_target_temperature_responce']=	"The target temperature for %device% is set to %value%°C.";
		$lang['c_LogMess_eFHZ_suntemp_responce']=					"The comfort temperature for %device% is set to %value%°C.";
		$lang['c_LogMess_eFHZ_lunatemp_responce']=				"The reduced temperature for %device% is set to %value%°C.";
		$lang['c_LogMess_eFHZ_windowtemp_responce']=				"The window temperature for %device% is set to %value%°C.";
		$lang['c_LogMess_eFHZ_actual_temperature_responce']=	"The measurement of the current room temperature for %device% returned %Value%°C.";
		$lang['c_LogMess_eFHZ_partytime_request']=				"Der Party-/Urlaubsmodus von %Device% wurde bis %Value% gesetzt.";
		$lang['c_LogMess_eFHZ_partytime_responce']=				"Der Party-/Urlaubsmodus von %Device% wurde bis %Value% aktiviert.";	
		$lang['c_LogMess_eFHZ_autoinit'][true]=					"Die Autoinitialisierung für %Device% wurde gestartet.";
		$lang['c_LogMess_eFHZ_autoinit'][false]=					"Die Autoinitialisierung für %Device% wurde beendet.";
		$lang['c_LogMess_eFHZ_battery'][true]=						"Der Batteriezustand von %Device% ist kritisch.";
		$lang['c_LogMess_eFHZ_battery'][false]=					"Der Batteriezustand von %Device% wurde zurückgesetzt oder ist in Ordnung.";
		$lang['c_LogMess_eFHZ_mode_request'][0]=					"The mode for %device% was set to automatic mode.";
		$lang['c_LogMess_eFHZ_mode_responce'][0]=					"The mode for %device% was set to automatic mode.";
		$lang['c_LogMess_eFHZ_mode_request'][1]=					"The mode for %device% was set to manual mode.";
		$lang['c_LogMess_eFHZ_mode_responce'][1]=					"The mode for %device% was set to manual mode.";
		$lang['c_LogMess_eFHZ_mode_request'][2]=					"Der Modus für %Device% wurde auf Party-/Urlaubsbetrieb gesetzt.";
		$lang['c_LogMess_eFHZ_mode_responce'][2]=					"Der Modus für %Device% wurde auf Party-/Urlaubsbetrieb eingestellt.";
		$lang['c_LogMess_eFHZ_windowopen'][true]=					"The window detector of device%% displays the message: windows opened.";
		$lang['c_LogMess_eFHZ_windowopen'][false]=				"The window detector of device%% displays the message: windows closed.";

		$lang['c_profile_eFHZ_drivecontrol_normal']=				"normal";
		$lang['c_profile_eFHZ_drivecontrol_valvedrive']=		"valvedriving";
		$lang['c_profile_eFHZ_drivecontrol_testmode']=			"testmode";
		$lang['c_profile_eFHZ_drivecontrol_syncing']=			"syncing";

		$lang['c_LogMess_eFHZ_new_time_is_set']=					"The date and time for %Device% has been changed.";
		$lang['c_LogMess_eFHZ_which_day']=							array("Monday","Tuesday","Wednesday","Thursday","Friday","Satuerday","Sunday");
		$lang['c_LogMess_eFHZ_new_weekprogram_is_set']=			"The weekprogram for '%Value%'' and %Device% has been changed.";
		
		return $lang;
	}
	
	/** @}*/
	
?>