<?
	/**@addtogroup ipscomponent
	 * @{
	 *
 	 *
	 * @file          IPSComponentHeating_Dummy.class.php
	 * @author        G�nter Strassnigg
	 *
	 *
	 */

   /**
    * @class IPSComponentHeating_Dummy
    *
    * Definiert ein IPSComponentHeating_Dummy Object, das ein IPSComponentHeating Object f�r IPSenhancedFHZ implementiert.
    *
    * @author G�nter Strassnigg
    * @version
    *   Version 2.50.1, 05.01.2014<br/>
    */

	IPSUtils_Include ('IPSComponentHeating.class.php', 'IPSLibrary::app::core::IPSComponent::IPSComponentHeating');

	class IPSComponentHeating_Dummy extends IPSComponentHeating {

		private $instanceId;
 		
		/**
		 * @public
		 *
		 * Initialisierung eines IPSComponentHeating_Dummy Objektes
		 *
		 * @param integer $instanceId1 InstanceId des Dummy Devices 
		 * @param integer $instanceId2 InstanceId 2 des Dummy Devices (Richtungs Relais f�r den Fall das normale EIB Switches verwendet werden)
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
		 * @param integer $variable ID der ausl�senden Variable
		 * @param string $value Wert der Variable
		 * @param IPSModuleHeating $module Module Object an das das aufgetretene Event weitergeleitet werden soll
		 */
		//public function HandleEvent($variable, $value, IPSModuleHeating $module){
		//}

		/**
		 * @public
		 *
		 * Funktion liefert String IPSComponent Constructor String.
		 * String kann dazu ben�tzt werden, das Object mit der IPSComponent::CreateObjectByParams
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
			IPSLogger_Trc(__file__, 'Activate "SetTemperature->'.$temperature.'" of "DummyHeating " "'.$this->instanceId.'"');
		}

		/**
		 * @public
		 *
		 * Setzen der Komforttemperatur (Raumthermostat)
		 */
		public function SetComfortTemperature($temperature) {
			IPSLogger_Trc(__file__, 'Activate "SetComfortTemperature->'.$temperature.'" of "DummyHeating " "'.$this->instanceId.'"');
		}

		/**
		 * @public
		 *
		 * Setzen der Absenktemperatur (Raumthermostat)
		 */
		public function SetReducedTemperature($temperature) {
			IPSLogger_Trc(__file__, 'Activate "SetReducedTemperature->'.$temperature.'" of "DummyHeating " "'.$this->instanceId.'"');
		}

		/**
		 * @public
		 *
		 * Setzen der Fenstertemperatur (Raumthermostat)
		 */
		public function SetWindowTemperature($temperature) {
			IPSLogger_Trc(__file__, 'Activate "SetWindowTemperature->'.$temperature.'" of "DummyHeating " "'.$this->instanceId.'"');
		}

		/**
		 * @public
		 *
		 * Setzen des Modus (Raumthermostat)
		 */
		public function SetMode($mode) {
			IPSLogger_Trc(__file__, 'Activate "SetMode->'.$mode.'" of "DummyHeating " "'.$this->instanceId.'"');
		}

		/**
		 * @public
		 *
		 * Setzen des Wochenprogrammes (Raumthermostat)
		 */
		public function SetWeekProgramm($weekday,$Time1Begin=false,$Time1End=false,$Time2Begin=false,$Time2End=false) {
			IPSLogger_Trc(__file__, 'Activate "SetWeekProgramm->'.$weekday.' '.$Time1Begin.'-'.$Time1End.' '.$Time2Begin.'-'.$Time2End.'" of "DummyHeating " "'.$this->instanceId.'"');
		}

	}

	/** @}*/
?>