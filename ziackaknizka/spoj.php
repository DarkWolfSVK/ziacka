<?php 
//spoj s db

/*databaza:gieciova_lukasDAT
meno:gieciova_lukas
heslo:lukasando*/

function spoj_s_db() {
	if ($link = mysql_connect('maxliving.sk', 'gieciova_mato', 'mato')) {
		if (mysql_select_db('gieciova_najsamlepsiadatabazka', $link)) {
			mysql_query("SET CHARACTER SET 'utf8'", $link); 
			echo 'vporiadku pirpojiiiiiiiiil';
			return $link;
		} else {
			// NEpodarilo sa vybraAY databA!zu!
			echo 'zla databaza';
			return false;
		}
	} else {
		// NEpodarilo sa spojiAY s databA!zovA1m serverom!
		echo 'zly server';
		return false;
	}
}

spoj_s_db();
?>