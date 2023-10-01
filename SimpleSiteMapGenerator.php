<?php

/* 
For an up-to-date version of this script check the GitHub at:
https://github.com/ComputingMongoose/SimpleSiteMapGenerator
*/

class SimpleSiteMapGenerator {
	var $destinationPath;
	var $baseURL;
	var $defaultChangeFreq;
	var $defaultPriority;
	var $defaultChangeFreqIndex;
	var $defaultPriorityIndex;
	
	public function __construct(){
		$this->destinationPath="";
		$this->baseURL="";
		$this->defaultChangeFreq="monthly";
		$this->defaultPriority="0.5";
		$this->defaultChangeFreqIndex="weekly";
		$this->defaultPriorityIndex="0.8";
	}
	
	public function setDestinationPath($path){
		$this->destinationPath=$path;
	}
	
	public function setBaseURL($url){
		$this->baseURL=$url;
	}
	
	public function setDefaultChangeFreq($freq){
		$this->defaultChangeFreq=$freq;
	}
	
	public function setDefaultPriority($prio){
		$this->defaultPriority=$prio;
	}
	
	public function setDefaultChangeFreqIndex($freq){
		$this->defaultChangeFreqIndex=$freq;
	}
	
	public function setDefaultPriorityIndex($prio){
		$this->defaultPriorityIndex=$prio;
	}

	private function _startsWith( $haystack, $needle ) {
		$length = strlen( $needle );
		return substr( $haystack, 0, $length ) === $needle;
	}
	
	private function _getPageData($page,$lastMod){
		$pageFile=false;
		$pageLastMod=$lastMod;
		$pageChangeFreq=$this->defaultChangeFreq;
		$pagePriority=$this->defaultPriority;
		
		if(is_array($page)){
			if(isset($page['page']))$pageFile=$page['page'];
			
			if(isset($page['lastmod']))$pageLastMod=$page['lastmod'];
			
			if(isset($page['priority']))$pagePriority=$page['priority'];
			else{
				if(strpos($pageFile,"index")!==false)$pagePriority=$this->defaultPriorityIndex;
			}
			
			if(isset($page['changefreq']))$pageChangeFreq=$page['changefreq'];
			else {
				if(strpos($pageFile,"index")!==false)$pageChangeFreq=$this->defaultChangeFreqIndex;
			}
		}else{
			$pageFile=$page;
			if(strpos($pageFile,"index")!==false){
				$pagePriority=$this->defaultPriorityIndex;
				$pageChangeFreq=$this->defaultChangeFreqIndex;
			}
		}
		
		if($pageFile!==false){
			if(!$this->_startsWith($pageFile,"http://") && !$this->_startsWith($pageFile,"https://")){
				if(strlen($this->destinationPath)>0 && $this->_startsWith($pageFile,$this->destinationPath)){
					$pageFile=substr($pageFile,strlen($this->destinationPath));
				}
				
				if(!$this->_startsWith($pageFile,"/"))$pageFile="/$pageFile";
				
				$pageFile=$this->baseURL.$pageFile;
			}
		}
		
		return ["pageFile"=>$pageFile, "pageLastMod"=>$pageLastMod, "pageChangeFreq"=>$pageChangeFreq, "pagePriority"=>$pagePriority];
	}			
	
	/*
	pages = array of pages. Each page in the array may be a String, indicating the actual page, or an Array containing:
		- page = the page file or http(s) link
		- lastmod = last modified
		- priority = page priority
		- changefreq = change frequency
		If any of the settings is missing, it will be replaced by the default values.
		
		For the generated XML content see: https://sitemaps.org/protocol.html
	*/
	public function generateSiteMapXML($pages){
		$fpath=((strlen($this->destinationPath)>0)?($this->destinationPath):("."))."/sitemap.xml";
		$fout=fopen($fpath,"w");
		$lastMod=date("Y-m-d");
		fwrite($fout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
		fwrite($fout,'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n");
		
		foreach($pages as $page){
			$pageData=$this->_getPageData($page,$lastMod);
			if($pageData['pageFile']===false || strlen($pageData['pageFile'])==0)continue;
				
			fwrite($fout,"<url>\n".
				"<loc>${pageData['pageFile']}</loc>\n".
				"<lastmod>${pageData['pageLastMod']}</lastmod>\n".
				"<changefreq>${pageData['pageChangeFreq']}</changefreq>\n".
				"<priority>${pageData['pagePriority']}</priority>\n".
				"</url>\n");
		}
		
		fwrite($fout,"</urlset>\n");
		fclose($fout);
	}

	public function generateSiteMapTXT($pages){
		$fpath=((strlen($this->destinationPath)>0)?($this->destinationPath):("."))."/sitemap.txt";
		$fout=fopen($fpath,"w");
		foreach($pages as $page){
			$pageData=$this->_getPageData($page,"");
			if($pageData['pageFile']===false || strlen($pageData['pageFile'])==0)continue;
				
			fwrite($fout,"${pageData['pageFile']}\n");
		}
		fclose($fout);
	}
}	

