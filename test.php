<?php

$host = 'www.payment.cdu.com.ph';
$up = ping($host);

// if site is up, send them to the site.
if( $up ) {
        //header('Location: http://'.$host);
		echo "UP";
}
// otherwise, take them to another one of our sites and show them a descriptive message
else {
        echo "DOWN";
}


function ping($host,$port=80,$timeout=6)
{
        $fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
        if ( ! $fsock )
        {
                return FALSE;
        }
        else
        {
                return TRUE;
        }
}
?>