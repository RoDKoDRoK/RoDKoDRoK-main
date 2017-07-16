<?php

class PratikPackage extends ClassIniter
{
	var $conflictresolution="force";
	var $conflictfolder="core/files/conflict";
	
	var $folderdestdownload="core/files/packagezip/";
	var $folderdestarchives="core/files/packageziparchived/";
	var $folderdestpackage="package/";
	
	var $chemingeneratortpl="deploy/deploytpl/generator.tpl";
	

	function __construct($initer=array())
	{
		parent::__construct($initer);
		
		//init conflictresolution
		if(isset($this->conf['conflictresolution']))
			$this->conflictresolution=$this->conf['conflictresolution'];
		
	}
	
	
	function deploy($packagecodename="example")
	{
		//conflict init
		if($this->conflictresolution!=null && !is_dir($this->conflictfolder))
			mkdir($this->conflictfolder,0777,true);
		
		//deploy package
		$this->initer['packagecodename']=$packagecodename;
		$classpackagename="";
		$tabclassname=explode(".",$packagecodename);
		foreach($tabclassname as $classnamecour)
			$classpackagename.=ucfirst(strtolower($classnamecour));
		
		
		if(file_exists("package/".$packagecodename))
		{
			//tab deployed files
			$tabdeployedfiles=array();
		
			//include descripter
			$this->initer['descripter']=array();
			if(file_exists("package/".$packagecodename."/package.descripter.php"))
				include "package/".$packagecodename."/package.descripter.php";
			if(isset($descripter))
				$this->initer['descripter']=$descripter;
			
			//load conf package
			$confstatic=null;
			if(file_exists("package/".$packagecodename."/conf.package.xml"))
				$confstatic=simplexml_load_file("package/".$packagecodename."/conf.package.xml");
			$this->initer['confstatic']=$confstatic;
			
			//load conf form package
			if(isset($_POST['confform'][$packagecodename]))
				$this->initer['confform'][$packagecodename]=$_POST['confform'][$packagecodename];
			if(isset($_SESSION['confform'][$packagecodename]))
				$this->initer['confform'][$packagecodename]=$_SESSION['confform'][$packagecodename];
			
			//reload initer
			$this->reloadIniter();
			
			
			//include predeployer static
			if(file_exists("package/".$packagecodename."/class/class.static.php"))
			{
				include "package/".$packagecodename."/class/class.static.php";
				eval("\$instanceStatic=new ".$classpackagename."Static(\$this->initer);");
			}
			if(file_exists("package/".$packagecodename."/static/static.predeployer.php"))
				include "package/".$packagecodename."/static/static.predeployer.php";
			
			//reload initer
			$this->reloadIniter();
			
			
			//load db static
			$sqltype=$this->getExtSql();
			$chemin_db_static="package/".$packagecodename."/static/static.db.deployer.".$sqltype;
			if(isset($this->db) && $this->db && file_exists($chemin_db_static))
			{
				//sql exec
				$sqltoload=file_get_contents($chemin_db_static);
				$tabsqltoload=explode(";",$sqltoload);
				foreach($tabsqltoload as $sqlcour)
				{
					$req=$this->db->query($sqlcour);
				}
				
				//filename creation
				$namefilecour=str_replace("package/".$packagecodename."/static/","core/files/db/".$packagecodename.".",$chemin_db_static);
				
				//conflict resolution "keep" mode
				if($this->conflictresolution=="keep")
				{
					$cptconflict="1";
					$conflictnamefilecour=$namefilecour;
					while(file_exists($conflictnamefilecour))
						$conflictnamefilecour=str_replace("core/files/db/","core/files/db/___CONFLICTFILE".($cptconflict++)."___",$namefilecour);
					$namefilecour=$conflictnamefilecour;
				}
				//conflict resolution "reverse" mode
				if($this->conflictresolution!=null)
				{
					//conflict management
					$cptconflict="1";
					if(file_exists($namefilecour))
					{
						do
						{
							$conflictnamefilecour=str_replace("core/files/db/","core/files/db/___CONFLICTFILE".($cptconflict++)."___",$namefilecour);
						}
						while(file_exists($this->conflictfolder."/".$conflictnamefilecour));
						
						if(!is_dir($this->conflictfolder."/core/files/db"))
							mkdir($this->conflictfolder."/core/files/db",0777,true);
						copy($namefilecour,$this->conflictfolder."/".$conflictnamefilecour);
						
						//set conflictfilelist
						$this->addToConflictFile($conflictnamefilecour);
					}
					
					//setup annuaire files in package
					$this->addToFileIsInPackageFile($packagecodename,$namefilecour);
				}
				
				//create file
				file_put_contents($namefilecour,$sqltoload);
				
				//return tab
				$tabdeployedfiles[]=$namefilecour;
			}
			
			//load files static
			foreach($this->initer['chaintab'] as $chaincour)
			{
				$tabfilestoload=$this->loader->charg_dossier_dans_tab("package/".$packagecodename."/static/".$chaincour);
				
				if(isset($tabfilestoload))
					foreach($tabfilestoload as $filecour)
					{
						$folder=substr($filecour,0,strrpos($filecour,"/"));
						$file=substr($filecour,strrpos($filecour,"/"),strlen($filecour)-0-strrpos($filecour,"/"));
					
						if($folder=="package/".$packagecodename."/static/".$chaincour)
							continue;
						
						$folder=str_replace("package/".$packagecodename."/static/".$chaincour."/","",$folder);
					
						if(!is_dir($folder))
							mkdir($folder,0777,true);
						
						//conflict resolution "keep" mode
						if($this->conflictresolution=="keep")
						{
							$cptconflict="1";
							$conflictnamefilecour=$file;
							while(file_exists($folder.$conflictnamefilecour))
								$conflictnamefilecour="/___CONFLICTFILE".($cptconflict++)."___".substr($file,1);
							$file=$conflictnamefilecour;
						}
						//conflict resolution "reverse" mode
						if($this->conflictresolution!=null)
						{
							//conflict management
							$cptconflict="1";
							if(file_exists($folder.$file))
							{
								do
								{
									$conflictnamefilecour="/___CONFLICTFILE".($cptconflict++)."___".substr($file,1);
								}
								while(file_exists($this->conflictfolder."/".$folder.$conflictnamefilecour));
								
								if(!is_dir($this->conflictfolder."/".$folder))
									mkdir($this->conflictfolder."/".$folder,0777,true);
								copy($folder.$file,$this->conflictfolder."/".$folder.$conflictnamefilecour);
								
								//set conflictfilelist
								$this->addToConflictFile($folder.$conflictnamefilecour);
							}
							
							//setup annuaire files in package
							$this->addToFileIsInPackageFile($packagecodename,$folder.$file);
						}
						
						//file create
						copy($filecour,$folder.$file);
						
						//return tab
						$tabdeployedfiles[]=$folder.$file;
					}
			}
			
			//include postdeployer static
			if(file_exists("package/".$packagecodename."/static/static.postdeployer.php"))
				include "package/".$packagecodename."/static/static.postdeployer.php";
			
			//reload initer
			$this->reloadIniter();
			
			
			
			
			//load conf package generator
			$confgenerator=null;
			if(file_exists("package/".$packagecodename."/conf.generator.xml"))
				$confgenerator=simplexml_load_file("package/".$packagecodename."/conf.generator.xml");
			$this->initer['confgenerator']=$confgenerator;
			
			//reload initer
			$this->reloadIniter();
			
			//include predeployer generator
			$instanceGenerator=new PackageGenerator($this->initer);
			if(file_exists("package/".$packagecodename."/class/class.generator.php"))
			{
				include "package/".$packagecodename."/class/class.generator.php";
				eval("\$instanceGenerator=new ".$classpackagename."Generator(\$this->initer);");
			}
			if(file_exists("package/".$packagecodename."/generator/generator.predeployer.php"))
				include "package/".$packagecodename."/generator/generator.predeployer.php";
			
			//reload initer
			$this->reloadIniter();
			
			
			//load db generator
			$chemin_db_generator_tpl="package/".$packagecodename."/generator/generator.db.deployer.__INSTANCE__.".$sqltype.".tpl";
			if(isset($this->db) && $this->db && file_exists($chemin_db_generator_tpl))
			{
				//pour chaque instance à générer
				foreach($confgenerator->instance as $instance)
				{
					//generate sql
					$instanceTpl=new Tp($this->conf,$this->log,"backoffice");
					$tpl=$instanceTpl->tpselected;
					
					//include generator conf tpl
					$tabgeneratorconftpl=$this->loader->charg_generatorconftpl_dans_tab("package/".$packagecodename."/generator");
					$tpl->remplir_template("generatorconf",$tabgeneratorconftpl);
					
					//include generator file cour
					$tpl->remplir_template("chemintpltogenerate",$chemin_db_generator_tpl);
					
					//preparedatafortpl
					$datafortpl=array();
					if(isset($instanceGenerator))
						$datafortpl=$instanceGenerator->prepareDataForTpl($instance);
					
					foreach($datafortpl as $iddatafortpl=>$contentdatafortpl)
						$tpl->remplir_template($iddatafortpl,$contentdatafortpl);
					
					//generate file with tpl
					$contentfilecour=$tpl->get_template($this->chemingeneratortpl);
					
					$namefilecour=str_replace("__INSTANCE__",$instance->name,$chemin_db_generator_tpl);
					$namefilecour=substr($namefilecour,0,-4);
					$namefilecour=str_replace("package/".$packagecodename."/generator/","core/files/db/".$packagecodename.".",$namefilecour);
					
					//conflict resolution "keep" mode
					if($this->conflictresolution=="keep")
					{
						$cptconflict="1";
						$conflictnamefilecour=$namefilecour;
						while(file_exists($conflictnamefilecour))
							$conflictnamefilecour=str_replace("core/files/db/","core/files/db/___CONFLICTFILE".($cptconflict++)."___",$namefilecour);
						$namefilecour=$conflictnamefilecour;
					}
					//conflict resolution "reverse" mode
					if($this->conflictresolution!=null)
					{
						//conflict management
						$cptconflict="1";
						if(file_exists($namefilecour))
						{
							do
							{
								$conflictnamefilecour=str_replace("core/files/db/","core/files/db/___CONFLICTFILE".($cptconflict++)."___",$namefilecour);
							}
							while(file_exists($this->conflictfolder."/".$conflictnamefilecour));
							
							if(!is_dir($this->conflictfolder."/core/files/db"))
								mkdir($this->conflictfolder."/core/files/db",0777,true);
							copy($namefilecour,$this->conflictfolder."/".$conflictnamefilecour);
							
							//set conflictfilelist
							$this->addToConflictFile($conflictnamefilecour);
						}
						
						//setup annuaire files in package
						$this->addToFileIsInPackageFile($packagecodename,$namefilecour);
					}
					
					//file create
					file_put_contents($namefilecour,$contentfilecour);
					
					
					//return tab
					$tabdeployedfiles[]=$namefilecour;
						
					
					//load db
					$sqltoload=file_get_contents($namefilecour);
					$tabsqltoload=explode(";",$sqltoload);
					foreach($tabsqltoload as $sqlcour)
					{
						$req=$this->db->query($sqlcour);
					}
				}
			}
			
			
			
			
			//load files generator
			foreach($this->initer['chaintab'] as $chaincour)
			{
				$tabfilestoload=$this->loader->charg_dossier_dans_tab("package/".$packagecodename."/generator/".$chaincour);
				
				if(isset($tabfilestoload))
					foreach($tabfilestoload as $filecour)
					{
						$folder=substr($filecour,0,strrpos($filecour,"/"));
						$file=substr($filecour,strrpos($filecour,"/"),strlen($filecour)-4-strrpos($filecour,"/"));
					
						if($folder=="package/".$packagecodename."/generator/".$chaincour)
							continue;
						
						
						$folder=str_replace("package/".$packagecodename."/generator/".$chaincour."/","",$folder);
					
						if(!is_dir($folder))
							mkdir($folder,0777,true);
							
						
						
						//pour chaque instance à générer
						if($confgenerator && $confgenerator->instance)
							foreach($confgenerator->instance as $instance)
							{
								//prepare chemin file with instance
								$file_generate=str_replace("__INSTANCE__",$instance->name,$file);
								
								//conflict resolution "keep" mode
								if($this->conflictresolution=="keep")
								{
									$cptconflict="1";
									$conflictnamefilecour=$file_generate;
									while(file_exists($folder.$conflictnamefilecour))
										$conflictnamefilecour="/___CONFLICTFILE".($cptconflict++)."___".substr($file_generate,1);
									$file_generate=$conflictnamefilecour;
								}
								//conflict resolution "reverse" mode
								if($this->conflictresolution!=null)
								{
									//conflict management
									$cptconflict="1";
									if(file_exists($folder.$file_generate))
									{
										do
										{
											$conflictnamefilecour="/___CONFLICTFILE".($cptconflict++)."___".substr($file_generate,1);
										}
										while(file_exists($this->conflictfolder."/".$folder.$conflictnamefilecour));
										
										if(!is_dir($this->conflictfolder."/".$folder))
											mkdir($this->conflictfolder."/".$folder,0777,true);
										copy($folder.$file_generate,$this->conflictfolder."/".$folder.$conflictnamefilecour);
										
										//set conflictfilelist
										$this->addToConflictFile($folder.$conflictnamefilecour);
									}
									
									//setup annuaire files in package
									$this->addToFileIsInPackageFile($packagecodename,$folder.$file_generate);
								}
								
								//chemin file ok
								$chemin_file_generator_tpl=$folder.$file_generate;
								
								
								//generate file
								$instanceTpl=new Tp($this->conf,$this->log,"backoffice");
								$tpl=$instanceTpl->tpselected;
								
								//include generator conf tpl
								$tabgeneratorconftpl=$this->loader->charg_generatorconftpl_dans_tab("package/".$packagecodename."/generator");
								$tpl->remplir_template("generatorconf",$tabgeneratorconftpl);
								
								//include generator file cour
								$tpl->remplir_template("chemintpltogenerate",$filecour);
								
								//preparedatafortpl
								$datafortpl=array();
								if(isset($instanceGenerator))
									$datafortpl=$instanceGenerator->prepareDataForTpl($instance);
								
								foreach($datafortpl as $iddatafortpl=>$contentdatafortpl)
									$tpl->remplir_template($iddatafortpl,$contentdatafortpl);
								
								//generate file with tpl
								$contentfilecour=$tpl->get_template($this->chemingeneratortpl);
								
								
								file_put_contents($chemin_file_generator_tpl,$contentfilecour);
								
								
								//return tab
								$tabdeployedfiles[]=$chemin_file_generator_tpl;
							}
						
					}
			}
			
			
			
			//include postdeployer generator
			if(file_exists("package/".$packagecodename."/generator/generator.postdeployer.php"))
				include "package/".$packagecodename."/generator/generator.postdeployer.php";
			
			//reload initer
			$this->reloadIniter();
			
			
			if(isset($this->db) && $this->db)
				$this->db->query("update `package` set deployed='1' where nomcodepackage='".$packagecodename."'");
			
			return $tabdeployedfiles;
		}
		
		return array();
	}
	
	
	
	function destroy($packagecodename="example")
	{
		//destroy package
		$this->initer['packagecodename']=$packagecodename;
		$classpackagename="";
		$tabclassname=explode(".",$packagecodename);
		foreach($tabclassname as $classnamecour)
			$classpackagename.=ucfirst(strtolower($classnamecour));
			
		if(file_exists("package/".$packagecodename))
		{		
			//include descripter
			$this->initer['descripter']=array();
			if(file_exists("package/".$packagecodename."/package.descripter.php"))
				include "package/".$packagecodename."/package.descripter.php";
			if(isset($descripter))
				$this->initer['descripter']=$descripter;
			
			//load conf package
			$confstatic=null;
			if(file_exists("package/".$packagecodename."/conf.package.xml"))
				$confstatic=simplexml_load_file("package/".$packagecodename."/conf.package.xml");
			$this->initer['confstatic']=$confstatic;
			
			//get conf form saved (already present in $this->conf)
			$this->initer['confform']=null;
			
			//reload initer
			$this->reloadIniter();
			
			
			
			//include predestroyer static
			$instanceStatic=null;
			if(file_exists("package/".$packagecodename."/class/class.static.php"))
			{
				include "package/".$packagecodename."/class/class.static.php";
				eval("\$instanceStatic=new ".$classpackagename."Static(\$this->initer);");
			}
			if(file_exists("package/".$packagecodename."/static/static.predestroyer.php"))
				include "package/".$packagecodename."/static/static.predestroyer.php";
			
			//reload initer
			$this->reloadIniter();
			
			
			//kill db static
			$sqltype=$this->getExtSql();
			if(isset($this->db) && $this->db && file_exists("package/".$packagecodename."/static/static.db.destroyer.".$sqltype))
			{
				$sqltoload=file_get_contents("package/".$packagecodename."/static/static.db.destroyer.".$sqltype);
				$tabsqltoload=explode(";",$sqltoload);
				foreach($tabsqltoload as $sqlcour)
				{
					$req=$this->db->query($sqlcour);
				}
			}
			
			//kill files static
			foreach($this->initer['chaintab'] as $chaincour)
			{
				$tabfilestoload=$this->loader->charg_dossier_dans_tab("package/".$packagecodename."/static/".$chaincour);
				
				if($tabfilestoload)
					foreach($tabfilestoload as $filecour)
					{
						$folder=substr($filecour,0,strrpos($filecour,"/"));
						$file=substr($filecour,strrpos($filecour,"/"),strlen($filecour)-0-strrpos($filecour,"/"));
					
						if($folder=="package/".$packagecodename."/static/".$chaincour)
							continue;
						
						$folder=str_replace("package/".$packagecodename."/static/".$chaincour."/","",$folder);
						
						if(file_exists($folder.$file))
						{
							//conflict "reverse" mode
							if($this->conflictresolution!=null)
							{
								//maj fileisinpackage.php
								$this->addToFileIsInPackageFile($packagecodename,$folder.$file,"unset");
								
								if($this->conflictresolution=="force" || $this->conflictresolution=="keep")
									unlink($folder.$file);
								
								//check if a conflict file exists ___CONFLICT... else suppr file and continue
								if(!file_exists($this->conflictfolder."/".$folder."/___CONFLICTFILE1___".substr($file,1)))
								{
									if(file_exists($folder.$file))
										unlink($folder.$file);
									continue;
								}
								
								//if a conflict file exists, find conflict for this package codename in tabconflict in conflict.php
								include $this->conflictfolder."/conflict.php";
								$cptconflict="1";
								$filecour=$folder."/___CONFLICTFILE".$cptconflict."___".substr($file,1);
								$conflictfile="";
								$cptconflictfound=0;
								while(file_exists($this->conflictfolder."/".$filecour))
								{
									$tabid=str_replace("/","-----",$filecour);
									if(isset($tabconflict[$tabid]) && $tabconflict[$tabid]==$packagecodename)
									{
										$conflictfile=$filecour;
										$cptconflictfound=$cptconflict;
										break;
									}
									
									$cptconflict++;
									$filecour=$folder."/___CONFLICTFILE".$cptconflict."___".substr($file,1);
								}
								
								//if not found, suppr file and move last conflict file instead of it
								if($conflictfile=="")
								{
									//suppr file
									unlink($folder.$file);
									//move last conflict file to official file
									$cptconflictlast=(--$cptconflict);
									if($this->conflictresolution=="reverse")
										rename($this->conflictfolder."/".$folder."/___CONFLICTFILE".$cptconflictlast."___".substr($file,1),$folder.$file);
									//clear last conflict file (check kill and clear in $tabconflict in conflict.php)
									if(file_exists($this->conflictfolder."/".$folder."/___CONFLICTFILE".$cptconflictlast."___".substr($file,1)))
										unlink($this->conflictfolder."/".$folder."/___CONFLICTFILE".$cptconflictlast."___".substr($file,1));
									//rewrite conflict files in tabconflict in conflict.php (add new lines with unset($tabconflict[lastconflictile]) )
									$filecour=$this->conflictfolder."/".$folder."/___CONFLICTFILE".$cptconflictlast."___".substr($file,1);
									$this->addToConflictFile($filecour,"unset");
								}
								//if conflict found, suppr conflict and reorder the next ones and rewrite them in tabconflict in conflict.php and DO NOT suppr file in use
								else
								{
									//suppr conflict file
									unlink($this->conflictfolder."/".$conflictfile);
									
									//reorder next conflict files
									$cptconflict=(++$cptconflictfound);
									$filecour=$folder."/___CONFLICTFILE".$cptconflict."___".substr($file,1);
									while(file_exists($this->conflictfolder."/".$filecour))
									{
										//move to prec conflict file
										$destfilecour=$folder."/___CONFLICTFILE".($cptconflict-1)."___".substr($file,1);
										rename($this->conflictfolder."/".$filecour,$this->conflictfolder."/".$destfilecour);
										
										//rewrite conflict files in tabconflict in conflict.php (add new lines with $tabconflict[cour]=$tabconflict[prec] or unset($tabconflict[cour]) )
										$this->addToConflictFile($filecour,"update",array('destfile'=>$destfilecour));
										
										//next
										$cptconflict++;
										$filecour=$folder."/___CONFLICTFILE".$cptconflict."___".substr($file,1);
									}
									
									//end rewrite conflict files in tabconflict in conflict.php (unset($tabconflict[cour] for last conflict file) )
									$filecour=$folder."/___CONFLICTFILE".($cptconflict-1)."___".substr($file,1);
									$this->addToConflictFile($filecour,"unset");
									
								}
							}
							else
							{
								//suppr file
								unlink($folder.$file);
							}
						}
					}
			}
			
			
				
			//include postdestroyer static
			if(file_exists("package/".$packagecodename."/static/static.postdestroyer.php"))
				include "package/".$packagecodename."/static/static.postdestroyer.php";
			
			//reload initer
			$this->reloadIniter();
			
			
			
			
			//load conf package generator
			$confgenerator=null;
			if(file_exists("package/".$packagecodename."/conf.generator.xml"))
				$confgenerator=simplexml_load_file("package/".$packagecodename."/conf.generator.xml");
			$this->initer['confgenerator']=$confgenerator;
			
			//reload initer
			$this->reloadIniter();
			
			//include predestroyer generator
			$instanceGenerator=null;
			if(file_exists("package/".$packagecodename."/class/class.generator.php"))
			{
				include "package/".$packagecodename."/class/class.generator.php";
				eval("\$instanceGenerator=new ".$classpackagename."Generator(\$this->initer);");
			}
			if(file_exists("package/".$packagecodename."/generator/generator.predestroyer.php"))
				include "package/".$packagecodename."/generator/generator.predestroyer.php";
			
			//reload initer
			$this->reloadIniter();
			
			
			
			//kill db generator
			$chemin_db_generator_tpl="package/".$packagecodename."/generator/generator.db.destroyer.__INSTANCE__.".$sqltype.".tpl";
			if(isset($this->db) && $this->db && file_exists($chemin_db_generator_tpl))
			{
				//pour chaque instance à générer
				foreach($confgenerator->instance as $instance)
				{
					//generate sql
					$instanceTpl=new Tp($this->conf,$this->log,"backoffice");
					$tpl=$instanceTpl->tpselected;
					
					//include generator conf tpl
					$tabgeneratorconftpl=$this->loader->charg_generatorconftpl_dans_tab("package/".$packagecodename."/generator");
					$tpl->remplir_template("generatorconf",$tabgeneratorconftpl);
					
					//include generator file cour
					$tpl->remplir_template("chemintpltogenerate",$chemin_db_generator_tpl);
					
					//preparedatafortpl
					$datafortpl=array();
					if(isset($instanceGenerator))
						$datafortpl=$instanceGenerator->prepareDataForTpl($instance);
					
					foreach($datafortpl as $iddatafortpl=>$contentdatafortpl)
						$tpl->remplir_template($iddatafortpl,$contentdatafortpl);
					
					//generate file with tpl
					$contentfilecour=$tpl->get_template($this->chemingeneratortpl);
					
					$namefilecour=str_replace("__INSTANCE__",$instance->name,$chemin_db_generator_tpl);
					$namefilecour=substr($namefilecour,0,-4);
					
					file_put_contents($namefilecour,$contentfilecour);
					
					
					//load db
					$sqltoload=file_get_contents($namefilecour);
					$tabsqltoload=explode(";",$sqltoload);
					foreach($tabsqltoload as $sqlcour)
					{
						$req=$this->db->query($sqlcour);
					}
				}
			}
			
			
			
			
			//kill files generator
			foreach($this->initer['chaintab'] as $chaincour)
			{
				$tabfilestoload=$this->loader->charg_dossier_dans_tab("package/".$packagecodename."/generator/".$chaincour);
				
				if($tabfilestoload)
					foreach($tabfilestoload as $filecour)
					{
						$folder=substr($filecour,0,strrpos($filecour,"/"));
						$file=substr($filecour,strrpos($filecour,"/"),strlen($filecour)-4-strrpos($filecour,"/"));
					
						if($folder=="package/".$packagecodename."/generator/".$chaincour)
							continue;
									
						$folder=str_replace("package/".$packagecodename."/generator/".$chaincour."/","",$folder);
							

						//pour chaque instance à générer
						foreach($confgenerator->instance as $instance)
						{
							//prepare chemin file with instance
							$file_generate=str_replace("__INSTANCE__",$instance->name,$file);
							$chemin_file_generator_tpl=$folder.$file_generate;
							
							if(file_exists($chemin_file_generator_tpl))
							{
								//conflict "reverse" mode
								if($this->conflictresolution!=null)
								{
									//maj fileisinpackage.php
									$this->addToFileIsInPackageFile($packagecodename,$folder.$file_generate,$action="unset");
									
									if($this->conflictresolution=="force" || $this->conflictresolution=="keep")
										unlink($folder.$file_generate);
									
									//check if a conflict file exists ___CONFLICT... else suppr file and continue
									if(!file_exists($this->conflictfolder."/".$folder."/___CONFLICTFILE1___".substr($file_generate,1)))
									{
										if(file_exists($folder.$file_generate))
											unlink($folder.$file_generate);
										continue;
									}
									
									//if a conflict file exists, find conflict for this package codename in tabconflict in conflict.php
									include $this->conflictfolder."/conflict.php";
									$cptconflict="1";
									$filecour=$folder."/___CONFLICTFILE".$cptconflict."___".substr($file_generate,1);
									$conflictfile="";
									$cptconflictfound=0;
									while(file_exists($this->conflictfolder."/".$filecour))
									{
										$tabid=str_replace("/","-----",$filecour);
										if(isset($tabconflict[$tabid]) && $tabconflict[$tabid]==$packagecodename)
										{
											$conflictfile=$tabid;
											$cptconflictfound=$cptconflict;
											break;
										}
										
										$cptconflict++;
										$filecour=$folder."/___CONFLICTFILE".$cptconflict."___".substr($file_generate,1);
									}
									
									//if not found, suppr file and move last conflict file instead of it
									if($conflictfile=="")
									{
										//suppr file
										unlink($folder.$file_generate);
										//move last conflict file to official file
										$cptconflictlast=(--$cptconflict);
										if($this->conflictresolution=="reverse")
											rename($this->conflictfolder."/".$folder."/___CONFLICTFILE".$cptconflictlast."___".substr($file_generate,1),$folder.$file_generate);
										//clear last conflict file (check kill and clear in $tabconflict in conflict.php)
										if(file_exists($this->conflictfolder."/".$folder."/___CONFLICTFILE".$cptconflictlast."___".substr($file_generate,1)))
											unlink($this->conflictfolder."/".$folder."/___CONFLICTFILE".$cptconflictlast."___".substr($file_generate,1));
										//rewrite conflict files in tabconflict in conflict.php (add new lines with unset($tabconflict[lastconflictile]) )
										$filecour=$this->conflictfolder."/".$folder."/___CONFLICTFILE".$cptconflictlast."___".substr($file_generate,1);
										$this->addToConflictFile($filecour,"unset");
									}
									//if conflict found, suppr conflict and reorder the next ones and rewrite them in tabconflict in conflict.php and DO NOT suppr file in use
									else
									{
										//suppr conflict file
										unlink($this->conflictfolder."/".$conflictfile);
										
										//reorder next conflict files
										$cptconflict=(++$cptconflictfound);
										$filecour=$folder."/___CONFLICTFILE".$cptconflict."___".substr($file_generate,1);
										while(file_exists($this->conflictfolder."/".$filecour))
										{
											//move to prec conflict file
											$destfilecour=$folder."/___CONFLICTFILE".($cptconflict-1)."___".substr($file_generate,1);
											rename($this->conflictfolder."/".$filecour,$this->conflictfolder."/".$destfilecour);
											
											//rewrite conflict files in tabconflict in conflict.php (add new lines with $tabconflict[cour]=$tabconflict[prec] or unset($tabconflict[cour]) )
											$this->addToConflictFile($filecour,"update",array('destfile'=>$destfilecour));
											
											//next
											$cptconflict++;
											$filecour=$folder."/___CONFLICTFILE".$cptconflict."___".substr($file_generate,1);
										}
										
										//end rewrite conflict files in tabconflict in conflict.php (unset($tabconflict[cour] for last conflict file) )
										$filecour=$folder."/___CONFLICTFILE".($cptconflict-1)."___".substr($file_generate,1);
										$this->addToConflictFile($filecour,"unset");
										
									}
								}
								else
								{
									unlink($chemin_file_generator_tpl);
								}
							}
						}
						
					}
			}
			
			
				
			//include postdestroyer generator
			if(file_exists("package/".$packagecodename."/generator/generator.postdestroyer.php"))
				include "package/".$packagecodename."/generator/generator.postdestroyer.php";
			
			//reload initer
			$this->reloadIniter();
			
			
			if(isset($this->db) && $this->db)
				$this->db->query("update `package` set deployed='0' where nomcodepackage='".$packagecodename."'");
		}
		
	}
	
	
	
	
	
	
	
	
	function preparePackageConfForm($packagecodename="example")
	{
		$preform=array();
		
		$preform['classicform']=true;
		
		$preform['deployconfirmbutton']=true;
		$preform['destroyconfirmbutton']=true;
		$preform['updateconfirmbutton']=true;
		
		$preform['hiddencodename']=true;
		
		$confform=null;
		if(file_exists("package/".$packagecodename."/conf.form.xml"))
		{
			$confform=simplexml_load_file("package/".$packagecodename."/conf.form.xml");
		
			$form=$confform->form;
			foreach($form->field as $field)
			{
				$preform['lineform'][]=array();
				$preform['lineform'][count($preform['lineform']) -1]['label']=$field->label;
				$preform['lineform'][count($preform['lineform']) -1]['name']="confform[".$packagecodename."][".$field->name."]";
				$preform['lineform'][count($preform['lineform']) -1]['default']=$field->default;
				$preform['lineform'][count($preform['lineform']) -1]['champs']="text";
			}
		}
		
		return $preform;
	}
	
	
	
	
	function rrmdir($dir) {
	   if (is_dir($dir)) {
		 $objects = scandir($dir);
		 foreach ($objects as $object) {
		   if ($object != "." && $object != "..") {
			 if (filetype($dir."/".$object) == "dir"){
				$this->rrmdir($dir."/".$object);
			 }else{ 
				unlink($dir."/".$object);
			 }
		   }
		 }
		 reset($objects);
		 rmdir($dir);
	  }
	}
	
	
	function getPackageFromRoDKoDRoKCom($packagecodename="example",$update="")
	{
		if(file_exists("package/".$packagecodename) && $update)
		{
			//zip and archive old package with date in filename
			if($this->zipAndArchivePackage($packagecodename))
			{
				//kill old package
				$dir = "package/".$packagecodename;
				$this->rrmdir($dir);
			}
		}
		
		if(!file_exists("package/".$packagecodename))
		{
			//upload package zip from url
			$force=false;
			if($update)
				$force=true;
			$downloaded=$this->downloadPackageFromUrl($packagecodename,$force);
			
			//dezip package
			if($downloaded)
				if($this->unzipPackage($packagecodename))
				{
					//update db for new package
					if(isset($this->db))
					{
						$descripter=array();
						$descripter['name']="";
						$descripter['description']="";
						$descripter['version']="";
						$descripter['groupe']="";
						
						if(file_exists("package/".$packagecodename."/package.descripter.php"))
							include "package/".$packagecodename."/package.descripter.php";
						
						
						//update dans la db
						$this->db->query("update `package` set nompackage='".$descripter['name']."', groupepackage='".$descripter['groupe']."', description='".$descripter['description']."', version='".$descripter['version']."' where nomcodepackage='".$packagecodename."'");
						
						//ajout des dependances
						if(isset($descripter['depend']) && is_array($descripter['depend']))
							foreach($descripter['depend'] as $dependcour)
								if($dependcour!="")
									$this->db->query("insert into `package_depends_on` (`nomcodepackage`, `nomcodedepend`) values ('".$packagecodename."','".$dependcour."')");
				
					}
					
					return true;
				}
			
			return false;
		}
		
		return true;
	}
	
	
	
	function downloadPackageFromUrl($packagecodename="example",$force=false)
	{
		$folderdest=$this->folderdestdownload;
		$filename=$packagecodename.".zip";
		
		//folder packages downloaded
		if(!is_dir($folderdest))
			mkdir($folderdest,0777,true);
		
		//kill old file if force
		if(file_exists($folderdest.$filename))
			if($force)
				unlink($folderdest.$filename);
			else
				return true;
		
		//search download mirror and upload new file
		$filelink="";
		if(class_exists("PratikDownloader") || (isset($this->includer) && $this->includer->include_pratikclass("Downloader")))
		{
			$donwloader=new PratikDownloader($this->initer);
			$filelink=$donwloader->getFileLink($filename,"packages");
		}
		if($filelink!="")
		{
			$filedata=file_get_contents($filelink);
			file_put_contents($folderdest.$filename,$filedata);
			chmod($folderdest.$filename, 0777);
			
			return true;
		}
		
		return false;
	}
	
	
	
	function unzipPackage($packagecodename="example")
	{
		$folderzip=$this->folderdestdownload;
		$folderdestunzip=$this->folderdestpackage;
		$filename=$packagecodename.".zip";
		
		if(file_exists($folderzip.$filename))
		{
			//unzip
			$zip = new ZipArchive;
			$res = $zip->open($folderzip.$filename);
			if ($res === TRUE) {
				$zip->extractTo($folderdestunzip);
				$zip->close();
				return true;
			}
			
		}
		
		return false;
	}
	
	
	
	function zipAndArchivePackage($packagecodename="example")
	{
		$folderpackage=$this->folderdestpackage;
		$folderdestzipandarchive=$this->folderdestarchives;
		$filename=date("YmdHis_____").$packagecodename.".zip";
		
		if(file_exists($folderpackage.$packagecodename))
		{
			//zip
			
			// Get real path for our folder
			$rootPath = realpath($folderpackage.$packagecodename);

			// Initialize archive object
			$zip = new ZipArchive();
			$zip->open($folderdestzipandarchive.$filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

			// Create recursive directory iterator
			/** @var SplFileInfo[] $files */
			$files = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($rootPath),
				RecursiveIteratorIterator::LEAVES_ONLY
			);

			foreach ($files as $name => $file)
			{
				// Skip directories (they would be added automatically)
				if (!$file->isDir())
				{
					// Get real and relative path for current file
					$filePath = $file->getRealPath();
					$relativePath = substr($filePath, strlen($rootPath) + 1);

					// Add current file to archive
					$zip->addFile($filePath, $relativePath);
				}
			}

			// Zip archive will be created only after closing object
			$zip->close();
			
			return true;
		}
		
		return false;
	}
	
	
	
	function getExtSql()
	{
		$sqltype="sql";
		
		if(isset($this->conf['maindb']['moteurbd']))
		{
			switch($this->conf['maindb']['moteurbd'])
			{
				case "Mysql":
					$sqltype="sql";
				break;
				
				default:
					$sqltype="sql";
				break;
			}
		}
		
		return $sqltype;
	}
	
	
	function setConflictResolution($conflictresolution="force")
	{
		$this->conflictresolution=$conflictresolution;
	}
	
	function getConflictResolution()
	{
		return $this->conflictresolution;
	}
	
	
	function checkDependAreDeployedForPackage($packagecodename="example")
	{
		//check depend are deployed
		$reqdepend=$this->db->query("select * from `package` where deployed='0' and nomcodepackage in (select nomcodedepend from `package_depends_on` where nomcodepackage='".$packagecodename."')");
		if($resdepend=$this->db->fetch_array($reqdepend))
			return false;
		
		return true;
	}
	
	
	function addToConflictFile($conflictfilename,$action="add",$params=array())
	{
		//for conflict "reverse" mode
		if(!file_exists($this->conflictfolder."/conflict.php"))
			file_put_contents($this->conflictfolder."/conflict.php","<?php \n?>");
	
		$conflictcontent=file_get_contents($this->conflictfolder."/conflict.php");
		$conflictcontent=substr($conflictcontent,0,-2);
		
		//filename prepare
		$conflictfilename=str_replace("/","-----",$conflictfilename);
		
		if($action=="add")
		{
			//packagecodename prepare
			include $this->conflictfolder."/fileisinpackage.php";
			
			$orginalfilenamestart=substr($conflictfilename,0,strpos($conflictfilename,"___CONFLICTFILE"));
			$orginalfilenameend=substr($conflictfilename,(strpos($conflictfilename,"___CONFLICTFILE")+strlen("___CONFLICTFILE")));
			$orginalfilenameend=substr($orginalfilenameend,(strpos($orginalfilenameend,"___")+strlen("___")));
			$originalfilename=$orginalfilenamestart.$orginalfilenameend;
			
			$packagecodename="";
			if(isset($tabfileisinpackage[$originalfilename]))
				$packagecodename=$tabfileisinpackage[$originalfilename];
			
			
			$conflictcontent.="\$tabconflict['".$conflictfilename."']='".$packagecodename."';";
		}
		
		if($action=="update")
		{
			$destfilename=$params['destfile'];
			$destfilename=str_replace("/","-----",$destfilename);
			
			$conflictcontent.="\$tabconflict['".$conflictfilename."']=\$tabconflict['".$destfilename."'];";
		}
		
		if($action=="unset")
		{
			$conflictcontent.="unset(\$tabconflict['".$conflictfilename."']);";
		}
		
		$conflictcontent.="\n?>";
		
		file_put_contents($this->conflictfolder."/conflict.php",$conflictcontent);
	}
	
	
	function addToFileIsInPackageFile($packagecodename,$filename,$action="add")
	{
		//for conflict "reverse" mode
		if(!file_exists($this->conflictfolder."/fileisinpackage.php"))
			file_put_contents($this->conflictfolder."/fileisinpackage.php","<?php \n?>");
	
		$conflictcontent=file_get_contents($this->conflictfolder."/fileisinpackage.php");
		$conflictcontent=substr($conflictcontent,0,-2);
		
		$filename=str_replace("/","-----",$filename);
		
		if($action=="add")
			$conflictcontent.="\$tabfileisinpackage['".$filename."']='".$packagecodename."';";
		
		if($action=="unset")
			$conflictcontent.="unset(\$tabfileisinpackage['".$filename."']);";
		
		$conflictcontent.="\n?>";
		
		file_put_contents($this->conflictfolder."/fileisinpackage.php",$conflictcontent);
	}
	
	
	
	function update($packagecodename="example")
	{
		//conflict init
		if($this->conflictresolution!=null && !is_dir($this->conflictfolder))
			mkdir($this->conflictfolder,0777,true);
		
		//update package
		$this->initer['update']="update";
		$this->initer['packagecodename']=$packagecodename;
		$classpackagename="";
		$tabclassname=explode(".",$packagecodename);
		foreach($tabclassname as $classnamecour)
			$classpackagename.=ucfirst(strtolower($classnamecour));
		
		
		if(file_exists("package/".$packagecodename))
		{
			//tab deployed files
			$tabdeployedfiles=array();
		
			//include descripter
			$this->initer['descripter']=array();
			if(file_exists("package/".$packagecodename."/package.descripter.php"))
				include "package/".$packagecodename."/package.descripter.php";
			if(isset($descripter))
				$this->initer['descripter']=$descripter;
			
			//load conf package
			$confstatic=null;
			if(file_exists("package/".$packagecodename."/conf.package.xml"))
				$confstatic=simplexml_load_file("package/".$packagecodename."/conf.package.xml");
			$this->initer['confstatic']=$confstatic;
			
			//load conf form package
			if(isset($_POST['confform'][$packagecodename]))
				$this->initer['confform'][$packagecodename]=$_POST['confform'][$packagecodename];
			if(isset($_SESSION['confform'][$packagecodename]))
				$this->initer['confform'][$packagecodename]=$_SESSION['confform'][$packagecodename];
			
			//reload initer
			$this->reloadIniter();
			
			
			//include predeployer static
			if(file_exists("package/".$packagecodename."/class/class.static.php"))
			{
				include "package/".$packagecodename."/class/class.static.php";
				eval("\$instanceStatic=new ".$classpackagename."Static(\$this->initer);");
			}
			if(file_exists("package/".$packagecodename."/static/static.predeployer.php"))
				include "package/".$packagecodename."/static/static.predeployer.php";
			
			//reload initer
			$this->reloadIniter();
			
			
			//load db static
			$sqltype=$this->getExtSql();
			$chemin_db_static="package/".$packagecodename."/static/static.db.deployer.".$sqltype;
			if(isset($this->db) && $this->db && file_exists($chemin_db_static))
			{
				//sql exec
				$sqltoload=file_get_contents($chemin_db_static);
				$tabsqltoload=explode(";",$sqltoload);
				foreach($tabsqltoload as $sqlcour)
				{
					$req=$this->db->query($sqlcour);
				}
				
				//filename creation
				$namefilecour=str_replace("package/".$packagecodename."/static/","core/files/db/".$packagecodename.".",$chemin_db_static);
				
				//conflict resolution "reverse" mode
				if($this->conflictresolution!=null)
				{
					//only if new file
					if(!file_exists($namefilecour))
					{
						//setup annuaire files in package 
						$this->addToFileIsInPackageFile($packagecodename,$namefilecour);
						
						//replace original file
						file_put_contents($namefilecour,$sqltoload);
					}
					else
					{
						//find existing conflict
						$conflictnamefilecour=str_replace("core/files/db/","core/files/db/___CONFLICTFILE1___",$namefilecour);
						$conflictfilefound="";
						if(file_exists($this->conflictfolder."/".$conflictnamefilecour))
						{
							$cptconflict="1";
							while(file_exists($this->conflictfolder."/".$conflictnamefilecour))
							{
								include $this->conflictfolder."/conflict.php";
								$tabid=str_replace("/","-----",$conflictnamefilecour);
								if(isset($tabconflict[$tabid]) && $tabconflict[$tabid]==$packagecodename)
								{
									$conflictfilefound=$conflictnamefilecour;
									break;
								}
								
								$conflictnamefilecour=str_replace("core/files/db/","core/files/db/___CONFLICTFILE".($cptconflict++)."___",$namefilecour);
							}
						}
						
						//if conflict found
						if(file_exists($conflictfilefound))
						{
							//if conflict exists, replace only conflict file
							if(!is_dir($this->conflictfolder."/core/files/db"))
								mkdir($this->conflictfolder."/core/files/db",0777,true);
							copy($namefilecour,$this->conflictfolder."/".$conflictnamefilecour);
						}
						else
						{
							//replace original file
							file_put_contents($namefilecour,$sqltoload);
						}
					}
					
				}
				else
				{
					//create file
					file_put_contents($namefilecour,$sqltoload);
				}
				
				//return tab
				$tabdeployedfiles[]=$namefilecour;
			}
			
			//load files static
			foreach($this->initer['chaintab'] as $chaincour)
			{
				$tabfilestoload=$this->loader->charg_dossier_dans_tab("package/".$packagecodename."/static/".$chaincour);
				
				if(isset($tabfilestoload))
					foreach($tabfilestoload as $filecour)
					{
						$folder=substr($filecour,0,strrpos($filecour,"/"));
						$file=substr($filecour,strrpos($filecour,"/"),strlen($filecour)-0-strrpos($filecour,"/"));
					
						if($folder=="package/".$packagecodename."/static/".$chaincour)
							continue;
						
						$folder=str_replace("package/".$packagecodename."/static/".$chaincour."/","",$folder);
					
						if(!is_dir($folder))
							mkdir($folder,0777,true);
						
						//conflict resolution "reverse" mode
						if($this->conflictresolution!=null)
						{
							//only if new file
							if(!file_exists($folder.$file))
							{
								//setup annuaire files in package 
								$this->addToFileIsInPackageFile($packagecodename,$folder.$file);
								
								//replace original file
								copy($filecour,$folder.$file);
							}
							else
							{
								//find existing conflict
								$conflictnamefilecour="/___CONFLICTFILE1___".substr($file,1);
								$conflictfilefound="";
								if(file_exists($this->conflictfolder."/".$folder.$conflictnamefilecour))
								{
									$cptconflict="1";
									while(file_exists($this->conflictfolder."/".$folder.$conflictnamefilecour))
									{
										include $this->conflictfolder."/conflict.php";
										$tabid=str_replace("/","-----",$folder.$conflictnamefilecour);
										if(isset($tabconflict[$tabid]) && $tabconflict[$tabid]==$packagecodename)
										{
											$conflictfilefound=$conflictnamefilecour;
											break;
										}
										
										$conflictnamefilecour="/___CONFLICTFILE".($cptconflict++)."___".substr($file,1);
									}
								}
								
								//if conflict found
								if(file_exists($conflictfilefound))
								{
									//if conflict exists, replace only conflict file
									if(!is_dir($this->conflictfolder."/".$folder))
										mkdir($this->conflictfolder."/".$folder,0777,true);
									copy($folder.$file,$this->conflictfolder."/".$folder.$conflictnamefilecour);
								}
								else
								{
									//replace original file
									copy($filecour,$folder.$file);
								}
							}
							
						}
						else
						{
							//file create
							copy($filecour,$folder.$file);
						}
						
						//return tab
						$tabdeployedfiles[]=$folder.$file;
					}
			}
			
			//include postdeployer static
			if(file_exists("package/".$packagecodename."/static/static.postdeployer.php"))
				include "package/".$packagecodename."/static/static.postdeployer.php";
			
			//reload initer
			$this->reloadIniter();
			
			
			
			
			//load conf package generator
			$confgenerator=null;
			if(file_exists("package/".$packagecodename."/conf.generator.xml"))
				$confgenerator=simplexml_load_file("package/".$packagecodename."/conf.generator.xml");
			$this->initer['confgenerator']=$confgenerator;
			
			//reload initer
			$this->reloadIniter();
			
			//include predeployer generator
			$instanceGenerator=new PackageGenerator($this->initer);
			if(file_exists("package/".$packagecodename."/class/class.generator.php"))
			{
				include "package/".$packagecodename."/class/class.generator.php";
				eval("\$instanceGenerator=new ".$classpackagename."Generator(\$this->initer);");
			}
			if(file_exists("package/".$packagecodename."/generator/generator.predeployer.php"))
				include "package/".$packagecodename."/generator/generator.predeployer.php";
			
			//reload initer
			$this->reloadIniter();
			
			
			//load db generator
			$chemin_db_generator_tpl="package/".$packagecodename."/generator/generator.db.deployer.__INSTANCE__.".$sqltype.".tpl";
			if(isset($this->db) && $this->db && file_exists($chemin_db_generator_tpl))
			{
				//pour chaque instance à générer
				foreach($confgenerator->instance as $instance)
				{
					//generate sql
					$instanceTpl=new Tp($this->conf,$this->log,"backoffice");
					$tpl=$instanceTpl->tpselected;
					
					//include generator conf tpl
					$tabgeneratorconftpl=$this->loader->charg_generatorconftpl_dans_tab("package/".$packagecodename."/generator");
					$tpl->remplir_template("generatorconf",$tabgeneratorconftpl);
					
					//include generator file cour
					$tpl->remplir_template("chemintpltogenerate",$chemin_db_generator_tpl);
					
					//preparedatafortpl
					$datafortpl=array();
					if(isset($instanceGenerator))
						$datafortpl=$instanceGenerator->prepareDataForTpl($instance);
					
					foreach($datafortpl as $iddatafortpl=>$contentdatafortpl)
						$tpl->remplir_template($iddatafortpl,$contentdatafortpl);
					
					//generate file with tpl
					$contentfilecour=$tpl->get_template($this->chemingeneratortpl);
					
					$namefilecour=str_replace("__INSTANCE__",$instance->name,$chemin_db_generator_tpl);
					$namefilecour=substr($namefilecour,0,-4);
					$namefilecour=str_replace("package/".$packagecodename."/generator/","core/files/db/".$packagecodename.".",$namefilecour);
					
					//conflict resolution "reverse" mode
					if($this->conflictresolution!=null)
					{
						//only if new file
						if(!file_exists($namefilecour))
						{
							//setup annuaire files in package 
							$this->addToFileIsInPackageFile($packagecodename,$namefilecour);
							
							//replace original file
							file_put_contents($namefilecour,$contentfilecour);
						}
						else
						{
							//find existing conflict
							$conflictnamefilecour=str_replace("core/files/db/","core/files/db/___CONFLICTFILE1___",$namefilecour);
							if(file_exists($this->conflictfolder."/".$conflictnamefilecour))
							{
								$cptconflict="1";
								$conflictfilefound="";
								while(file_exists($this->conflictfolder."/".$conflictnamefilecour))
								{
									include $this->conflictfolder."/conflict.php";
									$tabid=str_replace("/","-----",$conflictnamefilecour);
									if(isset($tabconflict[$tabid]) && $tabconflict[$tabid]==$packagecodename)
									{
										$conflictfilefound=$conflictnamefilecour;
										break;
									}
									
									$conflictnamefilecour=str_replace("core/files/db/","core/files/db/___CONFLICTFILE".($cptconflict++)."___",$namefilecour);
								}
							}
							
							//if conflict found
							if(file_exists($conflictfilefound))
							{
								//if conflict exists, replace only conflict file
								if(!is_dir($this->conflictfolder."/core/files/db"))
									mkdir($this->conflictfolder."/core/files/db",0777,true);
								copy($namefilecour,$this->conflictfolder."/".$conflictnamefilecour);
							}
							else
							{
								//replace original file
								file_put_contents($namefilecour,$contentfilecour);
							}
						}
						
					}
					else
					{
						//file create
						file_put_contents($namefilecour,$contentfilecour);
					}
					
					
					//return tab
					$tabdeployedfiles[]=$namefilecour;
						
					
					//load db
					$sqltoload=file_get_contents($namefilecour);
					$tabsqltoload=explode(";",$sqltoload);
					foreach($tabsqltoload as $sqlcour)
					{
						$req=$this->db->query($sqlcour);
					}
				}
			}
			
			
			
			
			//load files generator
			foreach($this->initer['chaintab'] as $chaincour)
			{
				$tabfilestoload=$this->loader->charg_dossier_dans_tab("package/".$packagecodename."/generator/".$chaincour);
				
				if(isset($tabfilestoload))
					foreach($tabfilestoload as $filecour)
					{
						$folder=substr($filecour,0,strrpos($filecour,"/"));
						$file=substr($filecour,strrpos($filecour,"/"),strlen($filecour)-4-strrpos($filecour,"/"));
					
						if($folder=="package/".$packagecodename."/generator/".$chaincour)
							continue;
						
						
						$folder=str_replace("package/".$packagecodename."/generator/".$chaincour."/","",$folder);
					
						if(!is_dir($folder))
							mkdir($folder,0777,true);
							
						
						
						//pour chaque instance à générer
						if($confgenerator && $confgenerator->instance)
							foreach($confgenerator->instance as $instance)
							{
								//prepare chemin file with instance
								$file_generate=str_replace("__INSTANCE__",$instance->name,$file);
								
								
								//generate file
								$instanceTpl=new Tp($this->conf,$this->log,"backoffice");
								$tpl=$instanceTpl->tpselected;
								
								//include generator conf tpl
								$tabgeneratorconftpl=$this->loader->charg_generatorconftpl_dans_tab("package/".$packagecodename."/generator");
								$tpl->remplir_template("generatorconf",$tabgeneratorconftpl);
								
								//include generator file cour
								$tpl->remplir_template("chemintpltogenerate",$filecour);
								
								//preparedatafortpl
								$datafortpl=array();
								if(isset($instanceGenerator))
									$datafortpl=$instanceGenerator->prepareDataForTpl($instance);
								
								foreach($datafortpl as $iddatafortpl=>$contentdatafortpl)
									$tpl->remplir_template($iddatafortpl,$contentdatafortpl);
								
								//generate file with tpl
								$contentfilecour=$tpl->get_template($this->chemingeneratortpl);
								
								
								
								//conflict resolution "reverse" mode
								if($this->conflictresolution!=null)
								{
									//only if new file
									if(!file_exists($folder.$file_generate))
									{
										//setup annuaire files in package 
										$this->addToFileIsInPackageFile($packagecodename,$folder.$file_generate);
										
										//replace original file
										file_put_contents($folder.$file_generate,$contentfilecour);
									}
									else
									{
										//find existing conflict
										$conflictnamefilecour="/___CONFLICTFILE1___".substr($file_generate,1);
										if(file_exists($this->conflictfolder."/".$folder.$conflictnamefilecour))
										{
											$cptconflict="1";
											$conflictfilefound="";
											while(file_exists($this->conflictfolder."/".$folder.$conflictnamefilecour))
											{
												include $this->conflictfolder."/conflict.php";
												$tabid=str_replace("/","-----",$folder.$conflictnamefilecour);
												if(isset($tabconflict[$tabid]) && $tabconflict[$tabid]==$packagecodename)
												{
													$conflictfilefound=$conflictnamefilecour;
													break;
												}
												
												$conflictnamefilecour="/___CONFLICTFILE".($cptconflict++)."___".substr($file_generate,1);
											}
										}
										
										//if conflict found
										if(file_exists($conflictfilefound))
										{
											//if conflict exists, replace only conflict file
											if(!is_dir($this->conflictfolder."/".$folder))
												mkdir($this->conflictfolder."/".$folder,0777,true);
											copy($folder.$file_generate,$this->conflictfolder."/".$folder.$conflictnamefilecour);
										}
										else
										{
											//replace original file
											file_put_contents($folder.$file_generate,$contentfilecour);
										}
									}
									
								}
								else
								{
									//chemin file ok
									$chemin_file_generator_tpl=$folder.$file_generate;
									
									file_put_contents($chemin_file_generator_tpl,$contentfilecour);
								}
								
								//return tab
								$tabdeployedfiles[]=$chemin_file_generator_tpl;
							}
						
					}
			}
			
			
			
			//include postdeployer generator
			if(file_exists("package/".$packagecodename."/generator/generator.postdeployer.php"))
				include "package/".$packagecodename."/generator/generator.postdeployer.php";
			
			//reload initer
			$this->reloadIniter();
			
			
			if(isset($this->db) && $this->db)
				$this->db->query("update `package` set toupdate='0' where nomcodepackage='".$packagecodename."'");
			
			return $tabdeployedfiles;
		}
		
		return array();
	}
	
	
	function checkUpdate($packagecodename="example")
	{
		//check package to update
		$downloader=null;
		$yourfile="core/files/packagezip/".$packagecodename.".zip";
		if(file_exists($yourfile))
		{
			//downloader init
			if($downloader==null && $this->includer->include_pratikclass("Downloader"))
				$downloader=new PratikDownloader($this->initer);
			
			//data distant file
			$distantfilesize="";
			if($downloader && ($distantfile=$downloader->getFileLink($packagecodename.".zip","packages"))!="")
			{
				$head = array_change_key_case(get_headers($distantfile, TRUE));
				$distantfilesize = $head['content-length'];
			}
			
			//data your file
			$yourfilesize=filesize($yourfile);
			
			//compare to show update or not
			if($distantfilesize!="" && $yourfilesize!=$distantfilesize)
				return true;
		}
		
		return false;
	}
	
}


?>