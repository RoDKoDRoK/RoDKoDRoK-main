<?php

//chain des fichiers ark to load
$arkchain=array();

$arkchain[]=array();
$arkchain[count($arkchain)-1]['file']="load";
$arkchain[count($arkchain)-1]['makevar']=true;
$arkchain[count($arkchain)-1]['class']="Load";
$arkchain[count($arkchain)-1]['var']="loader";

$arkchain[]=array();
$arkchain[count($arkchain)-1]['file']="arkitect";
$arkchain[count($arkchain)-1]['makevar']=true;
$arkchain[count($arkchain)-1]['class']="arkitect";
$arkchain[count($arkchain)-1]['var']="arkitect";

$arkchain[]=array();
$arkchain[count($arkchain)-1]['file']="instanciator";
$arkchain[count($arkchain)-1]['makevar']=true;
$arkchain[count($arkchain)-1]['class']="instanciator";
$arkchain[count($arkchain)-1]['var']="instanciator";


?>