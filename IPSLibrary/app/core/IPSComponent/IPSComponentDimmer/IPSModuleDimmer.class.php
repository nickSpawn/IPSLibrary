<?
	/**@addtogroup ipscomponent
	 * @{
	 *
 	 *
	 * @file          IPSModuleDimmer.class.php
	 * @author        Andreas Brauneis
	 *
	 *
	 */

	/**
	 * @class IPSModuleDimmer
	 *
	 * Definiert ein IPSModuleDimmer Object, das als Wrapper f�r Dimmer in der IPSLibrary
	 * verwendet werden kann.
	 *
	 * @author Andreas Brauneis
	 * @version
	 * Version 2.50.1, 31.01.2012<br/>
	 */

	abstract class IPSModuleDimmer extends IPSModule {

		/**
		 * @public
		 *
		 * Erm�glicht die Synchronisation des aktuellen Dimmer Levels
		 *
		 * @param integer $level aktueller Status des Ger�tes (Wertebereich 0-100)
		 */
		abstract public function SyncDimLevel($level);

	}

	/** @}*/
?>