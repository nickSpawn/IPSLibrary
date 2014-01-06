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
	 * @file          IPSAccessories_Language_EN.inc.php
	 * @author        Günter Strassnigg
	 * @version
	 *  Version 1.0.0, 06.01.2014<br/>
	 *
	 * Konfigurations Konstanten für IPSAccessories
	 *
	 */

	// Language Definitions:  ENGLISH Translation
	
	function IPSAccessories_GetLanguages() {

		$lang=array();		
		$lang['c_PropertyName_IPSAccessories_Dewpoint']=						"Dewpoint";
		$lang['c_PropertyName_IPSAccessories_SaturatedVaporPressure']=		"Saturated Vapor Pressure";
		$lang['c_PropertyName_IPSAccessories_VaporPressure']=					"Vapor Pressure";
		$lang['c_PropertyName_IPSAccessories_AbsoluteHumidity']=				"absolute Humidity";
		$lang['c_PropertyName_IPSAccessories_IsFog']=							"Fog";
		$lang['c_PropertyName_IPSAccessories_IsFrost']=							"Frost";
		$lang['c_PropertyName_IPSAccessories_CloudLowLimit']=					"Cloud low limit";
		$lang['c_PropertyName_IPSAccessories_IsWeekend']=						"Weekend";
		$lang['c_PropertyName_IPSAccessories_IsHoliDay']=						"Holiday";
		$lang['c_PropertyName_IPSAccessories_IsWorkingDay']=					"Working day";
		$lang['c_PropertyName_IPSAccessories_IsAdventDay']=					"Advent";

		return $lang;
	}
	
	/** @}*/
	
?>