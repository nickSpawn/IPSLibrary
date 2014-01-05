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
	 * @file          IPSenhancedFHZ_Configuration.inc.php
	 * @author        G�nter Strassnigg
	 * @version
	 *  Version 1.0.1, 04.01.2014<br/>
	 *
	 * Definition der Konstanten IPSenhancedFHZ
	 *
	 *
	 */

	/** Debugging des Empfangprotokolles
	 *
	 * Speichern des Empfangstrings in der Debug Variable
	 * 
	 * true:		Die Debugvariable wird �berschrieben.
	 * false:	Die Debugvariable wird nicht beschrieben.
	 *          Hat jedoch keinen Einflu� auf die LogMeldungen im IPS Melungsfenster	 
	 *
	 * Dieser Parameter kann jederzeit ge�ndert werden, keine Installation erforderlich.
	 */
   define ('c_eFHZ_debug',												false);

   
	/** Loggen der Anfordungen(Status�nderungen) �ber IPSenhancedFHZ
	 *
	 * (mitloggen �ber IPSLogger - IPSLogger muss installiert worden sein.)
	 * 
	 * true:		wird verarbeitet.
	 * false:	wird nicht verarbeitet.	 
	 *
	 * Dieser Parameter kann jederzeit ge�ndert werden, keine Installation erforderlich.
	 */
	define ('c_eFHZ_debug_logging',									false);

	/** Loggen der Empfangsmeldungen(Status�nderungen) �ber IPSenhancedFHZ
	 *
	 * (mitloggen �ber IPSLogger - IPSLogger muss installiert worden sein.)
	 * 
	 * true:		wird verarbeitet.
	 * false:	wird nicht verarbeitet.	 
	 *
	 * Dieser Parameter kann jederzeit ge�ndert werden, keine Installation erforderlich.
	 */
	define ('c_eFHZ_trace_logging',									false);

	/** Eingestellte Sprache
	 *
	 * Betrifft:  Namen der Statusvariablen -> Definierung vor Installation des Modules
	 *            Ausgabe der Meldungen
	 *
	 * DE =>		deutsch (=Voreinstellung)
	 * EN =>		englisch
	 *
	 * Dieser Parameter kann jederzeit ge�ndert werden, keine Installation erforderlich.
	 */
	define ('c_eFHZ_language',											"DE");

	/**
	 *
	 * Beispiel:
	 * @code
			function IPSenhancedFHZ_GetFHZConfiguration() {
				return array(
      			7336 =>	array(
      				c_Property_eFHZ_Type		    		=> c_Type_eFHZ_FHT80b,
      				c_Property_eFHZ_Name		    		=> 'eFHT80b_Buero',
      				c_Property_eFHZ_Description		=> 'B�ro',
      				),
			   );
			}
	 * @endcocde
	 *
	 * @return  Liefert Array mit FHT und FS20 Elementen
	 */

	function IPSenhancedFHZ_GetFHZConfiguration() {
		return array(
	   );
	}

	/** @}*/

?>