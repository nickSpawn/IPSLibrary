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
	 * @file          IPSenhancedFHZ_Language_DE.inc.php
	 * @author        Günter Strassnigg
	 * @version
	 *  Version 0.1.2, 04.01.2014<br/>
	 *
	 * Definition der Konstanten IPSenhancedFHZ
	 *
	 */

	// Language Definitions:  GERMAN Translation
	
	function IPSenhancedFHZ_GetLanguages() {

		$lang=array();		
		$lang['c_control_eFHZ_battery']=								"Batteriestatus";
		$lang['c_control_eFHZ_windowopen']=							"Fenster geöffnet";
		$lang['c_control_eFHZ_position']=							"Stellwert";
		$lang['c_control_eFHZ_drivecontrol']=						"Status Stellantrieb";
		$lang['c_control_eFHZ_drivecontrol_timer']=				"Status Stellantrieb (Timer)";
		$lang['c_control_eFHZ_target_temperature_request']=	"Solltemperatur (Anforderung)";
		$lang['c_control_eFHZ_target_temperature_responce']=	"Solltemperatur";
		$lang['c_control_eFHZ_actual_temperature_request']=	"aktuelle Temperatur (Anforderung)";
		$lang['c_control_eFHZ_actual_temperature_responce']=	"aktuelle Temperatur";
		$lang['c_control_eFHZ_suntemp_request']=					"Komforttemperatur (Anforderung)";
		$lang['c_control_eFHZ_suntemp_responce']=					"Komforttemperatur";
		$lang['c_control_eFHZ_lunatemp_request']=					"Absenktemperatur (Anforderung)";
		$lang['c_control_eFHZ_lunatemp_responce']=				"Absenktemperatur";
		$lang['c_control_eFHZ_weekprogram_request']=				"Wochenprogramm (Anforderung)";
		$lang['c_control_eFHZ_weekprogram_responce']=			"Wochenprogramm";
		$lang['c_control_eFHZ_windowtemp_request']=				"Fenstertemperatur (Anforderung)";
		$lang['c_control_eFHZ_windowtemp_responce']=				"Fenstertemperatur";
		$lang['c_control_eFHZ_mode_request']=						"Sollmodus (Anforderung)";
		$lang['c_control_eFHZ_mode_responce']=						"Sollmodus";
		$lang['c_control_eFHZ_partytime_request']=				"Party-/Urlaubsmodus (Anforderung)";
		$lang['c_control_eFHZ_partytime_responce']=				"Party-/Urlaubsmodus";
	
		$lang['c_LogMess_eFHZ_target_temperature_request']=	"Die Solltemperatur für %Device% wurde auf %Value%°C gesetzt.";
		$lang['c_LogMess_eFHZ_suntemp_request']=					"Die Komforttemperatur für %Device% wurde auf %Value%°C gesetzt.";
		$lang['c_LogMess_eFHZ_lunatemp_request']=					"Die Absenktemperatur für %Device% wurde auf %Value%°C gesetzt.";
		$lang['c_LogMess_eFHZ_windowtemp_request']=				"Die Fenstertemperatur für %Device% wurde auf %Value%°C gesetzt.";
		$lang['c_LogMess_eFHZ_target_temperature_responce']=	"Die Solltemperatur für %Device% ist auf %Value%°C eingestellt.";
		$lang['c_LogMess_eFHZ_suntemp_responce']=					"Die Komforttemperatur für %Device% ist auf %Value%°C eingestellt.";
		$lang['c_LogMess_eFHZ_lunatemp_responce']=				"Die Absenktemperatur für %Device% ist auf %Value%°C eingestellt.";
		$lang['c_LogMess_eFHZ_windowtemp_responce']=				"Die Fenstertemperatur für %Device% ist auf %Value%°C eingestellt.";
		$lang['c_LogMess_eFHZ_actual_temperature_responce']=	"Die Messung der aktuellen Raumtemperatur für %Device% ergab %Value%°C.";
		$lang['c_LogMess_eFHZ_partytime_request']=				"Der Party-/Urlaubsmodus von %Device% wurde bis %Value% gesetzt.";
		$lang['c_LogMess_eFHZ_partytime_responce']=				"Der Party-/Urlaubsmodus von %Device% wurde bis %Value% aktiviert.";	
		$lang['c_LogMess_eFHZ_autoinit'][true]=					"Die Autoinitialisierung für %Device% wurde gestartet.";
		$lang['c_LogMess_eFHZ_autoinit'][false]=					"Die Autoinitialisierung für %Device% wurde beendet.";
		$lang['c_LogMess_eFHZ_battery'][true]=						"Der Batteriezustand von %Device% ist kritisch.";
		$lang['c_LogMess_eFHZ_battery'][false]=					"Der Batteriezustand von %Device% wurde zurückgesetzt oder ist in Ordnung.";
		$lang['c_LogMess_eFHZ_mode_request'][0]=					"Der Modus für %Device% wurde auf Automatikbetrieb gesetzt.";
		$lang['c_LogMess_eFHZ_mode_responce'][0]=					"Der Modus für %Device% wurde auf Automatikbetrieb eingestellt.";
		$lang['c_LogMess_eFHZ_mode_request'][1]=					"Der Modus für %Device% wurde auf manuellen Betrieb gesetzt.";
		$lang['c_LogMess_eFHZ_mode_responce'][1]=					"Der Modus für %Device% wurde auf manuellen Betrieb eingestellt.";
		$lang['c_LogMess_eFHZ_mode_request'][2]=					"Der Modus für %Device% wurde auf Party-/Urlaubsbetrieb gesetzt.";
		$lang['c_LogMess_eFHZ_mode_responce'][2]=					"Der Modus für %Device% wurde auf Party-/Urlaubsbetrieb eingestellt.";
		$lang['c_LogMess_eFHZ_windowopen'][true]=					"Der Fenstermelder von %Device% meldet: Fenster geöffnet.";
		$lang['c_LogMess_eFHZ_windowopen'][false]=				"Der Fenstermelder von %Device% meldet: Fenster geschlossen.";

		$lang['c_profile_eFHZ_drivecontrol_normal']=				"normal";
		$lang['c_profile_eFHZ_drivecontrol_valvedrive']=		"Entkalkungsfahrt";
		$lang['c_profile_eFHZ_drivecontrol_testmode']=			"Testmodus";
		$lang['c_profile_eFHZ_drivecontrol_syncing']=			"Synchronisation";

		$lang['c_LogMess_eFHZ_new_time_is_set']=					"Das Datum und die Uhrzeit von %Device% wurde geändert.";
		$lang['c_LogMess_eFHZ_which_day']=							array("Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag","Sonntag");
		$lang['c_LogMess_eFHZ_new_weekprogram_is_set']=			"Das Wochenprogramm '%Value%'' und %Device% wurde geändert.";

		return $lang;
	}
	
	/** @}*/
	
?>