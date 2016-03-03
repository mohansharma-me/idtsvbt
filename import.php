<?php
session_start();
function getdtime() {
    $date = date("d-m-Y H:i:s A");echo "\n";
    return $date;
}
function assign_status($page) {
    $p=$_SERVER['SCRIPT_NAME'];
    if($p=="/idts/".$page) {
        echo "current";
    }
}
function carr($array) {
    $err=false;$i=0;
    foreach($array as $a) {
        if(strlen($a)<=0) {
            $err=true;
        }        $i++;
    }
    if($err) {
        return false;
    } else {
        return true;
    }
}
function getfilename($path) {
    $arr=explode("/",$path);
    $tot=count($arr);
    return $arr[$tot-1];
}
function cerr() {
	if(strlen(mysql_error())==0) {
		return true;
	} else {
		return false;
	}
}
function ms_err($no) {
	echo "<CODE><b><font color='red'>SORRY, ERROR CAN NOT BE IGNORED. ERROR NO. ".mysql_errno()." AT BREAK-POINT $no. <br/> PLEASE TRY AGAIN AFTER SOMETIME...<BR/> THANKX!!</font></b></CODE>";
}
function is_mail($e) {
	$o=explode("@",$e);
	if(isset($o[0]) && isset($o[1])) {
		$t=explode(".",$o[1]);
		if(isset($t[0]) && isset($t[1])) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
function cvar($v) {
	if(strlen($v)>0) {
		return true;
	} else {
		return false;
	}
}
function CSVExport($query) {
    $sql_csv = mysql_query($query) or die("Error: " . mysql_error());
    
    header("Content-type:text/octect-stream");
    header("Content-Disposition:attachment;filename=data.csv");
    while($row = mysql_fetch_row($sql_csv)) {
        print '"' . stripslashes(implode('","',$row)) . "\"\n";
    }
    exit;
}
function CSVImport($table, $fields, $csv_fieldname='csv',$clear=false,$add_data="") {
    //if(!$_FILES[$csv_fieldname]['name']) return;
    $handle = fopen($csv_fieldname,'r'); //$_FILES[$csv_fieldname]['tmp_name']
    if(!$handle) die('Cannot open uploaded file.');

    $row_count = 0;
    $sql_query = "INSERT INTO $table(". implode(',',$fields) .") VALUES(";
	
    $rows = array();

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $row_count++;
		$tot=count($data);
        foreach($data as $key=>$value) {
            $data[$key] = "\"" . addslashes($value) . "\"";
        }
		if(strlen($add_data)>0) {
			$td=explode(";",$add_data);
			for($i=0;$i<count($td);$i++) {
				$data[$tot+$i]="\"".$td[$i]."\"";
			}
		}
        $rows[] = implode(",",$data);
    }
    $sql_query .= implode("),(", $rows);
    $sql_query .= ")";
    fclose($handle);
	//echo $sql_query;
    if(count($rows)) {
        if($clear==true) {
            if(strlen($add_data)>0) {
                mysql_query("DELETE FROM $table where NOT(id=1)") or die("MySQL Error: " . mysql_error());
            } else {
                mysql_query("TRUNCATE TABLE $table") or die("MySQL Error: " . mysql_error());
            }
		}
        mysql_query($sql_query) or die("MySQL Error: " . mysql_error());
        print 'Successfully imported '.$row_count.' record(s)';
    } else {
        print 'Cannot import data - no records found.';
    }
} 
?>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />