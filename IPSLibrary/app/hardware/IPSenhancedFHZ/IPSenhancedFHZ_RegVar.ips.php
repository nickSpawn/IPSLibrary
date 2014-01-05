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
	 * @file          IPSenhancedFHZ_RegVar.ips.php
	 * @author        Günter Strassnigg
	 * @version
	 *  Version 1.00.1, 31.03.2013<br/>
	 *
	 * Verarbeitung der Protokolle im Empfangspuffer IPSenhancedFHZ
	 *
	 */
	 
	$ReceivingScriptID=IPSUtil_ObjectIDByPath('Program.IPSLibrary.app.hardware.IPSenhancedFHZ.IPSenhancedFHZ_Receive');
	if ($_IPS['SENDER'] == "RegisterVariable") {
		$data  = RegVar_GetBuffer($_IPS['INSTANCE']);
		$data .= $_IPS['VALUE'];
			$rcv = explode(chr(129), $data);
			for ($i = 0; $i < count($rcv)-1; $i++) {
				IPS_RunScriptEx($ReceivingScriptID, Array("RECEIVE" => (chr(129).$rcv[$i])));
			}
			$data = $rcv[count($rcv)-1];
		RegVar_SetBuffer($_IPS['INSTANCE'], $data);
	}

	/** @}*/
?>