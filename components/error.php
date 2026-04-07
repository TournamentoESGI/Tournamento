<?php

function displayPageError($error_message) {
	header("Location: ./?page=404&msg=".$error_message);
	
}

?>

