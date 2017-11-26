<?php

function LogMsg($logfile,$logname,$the_string){
	$m = substr(number_format(microtime(),3),2,3);
	if( $fh = @fopen($logfile.$logname."_".date('Ymd').".txt","a+") ){
		fputs( $fh, "\n".date('Y-m-d H:i:s:'.$m)." ".$the_string, "\n".date('Y-m-d H:i:s'.$m)." ".$the_string );
		fclose( $fh );
		return( true );
	}else{
		return( false );
	}
}

?>
