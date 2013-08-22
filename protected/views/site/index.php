<?php

function getNames($d){
	$names_str='';
	foreach($d as $dd)
		$names_str.=$dd->name.', ';
	return count($d).': '.$names_str;
}
//$dataProvider=new CActiveDataProvider($tabl);
/*
foreach()
$columns=
*/
$a=$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->search(),
	/*'columns'=>array(
        'id','name',
        array(
            'name'=>'Registar Account',
            'value'=>'$data->registarAccount->name',
        ),
        array(
            'name'=>'Hoster Account',
            'value'=>'$data->hosterAccount->name',
        ),
		array(
            'name'=>'Emails',
            'value'=>'getNames($data->emails)',
        ),
    ),*/
));/*
$d=$tabl::model()->findByPk(1);
$a=array_keys($d->tableSchema->columns);
$b=$d->relations();*/
$users=User::model()->findAll();
$this->dbg($users);