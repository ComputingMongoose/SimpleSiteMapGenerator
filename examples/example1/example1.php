<?php

require_once "../../SimpleSiteMapGenerator.php";

$pages=[
"index.html",
"file1.html",
"file2.html"
];

$sgen=new SimpleSiteMapGenerator();
$sgen->setBaseURL("https://mywebsite");
$sgen->generateSiteMapXML($pages);
$sgen->generateSiteMapTXT($pages);

