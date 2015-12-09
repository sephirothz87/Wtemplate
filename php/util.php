<?php
function logFileAndEcho($arr) {
	if (! is_array ( $arr )) {
		echo $arr . '<br/>';
		fwrite ( fopen ( "log.txt", "a" ), "[" . date ( 'Y-m-d H:i:s', time () + 60 * 60 * 6 ) . "]" . $arr . "\n" );
		return;
	}
	
	foreach ( $arr as $key => $val ) {
		if (is_array ( $val )) {
			logFileAndEcho ( $val );
		} else {
			echo $val . '<br/>';
			fwrite ( fopen ( "log.txt", "a" ), "[" . date ( 'Y-m-d H:i:s', time () + 60 * 60 * 6 ) . "]" . "[key]" . $key . "\n" );
			fwrite ( fopen ( "log.txt", "a" ), "[" . date ( 'Y-m-d H:i:s', time () + 60 * 60 * 6 ) . "]" . "[value]" . $val . "\n" );
		}
	}
}
function logFile($arr) {
	if (! is_array ( $arr )) {
		fwrite ( fopen ( "log.txt", "a" ), "[" . date ( 'Y-m-d H:i:s', time () + 60 * 60 * 6 ) . "]" . $arr . "\n" );
		return;
	}
	
	foreach ( $arr as $key => $val ) {
		if (is_array ( $val )) {
			logFile ( $val );
		} else {
			fwrite ( fopen ( "log.txt", "a" ), "[" . date ( 'Y-m-d H:i:s', time () + 60 * 60 * 6 ) . "]" . "[key]" . $key . "\n" );
			fwrite ( fopen ( "log.txt", "a" ), "[" . date ( 'Y-m-d H:i:s', time () + 60 * 60 * 6 ) . "]" . "[value]" . $val . "\n" );
		}
	}
}
function logEcho($arr) {
	if (! is_array ( $arr )) {
		echo $arr . '<br/>';
		return;
	}
	
	foreach ( $arr as $key => $val ) {
		if (is_array ( $val )) {
			logFile ( $val );
		} else {
			echo $val . '<br/>';
		}
	}
}
?>