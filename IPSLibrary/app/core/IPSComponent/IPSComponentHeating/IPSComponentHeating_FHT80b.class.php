<?
	/**@addtogroup ipscomponent
	 * @{
	 *
 	 *
	 * @file          IPSComponentHeating_FHT80b.class.php
	 * @author        Günter Strassnigg
	 *
	 *
	 */

   /**
    * @class IPSComponentHeating_FHT80b
    *
    * Definiert ein IPSComponentHeating_FHT80b Object, das ein IPSComponentHeating Object für IPSenhancedFHZ implementiert.
    *
    * @author Günter Strassnigg
    * @version
    *   Version 2.50.1, 05.01.2014<br/>
    */

	IPSUtils_Include ('IPSComponentHeating.class.php', 'IPSLibrary::app::core::IPSComponent::IPSComponentHeating');

	class IPSComponentHeating_FHT80b extends IPSComponentHeating {

		private $instanceId;
 		
		/**
		 * @public
		 *
		 * Initialisierung eines IPSComponentHeating_FHT80b Objektes
		 *
		 * @param integer $instanceId1 InstanceId des FHT80b Devices 
		 * @param integer $instanceId2 InstanceId 2 des FHT80b Devices (Richtungs Relais für den Fall das normale EIB Switches verwendet werden)
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
			if ($temperature>=5.5&&$temperature<=30.5)
			FHT_SetTemperature($this->instanceId, $temperature);
		}

		/**
		 * @public
		 *
		 * Setzen der Komforttemperatur (Raumthermostat)
		 */
		public function SetComfortTemperature($temperature) {
			IPSLogger_Not(__file__, 'Function "SetComfortTemperature" not implemented for Device "'.$this->instanceId.'"');
		}

		/**
		 * @public
		 *
		 * Setzen der Absenktemperatur (Raumthermostat)
		 */
		public function SetReducedTemperature($temperature) {
			IPSLogger_Not(__file__, 'Function "SetReducedTemperature" not implemented for Device "'.$this->instanceId.'"');
		}

		/**
		 * @public
		 *
		 * Setzen der Fenstertemperatur (Raumthermostat)
		 */
		public function SetWindowTemperature($temperature) {
			IPSLogger_Not(__file__, 'Function "SetWindowTemperature" not implemented for Device "'.$this->instanceId.'"');
		}

		/**
		 * @public
		 *
		 * Setzen des Modus (Raumthermostat)
		 */
		public function SetMode($mode) {
			if ($mode==0||$mode==1) {
				FHT_SetMode($this->instanceId, $mode);
			}
		}

		/**
		 * @public
		 *
		 * Setzen des Wochenprogrammes (Raumthermostat)
		 */
		public function SetWeekProgramm($weekday,$Time1Begin=false,$Time1End=false,$Time2Begin=false,$Time2End=false) {
			IPSLogger_Not(__file__, 'Function "SetWeekProgramm" not implemented for Device "'.$this->instanceId.'"');
		}

	}

	/** @}*/
?>