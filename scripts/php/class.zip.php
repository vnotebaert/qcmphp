<?
class zipfile 
{ 
	var $ctrl_dir = array(); 
	var $datasec = array(); 
	var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00"; 
	var $old_offset = 0; 
	
	function add_dir($name) { 
		$name = str_replace("\\", "/", $name); 
		
		$fr = "\x50\x4b\x03\x04"; 
		$fr .= "\x0a\x00"; 
		$fr .= "\x00\x00"; 
		$fr .= "\x00\x00"; 
		$fr .= "\x00\x00\x00\x00"; 
		
		$fr .= pack("V",0); 
		$fr .= pack("V",0); 
		$fr .= pack("V",0); 
		$fr .= pack("v", strlen($name) ); 
		$fr .= pack("v", 0 ); 
		$fr .= $name; 
		$fr .= pack("V", 0); 
		$fr .= pack("V", 0); 
		$fr .= pack("V", 0); 
		
		$this -> datasec[] = $fr;
		$new_offset = strlen(implode("", $this->datasec)); 
		
		$cdrec = "\x50\x4b\x01\x02"; 
		$cdrec .="\x00\x00"; 
		$cdrec .="\x0a\x00"; 
		$cdrec .="\x00\x00"; 
		$cdrec .="\x00\x00"; 
		$cdrec .="\x00\x00\x00\x00"; 
		$cdrec .= pack("V",0); 
		$cdrec .= pack("V",0); 
		$cdrec .= pack("V",0); 
		$cdrec .= pack("v", strlen($name) ); 
		$cdrec .= pack("v", 0 ); 
		$cdrec .= pack("v", 0 ); 
		$cdrec .= pack("v", 0 ); 
		$cdrec .= pack("v", 0 ); 
		$ext = "\x00\x00\x10\x00"; 
		$ext = "\xff\xff\xff\xff"; 
		$cdrec .= pack("V", 16 ); 
		$cdrec .= pack("V", $this -> old_offset ); 
		$cdrec .= $name; 
		
		$this -> ctrl_dir[] = $cdrec; 
		$this -> old_offset = $new_offset; 
		return; 
	} 
	
	function add_file($data, $name) { 
		$fp = fopen($data,"rb");
		$data = fread($fp,filesize($data));
		fclose($fp);
		$name = str_replace("\\", "/", $name); 
		$unc_len = strlen($data); 
		$crc = crc32($data); 
		$zdata = gzcompress($data); 
		$zdata = substr ($zdata, 2, -4); 
		$c_len = strlen($zdata); 
		$fr = "\x50\x4b\x03\x04"; 
		$fr .= "\x14\x00"; 
		$fr .= "\x00\x00"; 
		$fr .= "\x08\x00"; 
		$fr .= "\x00\x00\x00\x00"; 
		$fr .= pack("V",$crc); 
		$fr .= pack("V",$c_len); 
		$fr .= pack("V",$unc_len); 
		$fr .= pack("v", strlen($name) ); 
		$fr .= pack("v", 0 ); 
		$fr .= $name; 
		$fr .= $zdata; 
		$fr .= pack("V",$crc); 
		$fr .= pack("V",$c_len); 
		$fr .= pack("V",$unc_len); 
		
		$this -> datasec[] = $fr; 
		$new_offset = strlen(implode("", $this->datasec)); 
		
		$cdrec = "\x50\x4b\x01\x02"; 
		$cdrec .="\x00\x00"; 
		$cdrec .="\x14\x00"; 
		$cdrec .="\x00\x00"; 
		$cdrec .="\x08\x00"; 
		$cdrec .="\x00\x00\x00\x00"; 
		$cdrec .= pack("V",$crc); 
		$cdrec .= pack("V",$c_len); 
		$cdrec .= pack("V",$unc_len); 
		$cdrec .= pack("v", strlen($name) ); 
		$cdrec .= pack("v", 0 ); 
		$cdrec .= pack("v", 0 ); 
		$cdrec .= pack("v", 0 ); 
		$cdrec .= pack("v", 0 ); 
		$cdrec .= pack("V", 32 ); 
		$cdrec .= pack("V", $this -> old_offset ); 
		
		$this -> old_offset = $new_offset; 
		
		$cdrec .= $name; 
		$this -> ctrl_dir[] = $cdrec; 
	} 
	
	function file() { 
		$data = implode("", $this -> datasec); 
		$ctrldir = implode("", $this -> ctrl_dir); 
		
		return 
			$data . 
			$ctrldir . 
			$this -> eof_ctrl_dir . 
			pack("v", sizeof($this -> ctrl_dir)) . 
			pack("v", sizeof($this -> ctrl_dir)) . 
			pack("V", strlen($ctrldir)) . 
			pack("V", strlen($data)) . 
			"\x00\x00"; 
	}
	function add_repertoire($repertoire,$interdit,$filtre,$avancement){
		$Directory=$repertoire;
		if ($avancement==1) echo(".");
		$MyDirectory = opendir($Directory);
		$i=1;
		while ($File = readdir($MyDirectory)) {
			$extention=explode(".",$File);
			$extention=$extention[count($extention)-1];
			if (!is_dir($repertoire.$File) and !in_array($File,$interdit) and !in_array($extention,$filtre) and $File!=".." and $File!=".") {
				$this -> add_file($repertoire.$File,$repertoire.$File);
				$i++;
			}
			if (is_dir($repertoire.$File) and !in_array($File,$interdit) and $File!=".." and $File!=".") {
				$repertoiretemp=$repertoire.$File."/";
				$this -> add_dir($repertoiretemp);
				$this -> add_repertoire($repertoiretemp,$interdit,$filtre,$avancement);
			}
		}
		closedir($MyDirectory);
		clearstatcache();
	}
	
	function header_repertoire($name,$repertoire,$interdit,$filtre){
		Header("Content-type: application/octet-stream");
		Header ("Content-disposition: attachment; filename=".$name.".zip");
		$this -> add_repertoire($repertoire,$interdit,$filtre,0);
		echo $this -> file();
	}
	
	function link_repertoire($name,$repertoire,$interdit,$filtre){
		echo ("</br>"._COMPRESSION_EN_COURS."</br>");
		$this -> add_repertoire($repertoire,$interdit,$filtre,1);
		$filename = $name.".zip";
		$fd = fopen ($filename, "wb");
		$out = fwrite ($fd, $this -> file());
		fclose ($fd);
			
		echo ("</br><a href=\"".$filename."\">"._CLIQUEZ_ICI_POUR_TELECHARGER_LE_FICHIER.$filename.".</a>");
	}
}
?>