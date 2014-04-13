<?php 
echo "<pre>";
$con = mysql_connect('localhost', 'root', 'apmserver12') or die('connect:false');
if($con)
{
	mysql_select_db('new_idn', $con) or die('select-db:false');
}

// functions
/**
 * Company
 * migrate.php?f=company
 */
function company()
{
	global $con;
	
	//exit('exit;');
	
	// issues
	$issues = array('ACES','ADMG','AGRO','AKPI','AMFG','APIC','ARGO','ARII','ARNA','ASBI','ASDM','ASJT','BATA','BBTN','BNBA','BNBR','BNII','BRAM','BRAU','BRNA','BSWD','BTEK','BTEL','BYAN','DNET','DVLA','EMDE','ESTI','GDYR','GEMA','GOLD','HDTX','HITS','ICBP','INRU','ISSP','ITTG','JPFA','JRPT','KAEF','KIAS','LAMI','LCGP','LPCK','MAGP','MCOR','MEGA','MLPL','MRAT','MYOR','NIRO','PADI','PAFI','PNIN','PNLF','POLY','PWON','RANC','RDTX','RICY','SCCO','SKBM','SMAR','SMSM','SRTG','TFCO','TGKA','TOTO','TRIS','UNTX','VOKS','VRNA','WINS');
	
	// get company list
	$sql = "SELECT code,summary,description FROM company"; //." WHERE code IN ('". implode("','", $issues) ."')";
	$get = mysql_query($sql, $con) or die(mysql_error());
	if($get)
	{
		$i=1;
		while($row = mysql_fetch_assoc($get))
		{
			$summary = strip_tags(trim($row['summary']), '<p>');
			$summary = str_replace(array("'","\n","\r"), array("&apos;","",""), $summary);
			$summary = json_encode(array('en'=>$summary));
			
			$description = strip_tags(trim($row['description']), '<p>');
			$description = str_replace(array("'","\n","\r"), array("&apos;","",""), $description);
			$description = json_encode(array('en'=>$description));

			$sql = "UPDATE company SET summary='{$summary}', description='{$description}' WHERE code='{$row['code']}'";
			$run = mysql_query($sql, $con);
			echo "{$i}. {$row['code']}:". (($run) ? "true" : mysql_error()) ."\n";
			$i++;
		}
	}
} // end of company

// main
$f = isset($_GET['f']) ? $_GET['f'] : 'company';
if(function_exists($f))
{
	$f();
}
else
{
	die('fname:false');
}