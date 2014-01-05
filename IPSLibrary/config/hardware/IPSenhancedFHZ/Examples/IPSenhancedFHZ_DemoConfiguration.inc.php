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
	 *  Version 1.00.1, 26.03.2013<br/>
	 *
	 * Definition der Konstanten IPSenhancedFHZ
	 *
	 *

	 *
	 * Beispiel:
	 * @code
			function IPSenhancedFHZ_GetFHZConfiguration() {
				return array(
      			7336 =>	array(
      				c_Property_eFHZ_Type		    		=> c_Type_eFHZ_FHT80b,
      				c_Property_eFHZ_Name		    		=> 'eFHT80b_Buero',
      				c_Property_eFHZ_Beschreibung		=> 'Büro',
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
				c_Property_eFHZ_Beschreibung		=> 'Büro',
				),
			7366 =>	array(
				c_Property_eFHZ_Type		    		=> c_Type_eFHZ_FHT80b,
				c_Property_eFHZ_Name		    		=> 'eFHT80b_Badezimmer',
				c_Property_eFHZ_Beschreibung		=> 'Badezimmer',
				),
	   );
	}

	/** @}*/

?>