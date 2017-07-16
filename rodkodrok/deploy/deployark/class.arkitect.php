<?php

class Arkitect extends Load
{
	//arkitect du système
	var $arkitect=array();
	
	
	function __construct()
	{
		parent::__construct();
		$this->charg_arkitect();
		
	}
	
	
	
	function charg_arkitect()
	{	
		$arkitect=array();
		
		//conf arkitect
		$tab_chemins_arkitect=$this->charg_dossier_dans_tab("core/conf/arkitect");
		
		if(isset($tab_chemins_arkitect) && $tab_chemins_arkitect)
		{
			sort($tab_chemins_arkitect);
			foreach($tab_chemins_arkitect as $chemin_arkitect_to_load)
			{
				if(strstr($chemin_arkitect_to_load,".htaccess")=="" && substr($chemin_arkitect_to_load,-4)==".php")
					include $chemin_arkitect_to_load;
			}
		}
		
		$this->arkitect=array_merge($this->arkitect,$arkitect);

	}
	
	
	function get($idarkitect="",$idarkitect2="",$idarkitect3="",$idarkitect4="",$idarkitect5="")
	{
		$value="";
		
		if($idarkitect!="" && isset($this->arkitect[$idarkitect]))
		{
			$value=$this->arkitect[$idarkitect];
			if($idarkitect2!="" && isset($this->arkitect[$idarkitect][$idarkitect2]))
			{
				$value=$this->arkitect[$idarkitect][$idarkitect2];
				if($idarkitect3!="" && isset($this->arkitect[$idarkitect][$idarkitect2][$idarkitect3]))
				{
					$value=$this->arkitect[$idarkitect][$idarkitect2][$idarkitect3];
					if($idarkitect4!="" && isset($this->arkitect[$idarkitect][$idarkitect2][$idarkitect3][$idarkitect4]))
					{
						$value=$this->arkitect[$idarkitect][$idarkitect2][$idarkitect3][$idarkitect4];
						if($idarkitect5!="" && isset($this->arkitect[$idarkitect][$idarkitect2][$idarkitect3][$idarkitect4][$idarkitect5]))
						{
							$value=$this->arkitect[$idarkitect][$idarkitect2][$idarkitect3][$idarkitect4][$idarkitect5];
						}
					}
				}
			}
		}
		
		return $value;
	}
	
	
}



?>