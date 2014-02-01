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

   /**
    * @class IPSenhancedFHZ
    *
    * Definiert das IPSenhancedFHZ Object, das den Versand und Empfang über den IPSenhancedFHZ-Puffer verarbeitet.
    *
	 * @file          IPSenhancedFHZ_Device.class.php
    * @author Günter Strassnigg
    * @version
	 *  Version 0.1.2, 05.01.2014<br/>
    */

	class IPSenhancedFHZ  {

		/**
		 * @public
		 */
		public $deviceId;
		
		/**
		 * @private
		 */
		private $eFHZ_InstanceId;	
		public  $ConnectionReady=false;
		private $FTDIInstanceId;		
		private $config;		
		private $Housecode;
		private $Name;
		private $Leap;
		private $Description;
		private $S1Buffer=array();
		private $S2Buffer=array();
		private $OK=false;
		private $PtyT;


		/**
		 *
		 * @Initialisierung des IPSenhancedFHZ Objektes
		 *
		 */
		// ----------------------------------------------------------------------------------------------------------------------------
		public function __construct($deviceId) {
			$this->config=IPSenhancedFHZ_GetFHZConfiguration();
			$this->deviceId = IPSUtil_ObjectIDByPath($deviceId);
			$this->CheckConnection(); 
			$keys=array_keys($this->config);$i=0;
			foreach ($this->config as $configId) {
				$i+=1;
				if ($configId[c_Property_eFHZ_Name]==IPS_GetName($this->deviceId)) {
					$this->Housecode=$keys[$i-1];
					$this->Leap=$this->config[(string)$this->Housecode][c_Property_eFHZ_Leap];
					$this->Description=$this->config[(string)$this->Housecode][c_Property_eFHZ_Description];
					break;
				}
			}
		}
		
		/**
		 *
		 * @Deklaration der IPSenhancedFHZ Klassenfunktionen
		 *
		 */

		// ----------------------------------------------------------------------------------------------------------------------------
		protected function isBit($bitField,$n) {
			return ((($bitField & (0x01 << ($n-1))))>0);
		}
		
		// ----------------------------------------------------------------------------------------------------------------------------
		protected function setBit(&$bitField,$n) {
			if(($n < 0) or ($n > 32)) return false;
			$bitField |= (0x01 << ($n-1));
			return true;
		}
		
		// ----------------------------------------------------------------------------------------------------------------------------
		protected function clearBit(&$bitField,$n) {
			$bitField &= ~(0x01 << ($n-1));
			return true;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		protected function GetIdentValue($variableIdent,$deviceID) {
			$variableId = IPS_GetObjectIDByIdent($variableIdent, $deviceID);
			if ($variableId === false) {
				throw new Exception('Variable '.$variableIdent.' could NOT be found for DeviceId='.$this->deviceId);
			}
			return GetValue($variableId);
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		protected function SetIdentValue($variableIdent, $value,$deviceID) {
			$variableId = IPS_GetObjectIDByIdent($variableIdent, $deviceID);
			if ($variableId === false) {
				throw new Exception('Variable '.$variableIdent.' could NOT be found for DeviceId='.$this->deviceId);
			}
			SetValue($variableId, $value);
		}
		
		// ----------------------------------------------------------------------------------------------------------------------------
		protected function eFHZLogValue($variableIdent,$Value,$deviceID,$lang,$Key=false) {
			$name=IPS_GetName($deviceID);
			if ($Key===false)   {
				$logmessage=str_replace("%Device%",$name,$lang["c_LogMess_eFHZ_".$variableIdent]);
				$logmessage=str_replace("%Value%",$Value,$logmessage);
			} else {
				$logmessage=str_replace("%Device%",$name,$lang["c_LogMess_eFHZ_".$variableIdent][$Value]);
			}
			return $logmessage;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		protected function eFHZLogOtherValue($Identifier,$deviceID,$lang) {
			$name=IPS_GetName($deviceID);
			$logmessage=str_replace("%Device%",$name,$lang[$Identifier]);
			return $logmessage;
		}
		// ----------------------------------------------------------------------------------------------------------------------------
		protected function GetModeBasedOnWeeklyProgram($weekprogram,$timestamp) {
			if (!is_array($wp=unserialize($weekprogram))) return 0;
			//$Day=(int)date("w",$timestamp);$Day=($Day==0) ? 6 : $Day-1;
			$Day=(int)date("N",$timestamp)-1;
			$Time=(((float)(date("H",$timestamp)))+((float)(date("i",$timestamp))/60))*6;
			$x1on=$Day*4;$x1off=$x1on+1;$x2on=$x1off+1;$x2off=$x2on+1;$Value=2;
			if ($wp[$x1on]!=144 && $wp[$x1off]!=144 && $wp[$x1on]!=$wp[$x1off]) {
				if (($wp[$x1on]<$wp[$x1off])&&($Time>=$wp[$x1on] && $Time<$wp[$x1off])) return 3;
				if (($wp[$x1on]>$wp[$x1off])&&($Time>=$wp[$x1on] || $Time<$wp[$x1off])) return 3;
			}
			elseif ($wp[$x1on]==144 && $wp[$x1off]==144) $Value=1;
			if ($wp[$x2on]!=144 && $wp[$x2off]!=144 && $wp[$x2on]!=$wp[$x2off]) {
				if (($wp[$x2on]<$wp[$x2off])&&($Time>=$wp[$x2on] && $Time<$wp[$x2off])) return 3;
				if (($wp[$x2on]>$wp[$x2off])&&($Time>=$wp[$x2on] || $Time<$wp[$x2off])) return 3;
			}
			return $Value;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		protected function GetTemperatureBasedOnWeeklyProgram($weekprogram,$timestamp,$deviceID) {
			$Value=$this->GetModeBasedOnWeeklyProgram($weekprogram,$timestamp);
			if ($Value==3) return ($this->GetIdentValue(c_control_eFHZ_suntemp_responce,$deviceID));
			if ($Value==2) return ($this->GetIdentValue(c_control_eFHZ_lunatemp_responce,$deviceID));
			return 17;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		private function CheckConnection() {
			foreach(IPS_GetInstanceList() as $id) {
				$Instance = IPS_GetInstance($id);
				if ($Instance['ModuleInfo']['ModuleID']=='{F3855B3C-7CD6-47CA-97AB-E66D346C037F}') {
					$this->eFHZ_InstanceId=$Instance['InstanceID'];
					$status_REGVAR=$Instance['InstanceStatus'];
					$Conn=$Instance['ConnectionID'];
					if ($Conn>0) {
						$Instance = IPS_GetInstance($Conn);
						if ($Instance['ModuleInfo']['ModuleID']=='{C1D478E9-2A3E-4344-BCC4-37C892F58751}') {
							$this->FTDIInstanceId=$Instance['InstanceID'];
							$status_FTDI=$Instance['InstanceStatus'];
							if ($status_REGVAR==102 && $status_FTDI==102) {
								$this->ConnectionReady=true;
								return;
							}
						}
					}
				}
			}
			return;
		}
		
		// ----------------------------------------------------------------------------------------------------------------------------
		private function SetProtocolBit($key,$bit) {
			if (!isset($this->S1Buffer[$key])) $this->S1Buffer[$key]=1;
			$this->S1Buffer[$key]=($this->S1Buffer[$key]|1<<$bit);
		}
	   
		// ----------------------------------------------------------------------------------------------------------------------------
		private function CheckTemperature($value) {
			$value=(float)$value;
			if ($value>=5.5 && $value<=30.5) return true;
			else return false;
		}
	   
		// ----------------------------------------------------------------------------------------------------------------------------
		private function SetProtocolHouseCode($sendstring) {
			$sendstring[7]=intval($this->Housecode/100);
			$sendstring[8]=$this->Housecode-$sendstring[7]*100;
			return $sendstring;
		}
	   
		// ----------------------------------------------------------------------------------------------------------------------------
		private function BuildProtocolSendString($sendstring,$buffer) {
			ksort($buffer);$i=9;
			while (list($sendstring[$i],$sendstring[$i+1])=each($buffer)) {$i+=2;}
			array_pop($sendstring);array_pop($sendstring);
			return $sendstring;
		}
	   
		// ----------------------------------------------------------------------------------------------------------------------------
		private function ProtocolBlockCheck($sendstring) {
			$sendstring[3]=array_sum($sendstring) & 0xff;
			return $sendstring;
		}
	   
		// ----------------------------------------------------------------------------------------------------------------------------
		private function SendProtocolString($sendstring) {
			if ($this->ConnectionReady) {
				$sendstring[1]=count($sendstring);$sendstring[0]=0x81;ksort($sendstring);$buffer='';
				for($i=0;$i<count($sendstring);$i++) {
					$buffer.=chr($sendstring[$i]);
				}
				$return=RegVar_SendText($this->eFHZ_InstanceId,$buffer);IPS_Sleep(200);
				return $return;
			}
			else return false;
		}
	   
		// ----------------------------------------------------------------------------------------------------------------------------
		private function CorrectLeapTime($timestamp,$leap) {
			if ($leap) {
				$Year=date("Y",$timestamp);$l_year=$Year/8;
				if (($l_year==intval($l_year))&&($l_year<=254)&&($timestamp>mktime(0,0,0,3,1,$Year))) {
					$timestamp=strtotime("+6 years",$timestamp);
				}
			}
			return $timestamp;
		}
	   
		/**
		 *
		 * @FHZ Single-Methoden der IPSenhancedFHZ Klasse
		 *
		 */

		public function sFHZ_FreeMem() {
			if ($this->ConnectionReady) {
				$str=array(4=>0xc9,5=>0x01,6=>0x85);
				$str=$this->ProtocolBlockCheck($str);$str[2]=4;
				$this->SendProtocolString($str);
				return;//ord(substr(self::xipsvarget(self::$FHZ_BufferVar,'String'),-1));
			}
			else return false;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		public function sFHZ_GetSerial() {
			if ($this->ConnectionReady) {
				$str=array(4=>0xc9,5=>0x01,6=>0x84,7=>0x57,8=>0x02,9=>0x08);
				$str=$this->ProtocolBlockCheck($str);$str[2]=4;
				return $this->SendProtocolString($str);
				return true;
			}
			else return false;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		public function sFHZ_Hello() {
			if ($this->ConnectionReady) {
				$str=array(4=>0x02,5=>0x01,6=>0x1f,7=>0x0a);
				$str=$this->ProtocolBlockCheck($str);$str[2]=0xc9;
				return $this->SendProtocolString($str);
			}
			else return false;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		public function sFHZ_SetDateAndTime($timestamp=0) {
			if ($timestamp==0) $timestamp=time();
			$timestamp=$this->CorrectLeapTime($timestamp,$this->Leap);
			if ($this->ConnectionReady) {
	         $this->S2Buffer=array();
	         $this->S2Buffer[0x60]=(int)date("y",$timestamp);
	         $this->S2Buffer[0x61]=(int)date("m",$timestamp);
	         $this->S2Buffer[0x62]=(int)date("d",$timestamp);
	         $this->S2Buffer[0x63]=(int)date("H",$timestamp);
	         $this->S2Buffer[0x64]=(int)date("i",$timestamp);
				$str=$this->BuildProtocolSendString(array(4=>2,5=>1,6=>0x83),$this->S2Buffer);
				$str=$this->SetProtocolHouseCode($str);
				$str=$this->ProtocolBlockCheck($str);$str[2]=4;
	         $this->S2Buffer=array();
				return $this->SendProtocolString($str);
			}
			else return false;
		}

		/**
		 *
		 * @FHT Single-Methoden der IPSenhancedFHZ Klasse
		 *
		 */

		// ----------------------------------------------------------------------------------------------------------------------------
		public function sFHT_Init() {
			if ($this->ConnectionReady) {
				$this->S2Buffer=array();$this->S2Buffer[0x65]=0xff;$this->S2Buffer[0x66]=0xff;
				$str=$this->BuildProtocolSendString(array(4=>2,5=>1,6=>0x83),$this->S2Buffer);
				$str=$this->SetProtocolHouseCode($str);$str=$this->ProtocolBlockCheck($str);$str[2]=4;
				$this->S2Buffer=array();
				return ($this->SendProtocolString($str));
			}
			else return false;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
	   public function sFHT_SetWeekProgram($Day,$Von1=false,$Bis1=false,$Von2=false,$Bis2=false) {
	      if ($this->ConnectionReady) {
	         $this->S2Buffer=array();
	         if (($Day=(int)$Day)<7) {
	            $this->S2Buffer[0x65]=(($Day-=1)<0) ? 64 : 1<<$Day;
	            $reg=20+(($Day<0) ? 6 : $Day)*4;
	            if ($Von1===false||$Bis1===false) {$Von1=false;$Bis1=false;$Von2=false;$Bis2=false;}
	            else {
	               if ((!is_string($Von1))||(($Von1=strtotime($Von1,0))===false)) {return false;}
	               if ((!is_string($Bis1))||(($Bis1=strtotime($Bis1,0))===false)) {return false;}
	            }
	            if ($Von2===false||$Bis2===false) {$Von2=false;$Bis2=false;}
	            else {
	               if ((!is_string($Von2))||(($Von2=strtotime($Von2,0))===false)) {return false;}
	               if ((!is_string($Bis2))||(($Bis2=strtotime($Bis2,0))===false)) {return false;}
	            }
					$wp=$this->GetIdentValue(c_control_eFHZ_weekprogram_request,$this->deviceId);
					if (!is_array($wp=unserialize($wp))) {$wp=array_fill(0,28,144);}
	     
		         if ($Von1!==false) $this->S2Buffer[$reg]=(((float)(date("H",$Von1)))+((float)(date("i",$Von1))/60))*6;
	            else $this->S2Buffer[$reg]=144;
	            $wp[$reg-20]=$this->S2Buffer[$reg];
	     
		         if ($Bis1!==false) $this->S2Buffer[$reg+1]=(((float)(date("H",$Bis1)))+((float)(date("i",$Bis1))/60))*6;
	            else $this->S2Buffer[$reg+1]=144;
		         $wp[$reg-19]=$this->S2Buffer[$reg+1];

	            if ($Von2!==false) $this->S2Buffer[$reg+2]=(((float)(date("H",$Von2)))+((float)(date("i",$Von2))/60))*6;
	            else $this->S2Buffer[$reg+2]=144;
		         $wp[$reg-18]=$this->S2Buffer[$reg+2];

	            if ($Bis2!==false) $this->S2Buffer[$reg+3]=(((float)(date("H",$Bis2)))+((float)(date("i",$Bis2))/60))*6;
	            else $this->S2Buffer[$reg+3]=144;
	            $wp[$reg-17]=$this->S2Buffer[$reg+3];
	            
					$str=$this->BuildProtocolSendString(array(4=>2,5=>1,6=>0x83),$this->S2Buffer);
					$str=$this->SetProtocolHouseCode($str);
					$str=$this->ProtocolBlockCheck($str);$str[2]=4;
		         $this->S2Buffer=array();
		         $this->SetIdentValue(c_control_eFHZ_weekprogram_request, serialize($wp),$this->deviceId);
					return $this->SendProtocolString($str);
	         }
	         else return false;
	      }
	      else return false;
	   }

		/**
		 *
		 * @FHT Puffer-Methoden der IPSenhancedFHZ Klasse
		 *
		 */

		// ----------------------------------------------------------------------------------------------------------------------------
		public function bFHT_ClrBuffer() {
			$this->S1Buffer=array();
			return true;
		}
	   
		// ----------------------------------------------------------------------------------------------------------------------------
		public function bFHT_RclActualState() {
			if ($this->ConnectionReady) {
				$this->SetProtocolBit(0x66,0);$this->SetProtocolBit(0x66,5);
				return true;
			}
			else return false;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		public function bFHT_RclTargetState() {
			if ($this->ConnectionReady) {
				$this->SetProtocolBit(0x66,1);$this->SetProtocolBit(0x66,2);$this->SetProtocolBit(0x66,3);
				return true;
			}
			else return false;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		public function bFHT_RclWeekProgram($Day=7) {
			if ($this->ConnectionReady) {
				$this->S1Buffer[0x65]=($Day>=7 ? 127 : ((($Day-=1)<0) ? 64 : 1<<$Day));
				return true;
			}
			else return false;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		public function bFHT_SetTemperature($value) {
			if ($this->CheckTemperature($value) && $this->ConnectionReady) {
				$this->S1Buffer[0x41]=$value*2;
				$this->SetProtocolBit(0x66,3);
				return true;
			}
			else return false;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		public function bFHT_SetSunTemperature($value) {
			if ($this->CheckTemperature($value) && $this->ConnectionReady) {
				$this->S1Buffer[0x82]=$value*2;
				$this->SetProtocolBit(0x66,2);
				return true;
			}
			else return false;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		public function bFHT_SetLunaTemperature($value) {
			if ($this->CheckTemperature($value) && $this->ConnectionReady) {
				$this->S1Buffer[0x84]=$value*2;
				$this->SetProtocolBit(0x66,2);
				return true;
			}
			else return false;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		public function bFHT_SetWindTemperature($value) {
			if ($this->CheckTemperature($value) && $this->ConnectionReady) {
				$this->S1Buffer[0x8a]=$value*2;
				$this->SetProtocolBit(0x66,2);
				return true;
			}
			else return false;
		}
		
 		// ----------------------------------------------------------------------------------------------------------------------------
		public function bFHT_SetTemperatureByWindowMode($mode=false) {
			if ($this->ConnectionReady) {
				if ($mode==false) {
					$weekprogram=$this->GetIdentValue(c_control_eFHZ_weekprogram_responce,$this->deviceId);
					$targettemperatur=$this->GetTemperatureBasedOnWeeklyProgram($weekprogram,time(),$this->deviceId); 
				} else {
					$targettemperatur=$this->vFHT_GetWindTemperature();
				}
				$this->bFHT_SetTemperature($targettemperatur);
			}
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		public function bFHT_SetMode($Mode) {
			if ($this->ConnectionReady) {
				if ($Mode>1) {
					$timestamp=$Mode;
					$st_t=$this->CorrectLeapTime(time(),$this->Leap)+1200;
					if ($timestamp<$st_t) $timestamp=$st_t;
					$dif=$timestamp-$st_t;
					if ($dif>86400) {
						if ($dif>101*86400) $dif=101*86400;
						$this->PtyT=mktime(0,0,0,date("m",$st_t+$dif),date("d",$st_t+$dif),date("Y"));$Mode=2;
						$this->S1Buffer[0x3f]=(int)date("d",$this->PtyT);
						$this->S1Buffer[0x40]=(int)date("m",$this->PtyT);
					} else {
						$this->PtyT=$timestamp;
						$this->S1Buffer[0x3f]=(((float)(date("H",$this->PtyT)))+((round((date("i",$this->PtyT))/10+0.4,0))*1/6))*6;
						$this->S1Buffer[0x40]=(int)date("d",$this->PtyT);
						$Mode=3;
					}
				}
				$this->S1Buffer[0x3e]=$Mode;
				$this->SetProtocolBit(0x66,1);
				return true;
			}
			else return false;
		}

		// ----------------------------------------------------------------------------------------------------------------------------
		public function bFHT_SendTo($ClrBuffer=true) {
			if ($this->ConnectionReady && count($this->S1Buffer)>0) {
				ksort($this->S1Buffer);
				while (list($key,$value)=each($this->S1Buffer)) {
					if ($key==0x3e) {
						$this->SetIdentValue(c_control_eFHZ_mode_request,$value,$this->deviceId);
					}
					elseif ($key==0x3f) {
						$ti=date("H:i:s d.m.Y",($to=mktime(($h=round(($this->S1Buffer[0x3f]/6),-1)),($this->S1Buffer[0x3f]/6-$h)*60,0))+($this->S1Buffer[0x40]!=(int)date("d",$to) ? 1 : 0)*86400);
						$this->SetIdentValue(c_control_eFHZ_partytime_request,$ti,$this->deviceId);
					}
					elseif ($key==0x41) {
						$this->SetIdentValue(c_control_eFHZ_target_temperature_request,$value/2,$this->deviceId);
						if (c_eFHZ_debug_logging) {
							IPSLogger_Dbg(__file__, c_PropertyName_eFHZ_target_temperature_request);
						}
					}
					elseif ($key==0x82) $this->SetIdentValue(c_control_eFHZ_suntemp_request,$value/2,$this->deviceId);
					elseif ($key==0x84) $this->SetIdentValue(c_control_eFHZ_lunatemp_request,$value/2,$this->deviceId);
					elseif ($key==0x8a) $this->SetIdentValue(c_control_eFHZ_windowtemp_request,$value/2,$this->deviceId);
				}
				$str=$this->BuildProtocolSendString(array(4=>0x02,5=>0x01,6=>0x83),$this->S1Buffer);
				$str=$this->SetProtocolHouseCode($str);$str=$this->ProtocolBlockCheck($str);$str[2]=4;
				if ($ClrBuffer) $this->S1Buffer=array();
				return ($this->SendProtocolString($str));
			}
			else return false;
		}

      /**
		 *
		 * @FHT Variablen-Methoden der IPSenhancedFHZ Klasse
		 *                                  
		 */


		// ----------------------------------------------------------------------------------------------------------------------------
	   public function vFHT_GetActualTemperature() {
		   return $this->GetIdentValue(c_control_eFHZ_actual_temperature_responce,$this->deviceId);
	   }  

		// ----------------------------------------------------------------------------------------------------------------------------
	   public function vFHT_GetTemperature() {
		   return $this->GetIdentValue(c_control_eFHZ_target_temperature_responce,$this->deviceId);
	   }  

		// ----------------------------------------------------------------------------------------------------------------------------
	   public function vFHT_GetSunTemperature() {
		   return $this->GetIdentValue(c_control_eFHZ_suntemp_responce,$this->deviceId);
	   }  

		// ----------------------------------------------------------------------------------------------------------------------------
	   public function vFHT_GetLunaTemperature() {
		   return $this->GetIdentValue(c_control_eFHZ_lunatemp_responce,$this->deviceId);
	   }  

		// ----------------------------------------------------------------------------------------------------------------------------
	   public function vFHT_GetWindTemperature() {
		   return $this->GetIdentValue(c_control_eFHZ_windowtemp_responce,$this->deviceId);
	   }  

		// ----------------------------------------------------------------------------------------------------------------------------
	   public function vFHT_GetMode() {
		   return $this->GetIdentValue(c_control_eFHZ_mode_responce,$this->deviceId);
	   }  

		// ----------------------------------------------------------------------------------------------------------------------------
		public function vFHT_DecodeWeekProgram($Day,$request=false) {
			$arr=array();
			$e_sign="--:--";
			if ($request) {
				$wp=$this->GetIdentValue(c_control_eFHZ_weekprogram_request,$this->deviceId);
			}
			else {
				$wp=$this->GetIdentValue(c_control_eFHZ_weekprogram_responce,$this->deviceId);
			}
			if (!is_array($wp=unserialize($wp))) {return false;}
			$cntr=($Day>=7) ? 6 : 0;
			for($i=0;$i<=$cntr;$i++) {
				if ($cntr==0) {
					$idx=($Day==0) ? 6 : ($Day-1);
				}
				else {
					$idx=($i==6) ? 0 : ($i+1);
				}
				for($j=0;$j<=3;$j++) {
					$v=$wp[($idx*4)+$j];$idn=($idx==6) ? 0 : ($idx+1);
					if ($v==144) {
						$arr[$idn][$j]=$e_sign;
					}
					else {
						$x=$wp[($idx*4)+$j]/6;$y=round(($x-intval($x))*60,0);
						$arr[$idn][$j]=sprintf("%02d:%02d", intval($x), $y);
					}
				}
			}
			ksort($arr);
			return $arr;
		}

	}


	/** @}*/


?>