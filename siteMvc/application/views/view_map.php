<?php
	$this->load->view('header');

	echo '<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyA75_Io2wz28vSQMll7wwHo32tutbq9pRY&hl=en" async="" defer="defer" type="text/javascript"></script>';
	echo "<div class='col-md-offset-2 col-md-10'>";
	echo $map['js'];
	echo $map['html'];
	echo "</div>";

	$this->load->view('footer');
