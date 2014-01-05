<?
	/**@addtogroup ipscomponent
	 * @{
	 *
 	 *
	 * @file          IPSComponentHeating_eFHT80b.class.php
	 * @author        Günter Strassnigg
	 *
	 *
	 */

   /**
    * @class IPSComponentHeating_eFHT80b
    *
    * Definiert ein IPSComponentHeating_eFHT80b Object, das ein IPSComponentHeating Object für IPSenhancedFHZ implementiert.
    *
    * @author Günter Strassnigg
    * @version
    *   Version 2.50.1, 05.01.2014<br/>
    */

	IPSUtils_Include ('IPSComponentHeating.class.php', 'IPSLibrary::app::core::IPSComponent::IPSComponentHeating');
	IPSUtils_Include("IPSenhancedFHZ.inc.php",		"IPSLibrary::app::hardware::IPSenhancedFHZ");

	class IPSComponentHeating_eFHT80b extends IPSComponentHeating {

		private $instanceId;
 		
		/**
		 * @public
		 *
		 * Initialisierung eines IPSComponentHeating_eFHT80b Objektes
		 *
		 * @param integer $instanceId1 InstanceId des eFHT80b Devices 
		 * @param integer $instanceId2 InstanceId 2 des eFHT80b Devices (Richtungs Relais für den Fall das normale EIB Switches verwendet werden)
		 * @param boolean $reverseControl Richtungs Schalter (default=false)
		 */
		public function __construct($instanceId) {
			$this->instanceId     = IPSUtil_ObjectIDByPath($instanceId);
		}

		/**
		 * @public
		 *
		 * Function um Events zu behandeln, diese Funktion wird vom IPSMessageHandler aufgerufen, um ein aufgetretenes Event 
		 * an das entsprechende Module zu leiten.
		 *
		 * @param integer $variable ID der auslösenden Variable
		 * @param string $value Wert der Variable
		 * @param IPSModuleHeating $module Module Object an das das aufgetretene Event weitergeleitet werden soll
		 */
		//public function HandleEvent($variable, $value, IPSModuleHeating $module){
		//}

		/**
		 * @public
		 *
		 * Funktion liefert String IPSComponent Constructor String.
		 * String kann dazu benützt werden, das Object mit der IPSComponent::CreateObjectByParams
		 * wieder neu zu erzeugen.
		 *
		 * @return string Parameter String des IPSComponent Object
		 */
		public function GetComponentParams() {
			return get_class($this).','.$this->instanceId;
		}

		/**
		 * @public
		 *
		 * Setzen der Solltemperatur (Raumthermostat)
		 */
		public function SetTemperature($temperature) {
			$thermostat = new IPSenhancedFHZ($this->instanceId);
			$thermostat->bFHT_SetTemperature($temperature);
			$thermostat->bFHT_SendTo();
		}

		/**
		 * @public
		 *
		 * Setzen der Komforttemperatur (Raumthermostat)
		 */
		public function SetComfortTemperature($temperature) {
			$thermostat = new IPSenhancedFHZ($this->instanceId);
			$thermostat->bFHT_SetSunTemperature($temperature);
			$thermostat->bFHT_SendTo();
		}

		/**
		 * @public
		 *
		 * Setzen der Absenktemperatur (Raumthermostat)
		 */
		public function SetReducedTemperature($temperature) {
			$thermostat = new IPSenhancedFHZ($this->instanceId);
			$thermostat->bFHT_SetLunaTemperature($temperature);
			$thermostat->bFHT_SendTo();
		}

		/**
		 * @public
		 *
		 * Setzen der Fenstertemperatur (Raumthermostat)
		 */
		public function SetWindowTemperature($temperature) {
			$thermostat = new IPSenhancedFHZ($this->instanceId);
			$thermostat->bFHT_SetWindTemperature($temperature);
			$thermostat->bFHT_SendTo();
		}

		/**
		 * @public
		 *
		 * Setzen des Modus (Raumthermostat)
		 */
		public function SetMode($mode) {
			if (is_int($mode) || is_float($mode)) {
				$thermostat = new IPSenhancedFHZ($this->instanceId);
				$thermostat->bFHT_SetMode($mode);			
				$thermostat->bFHT_SendTo();
			}
		}

		/**
		 * @public
		 *
		 * Setzen des Wochenprogrammes (Raumthermostat)
		 */
		public function SetWeekProgramm($weekday,$Time1Begin=false,$Time1End=false,$Time2Begin=false,$Time2End=false) {
			$thermostat = new IPSenhancedFHZ($this->instanceId);
			$thermostat->sFHT_SetWeekProgram($weekday,$Time1Begin,$Time1End,$Time2Begin,$Time2End);
		}

	}

	/** @}*/
?>