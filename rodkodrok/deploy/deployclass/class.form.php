<?php

class PratikForm extends ClassIniter
{	

	var $chemin_pratiklib_form="deploy/deploylib/pratik/form/"; 
	

	function __construct($initer=array())
	{
		parent::__construct($initer);
		
		
	}
	


	function formconverter($tabform=array(),$tabparam=array()) 
	{
		$form=array();
		
		foreach($tabform as $idform=>$contentform)
		{
			if($idform=='lineform')
			{
				foreach($tabform['lineform'] as $contentlineform)
				{
					$form['lineform'][]=array();
					
					$form['lineform'][count($form['lineform'])-1]['label']="";
					if(isset($contentlineform['label']))
						$form['lineform'][count($form['lineform'])-1]['label']=$contentlineform['label'];
					
					$form['lineform'][count($form['lineform'])-1]['hiddenlabel']="";
					if(isset($contentlineform['champs']) && strstr($contentlineform['champs'],"hidden")!==false)
						$contentlineform['hiddenlabel']="on";
					if(isset($contentlineform['hiddenlabel']))
						$form['lineform'][count($form['lineform'])-1]['hiddenlabel']=$contentlineform['hiddenlabel'];
					
					$form['lineform'][count($form['lineform'])-1]['name']="";
					if(isset($contentlineform['name']))
						$form['lineform'][count($form['lineform'])-1]['name']=$contentlineform['name'];
					
					$form['lineform'][count($form['lineform'])-1]['default']="";
					if(isset($contentlineform['default']) && strtolower($contentlineform['default'])=="null")
						$contentlineform['default']="";
					if(isset($contentlineform['default']))
						$form['lineform'][count($form['lineform'])-1]['default']=$contentlineform['default'];
					
					$form['lineform'][count($form['lineform'])-1]['suggestlist']="";
					if(isset($contentlineform['suggestlist']))
						$form['lineform'][count($form['lineform'])-1]['suggestlist']=$contentlineform['suggestlist'];
					
					
					
					//$instanceTpl=new Tp($this->conf,$this->log);
					//$tpl=$instanceTpl->tpselected;
					$tpl=new TemplateSmarty();
					
					//load css and js for case
					$tpl->remplir_template("css",$this->getCssForm("champs.".$contentlineform['champs']));
					$tpl->remplir_template("js",$this->getJsForm("champs.".$contentlineform['champs']));
					
					//custom code to prepare champs input (charger une liste de suggestions par exemple)
					if(file_exists($this->chemin_pratiklib_form."customform/champs.".$contentlineform['champs'].".php"))
						include $this->chemin_pratiklib_form."customform/champs.".$contentlineform['champs'].".php";
					else
						$this->log->pushtolog("Fichier introuvable : ".$this->chemin_pratiklib_form."customform/champs.".$contentlineform['champs'].".php");
					
					$tpl->remplir_template("lineform",$contentlineform);
					
					//tpl du champs
					$chemin_tpl_champs=$this->chemin_pratiklib_form."template/champs.".$contentlineform['champs'].".tpl";
					if(!file_exists($chemin_tpl_champs))
						$chemin_tpl_champs=$this->chemin_pratiklib_form."template/champs.text.tpl";
					
					//set chemin form
					$tpl->remplir_template("cheminform",$chemin_tpl_champs);
						
					$form['lineform'][count($form['lineform'])-1]['champs']=$tpl->get_template($this->chemin_pratiklib_form."form.tpl");
					
				}
			}
			else
			{
				
				//$instanceTpl=new Tp($this->conf,$this->log);
				//$tpl=$instanceTpl->tpselected;
				$tpl=new TemplateSmarty();
				
				//load css and js for case
				$tpl->remplir_template("css",$this->getCssForm("form.".$idform));
				$tpl->remplir_template("js",$this->getJsForm("form.".$idform));
				
				//load other params
				foreach($tabparam as $idparam=>$contentparam)
					$tpl->remplir_template($idparam,$contentparam);
				
				//custom code to prepare champs input (charger une liste de suggestions par exemple)
				if(file_exists($this->chemin_pratiklib_form."customform/form.".$idform.".php"))
					include $this->chemin_pratiklib_form."customform/form.".$idform.".php";
				else
					$this->log->pushtolog("Fichier introuvable : ".$this->chemin_pratiklib_form."customform/form.".$idform.".php");
				
				
				//tpl de l'elmt form
				$form[$idform]="";
				if($contentform==true)
				{
					//cas avec structure de base de form.tpl
					$chemin_tpl_champs=$this->chemin_pratiklib_form."template/form.".$idform.".tpl";
					if(!file_exists($chemin_tpl_champs))
					{
						//cas de balises ouvrante et fermante (sans structure de base form.tpl)
						$chemin_tpl_champs=$this->chemin_pratiklib_form."template/form.".$idform."__open.tpl";
						if(!file_exists($chemin_tpl_champs))
							$chemin_tpl_champs=$this->chemin_pratiklib_form."template/form.none.tpl";
						else
						{
							//custom code to prepare champs input for open and close (charger une liste de suggestions par exemple)
							if(file_exists($this->chemin_pratiklib_form."customform/form.".$idform."__open.php"))
								include $this->chemin_pratiklib_form."customform/form.".$idform."__open.php";
							else
								$this->log->pushtolog("Fichier introuvable : ".$this->chemin_pratiklib_form."customform/form.".$idform."__open.php");
				
							//tpl open
							$form[$idform."__open"]=$tpl->get_template($chemin_tpl_champs);
							
							
							
							//custom code to prepare champs input for open and close (charger une liste de suggestions par exemple)
							if(file_exists($this->chemin_pratiklib_form."customform/form.".$idform."__close.php"))
								include $this->chemin_pratiklib_form."customform/form.".$idform."__close.php";
							else
								$this->log->pushtolog("Fichier introuvable : ".$this->chemin_pratiklib_form."customform/form.".$idform."__close.php");
				
							//tpl close
							$chemin_tpl_champs=$this->chemin_pratiklib_form."template/form.".$idform."__close.tpl";
							$form[$idform."__close"]="";
							if(file_exists($chemin_tpl_champs))
								$form[$idform."__close"]=$tpl->get_template($chemin_tpl_champs);
							
							
							
							//tpl none for secure
							$chemin_tpl_champs=$this->chemin_pratiklib_form."template/form.none.tpl";
							$form[$idform]="";
							if(file_exists($chemin_tpl_champs))
								$form[$idform]=$tpl->get_template($chemin_tpl_champs);
							
							
							continue;
						}
					}
					
					//set chemin form
					$tpl->remplir_template("cheminform",$chemin_tpl_champs);
					
					$form[$idform]=$tpl->get_template($this->chemin_pratiklib_form."form.tpl");
					
				}
			}
		}
		
		
		return $form;
	}
	

	function submiter($preform=array(),$tabaction=array(),$tabparam=array())
	{
		
		//get var
		$tabpost=array();
		
		if(isset($preform['lineform']))
			foreach($preform['lineform'] as $lineform)
			{
				$tabpost[$lineform['name']]=$this->instanceVar->varpost($lineform['name']);
				
				//custom code for champ submitted
				if(file_exists($this->chemin_pratiklib_form."customsubmit/champs.".$lineform['champs'].".php"))
					include $this->chemin_pratiklib_form."customsubmit/champs.".$lineform['champs'].".php";
				else
					$this->log->pushtolog("Fichier introuvable : ".$this->chemin_pratiklib_form."customsubmit/champs.".$lineform['champs'].".php");
				
			}
		
		
		//submit action to do
		if(isset($tabaction))
			foreach($tabaction as $action)
				if(file_exists($this->chemin_pratiklib_form."customsubmit/form.".$action.".php"))
					include $this->chemin_pratiklib_form."customsubmit/form.".$action.".php";
				else
					$this->log->pushtolog("Fichier introuvable : ".$this->chemin_pratiklib_form."customsubmit/champs.".$action.".php");
		
	}
	

	function redirectAfterSubmiter($url="")
	{
		//to prevent reload forms when refresh with F5
		$jsreturned="";
		
		$jsreturned.="<script>";
		$jsreturned.="$(document).ready(function(){";
		$jsreturned.="window.location.replace('";
		if($url!="")
		{
			if(substr($url,0,4)=="http")
				$jsreturned.=$url;
			else
			{
				$hostcour="http".(($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://").$_SERVER['HTTP_HOST'];
				$subfolder=substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],"/"));
				$jsreturned.=$hostcour.$subfolder."/".$url;
			}
		}
		else
		{
			$urlcour="http".(($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://").$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$jsreturned.=$urlcour;
		}
		$jsreturned.="');";
		$jsreturned.="});";
		$jsreturned.="</script>";
		
		//exec redirection
		echo $jsreturned;
		
		return $jsreturned;
	}
	
	
	
	//get css and js
	function getCssForm($nomcodeform="")
	{
		$css="";
		
		if(file_exists("core/src/pratiklib/form/css/".$nomcodeform.".css"))
			$css.="<link rel=\"stylesheet\" href=\"core/src/pratiklib/form/css/".$nomcodeform.".css\" type=\"text/css\" />\n";
		
		//surcharge de la css possible dans le design
		if(file_exists("core/design/pratik/form/".$nomcodeform.".css"))
			$css.="<link rel=\"stylesheet\" href=\"core/design/pratik/form/".$nomcodeform.".css\" type=\"text/css\" />\n";
		
		return $css;
	}
	
	function getJsForm($nomcodeform="")
	{
		$js="";
		
		if(file_exists("core/src/pratiklib/form/js/".$nomcodeform.".js"))
			$js.="<script src=\"core/src/pratiklib/form/js/".$nomcodeform.".js\"></script>\n";
		
		return $js;
	}
	
	

}


?>