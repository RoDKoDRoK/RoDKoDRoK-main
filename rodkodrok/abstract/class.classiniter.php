<?php

class ClassIniter
{
	var $initer;
	
	private $recursemaxdepth=3;

	
	function __construct($initer=array())
	{
		$this->initer=$initer;
		
		foreach($initer as $idiniter=>$valueiniter)
		{
			eval("\$this->".$idiniter."=\$valueiniter;");
		}
		
	}
	
	
	function getIniter()
	{
		return $this->initer;
	}
	
	
	
	function reloadIniter($initer=null)
	{
		if($initer)
			$this->initer=$initer;
		
		if($this->initer)
			foreach($this->initer as $idiniter=>$valueiniter)
			{
				eval("\$this->".$idiniter."=\$valueiniter;");
			}
	}
	
	
	function showIniter($recurse=false,$elmtinitertostr="",$indent="0",$otheriniter=null,$getparamsorigin=null)
	{
		$returned="";
		
		if($elmtinitertostr=="")
			$returned.="<div style='margin:10px;padding:10px;border:3px solid #7B0202;background:#E29292;'>";
		
		//affiche le contenu de la variable initer dans une arborescence lisible
		$tabiniter=explode("@@@",$elmtinitertostr);
		$variniter="\$this->initer";
		if($otheriniter)
			$variniter="\$otheriniter";
		if($elmtinitertostr!="")
			foreach($tabiniter as $elmtinitercour)
			{
				if(is_array(eval("return ".$variniter.";")))
					$variniter.="['".$elmtinitercour."']";
				else if(is_object(eval("return ".$variniter.";")))
					$variniter.="->".$elmtinitercour;
			}
		
		eval("\$elmtiniter=".$variniter.";");
		
		if(is_array($elmtiniter) || is_object($elmtiniter))
		{
			//print variables disponibles
			foreach($elmtiniter as $idelmt=>$valueelmt)
			{
				//random value
				$randvalue=rand();
				
				//get values sent to parameter to recreate the initer original in further ajax calls
				if($getparamsorigin==null)
					$getparamsorigin=$_GET;
				$getparams="";
				foreach($getparamsorigin as $idgetparams=>$valuegetparams)
					$getparams.="&get".$idgetparams."=".$valuegetparams;
					
				$returned.="<div onclick=\"";
				
				if($recurse==false)
				{
					$returned.="if(document.getElementById('showiniter_".$idelmt."_".$randvalue."').style.display == 'none') ajaxCall('showiniter_".$idelmt."_".$randvalue."','showiniter','indent=".($indent+20)."&elmtinitertostr=";
					if($elmtinitertostr!="")
						$returned.=$elmtinitertostr."@@@";
					$returned.=$idelmt.$getparams."'); else \$('#showiniter_".$idelmt."_".$randvalue."').fadeOut('slow', 'linear');";
				}
				else
				{
					$returned.="if(document.getElementById('showiniter_".$idelmt."_".$randvalue."').style.display == 'none') document.getElementById('showiniter_".$idelmt."_".$randvalue."').style.display = ''; else document.getElementById('showiniter_".$idelmt."_".$randvalue."').style.display = 'none';";
				}
				
				$returned.="\" style='padding:3px;padding-left:10px;margin-left:".$indent."px;border:1px solid #666666;background:";
				if(is_array($valueelmt))
					$returned.="#CAC367";
				else if(is_object($valueelmt))
					$returned.="#5B82B6";
				else
					$returned.="yellow";
				
				$returned.=";'>".$idelmt." (";
				if(is_array($valueelmt))
					$returned.="Array";
				else if(is_object($valueelmt))
					$returned.="Object";
				else
					$returned.="Value";
				
				$returned.=")</div>";
				$returned.="<div style='display:none' id='showiniter_".$idelmt."_".$randvalue."'>";
				
				//recurse
				if($recurse)
				{
					$elmtsuivant=$idelmt;
					$otheriniterfornext=$elmtiniter;
					if($elmtinitertostr!="")
					{
						$elmtsuivant=$elmtinitertostr."@@@".$idelmt;
						$otheriniterfornext=$otheriniter;
					}
					if($recurse==true)
						$recurse=1;
					else
						$recurse++;
					if($recurse<$this->recursemaxdepth)
						$returned.=$this->showIniter($recurse,$elmtsuivant,$indent+20,$otheriniterfornext);
					else
						$returned.="Max depth of a tree <i>showIniter</i> reached. To see more, change the parameter <i>\$recursemaxdepth</i> in the file <i>abstract/class.classiniter.php</i>";
				}
				
				$returned.="</div>";
			}
			//print functions disponibles
			if(is_object($elmtiniter))
			{
				$classmethods=get_class_methods($elmtiniter);
				foreach($classmethods as $methodname)
				{
					if($methodname!="__construct")
					{
						$returned.="<div style='padding:3px;padding-left:10px;margin-left:".$indent."px;border:1px solid #666666;background:#4DA950;'>".$methodname."( ";
						
						//Get the parameters of a method
						$paramslist="";
						$reflector = new ReflectionClass($elmtiniter);
						$parameters = $reflector->getMethod($methodname)->getParameters();
						if($parameters)
						{
							foreach($parameters as $paramcour)
							{
								$paramslist.=$paramcour->name;
								$paramslist.=" , ";
							}
							$paramslist=substr($paramslist,0,-strlen(" , "));
						}
						$returned.=$paramslist;
						
						$returned.=" ); (Function)</div>";
					}
				}
			}
		}
		else
			$returned.="<div style='padding:3px;padding-left:10px;margin-left:".$indent."px;border:1px solid #666666;background:orange;'>".$elmtiniter."</div>";
		
		if($elmtinitertostr=="")
			$returned.="</div>";
		
		return $returned;
	}
	
}

?>