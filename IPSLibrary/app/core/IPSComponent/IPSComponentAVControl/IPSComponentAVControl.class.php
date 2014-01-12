<?
	/**@addtogroup ipscomponent
	 * @{
	 *
	 * @file          IPSComponentAVControl.class.php
	 * @author        Andreas Brauneis
	 *
	 */

   /**
    * @class IPSComponentAVControl
    *
    * Definiert ein IPSComponentAVControl Object, das als Wrapper f�r Audio/Video Receiver verschiedener Hersteller 
    * verwendet werden kann.
    *
    * @author Andreas Brauneis
    * @version
    * Version 2.50.1, 31.01.2012<br/>
    */

	IPSUtils_Include ('IPSComponent.class.php', 'IPSLibrary::app::core::IPSComponent');

	abstract class IPSComponentAVControl extends IPSComponent {

		/**
		 * @public
		 *
		 * Function um Events zu behandeln, diese Funktion wird vom IPSMessageHandler aufgerufen, um ein aufgetretenes Event 
		 * an das entsprechende Module zu leiten.
		 *
		 * @param integer $variable ID der ausl�senden Variable
		 * @param string $value Wert der Variable
		 * @param IPSModuleAVControl $module Module Object an das das aufgetretene Event weitergeleitet werden soll
		 */
		abstract public function HandleEvent($variable, $value, IPSModuleAVControl $module);

		/**
		 * @public
		 *
		 * Funktion liefert String IPSComponent Constructor String.
		 * String kann dazu ben�tzt werden, das Object mit der IPSComponent::CreateObjectByParams
		 * wieder neu zu erzeugen.
		 *
		 * @return string Parameter String des IPSComponent Object
		 */
		abstract public function GetComponentParams();

		/**
		 * @public
		 *
		 * Ein/Ausschalten eines Raumes/Ausgangs
		 *
		 * @param integer $outputId Ausgang der ge�ndert werden soll (Wertebereich 0 - x)
		 * @param boolean $value Wert f�r Power (Wertebereich false=Off, true=On)
		 */
		abstract public function SetPower($outputId, $value);

		/**
		 * @public
		 *
		 * Retourniert Power Zustand eines Raumes
		 *
		 * @param integer $outputId Ausgang (Wertebereich 0 - x)
		 * @return boolean Wert der Lautst�rke (Wertebereich false=Off, true=On)
		 */
		abstract public function GetPower($outputId);


		/**
		 * @public
		 *
		 * Setzen der Lautst�rke f�r einen Ausgang
		 *
		 * @param integer $outputId Ausgang der ge�ndert werden soll (Wertebereich 0 - x)
		 * @param integer $value Wert der Lautst�rke (Wertebereich 0 - 100)
		 */
		abstract public function SetVolume($outputId, $value);

		/**
		 * @public
		 *
		 * Retourniert aktuelle Lautst�rke eines Raumes
		 *
		 * @param integer $outputId Ausgang (Wertebereich 0 - x)
		 * @return integer Wert der Lautst�rke (Wertebereich 0 - 100)
		 */
		abstract public function GetVolume($outputId);

		/**
		 * @public
		 *
		 * Setzen des Mutings f�r einen Ausgang
		 *
		 * @param integer $outputId Ausgang der ge�ndert werden soll (Wertebereich 0 - x)
		 * @param boolean $value Wert f�r Muting (Wertebereich true oder false)
		 */
		abstract public function SetMute($outputId, $value);

		/**
		 * @public
		 *
		 * Liefert Muting Status eines Ausgangs
		 *
		 * @param integer $outputId Ausgang (Wertebereich 0 - x)
		 * @return boolean Wert f�r Muting (Wertebereich true oder false)
		 */
		abstract public function GetMute($outputId);

		/**
		 * @public
		 *
		 * Setzen des Eingangs/Source f�r einen Ausgang
		 *
		 * @param integer $outputId Ausgang der ge�ndert werden soll (Wertebereich 0 - x)
		 * @param integer $value Eingang der gesetzt werden soll (Wertebereich 0 - x)
		 */
		abstract public function SetSource($outputId, $value);

		/**
		 * @public
		 *
		 * Retourniert aktuellen Eingang eines Raumes
		 *
		 * @param integer $outputId Ausgang (Wertebereich 0 - x)
		 * @return integer Eingang der gerade gew�hlt ist (Wertebereich 0 - x)
		 */
		abstract public function GetSource($outputId);

	}

	/** @}*/
?>