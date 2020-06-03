<?php
$this->load->view('header');

	echo "<div class='col-md-offset-1'>";
	echo '<h2>'.$title.'</h2>';
	echo '<h3>'.$good[0]['title'].'</h3>';
	echo '<p>'.$good[0]['price'].'</p>';
	echo '<p style="color:red;font-size:14pt;>'.$good[0]['image'].'</p>';
	echo '<p>'.$good[0]['info'].'</p>';
	echo "</div>";

	$this->load->view('footer');
