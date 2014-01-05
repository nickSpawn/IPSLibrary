<?
	/**@addtogroup ipscomponent
	 * @{
	 *
	 * @file          IPSComponentPlayer_Squeezebox.class.php
	 * @author        Andreas Brauneis
	 *
	 */

	IPSUtils_Include ('IPSComponentPlayer.class.php', 'IPSLibrary::app::core::IPSComponent::IPSComponentPlayer');

	/**
    * @class IPSComponentPlayer_Squeezebox
    *
    * Definiert ein IPSComponentPlayer_Squeezebox Object, das ein IPSComponentPlayer Object mit Hilfe des Squeezebox Players implementiert
    *
    * @author Andreas Brauneis
    * @version
    * Version 2.50.1, 31.01.2012<br/>
    */

	class IPSComponentPlayer_Squeezebox extends IPSComponentPlayer{

		/**
		 * @public
		 *
		 * Function um Events zu behandeln, diese Funktion wird vom IPSMessageHandler aufgerufen, um ein aufgetretenes Event 
		 * an das entsprechende Module zu leiten.
		 *
		 * @param integer $variable ID der ausl�senden Variable
		 * @param string $value Wert der Variable
		 * @param IPSModulePlayer $module Module Object an das das aufgetretene Event weitergeleitet werden soll
		 */
		public function HandleEvent($variable, $value, IPSModulePlayer $module) {
			$name = IPS_GetName($variable);
			throw new IPSComponentException('Event Handling NOT supported for Variable '.$variable.'('.$name.')');
		}

		/**
		 * @public
		 *
		 * Abspielen der aktuellen Source 
		 */
		public function Play() {
		}

		/**
		 * @public
		 *
		 * Stop 
		 */
		public function Stop(){
		}

		/**
		 * @public
		 *
		 * Pause
		 */
		public function Pause(){
		}

		/**
		 * @public
		 *
		 * N�chster Titel
		 */
		public function Next(){
		}

		/**
		 * @public
		 *
		 * Voriger Titel 
		 */
		public function Prev(){
		}

		/**
		 * @public
		 *
		 * Titel zur Playlist hinzuf�gen
		 *
		 * @param string $titel Titel der zur Playlist hinzugef�gt werden soll
		 */
		public function AddPlaylist($titel){
		}

		/**
		 * @public
		 *
		 * Playlist l�schen
		 */
		public function ClearPlaylist(){
		}

		/**
		 * @public
		 *
		 * Bestimmten Titel der Playlist setzen
		 *
		 * @param integer $position Nummer des Titels der abgespielt werden soll (0-n)
		 */
		public function SetPlaylistPosition($position){
		}
		
		/**
		 * @public
		 *
		 * Retouniert aktuelle Position der Playlist
		 *
		 * @return integer Nummer des Titels der gerade abgespielt wird (0-n), false falls kein Titel vorhanden ist
		 */
		public function GetPlaylistPosition() {
		}
		
		/**
		 * @public
		 *
		 * Function retouniert L�nge der Playlist
		 *
		 * @return integer L�nge der Playlist (0-n)
		 */
		public function GetPlaylistLength(){
		}


	}

	/** @}*/
?>