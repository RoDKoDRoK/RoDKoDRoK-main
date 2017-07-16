<?php

//list des packages to deploy dans l'ordre
$tabpackagetodeploy=array();

//PREMIERS PACKAGES OBLIGATOIRES PAR DEFAUT POUR TOUT DEPLOIEMENT !!!!!!!!!!!!!!!!!!!!!!
//packages src.ark
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="ark.starter";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//packages chain.default
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.default";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;
//...packages chain.default


//VOTRE CHAINE DE DEPLOIEMENT

//PACKAGES BEFORE DB !!!

//STARTER
//packages abstract.starter
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="abstract.starter";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

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

//packages chain.xml
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.xml";

//packages chain.json
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.json";

//packages chain.cron
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.cron";

//packages chain.virtualtask
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.virtualtask";

//packages chain.terminal
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.terminal";




//ABSTRACT ONLY
//PRATIK STARTER
//packages abstract.pratik
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="abstract.pratik";

//TASK STARTER
//packages abstract.task
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="abstract.task";




//CONF ONLY
//packages conf.wysiwyg
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="conf.wysiwyg";

//packages arkitect.extension.starter
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="arkitect.extension.starter";

//packages arkitect.extension.mirror
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="arkitect.extension.mirror";





//INTEGRATE
//packages db
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.db.nodb";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.db.mysql";

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.db.mysqli";


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


//packages formater
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.formater.link.origin";


//packages dump
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.dump.nodump";

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.dump.mysql";


//packages user
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.user.nouser";


//packages token
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.token.notoken";


//packages filestorage
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.filestorage.nofile";




//MIRRORS
//packages mirror
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.mirror";

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.filestorage.mirror";




//PRATIK (IMPORTANTS)
//packages destructor and path
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.destructor";

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.path";

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

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratiklib.form.champs.select";

//package view
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.view";

//package downloader
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.downloader";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//package dump
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.dump";

//package initersimul
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.initersimul";


//PRATIK (MOINS IMPORTANTS, FACULTATIFS)
//package pager
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.pager";

//package search
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.search";




//CONNECTOR

//packages connector.arkitectoutput
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.arkitectoutput";


//CONNECTOR SRC
//packages connector.codeloader (pour les class)
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.codeloader";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//packages integrate.codeloader.phpclass
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.codeloader.phpclass";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;


//CONNECTOR INSTANCIATOR EXTENDED (for driver auto instanciation)
//packages connector.instanciatorextended
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.instanciatorextended";


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




//CONNECTOR INCLUDER
//packages chain.index.classpath
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.index.classpath";

//packages chain.ajax.classpath
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.ajax.classpath";

//packages chain.cron.classpath
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.cron.classpath";

//packages chain.virtualtask.classpath
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.virtualtask.classpath";

//packages chain.xml.classpath
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.xml.classpath";

//packages chain.terminal.classpath
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.terminal.classpath";

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

//packages connector.filestorage
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.filestorage";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//packages connector.variable
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.variable";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;




//MIRRORS AFTER CONNECTOR
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="mirror.dev";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="mirror.share";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;




//DB MAIN DEPLOYMENT !!!

//packages connector.db
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.db";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//packages connector.requestor
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.requestor";

//... DB MAIN DEPLOYMENT !!!




//PACKAGES AFTER DB !!!


//PRATIK WITH DB (IMPORTANTS POUR SITE MANAGEMENT ET LA SUITE)
//package params
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratik.params";




//USER
//packages user to integrate before connector.user
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.user.roduser";

//packages connector.user
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.user";

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

//USER TOKEN
//packages token to integrate before connector.token
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.token.rodtoken";

//packages connector.token
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.token";




//CONTENT WITHOUT VISUAL OUPTUT (WHICH EXECUTE CODE ONLY like server.cron or virtual.virtualtask chains...)
//packages connector.thread.server.cron
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.thread.server.cron";

//packages connector.thread.virtual.virtualtask
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.thread.virtual.virtualtask";

//packages connector.thread.server.terminal
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.thread.server.terminal";

//...CONTENT




//SET CHAIN IS TASK (before EVENT)
//packages chain.cron.istask
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.cron.istask";

//packages chain.virtualtask.istask
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="chain.virtualtask.istask";

//EVENT
//packages rod.eventandtask
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.eventandtask";

//packages connector.event
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.event";


//PACKAGES WITH ACTION ON TABLE EVENTEXECTASK AFTER THAT POINT...

//VIRTUAL TASK FOR CODELOADER FIRST
//packages thread.virtualtask.loadcodefromthread
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="thread.virtualtask.loadcodefromthread";




//CONNECTOR CHAIN AND CONNECTOR PLUS
//packages chain and connector management plus
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.chainandconnector";


//CODELOADER DB INTEGRATION FOR NEXT CODE LOAD
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.codeloader";

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.codeloader.css";

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.codeloader.js";


//CONNECTOR LIB
//packages connector.lib
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.lib";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;




//INTEGRATE WITH LIB
//packages tp
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.tp.smarty";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//packages ajax
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.ajax.jquery";

//packages connector.ajax
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.ajax";
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

//packages case menu
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratiklib.case.menu";

//...CASES




//CONTENT MAIN OUTPUT (like index, ajax, ...)
//packages connector.thread.main.index
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.thread.main.index";
//$tabpackagetodeploy[count($tabpackagetodeploy)-1]['locked']=true;

//packages connector.thread.sub.ajax
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.thread.sub.ajax";

//packages connector.thread.ws.xml
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.thread.ws.xml";

//packages connector.thread.ws.json
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.thread.ws.json";

//...CONTENT



//USER INTERFACE (and token to kill later ? )
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
//packages design.default
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="design.default";

//packages thread.virtualtask.loadcodefromdesign
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="thread.virtualtask.loadcodefromdesign";



//packages connector.message
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.message";



//HEADERFOOTER
//packages connector.headerfooter
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.headerfooter";



//MENUS
//packages menu leftrightcolumn
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="pratiklib.menu.leftrightcolumn";

//packages adminmenu
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.adminmenu";

//packages constructmenu
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.constructmenu";

//packages reportmenu
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.reportmenu";

//...MENUS



//OTHER CONNECTOR

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



//PRATIK WITH DB (FACULTATIFS, MOINS IMPORTANTS)
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
/*
//packages packager
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.packager";

/*
//TODO
//packages mirror
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.mirror";

//packages shareonrkrportal
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.shareonrkrportal";
//...
*/
/*
//packages deployer
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.deployer";
*/
//package multisite
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.multisite";


//packages report
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="integrate.graph.highcharts";

$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="rod.tracker.stats";



//DESIGNS
//packages lib icons (available but a lot of files to load, better to load after deployment with the backoffice)
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="design.iconlib.rodkodrok";


//packages design
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



//END
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="connector.tracker";


//VIRTUAL TASK FOR CODELOADER LAST
//packages thread.virtualtask.loadcodefromthreadcontrol
$tabpackagetodeploy[]=array();
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['type']="none";
$tabpackagetodeploy[count($tabpackagetodeploy)-1]['name']="thread.virtualtask.loadcodefromthreadcontrol";



?>