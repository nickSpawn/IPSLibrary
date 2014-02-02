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
	 * @author        Günter Strassnigg
	 * @version
	 *  Version 0.1.3, 19.01.2014<br/>
	 *
	 * Definition der Konstanten IPSenhancedFHZ
	 *
	 *
	 */                 

   
	/** Loggen der Anfordungen(Statusänderungen) über IPSenhancedFHZ
	 *
	 * (mitloggen über IPSLogger - IPSLogger muss installiert worden sein.)
	 * 
	 * true:		wird verarbeitet.
	 * false:	wird nicht verarbeitet.	 
	 *
	 * Dieser Parameter kann jederzeit geändert werden, keine Installation erforderlich.
	 */
	define ('c_eFHZ_debug_logging',									false);

	/** Loggen der Empfangsmeldungen(Statusänderungen) über IPSenhancedFHZ
	 *
	 * (mitloggen über IPSLogger - IPSLogger muss installiert worden sein.)
	 * 
	 * true:		wird verarbeitet.
	 * false:	wird nicht verarbeitet.	 
	 *
	 * Dieser Parameter kann jederzeit geändert werden, keine Installation erforderlich.
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
	 * Nach Änderung dieses Parameters muss eine erneute Installation über den ModuleManagers durchgeführt werden.
	 */
	define ('c_eFHZ_language',											"DE");

	/** Objekt ID des FTDI Adapters 
	 *
	 * Betrifft:  Objekt ID des FTDI Adapters über den empfangen oder gesendet wird 
	 * 				Das FTDI Gerät enthält den ELV FHZ Schnittstellencontroller	 
	 *
	 * Nach Änderung dieses Parameters muss eine erneute Installation über den ModuleManagers durchgeführt werden.
	 */
	define ('c_eFHZ_FTDIfhzID',										52744);

	/** Start der Autoinitialisierung der FHT's
	 *
	 * Betrifft:  Falls der Handshake zwischen FHZ und FHT gestört ist:
	 * 				eine automatische Initialisierung des betreffenden FHT's durchführen	  
	 *
	 * true:		wird verarbeitet.
	 * false:	wird nicht verarbeitet.	 
	 *
	 * Dieser Parameter kann jederzeit geändert werden, keine Installation erforderlich.
	 */
	define ('c_eFHZ_autoinit',											true);

	/**
	 *
	 * Beispiel:
	 * @code
		function IPSenhancedFHZ_GetFHZConfiguration() {
			return array(
					7336 =>	array(
						c_Property_eFHZ_Type		    		=> c_Type_eFHZ_FHT80b,
						c_Property_eFHZ_Name		    		=> 'eFHT80b_Buero',
						c_Property_eFHZ_Description		=> 'Büro',
						c_Property_eFHZ_Leap					=> false,
						c_Property_eFHZ_windowemulate		=> true,
						c_Property_eFHZ_windowsensors    => array (41110=>false),
						),
		   );
		}
	 * @endcocde
	 *
	 * @return  Liefert Array mit FHT und FS20 Elementen
	 */

	function IPSenhancedFHZ_GetFHZConfiguration() {
		return array(
			7336 =>	array(
				c_Property_eFHZ_Type		    		=> c_Type_eFHZ_FHT80b,
				c_Property_eFHZ_Name		    		=> 'eFHT80b_Buero',
				c_Property_eFHZ_Description		=> 'Büro',
				c_Property_eFHZ_Leap					=> false,
				c_Property_eFHZ_windowemulate		=> false,
				c_Property_eFHZ_windowsensors    => array (),
				),
			7346 =>	array(
				c_Property_eFHZ_Type		    		=> c_Type_eFHZ_FHT80b,
				c_Property_eFHZ_Name		    		=> 'eFHT80b_Kueche',
				c_Property_eFHZ_Description		=> 'Küche',
				c_Property_eFHZ_Leap					=> true,
				c_Property_eFHZ_windowemulate		=> true,       
				c_Property_eFHZ_windowsensors    => array (41110=>false),
				),
			7356 =>	array(
				c_Property_eFHZ_Type		    		=> c_Type_eFHZ_FHT80b,
				c_Property_eFHZ_Name		    		=> 'eFHT80b_Schrankraum',
				c_Property_eFHZ_Description		=> 'Schrankraum',
				c_Property_eFHZ_Leap					=> false,
				c_Property_eFHZ_windowemulate		=> false,
				c_Property_eFHZ_windowsensors    => array (),
				),
			7366 =>	array(
				c_Property_eFHZ_Type		    		=> c_Type_eFHZ_FHT80b,
				c_Property_eFHZ_Name		    		=> 'eFHT80b_Badezimmer',
				c_Property_eFHZ_Description		=> 'Badezimmer',
				c_Property_eFHZ_Leap					=> false,
				c_Property_eFHZ_windowemulate		=> false,
				c_Property_eFHZ_windowsensors    => array (),
				),
	   );
	}

	/** @}*/

?>