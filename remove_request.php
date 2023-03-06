 <?php
header('Content-Type: text/html; charset=utf-8');
if (eregi('href|http', $_REQUEST['a']) || eregi('href|http', $_REQUEST['b']) || eregi('href|http', $_REQUEST['c'])|| eregi('href|http', $_REQUEST['d'])){
die("wrong characters in the input");
$from = getenv("HTTP_REFERER");
header("Location: $from");
exit;
}
$m = $_REQUEST["a"];
$t = $_REQUEST["b"];
$d = $_REQUEST["c"];
$mn = $_REQUEST["d"];


$months = array("January", "February", "March", "April", "May","June", "July", "August", "September", "October", "November", "December");
$filename = "month.txt";
$time = date("d/m");
$fp = fopen($filename, "r");
$file_contents = @fread($fp, filesize($filename));
fclose($fp);
$line = explode("|", $file_contents);
$dayToChange=$line[$d-1];
$masterScedule=explode(":", $dayToChange);
$temp=explode(",", $masterScedule[1+$m]);

//echo sizeof($temp);
$i = 0;
while($i < sizeof($temp)) {		

		if ($temp[$i] == $t) {
$found=1;break;}
else{$found=0;}
$i++;}

if($found==1){
while (($j = array_search($t, $temp)) !== false) {
  unset($temp[$j]);
} 
sort($temp);
$old=$dayToChange;
$tmp=join(',',$temp);
if($m==0){
$new=$masterScedule[0].':'.$tmp.':'.$masterScedule[2].':'.$masterScedule[3];}
if($m==1){
$new=$masterScedule[0].':'.$masterScedule[1].':'.$tmp.':'.$masterScedule[3];}
if($m==2){
$new=$masterScedule[0].':'.$masterScedule[1].':'.$masterScedule[2].':'.$tmp;}
//echo $new.'<br>';
$file_contents = str_replace("$old","$new",$file_contents);
$handle= fopen($filename,'w');
fputs($handle, $file_contents);
fclose($handle);
echo $file_contents;//"You canceled service for ".$d." of ".$months[$mn]." at ".$t.".00 by Master ".$m;
}

?> 