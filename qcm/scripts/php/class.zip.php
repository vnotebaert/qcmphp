<?php
/* $Id: zip.lib.php,v 1.6 2002/03/30 08:24:04 loic1 Exp $ */


/**
 * Zip file creation class.
 * Makes zip files.
 *
 * Based on :
 *
 *  http://www.zend.com/codex.php?id=535&single=1
 *  By Eric Mueller <eric@themepark.com>
 *
 *  http://www.zend.com/codex.php?id=470&single=1
 *  by Denis125 <webmaster@atlant.ru>
 *
 *  a patch from Peter Listiak <mlady@users.sourceforge.net> for last modified
 *  date and time of the compressed file
 *
 * Official ZIP file format: http://www.pkware.com/appnote.txt
 *
 * @access  public
 */
class zipfile
{
   /**
     * Array to store compressed data
     *
     * @var  array    $datasec
     */
    var $datasec      = array();

  /**
     * Central directory
     *
     * @var  array    $ctrl_dir
     */
    var $ctrl_dir     = array();

  /**
     * End of central directory record
     *
     * @var  string   $eof_ctrl_dir
     */
    var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";

  /**
     * Last offset position
     *
     * @var  integer  $old_offset
     */
    var $old_offset   = 0;


  /**
     * Converts an Unix timestamp to a four byte DOS date and time format (date
     * in high two bytes, time in low two bytes allowing magnitude comparison).
     *
     * @param  integer  the current Unix timestamp
     *
     * @return integer  the current date in a four byte DOS format
     *
     * @access private
     */
    function unix2DosTime($unixtime = 0) 
	{
        $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);
		
        if ($timearray['year'] < 1980) 
		{
        	$timearray['year']    = 1980;
        	$timearray['mon']     = 1;
        	$timearray['mday']    = 1;
        	$timearray['hours']   = 0;
        	$timearray['minutes'] = 0;
        	$timearray['seconds'] = 0;
        } // end if

        return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
                ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
    } // end of the 'unix2DosTime()' method


  /**
     * Adds "file" to archive
     *
     * @param  string   file contents
     * @param  string   name of the file in the archive (may contains the path)
     * @param  integer  the current timestamp
     *
     * @access public
     */
    function addFile($data, $name, $time = 0)
    {
        $name     = str_replace('\\', '/', $name);

        $dtime    = dechex($this->unix2DosTime($time));
        $hexdtime = '\x' . $dtime[6] . $dtime[7]
                  . '\x' . $dtime[4] . $dtime[5]
                  . '\x' . $dtime[2] . $dtime[3]
                  . '\x' . $dtime[0] . $dtime[1];
        eval('$hexdtime = "' . $hexdtime . '";');

        $fr   = "\x50\x4b\x03\x04";
        $fr   .= "\x14\x00";            // ver needed to extract
        $fr   .= "\x00\x00";            // gen purpose bit flag
        $fr   .= "\x08\x00";            // compression method
        $fr   .= $hexdtime;             // last mod time and date

        // "local file header" segment
        $unc_len = strlen($data);
        $crc     = crc32($data);
        $zdata   = gzcompress($data);
        $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2); // fix crc bug
        $c_len   = strlen($zdata);
        $fr      .= pack('V', $crc);             // crc32
        $fr      .= pack('V', $c_len);           // compressed filesize
        $fr      .= pack('V', $unc_len);         // uncompressed filesize
        $fr      .= pack('v', strlen($name));    // length of filename
        $fr      .= pack('v', 0);                // extra field length
        $fr      .= $name;

        // "file data" segment
        $fr .= $zdata;

        // "data descriptor" segment (optional but necessary if archive is not
        // served as file)
        $fr .= pack('V', $crc);                 // crc32
        $fr .= pack('V', $c_len);               // compressed filesize
        $fr .= pack('V', $unc_len);             // uncompressed filesize

        // add this entry to array
        $this -> datasec[] = $fr;
        $new_offset        = strlen(implode('', $this->datasec));

        // now add to central directory record
        $cdrec = "\x50\x4b\x01\x02";
        $cdrec .= "\x00\x00";                // version made by
        $cdrec .= "\x14\x00";                // version needed to extract
        $cdrec .= "\x00\x00";                // gen purpose bit flag
        $cdrec .= "\x08\x00";                // compression method
        $cdrec .= $hexdtime;                 // last mod time & date
        $cdrec .= pack('V', $crc);           // crc32
        $cdrec .= pack('V', $c_len);         // compressed filesize
        $cdrec .= pack('V', $unc_len);       // uncompressed filesize
        $cdrec .= pack('v', strlen($name) ); // length of filename
        $cdrec .= pack('v', 0 );             // extra field length
        $cdrec .= pack('v', 0 );             // file comment length
        $cdrec .= pack('v', 0 );             // disk number start
        $cdrec .= pack('v', 0 );             // internal file attributes
        $cdrec .= pack('V', 32 );            // external file attributes - 'archive' bit set

        $cdrec .= pack('V', $this -> old_offset ); // relative offset of local header
        $this -> old_offset = $new_offset;

        $cdrec .= $name;

        // optional extra field, file comment goes here
        // save to central directory
        $this -> ctrl_dir[] = $cdrec;
    } // end of the 'addFile()' method


  /**
     * Dumps out file
     *
     * @return  string  the zipped file
     *
     * @access public
     */
    function file()
    {
        $data    = implode('', $this -> datasec);
        $ctrldir = implode('', $this -> ctrl_dir);
		
        return
            $data .
            $ctrldir .
            $this -> eof_ctrl_dir .
            pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries "on this disk"
            pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries overall
            pack('V', strlen($ctrldir)) .           // size of central dir
            pack('V', strlen($data)) .              // offset to start of central dir
            "\x00\x00";                             // .zip file comment length
    } // end of the 'file()' method


	function add_dir($name) 
	{ 
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
	
	function add_file_named($name) 
	{ 
		$fp = fopen($name,"rb");
		$data = fread($fp,filesize($name));
		fclose($fp);
		$this -> addFile($data,$name);
	} 

	function add_repertoire($repertoire,$interdit,$filtre,$avancement)
	{
		$Directory=$repertoire;
		if ($avancement==1) echo(".");
		$MyDirectory = opendir($Directory);
		$i=1;
		while ($File = readdir($MyDirectory)) {
			$extention=explode(".",$File);
			$extention=$extention[count($extention)-1];
			if (!is_dir($repertoire.$File) and !in_array($File,$interdit) and !in_array($extention,$filtre) and $File!=".." and $File!=".") {
				$this -> add_file_named($repertoire.$File);
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
		Header ("Content-disposition: attachment;filename=".$name.".zip");
		$this -> add_repertoire($repertoire,$interdit,$filtre,0);
		echo $this -> file();
	}
	
	function link_repertoire($name,$repertoire,$interdit,$filtre,$avancement=1){
		echo ("<p><span>"._COMPRESSION_EN_COURS."</span></p>");
		$this -> add_repertoire($repertoire,$interdit,$filtre,$avancement);
		$filename = $name.".zip";
		$fd = fopen ($filename, "wb");
		$out = fwrite ($fd, $this -> file());
		fclose ($fd);
			
		echo ("<p><span><a href=\"".$filename."\">"._CLIQUEZ_ICI_POUR_TELECHARGER_LE_FICHIER.$filename.".</a></span></p>");
	}
}
?>