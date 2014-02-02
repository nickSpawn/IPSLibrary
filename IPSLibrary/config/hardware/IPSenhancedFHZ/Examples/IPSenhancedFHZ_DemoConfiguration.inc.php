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
	 *  Version 0.1.3, 19.01.2014<br/>
	 *
	 * Definition der Konstanten IPSenhancedFHZ
	 *
	 *
	 */                 

   
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
	 * Nach �nderung dieses Parameters muss eine erneute Installation �ber den ModuleManagers durchgef�hrt werden.
	 */
	define ('c_eFHZ_language',											"DE");

	/** Objekt ID des FTDI Adapters 
	 *
	 * Betrifft:  Objekt ID des FTDI Adapters �ber den empfangen oder gesendet wird 
	 * 				Das FTDI Ger�t enth�lt den ELV FHZ Schnittstellencontroller	 
	 *
	 * Nach �nderung dieses Parameters muss eine erneute Installation �ber den ModuleManagers durchgef�hrt werden.
	 */
	define ('c_eFHZ_FTDIfhzID',										52744);

	/** Start der Autoinitialisierung der FHT's
	 *
	 * Betrifft:  Falls der Handshake zwischen FHZ und FHT gest�rt ist:
	 * 				eine automatische Initialisierung des betreffenden FHT's durchf�hren	  
	 *
	 * true:		wird verarbeitet.
	 * false:	wird nicht verarbeitet.	 
	 *
	 * Dieser Parameter kann jederzeit ge�ndert werden, keine Installation erforderlich.
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
						c_Property_eFHZ_Description		=> 'B�ro',
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
				c_Property_eFHZ_Description		=> 'B�ro',
				c_Property_eFHZ_Leap					=> false,
				c_Property_eFHZ_windowemulate		=> false,
				c_Property_eFHZ_windowsensors    => array (),
				),
			7346 =>	array(
				c_Property_eFHZ_Type		    		=> c_Type_eFHZ_FHT80b,
				c_Property_eFHZ_Name		    		=> 'eFHT80b_Kueche',
				c_Property_eFHZ_Description		=> 'K�che',
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