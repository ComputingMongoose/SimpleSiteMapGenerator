<?php

require_once "../../SimpleSiteMapGenerator.php";

$pages=[
"index.html",
["page"=>"file1.html", "lastmod"=>"2023-01-01", "changefreq"=>"daily", "priority"=>"0.7"],
"file2.html"
];

$sgen=new SimpleSiteMapGenerator();

$sgen->setBaseURL("https://mywebsite");
$sgen->setDestinationPath(".");
$sgen->setDefaultChangeFreq("weekly");
$sgen->setDefaultPriority("0.5");
$sgen->setDefaultChangeFreqIndex("daily");
$sgen->setDefaultPriorityIndex("0.9");

$sgen->generateSiteMapXML($pages);
$sgen->generateSiteMapTXT($pages);

