<?php

//list des packages to deploy dans l'ordre
$tabpackagetodeploy=array();

//PREMIER PACKAGE CHAIN OBLIGATOIRE PAR DEFAUT POUR TOUT DEPLOIEMENT !!!!!!!!!!!!!!!!!!!!!!
//packages chain.default
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.default";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;
//...packages chain.default


//VOTRE CHAINE DE DEPLOIEMENT

//PACKAGES BEFORE DB !!!

//FILES
//packages files.starter
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="files.starter";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;



//CHAIN
//packages chain.index
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.index";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//packages chain.ajax
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.ajax";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//packages chain.ws
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.ws";

//packages chain.cron
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.cron";

//packages chain.terminal
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.terminal";




//INTEGRATE
//packages tp
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.tp.smarty";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;


//packages db
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.db.nodb";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.db.mysql";


//packages log
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.log.nolog";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.log.rodfilelog";


//packages cache
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.cache.nocache";



//packages access
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.access.nodroit";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;


//packages ajax
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.ajax.jquery";


//packages formater
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.formater.link.origin";




//PRATIK
//packages form
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.form";

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratiklib.form.customsubmit.db";

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratiklib.form.customsubmit.mail";

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratiklib.form.customsubmit.conf";

//package view
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.view";

//package downloader
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.downloader";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;




//CONNECTOR

//CONNECTOR SRC
//packages connector.classloader
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.classloader";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;


//CONNECTOR CONF
//packages connector.conf
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.conf";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;


//CONNECTOR LOG
//packages connector.log
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.log";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;




//LANG
//packages lang
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="lang.fr_fr";




//CONNECTOR LIB
//packages connector.lib
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.lib";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//packages connector.includer
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.includer";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//packages connector.formater
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.formater";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//packages connector.variable
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.variable";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;




//DB MAIN DEPLOYMENT !!!

//packages connector.db
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.db";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//... DB MAIN DEPLOYMENT !!!




//PACKAGES AFTER DB !!!

//DROIT
//packages access to integrate before connector.droit
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.access.roddroit";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//packages connector.droit
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.droit";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;



//SITE MANAGEMENT (AFTER DROIT BEFORE USER AND DESIGN)
//packages site management
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.menu";

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.caseandcolonne";

//CASES
//packages case login
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratiklib.case.login";

//...CASES



//USER
//packages user and token
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.user";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.token";



// AFTER DB, USER AND DROIT !!!!



//TEMPLATE
//packages connector.tp
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.tp";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;



//DESIGN
//packages connector.design
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.design";

//packages design
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="design.default";



//packages connector.js
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.js";

//packages connector.message
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.message";



//HEADERFOOTER
//packages connector.headerfooter
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.headerfooter";



//CONTENT
//packages connector.content
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.content";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//packages connector.lang
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.lang";

//packages connector.cache
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.cache";

//CONNECTOR END




//INTEGRATE WITH DB
//packages log
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.log.roddblog";

//packages cache
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.cache.rodcachedb";

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.cache.rodcache";



//PRATIK WITH DB
//package mail
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.mail";



//ROD FUNCTIONNALITIES PACK WITH DB
//packages dbmaker
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.dbmaker";

//packages packagemanager
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.package";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;




//DESIGNS
//packages lib icons (available but a lot of files to load, better to load after deployment with the backoffice)
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="design.iconlib.rodkodrok";


//packages design.default
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="design.yours";

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="design.rodkodrokstarter";



//PRATIKLIB ADDONS




//EXAMPLE
//packages example (available, you can uncomment to load example files on your site)
/*$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.example";*/





?>