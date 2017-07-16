<?php


class PackageGenerator extends ClassIniter
{

	function __construct($initer=array())
	{
		parent::__construct($initer);
	}


	function prepareDataForTpl($instancecour="")
	{	
		$tabdata=array();
		
		//load packagecodename
		$tabdata['packagecodename']=$this->packagecodename;
		
		//load descripter pour tpl fichier generator
		if(isset($this->descripter))
			foreach($this->descripter as $key=>$value){
				$tabdata['descripter'][$key] = $this->load_string_from_xml($value);
			}
			
		//load confstatic pour tpl fichier generator
		if(isset($this->confstatic))
			foreach($this->confstatic as $key=>$value){
				$tabdata['confstatic'][$key] = $this->load_string_from_xml($value);
			}
		
		//load confform pour tpl fichier generator
		if(isset($this->confform[$this->packagecodename]))
			foreach($this->confform[$this->packagecodename] as $key=>$value){
				$tabdata['confform'][$key] = $this->load_string_from_xml($value);
			}
		
		//load confgenerator instances pour tpl fichier generator
		$cptinstance=0;
		if(isset($this->confgenerator))
			foreach($this->confgenerator->instance as $instance){
				if(isset($instance->name))
				{
					$instancename=(string) $instance->name;
					$tabdata['confgenerator']['instances'][$instancename]=array();
				}
				else
				{
					$instancename=$cptinstance;
					$tabdata['confgenerator']['instances'][$instancename]=array();
					$cptinstance++;
				}
				foreach($instance as $key=>$value)
					if($key!="name")
						$tabdata['confgenerator']['instances'][$instancename][$key] = $this->load_string_from_xml($value);
			}
			
		//load confgenerator instancecour pour tpl fichier generator
		if(isset($instancecour))
			foreach($instancecour as $key=>$value){
				$tabdata['confgenerator']['instancecour'][$key]=$this->load_string_from_xml($value);
			}
			
		return $tabdata;
	}


	//chargement d'une chaine depuis un xml
	function load_string_from_xml($chaine)
	{
		if(is_object($chaine) && $chaine->children()->getName())
		{
			$tabdatacour=array();
			$lastkeys=array();
			if($chaine)
				foreach($chaine as $key=>$value)
				{
					//test si key déjà présente pour ne pas écraser les datas
					if(isset($tabdatacour[$key]))
					{
						if($tabkeys[$key] || !is_array($tabdatacour[$key]))
						{
							$tmpdata=$tabdatacour[$key];
							unset($tabdatacour[$key]);
							$tabdatacour[$key]=array();
							$tabdatacour[$key][]=$tmpdata;
							
							$tabkeys[$key]=false;
						}
						
						//reorganise en sous tab pour éviter suppr de datas
						$tabdatacour[$key][] = $this->load_string_from_xml($value);
					}
					else
					{
						//ajout key dans tab
						$tabdatacour[$key] = $this->load_string_from_xml($value);
						
						//tabkeys to check if no data are deleted
						$tabkeys[$key]=true;
					}
				}
			if(count($tabdatacour)==0)
				$tabdatacour="";
			return $tabdatacour;
		}
		
		return utf8_decode(str_replace('@@@','\n',eval("return \"".str_replace('\n','@@@',str_replace('"','&quot;',(string)$chaine)."\";"))));
	}
	

}



?>
