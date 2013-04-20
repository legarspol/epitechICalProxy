<?php
error_reporting(-1);
/* STEP 1. let’s create a cookie file */

$ckfile = tempnam ("./", "CURLCOOKIE");

/* STEP 2. visit the homepage to set the cookie properly */

$ch = curl_init ("https://intra.epitech.eu/");
curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "login=XXXXXXXXXX&password=YYYYYYYY");

$date1 = date("Y-m-d");
$date2 = strtotime(date("Y-m-d", strtotime($date1)) . " +1 month");
$date2 = date("Y-m-d", $date2);
$output = curl_exec ($ch);
/*echo $output;*/


echo "==============================================================================";


/* STEP 3. visit cookiepage.php */
$url = "https://intra.epitech.eu/planning/load?format=ical&start=".$date1."&end=".$date2."&location=FR/LYN&onlymypromo=true&onlymymodule=true&onlymyevent=true&semester=0|6";
$ch = curl_init ($url);
curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec ($ch);
echo "[  ".strlen($output)."  ]";
$output = str_replace("END:VEVENT", "LOCATION: 86 Boulevard Marius Vivier Merle, 69003 Lyon\nEND:VEVENT", $output);
$output = str_replace("DTSTART:", "DTSTART;TZID=Europe/Paris:", $output);
$output = str_replace("000Z", "000", $output);
echo $output;

/*echo $output;*/
file_put_contents("test.ics", $output);
echo "<br />DONE"
/* here you can do whatever you want with $output */

?>