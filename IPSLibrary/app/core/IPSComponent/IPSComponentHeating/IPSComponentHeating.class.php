<?
	/**@addtogroup ipscomponent
	 * @{
	 *
 	 *
	 * @file          IPSComponentHeating.class.php
	 * @author        Günter Strassnigg
	 *
	 *
	 */

   /**
    * @class IPSComponentHeating
    *
    * Definiert ein IPSComponentHeating Object, das als Wrapper für Heizung Ansteuerungen verschiedener Hersteller 
    * verwendet werden kann.
    *
    * @author Günter Strassnigg
    * @version
    * Version 2.50.1, 05.01.2014<br/>
    */

	IPSUtils_Include ('IPSComponent.class.php', 'IPSLibrary::app::core::IPSComponent');

	abstract class IPSComponentHeating extends IPSComponent {

		/**
		 * @public
		 *
		 * Function um Events zu behandeln, diese Funktion wird vom IPSMessageHandler aufgerufen, um ein aufgetretenes Event 
		 * an das entsprechende Module zu leiten.
		 *
		 * @param integer $variable ID der auslösenden Variable
		 * @param string $value Wert der Variable
		 * @param IPSModuleShutter $module Module Object an das das aufgetretene Event weitergeleitet werden soll
		 */
		//abstract public function HandleEvent($variable, $value, IPSModuleHeating $module);

		/**
		 * @public
		 *
		 * Setzen der Solltemperatur (Raumthermostat)
		 */
		abstract public function SetTemperature($temperature);

		/**
		 * @public
		 *
		 * Setzen der Komforttemperatur (Raumthermostat)
		 */
		abstract public function SetComfortTemperature($temperature);

		/**
		 * @public
		 *
		 * Setzen der Absenktemperatur (Raumthermostat)
		 */
		abstract public function SetReducedTemperature($temperature);

		/**
		 * @public
		 *
		 * Setzen der Fenstertemperatur (Raumthermostat)
		 */
		abstract public function SetWindowTemperature($temperature);

		/**
		 * @public
		 *
		 * Setzen des Modus (Raumthermostat)
		 */
		abstract public function SetMode($mode);

		/**
		 * @public
		 *
		 * Setzen des Wochenprogrammes (Raumthermostat)
		 */
		abstract public function SetWeekProgramm($weekday,$Time1Begin,$Time1End,$Time2Begin,$Time2End);

	}
	/** @}*/

?>