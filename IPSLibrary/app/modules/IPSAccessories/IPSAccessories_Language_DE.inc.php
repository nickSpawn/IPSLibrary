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

	/**@defgroup ipsaccessories_configuration IPSAccessories Language
	 * @ingroup ipsaccessories
	 * @{
	 *
	 * @file          IPSAccessories_Language_DE.inc.php
	 * @author        Günter Strassnigg
	 * @version
	 *  Version 1.0.0, 06.01.2014<br/>
	 *
	 * Konfigurations Konstanten für IPSAccessories
	 *
	 */

	// Language Definitions:  GERMAN Translation
	
	function IPSAccessories_GetLanguages() {

		$lang=array();		
		$lang['c_PropertyName_IPSAccessories_Dewpoint']=						"Taupunkt";
		$lang['c_PropertyName_IPSAccessories_SaturatedVaporPressure']=		"Sättigungsdampfdruck";
		$lang['c_PropertyName_IPSAccessories_VaporPressure']=					"Dampfdruck";
		$lang['c_PropertyName_IPSAccessories_AbsoluteHumidity']=				"absolute Feuchte";
		$lang['c_PropertyName_IPSAccessories_IsFog']=							"Nebel";
		$lang['c_PropertyName_IPSAccessories_IsFrost']=							"Frost";
		$lang['c_PropertyName_IPSAccessories_CloudLowLimit']=					"Wolkenuntergrenze";
		$lang['c_PropertyName_IPSAccessories_IsWeekend']=						"Wochenende";
		$lang['c_PropertyName_IPSAccessories_IsHoliDay']=						"Feiertag";
		$lang['c_PropertyName_IPSAccessories_IsWorkingDay']=					"Werktag";
		$lang['c_PropertyName_IPSAccessories_IsAdventDay']=					"Advent";

		return $lang;
	}
	
	/** @}*/
	
?>