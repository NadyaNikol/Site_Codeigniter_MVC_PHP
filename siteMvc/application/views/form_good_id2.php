<?php  

$this->load->view('header');
$st['class']='form-horizontal';
echo form_open('index.php/home/getGoodInfo2', $st);
echo '<div class="">';
echo form_label('Select good', 'labgood', array('class'=>'control-label'));
echo '<select name="goodid">';

foreach ($list as $l)
{
	echo '<option value='.$l['id'].'>';
	echo $l['title'];
	echo '</option>';
}
echo '</select>';
echo form_submit(array('name'=>'send','value'=>'Send', 'class'=>'btn btn-success'));
echo '</div>';
echo form_close();
$this->load->view('footer');

