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

	/**@defgroup IPSSchaltuhr_configuration IPSSchaltuhr Konfiguration
	* @ingroup IPSSchaltuhr
	* @{
	*
	* @file          IPSSchaltuhr_Configuration.inc.php
	* @author        Andr� Czwalina
	* @version
	* Version 1.00.0, 28.04.2012<br/>
	*
	* Konfigurations File f�r IPSSchaltuhr
	*
	*/
	IPSUtils_Include ("IPSSchaltuhr_Constants.inc.php",      "IPSLibrary::app::modules::IPSSchaltuhr");


	/**
	* Definiert die Anzahl der Meldungen, die im Applikation Logging Window angezeigt werden.
	*/
	define ("c_LogMessage_Count",			19);


	/**
	*
	* Definition der Zeitschalten
	* Die Konfiguration erfolgt in Form eines Arrays, f�r jeden Zeitschaltuhr (ZSU) wird ein Eintrag im Array erzeugt.
	*
	* In c_Property_Name wird der Name der ZSU festgelegt.
	*
	* In dem Array c_Property(Start/Stop/Run)Sensoren werden die Sensoren eingetragen beginnend mit 1 max. 10.
	*  c_Property_Name ist der Name des Sensors
	*  c_Property_SesnorID ist die ObjectID des Varaible z.B. Temperatur sensor o. �. KEINE INSTANCE.
	*  c_Property_Condition ist die Vergleichsbedingung. M�glich ist <, >, =.
	*  c_Property_Value ist der Schwellwert
	*
	* Ist die Startzeit auf 08:00 eingestellt, wird zu dem Zeitpunkt alle eingeschalteten StartSensoren gepr�ft.
	* Sind alle Bedingungen der Startsensoren erf�llt wirrd die CallBack Funktion in IPSSchaltuhr_Custom mit Modus START aufgerufen.
	* Ist eine Bedingung nicht erf�llt, wird keine CallBack Funktion aufgerufen.
	*
	* Ist die Stopzeit auf 20:00 eingestellt, wird zu dem Zeitpunkt alle eingeschalteten StopSensoren gepr�ft.
	* Sind alle Bedingungen der Stopsensoren erf�llt, wird die CallBack Funktion in IPSSchaltuhr_Custom mit Modus STOP aufgerufen.
	* Ist eine Bedingung nicht erf�llt, wird keine CallBack Funktion aufgerufen.
	*
	* �bermittel ein RunSensor neue Werte, werden die Bedingungen gepr�ft. Ist der RunSensor aktiv und die Bedingung ist nicht erf�llt,
	* wird die CallBack Funktion in IPSSchaltuhr_Custom mit Modus STOP aufgerufen. Sobald die Bedingeungen wieder erf�llt sind,
	* wird die CallBack Funktion in IPSSchaltuhr_Custom mit Modus START aufgerufen.
	*
	* Jeder Sensor kann �ber das Webfront aktiviert/deaktiviert werden.
	* Wird kein Sensor angegeben, ist es einen normale Zeitschaltuhr.
	*
	* Erkl�rung zum Beipiel:
	* Vorrausetzung ist, das alle Sensoren eingeschaltet sind. Startzeit ist 08:00, Stopzeit ist 20:00.
	*
	* Ablauf:
	* Um 08:00 wird der Sensor 15530 ausgelesen ist der Wert > 15, ist die Bedingung erf�llt und wird START ausgef�hrt.
	* Ist der Wert kleiner als 15, passiert nichts!!!!
	*
	* Wurde eingeschaltet, wird laufend der Sensor 15530 ausgewertet. Ist diese permanent > 10 passiert nichts.
	* F�llt dieser unter 10, wird STOP ausgef�hrt.
	* Steigt dieser wieder �ber 10 wird START ausgef�hrt.
	* Wurde der Wecker um 08:00 nicht eingeschaltet, passiert nichts!!!!
	*
	* Um 20:00 wird der Sensor 15530 ausgelesen, ist der Wert < 15, wird STOP ausgef�hrt.
	* Ist der Wert gr��er als 15 passiert nichts!!
	* Die RUN Bedingungen werden weiter ausgef�hrt, also �ber 10 = START, unter 10 = STOP.
	*
	* Beispiel:
	* @code
	function get_ZSUConfiguration() {
		return array(
			c_ZSUCircle.'1'  =>	array(
				c_Property_Name           =>   'Beleuchtung Aquarium',

				c_Property_StartSensoren	=>   array(
					'1'	  	=>   array(
						c_Property_Name			=> 'Temperatur Garten',
						c_Property_SensorID	=> 15530 ,
						c_Property_Condition	=>	'>',
						c_Property_Value		=>	15,
						),
				),

				c_Property_RunSensoren		=>   array(
					'1'	  	=>   array(
						c_Property_Name			=> 'Temperatur Garten',
						c_Property_SensorID		=> 15530 ,
						c_Property_Condition		=>	'>',
						c_Property_Value			=>	10,
						),

					'2'	  	=>   array(
						c_Property_Name			=> 'Temperatur Garten',
						c_Property_SensorID		=> 15530 ,
						c_Property_Condition		=>	'<',
						c_Property_Value			=>	15,
						),
				),

				c_Property_StopSensoren	  	=>   array(
				),
			),
		);
	}
	* @endcode
	*
	* @return string Liefert Array mit Bew�sserungs Kreisen
	*/

//print_r(get_ZSUConfiguration());

	function get_ZSUConfiguration() {
		return array(
			c_ZSUCircle.'1'  =>	array(
				c_Property_Name           =>   'Beleuchtung Aquarium',

				c_Property_StartSensoren	=>   array(
//					'1'	  	=>   array(
//						c_Property_Name			=> 'Temperatur Garten',
//						c_Property_SensorID	=> 53094  /*[Wettersensor OC3\TEMPERATURE]*/ ,
//						c_Property_Condition	=>	'>',
//						c_Property_Value		=>	10,
//						),
//
//					'2'	  	=>   array(
//						c_Property_Name			=> 'Helligkeit Garten',
//						c_Property_SensorID	=> 41726  /*[Wettersensor OC3\BRIGHTNESS]*/ ,
//						c_Property_Condition	=>	'>',
//						c_Property_Value		=>	30,
//						),

				),

				c_Property_RunSensoren		=>   array(
				),

				c_Property_StopSensoren	  	=>   array(
				),
			),

			c_ZSUCircle.'2'  =>	array(
				c_Property_Name           =>   'Beleuchtung Terrarium',

				c_Property_StartSensoren	  	=>   array(
				),

				c_Property_RunSensoren	  	=>   array(
				),

				c_Property_StopSensoren	  	=>   array(
				),
			),





		);
	}


	/** @}*/
?>