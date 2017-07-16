<?php

class PratikDownloader extends ClassIniter
{
	var $tabsrclink=array();
	
	var $defaultsrclinkfolder="deploy/deploylib/pratik/downloader/srclinks/";
	
	
	function __construct($initer=array())
	{
		parent::__construct($initer);
		
		//prepare src links
		$this->tabsrclink=$this->prepareSrcLinks();
	}
	
	
	function prepareSrcLinks()
	{
		$tabsrclink=array();
		
		//get folder src link
		$srclinksfolder=$this->defaultsrclinkfolder;
		if(isset($this->conf['srclinkfolder']) && is_dir($this->conf['srclinkfolder']))
			$srclinksfolder=$this->conf['srclinkfolder'];
		
		//load srclinks in array
		$tab_chemins_srclinks=array();
		if(isset($this->loader))
			$tab_chemins_srclinks=$this->loader->charg_dossier_dans_tab($srclinksfolder);
		
		if(isset($tab_chemins_srclinks) && $tab_chemins_srclinks)
			foreach($tab_chemins_srclinks as $chemin_srclinks_to_load)
			{
				if(strstr($chemin_srclinks_to_load,".htaccess")=="" && substr($chemin_srclinks_to_load,-4)==".php")
					include $chemin_srclinks_to_load;
			}
		
		ksort($tabsrclink);
		$tabsrclink=array_slice($tabsrclink,0);
		
		//check and prepare local link without http
		for($cptsrclink=0;$cptsrclink<count($tabsrclink);$cptsrclink++)
		{
			$urlcour=$tabsrclink[$cptsrclink];
			if(substr($urlcour,0,4)!="http")
				$tabsrclink[$cptsrclink]="http".($this->isSecure()?"s":"")."://".$_SERVER['HTTP_HOST']."/".$urlcour;
		}
		
		return $tabsrclink;
	}
	
	
	function getSrcLink($srclink="")
	{
		if($srclink=="" && isset($this->tabsrclink[0]))
			return $this->tabsrclink[0];
		
		if(is_numeric($srclink) && $srclink>=0 && isset($this->tabsrclink[$srclink]))
			return $this->tabsrclink[$srclink];
		
		return $srclink;
	}
	
	function getTabSrcLink()
	{
		return $this->tabsrclink;
	}
	
	function getFileLink($filename="",$subfolder="")
	{
		for($cptsrclink=0;$cptsrclink<count($this->getTabSrcLink());$cptsrclink++)
		{
			$urltodownload=$this->getSrcLink($cptsrclink);
			$urltodownload=$urltodownload."/".$subfolder."/";
			
			$file_headers = @get_headers($urltodownload.$filename);
			if($file_headers[0] != 'HTTP/1.1 404 Not Found')
			{
				return $urltodownload.$filename;
			}
		}
		
		return "";
	}
	
	function isSecure()
	{
		return ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443);
	}

}



?>