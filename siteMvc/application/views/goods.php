<?php
$this->load->view('header');

echo '<h2>'.$title.'</h2>';
echo '<table class="table table-striped" >';
foreach($goods as $c)
{
echo '<tr>';
echo '<td>'.$c['title'].'</td>';
echo '<td>'.$c['price'].'</td>';
echo '<td>'.$c['image'].'</td>';
echo '<td>'.$c['info'].'</td>';
echo '</tr>';
}
echo '</table>';

$this->load->view('footer');

