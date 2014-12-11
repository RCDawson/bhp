<?php
$blue = $this->session->flashdata('messages');
if(!empty($blue)) {
	foreach( $this->session->flashdata('messages') as $type => $response )
	echo '<h2>'.$response.'</h2>';
}
?>