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

	/**@ingroup ipsaccessories
	 * @{
	 *
	 * @file          IPSAccessories_Constants.inc.php
	 * @author        Günter Strassnigg
	 * @version
	 *  Version 1.0.1, 04.01.2014<br/>
	 *
	 * Definition der Konstanten IPSAccessories
	 *
	 */


	// Do not change
	if (!(defined('c_IPSAccessories_language'))) {
		define ('c_IPSAccessories_language',	"DE");
	}
	IPSUtils_Include("IPSAccessories_Language_".c_IPSAccessories_language.".inc.php",
							"IPSLibrary::app::modules::IPSAccessories");

	/** @}*/
?>