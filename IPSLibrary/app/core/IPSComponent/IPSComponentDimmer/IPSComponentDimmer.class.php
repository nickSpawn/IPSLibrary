<?
	/**@addtogroup ipscomponent
	 * @{
	 *
	 * @file          IPSComponentDimmer.class.php
	 * @author        Andreas Brauneis
	 *
	 */

   /**
    * @class IPSComponentDimmer
    *
    * Definiert ein IPSComponentDimmer Object, das als Wrapper f�r Dimmer Ger�te verschiedener Hersteller 
    * verwendet werden kann.
    *
    * @author Andreas Brauneis
    * @version
    * Version 2.50.1, 31.01.2012<br/>
    */

	IPSUtils_Include ('IPSComponent.class.php', 'IPSLibrary::app::core::IPSComponent');

	abstract class IPSComponentDimmer extends IPSComponent {

		/**
		 * @public
		 *
		 * Function um Events zu behandeln, diese Funktion wird vom IPSMessageHandler aufgerufen, um ein aufgetretenes Event 
		 * an das entsprechende Module zu leiten.
		 *
		 * @param integer $variable ID der ausl�senden Variable
		 * @param string $value Wert der Variable
		 * @param IPSModuleDimmer $module Module Object an das das aufgetretene Event weitergeleitet werden soll
		 */
		abstract public function HandleEvent($variable, $value, IPSModuleDimmer $module);

		/**
		 * @public
		 *
		 * Zustand Setzen 
		 *
		 * @param boolean $power Ger�te Power
		 * @param integer $level Wert f�r Dimmer Einstellung
		 */
		abstract public function SetState($power, $level);

		/**
		 * @public
		 *
		 * Liefert aktuellen Zustand des Dimmers
		 *
		 * @return integer aktueller Dimmer Zustand  
		 */
		abstract public function GetLevel();

		/**
		 * @public
		 *
		 * Liefert aktuellen Power Zustand des Dimmers
		 *
		 * @return boolean Ger�tezustand On/Off des Dimmers
		 */
		abstract public function GetPower();
	}

	/** @}*/
?>