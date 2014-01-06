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

	/**@defgroup ipsaccessories_configuration IPSAccessories Konfiguration
	 * @ingroup ipsaccessories
	 * @{
	 *
	 * @file          IPSAccessories_Configuration.inc.php
	 * @author        Günter Strassnigg
	 * @version
	 *  Version 1.0.0, 06.01.2014<br/>
	 *
	 * Konfigurations Konstanten für IPSAccessories
	 *
	 */

	/** Eingestellte Sprache
	 *
	 * Betrifft:  Namen der Statusvariablen -> Definierung vor Installation des Modules
	 *            Ausgabe der Meldungen
	 *
	 * DE =>		deutsch (=Voreinstellung)
	 * EN =>		englisch
	 *
	 * Dieser Parameter kann jederzeit geändert werden, keine Installation erforderlich.
	 */
	define ('c_IPSAccessories_language',						"DE");

	function IPSAccessories_GetConfiguration() {
		return array(
		);
	}



	/** @}*/
?>