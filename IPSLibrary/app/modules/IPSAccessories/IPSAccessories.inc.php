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

	/**@addtogroup ipsaccessories
	 * @{
	 *
	 * @file          IPSAccessories.inc.php
	 * @author        Günter Strassnigg
	 * @version
	 *   Version 1.0.0, 05.01.2014<br/>
	 *
	 * IPSAccessories - Kleine Zubehörscripts "Kleines Allerlei"
	 */


	/**
	 *
	 * Berechnung: Taupunkttemperatur
	 * alle Formeln laut http://www.wettermail.de/wetter/feuchte.html
	 *
	 * @author        Günter Strassnigg
	 *
	 * @param variant $temperature			Temperatur (°C)
	 * @param variant $relativehumidity		Relative Feuchtigkeit 
	 * @return variant $value					Taupunkttemperatur (°C)
	 */
	function IPSAccessories_Dewpoint($temperature,$relativehumidity) {
	    $value = (234.67*0.434292289*log(6.1*exp((7.45*$temperature)
	            /(234.67+$temperature)*2.3025851)*$relativehumidity/100/6.1))
	            /(7.45-0.434292289*log(6.1*exp((7.45*$temperature)
	            /(234.67+$temperature)*2.3025851)*$relativehumidity/100/6.1) );
	    return $value;
	}

	/**
	 *
	 * Berechnung: Sättigungsdampfdruck
	 * alle Formeln laut http://www.wettermail.de/wetter/feuchte.html
	 *
	 * @author        Günter Strassnigg
	 *
	 * @param variant $temperature			Temperatur (°C)
	 * @return variant $value					Sättigungsdampfdruck (hPa)
	 */
	function IPSAccessories_SaturatedVaporPressure($temperature) {
	    if ($temperature >= 0) {
	        $a = 7.5;
	        $b = 237.3;
	    }
	    elseif ($temperature < 0) {
	        $a = 7.6;
	        $b = 240.7;
	    }
	    $value = (6.1078 * exp(log(10) * (($a * $temperature) / ($b + $temperature))));
	    return $value;
	}

	/**
	 *
	 * Berechnung: Dampfdruck
	 * alle Formeln laut http://www.wettermail.de/wetter/feuchte.html
	 *
	 * @author        Günter Strassnigg
	 *
	 * @param variant $temperature			Temperatur (°C)
	 * @param variant $relativehumidity		Relative Feuchtigkeit 
	 * @return variant $value					Dampfdruck (hPa)
	 */
	function IPSAccessories_VaporPressure($temperature,$relativehumidity) {
	    $value = $relativehumidity/100 * SaturatedVaporPressure($temperature);
	    return $value;
	}

	/**
	 *
	 * Berechnung: absolute Feuchte
	 * alle Formeln laut http://www.wettermail.de/wetter/feuchte.html
	 *
	 * @author        Günter Strassnigg
	 *
	 * @param variant $temperature			Temperatur (°C)
	 * @param variant $relativehumidity		Relative Feuchtigkeit 
	 * @return variant $value					absolute Feuchte (g/m³)
	 */
	function IPSAccessories_AbsoluteHumidity($temperature,$relativehumidity) {
	    $tk = ($temperature + 273.15);
	    $value  = (exp(log(10) * 5) * 18.016/8314.3 * IPSAccessories_VaporPressure($temperature,$relativehumidity)/$tk);
	    return $value;
	}

	/**
	 *
	 * Berechnung: Nebel
	 *
	 * @author        Günter Strassnigg
	 *
	 * @param variant $temperature			Temperatur (°C)
	 * @param variant $relativehumidity		Relative Feuchtigkeit 
	 * @return boolean $value					TRUE oder FALSE
	 */
	function IPSAccessories_IsFog($temperature,$relativehumidity,$offset=0) {
		$dewpoint= IPSAccessories_Dewpoint($temperature,$relativehumidity);
		if (($temperature<=$dewpoint) && ($relativehumidity>=100 - $offset)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 *
	 * Berechnung: Frost
	 *
	 * @author        Günter Strassnigg
	 *
	 * @param variant $temperature			Temperatur (°C)
	 * @param variant $relativehumidity		Relative Feuchtigkeit 
	 * @return boolean $value					TRUE oder FALSE
	 */
	function IPSAccessories_IsFrost($temperature,$relativehumidity) {
		$dewpoint= IPSAccessories_Dewpoint($temperature,$relativehumidity);
		if (($temperature<$dewpoint) && ($temperature<0)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 *
	 * Berechnung: Wolkenuntergrenze
	 *
	 * @author        Günter Strassnigg
	 *
	 * @param variant $temperature			Temperatur (°C)
	 * @param variant $relativehumidity		Relative Feuchtigkeit 
	 * @return variant $value					absolute Feuchte (g/m³)
	 */
	function IPSAccessories_CloudLowLimit($temperature,$relativehumidity) {
		$spread=122;
		$dewpoint= IPSAccessories_Dewpoint($temperature,$relativehumidity);
		return (round(($temperature-$dewpoint)*$spread,2));    
	}

	/**
	 *
	 * Berechnung: Prüfung ob Datum im Wochenende ist
	 *
	 * @author        Günter Strassnigg
	 *
	 * @param int,float $date Das zu prüfende Datum oder FALSE für aktuelles Datum
	 * @return boolean TRUE wenn Wochenende
	 *  					 FALSE wenn kein Wochenende 
	 *  					 NULL wenn $region oder $date ungültig 
	 */
	function IPSAccessories_IsWeekend($date=false)	{
		if ($date===false) {$date=time();}
		if (!(is_int($date)||is_float($date))) {return null;}
		if (date('w',$date)==0 || date('w',$date)==6) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 *
	 * Berechnung: Ostersonntag
	 * Code entnommen (und geändert) von IPSWecker.inc.php
	 *
	 * @author        Günter Strassnigg, André Czwalina
	 *
	 * @param variant $year Jahreszahl oder FALSE für aktuelles Jahr
	 * @return int $year Jahr von Ostersonntag (Referenz)
	 * @return int Datum von Ostersonntag oder NULL falls $year kein gültiger TIMESTAMP ist
	 */
	function IPSAccessories_EasterSundayDate(&$year=false)	{
		if ($year===false) {$year=(int)date("Y");}
		if (is_int($year)) {
			$p = floor($year/100);
			$r = floor($year/400);
			$o = floor(($p*8+13)/25)-2;
			$w = (19*($year%19)+(13+$p-$r-$o)%30)%30;
			$e = ($w==29?28:$w);
			if ($w==28&&($year%19)>10) $e=27;
			$day = (2*($year%4)+4*($year%7)+6*$e+(4+$p-$r)%7)%7+22+$e;
			$month = ($day>31?4:3);
			if ($day>31) $day-=31;
			return mktime(0, 0, 0, $month, $day, $year);
		} else return null;
	}

	/**
	 *
	 * Berechnung: Liste der Feiertage
	 * Code entnommen (und geändert) von IPSWecker.inc.php
	 *
	 * @author        Günter Strassnigg, André Czwalina
	 *
	 * @param string $region Staat oder Bundesland für den die Feiertagsliste berechnet wird
	 *  	AT = Österreich
	 *  	BW = Baden-Württemberg
	 *  	BY = Bayern
	 *  	BE = Berlin
	 *  	BB = Brandenburg
	 *  	HB = Bremen
	 *  	HH = Hamburg
	 *  	HE = Hessen
	 *  	MV = Mecklenburg-Vorpommern
	 *  	NI = Niedersachsen
	 *  	NW = Nordrhein-Westfalen
	 *  	RP = Rheinland-Pfalz
	 *  	SL = Saarland
	 *  	SN = Sachsen
	 *  	ST = Sachen-Anhalt
	 *  	SH = Schleswig-Holstein
	 *  	TH = Thüringen
	 * @param variant $year Jahreszahl oder FALSE für aktuelles Jahr
	 * @return array Liste der Feiertage (nach Timestamp sortiert) oder 
	 * 		  NULL falls $year kein gültiger TIMESTAMP ist
	 */
	function IPSAccessories_Holidays($region,$year=false) {
		if (!is_string($region)) {return null;}
		$time = IPSAccessories_EasterSundayDate($year);
		if ($time!==null) {
 			// Fester Feiertag in AT, BW, BY, BE, BB, HB, HH, HE, MV, NI, NW, RP, SL, SN, ST, SH, TH
			// (einzeln genannt falls andere Länder noch hinzu kommen sollten)
			$regions=array('AT', 'BW', 'BY', 'BE', 'BB', 'HB', 'HH', 'HE', 'MV', 'NI', 'NW', 'RP', 'SL', 'SN', 'ST', 'SH', 'TH');
			if (in_array($region,$regions)) {
				$days["Neujahr"] 							= mktime(0, 0, 0, 1, 1, $year);
				$days["Ostersonntag"] 					= $time;
				$days["Ostermontag"] 					= $time+(86400);
				$days["Christi Himmelfahrt"] 			= $time+(86400*39);
				$days["Pfingstsonntag"] 				= $time+(86400*49);
				$days["Pfingstmontag"] 					= $time+(86400*50);
			}			
 			// Fester Feiertag in BW, BY, BE, BB, HB, HH, HE, MV, NI, NW, RP, SL, SN, ST, SH, TH
			// ==> alle außer Österreich (einzeln genannt falls andere Länder noch hinzu kommen sollten)
			$regions=array('BW', 'BY', 'BE', 'BB', 'HB', 'HH', 'HE', 'MV', 'NI', 'NW', 'RP', 'SL', 'SN', 'ST', 'SH', 'TH');
			if (in_array($region,$regions)) {
				$days["Karfreitag"] 						= $time-(86400*2);
				$days["Tag der Arbeit"]        		= mktime(0, 0, 0, 5, 1, $year);
				$days["Tag der deutschen Einheit"] 	= mktime(0, 0, 0, 10, 3, $year);
				$days["Buß- und Bettag"] 				= mktime(0, 0, 0, 11, 26 + (7 - date('w', mktime(0, 0, 0, 11, 26, $year)))-11, $year);
				$days["1. Weihnachtsfeiertag"] 		= mktime(0, 0, 0, 12, 25, $year);
				$days["2. Weihnachtsfeiertag"] 		= mktime(0, 0, 0, 12, 26, $year);
			}

			// Fester Feiertag in AT
			if (($region == "AT")) {
				$days["Staatsfeiertag"]        		= mktime(0, 0, 0, 5, 1, $year);
				$days["Nationalfeiertag"]        	= mktime(0, 0, 0, 10, 26, $year);
		  		$days["Maria Empfängnis"] 				= mktime(0, 0, 0, 12, 8, $year);
		  		$days["Christtag"] 						= mktime(0, 0, 0, 12, 25, $year); 
		  		$days["Stefanitag"] 						= mktime(0, 0, 0, 12, 26, $year); 
			}

			// Fester Feiertag in AT, BW, BY, ST
			$regions=array('AT', 'BW', 'BY', 'ST');
			if (in_array($region,$regions)) {
		  		$days["Heilige 3 Könige"] 				= mktime(0, 0, 0, 1, 6, $year);
			}
			
			// Fester Feiertag in BB, MV, SA, ST, TH
			$regions=array('BB', 'MV', 'SA', 'ST', 'TH');
			if (in_array($region,$regions)) {
		  		$days["Reformationstag"] 			   = mktime(0, 0, 0, 10, 31, $year);
			}
			
			// Fester Feiertag in AT, BW, BY, NW, RP, SL
			$regions=array('AT', 'BW', 'BY', 'NW', 'RP', 'SL');
			if (in_array($region,$regions)) {
		  		$days["Allerheiligen"] 					= mktime(0, 0, 0, 11, 1, $year);
			}
			
			// Fester Feiertag in AT, BY (nicht überall), SL
			$regions=array('AT', 'BY', 'SL');
			if (in_array($region,$regions)) {
		  		$days["Maria Himmelfahrt"] 			= mktime(0, 0, 0, 8, 15, $year); 
			}
			
			// Bewegliche Feiertage AT, BW, BY, HE, NW, RP, SL, (SA, TH nicht überall)
			$regions=array('AT', 'BW', 'BY', 'HE', 'NW', 'RP', 'SL', 'SA', 'TH');
			if (in_array($region,$regions)) {
		    	$days["Fronleichnam"] 					= $time+(86400*60); 
			}
			asort($days);	
			return $days;
		} else return null;
	}

	/**
	 *
	 * Berechnung: Prüfung ob Datum ein Feiertag ist
	 * Code entnommen (und geändert) von IPSWecker.inc.php
	 *
	 * @author        Günter Strassnigg
	 *
	 * @param string $region Staat oder Bundesland für den die Feiertagsliste berechnet wird
	 *  	AT = Österreich
	 *  	BW = Baden-Württemberg
	 *  	BY = Bayern
	 *  	BE = Berlin
	 *  	BB = Brandenburg
	 *  	HB = Bremen
	 *  	HH = Hamburg
	 *  	HE = Hessen
	 *  	MV = Mecklenburg-Vorpommern
	 *  	NI = Niedersachsen
	 *  	NW = Nordrhein-Westfalen
	 *  	RP = Rheinland-Pfalz
	 *  	SL = Saarland
	 *  	SN = Sachsen
	 *  	ST = Sachen-Anhalt
	 *  	SH = Schleswig-Holstein
	 *  	TH = Thüringen
	 * @param int,float $date Das zu prüfende Datum oder FALSE für aktuelles Datum
	 * @return boolean TRUE wenn Feiertag
	 *  					 FALSE wenn kein Feiertag 
	 *  					 NULL wenn $region oder $date ungültig 
	 */
  	function IPSAccessories_IsHoliDay($region,$date=false) {
		if (!is_string($region)) {return null;}
		if ($date===false) {$date=time();}
		if (!(is_int($date)||is_float($date))) {return null;}
		$day=date("d",$date); $month=date("m",$date); $year=date("Y",$date);
		$date=mktime(0,0,0,$month,$day,$year);
		$holidays=IPSAccessories_Holidays($region,(int)$year);
		if (in_array($date,$holidays)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 *
	 * Berechnung: Prüfung ob Datum ein Werktag ist
	 *
	 * @author        Günter Strassnigg
	 *
	 * @param string $region Staat oder Bundesland für den die Feiertagsliste berechnet wird
	 *  	AT = Österreich
	 *  	BW = Baden-Württemberg
	 *  	BY = Bayern
	 *  	BE = Berlin
	 *  	BB = Brandenburg
	 *  	HB = Bremen
	 *  	HH = Hamburg
	 *  	HE = Hessen
	 *  	MV = Mecklenburg-Vorpommern
	 *  	NI = Niedersachsen
	 *  	NW = Nordrhein-Westfalen
	 *  	RP = Rheinland-Pfalz
	 *  	SL = Saarland
	 *  	SN = Sachsen
	 *  	ST = Sachen-Anhalt
	 *  	SH = Schleswig-Holstein
	 *  	TH = Thüringen
	 * @param int,float $date Das zu prüfende Datum oder FALSE für aktuelles Datum
	 * @return boolean TRUE wenn Werktag
	 *  					 FALSE wenn kein Werktag 
	 *  					 NULL wenn $region oder $date ungültig 
	 */
	function IPSAccessories_IsWorkingDay($region,$date=false) {
		if (!is_string($region)) {return null;}
		if ($date===false) {$date=time();}
		if (!(is_int($date)||is_float($date))) {return null;}
		$day=date("d",$date); $month=date("m",$date); $year=date("Y",$date);
		$date=mktime(0,0,0,$month,$day,$year);
		if (IPSAccessories_IsWeekend($date)||IPSAccessories_IsHoliDay($date)) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 *
	 * Berechnung: Prüfung ob Datum innerhalb der Adventzeit ist
	 * 				Definition von Avent:  1. Adventsonntag bis Hl. 3 Könige (06.01.XXXX)	 
	 *
	 * @author        Günter Strassnigg
	 *
	 * @param int,float $date Das zu prüfende Datum oder FALSE für aktuelles Datum
	 * @param int		  $offset_begin Anzahl der Tage VOR Adventbeginn
	 * @param int		  $offset_end   Anzahl der Tage NACH Adventende
	 * @return boolean TRUE wenn Adventtag
	 *  					 FALSE wenn kein Adventtag 
	 *  					 NULL wenn $date ungültig 
	 */
	function IPSAccessories_IsAdventDay($date=false,$offset_begin=0,$offset_end=0) {
		if ($date===false) {$date=time();}
		if (!(is_int($date)||is_float($date))) {return null;}
	   
		$advday = date('w', gmmktime(0, 0, 0, 11, 26, date("Y",$date)-1));
		$AdvStart1 = gmmktime(0, 0, 0, 11, 26, date("Y",$date)-1) + (($advday == 0 ? 0 : 7 - $advday) * 86400)-$offset_begin*86400;
		$AdvStart2 = gmmktime(0, 0, 0, 11, 26, date("Y",$date)) + (($advday == 0 ? 0 : 7 - $advday) * 86400)-$offset_begin*86400;		

		if ($date<$AdvStart2) {
		   $AdvStart=$AdvStart1;
			$AdvStop   = mktime(23,59,59,1,6,date("Y",$date))+$offset_end*86400;
		} else {
		   $AdvStart=$AdvStart2;
			$AdvStop   = mktime(23,59,59,1,6,date("Y",$date)+1)+$offset_end*86400;
		}
	
		if (($date >= $AdvStart) && ($date < $AdvStop)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 *
	 * Berechnung: Prüfung ob Datum ein Urlaubstag ist
	 *             NOT IMPLEMENTED	 
	 *
	 * @author        Günter Strassnigg
	 *
	 * @param int,float $date Das zu prüfende Datum oder FALSE für aktuelles Datum
	 * @return boolean TRUE wenn Urlaubstag
	 *  					 FALSE wenn kein Urlaubstag 
	 *  					 NULL wenn $date ungültig 
	 */
	function IPSAccessories_IsVacationDay($date=false) {
/*		if (!is_string($region)) {return null;}
		if ($date===false) {$date=time();}
		if (!(is_int($date)||is_float($date))) {return null;}
		$day=date("d",$date); $month=date("m",$date); $year=date("Y",$date);
		$date=mktime(0,0,0,$month,$day,$year);
*/	}  
	
	/** @}*/
?>
