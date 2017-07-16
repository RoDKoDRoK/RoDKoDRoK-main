<?php

class Load
{
	
	function __construct()
	{
	}
	
	function charg_dossier_unique_dans_tab($dossier,$withdir=false)
	{
		if(!is_dir($dossier))
			return null;
			
		$tab=array();
		$rep=opendir($dossier);
		
		while ($file = readdir($rep))
		{
			if($file != '..' && $file !='.' && $file !='')
			{
				if(is_file($dossier."/".$file) || $withdir)
				{
					//chargement du fichier
					$tab[]=$dossier."/".$file;
				}
			}
		}
		return $tab;
	}
	
	function charg_dossier_dans_tab($dossier)
	{
		if(!is_dir($dossier))
			return null;
			
		$tab=array();
		$tab_bis=array();
		$rep=opendir($dossier);
		
		while ($file = readdir($rep))
		{
			if($file != '..' && $file !='.' && $file !='')
			{
				if(is_dir($dossier."/".$file))
				{
					//chargement du contenu du dossier
					$tab_bis=$this->charg_dossier_dans_tab($dossier."/".$file);
					$tab=array_merge($tab,$tab_bis);
				}
				else
				{
					//chargement du fichier
					$tab[]=$dossier."/".$file;
				}
			}
		}
		return $tab;
	}
	
	
	
	
	function charg_chain_dans_tab($dossier="chain")
	{
		//check $dossier in arkitect
		$arkitect=new Arkitect();
		$tmpdossier=$arkitect->get("chain");
		if($tmpdossier!="" && is_dir($tmpdossier))
			$dossier=$tmpdossier;
		
		//load chain dans tab
		$tab=array();
		
		if(!is_dir($dossier))
		{
			$tab[]="default";
			return $tab;
		}
				
		$nameconnectorchain="connector.chain.";
		
		$rep=opendir($dossier);
		
		while ($file = readdir($rep))
		{
			if($file != '..' && $file !='.' && $file !='')
			{
				if(is_file($dossier."/".$file))
				{
					//chargement du fichier
					$chaincour=$file;
					if(strstr($chaincour,$nameconnectorchain))
					{
						$chaincour=substr($chaincour,strlen($nameconnectorchain),-4);
						//ajout du nom de la chain
						$tab[]=$chaincour;
					}
				}
			}
		}
		
		//cas aucune chain installée
		if(count($tab)==0)
			$tab[]="default";
		
		return $tab;
	}
	
	
	
	
	function charg_connector_dans_tab($dossier="connector")
	{
		//check $dossier in arkitect
		$arkitect=new Arkitect();
		$tmpdossier=$arkitect->get("connector");
		if($tmpdossier!="" && is_dir($tmpdossier))
			$dossier=$tmpdossier;
		
		//load chain dans tab
		if(!is_dir($dossier))
			return null;
			
		$nameconnector="connector.";
		
		$tab=array();
		$rep=opendir($dossier);
		
		while ($file = readdir($rep))
		{
			if($file != '..' && $file !='.' && $file !='')
			{
				if(is_file($dossier."/".$file))
				{
					//chargement du fichier
					$connectorcour=$file;
					if(strstr($connectorcour,$nameconnector))
					{
						$connectorcour=substr($connectorcour,strlen($nameconnector),-4);
						//ajout du nom de la chain
						$tab[]=$connectorcour;
					}
				}
			}
		}
		
		return $tab;
	}
	
	
	
	
	function charg_generatorconftpl_dans_tab($dossier)
	{
		if(!is_dir($dossier))
			return null;
			
		$tab=array();
		$rep=opendir($dossier);
		
		while ($file = readdir($rep))
		{
			if($file != '..' && $file !='.' && $file !='')
			{
				if(is_file($dossier."/".$file) && strstr($file,"generator.conf.") && substr($file,-4)==".tpl")
				{
					//chargement du fichier
					$tab[]=$dossier."/".$file;
				}
			}
		}
		return $tab;
	}
	
	
	
	function construct_tab_toprint($tabconnector=array(),$initercour=null)
	{
		$tabtoprint=array();
		
		if($initercour==null)
			return $tabtoprint;
		
		if($tabconnector)
			foreach($tabconnector as $connectorcour)
			{
				if(!(isset($connectorcour['outputaction']) && isset($connectorcour['vartoiniter']) && isset($connectorcour['aliasiniter'])))
					continue;
				
				$varcour="";
				if(isset($connectorcour['vartoiniter']) && isset($connectorcour['name']))
					$varcour=$connectorcour['name'];
				if(isset($connectorcour['aliasiniter']) && $connectorcour['aliasiniter']!="none")
					$varcour=$connectorcour['aliasiniter'];
				
				if(strstr($connectorcour['outputaction'],"toprint")!==false)
				{
					$tabcour=explode("-",$connectorcour['outputaction']);
					
					if(count($tabcour)!=3)
						continue;
					
					//cas variable directe
					if($tabcour[1]=="self")
					{
						//get var directement
						if(!isset($tabtoprint['self'][$varcour]))
							eval("\$tabtoprint['self'][\$varcour]=\$initercour['".$varcour."'];");
					}
					else
					{
						//get var directement
						if(!isset($tabtoprint['other'][$varcour]))
							eval("\$tabtoprint['other'][\$varcour]=\$initercour['".$varcour."'];");
							
						//get var dans tab indiqué (exemple content:2 devient $tabtoprint['content'][2]
						$tabdest=explode(":",$tabcour[1]);
						
						//cas var simple
						if($tabcour[2]=="var")
						{
							$tabtoprint[$tabdest[0]][$tabdest[1]]['name']=$varcour;
							$tabtoprint[$tabdest[0]][$tabdest[1]]['type']="var";
							$tabtoprint[$tabdest[0]][$tabdest[1]]['chemin']="";
							eval("\$tabtoprint[\$tabdest[0]][\$tabdest[1]]['value']=\$initercour['".$varcour."'];");
						}
						else
						{
							//cas subtpl
							$tabchemin=explode(":",$tabcour[2]);
							if($tabchemin[0]=="subtpl")
							{
								$tabtoprint[$tabdest[0]][$tabdest[1]]['name']=$varcour;
								$tabtoprint[$tabdest[0]][$tabdest[1]]['type']="subtpl";
								eval("\$tabtoprint[\$tabdest[0]][\$tabdest[1]]['value']=\$initercour['".$varcour."'];");
								
								//construct chemin tpl
								$chemincour="";
								
								$arkitectname=$tabchemin[1];
								$arkitectname.=".tplpath";
								
								$arkitect=new Arkitect();
								$chemincour=$arkitect->get($arkitectname);
								
								$tabtoprint[$tabdest[0]][$tabdest[1]]['chemin']=$chemincour;
								
							}
						}
					}
					
					
				}
			}
		
		//reorder array with keys 0,1,2,3,...	
		if(isset($tabtoprint))
			foreach($tabtoprint as $idtab=>$valuetab)
			{
				if($idtab!="self" && $idtab!="other")
				{
					ksort($tabtoprint[$idtab]);
					array_splice($tabtoprint[$idtab],0,0);
				}
			}
		
		return $tabtoprint;
	}
	
	
	
	function charg_url_unique_dans_tab($url="",$withdir=false)
	{		
		$tab=array();
		$matches = array();
		
		preg_match_all("/(a href\=\")([^\?\"]*)(\")/i", $this->get_text($url), $matches);
		
		foreach($matches[2] as $match) {
			if(substr($match,-4)==".zip" || $withdir)
				$tab[]=$match;
		}
		return $tab;
	}
	
	//to use with function charg_url_unique_dans_tab
	private function get_text($filename)
	{
		$content="";
		
		$fp_load = fopen("$filename", "rb");

		if ( $fp_load ) 
		{
            while ( !feof($fp_load) )
			{
                $content .= fgets($fp_load, 8192);
            }

            fclose($fp_load);
		}
		
		return $content;
	}
	
	
	
	function load_js($filejs="")
	{
		$js="";
		
		$js.="<script src=\"".$filejs."\" type=\"text/javascript\"></script>\n";
		
		return $js;
	}
	
	
	function load_css($filecss="")
	{
		$css="";
		
		$css.="<link rel=\"stylesheet\" type=\"text/css\" href=\"".$filecss."\" />\n";
		
		return $css;
	}
	
	
}



?>