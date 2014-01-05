<?
	/**@addtogroup ipscomponent
	 * @{
	 *
	 * @file          IPSComponentPlayer.class.php
	 * @author        Andreas Brauneis
	 *
	 */

   /**
    * @class IPSComponentPlayer
    *
    * Definiert ein IPSComponentPlayer Object, das als Wrapper f�r Abspielger�te verschiedener Hersteller 
    * verwendet werden kann.
    *
    * @author Andreas Brauneis
    * @version
    * Version 2.50.1, 31.01.2012<br/>
    */

	IPSUtils_Include ('IPSComponent.class.php', 'IPSLibrary::app::core::IPSComponent');

	abstract class IPSComponentPlayer extends IPSComponent {

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
		abstract public function HandleEvent($variable, $value, IPSModulePlayer $module);

		/**
		 * @public
		 *
		 * Abspielen der aktuellen Source 
		 */
		abstract public function Play();

		/**
		 * @public
		 *
		 * Stop 
		 */
		abstract public function Stop();

		/**
		 * @public
		 *
		 * Pause
		 */
		abstract public function Pause();

		/**
		 * @public
		 *
		 * N�chster Titel
		 */
		abstract public function Next();

		/**
		 * @public
		 *
		 * Voriger Titel 
		 */
		abstract public function Prev();

		/**
		 * @public
		 *
		 * Titel zur Playlist hinzuf�gen
		 *
		 * @param string $titel Titel der zur Playlist hinzugef�gt werden soll
		 */
		abstract public function AddPlaylist($titel);

		/**
		 * @public
		 *
		 * Playlist l�schen
		 */
		abstract public function ClearPlaylist();

		/**
		 * @public
		 *
		 * Bestimmten Titel der Playlist setzen
		 *
		 * @param integer $position Nummer des Titels der abgespielt werden soll (0-n)
		 */
		abstract public function SetPlaylistPosition($position);

		/**
		 * @public
		 *
		 * Retouniert aktuelle Position der Playlist
		 *
		 * @return integer Nummer des Titels der gerade abgespielt wird (0-n), false falls kein Titel vorhanden ist
		 */
		abstract public function GetPlaylistPosition();

		/**
		 * @public
		 *
		 * Function retouniert L�nge der Playlist
		 *
		 * @return integer L�nge der Playlist (0-n)
		 */
		abstract public function GetPlaylistLength();

		/**
		 * @public
		 *
		 * Liefert Titel des gerade abgespielten Tracks
		 *
		 * @return string Name des Titels der gerade abgespielt wird
		 */
		abstract public function GetTrackName();

		/**
		 * @public
		 *
		 * Liefert L�nge des gerade abgespielten Tracks
		 *
		 * @return string L�nge des Titels der gerade abgespielt wird
		 */
		abstract public function GetTrackLength();

		/**
		 * @public
		 *
		 * Liefert Position des gerade abgespielten Tracks
		 *
		 * @return string Position des Titels der gerade abgespielt wird
		 */
		abstract public function GetTrackPosition();

	}

	/** @}*/
?>