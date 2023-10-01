# SimpleSiteMapGenerator

This is a PHP utility for generating a SiteMap. Generation can be as easy as providing a list of files with a base URL (see example1) or more complex, providing individual options for different files (see example2). The generated file can be either in XML or TXT format. The generated file can be used for indexing a website in a search engine, such as Google. For more details about the file format see: https://sitemaps.org/protocol.html .

Its primary intended usage is for generating sitemaps for static websites. You pass an array of file paths and get a sitemap file generated in the specified destination path. The generation process will assign a different change frequency and priority to index files. However, the generation process can be fully controlled by passing a detailed array of options to the generation process, as detailed below. Take a look at the examples folder for different usage scenarios.

## Methods

### generateSiteMapXML($pages)
This method will generate a sitemap file in XML format. The "pages" argument is an array with the pages to be included in the sitemap. Each entry contains either:
- a) a string representing the page (file on the file system or a complete http(s) URL)
- b) an array containing some or all of the following (missing elements are replaced with default values):
  - _page_ is the file or URL
  - _lastmod_ is the last modification string to be included in the sitemap
  - _changefreq_ is the change frequency string to be included in the sitemap
  - _priority_ is the priority string to be included in the sitemap

### generateSiteMapTXT($pages)
This method will generate a sitemap file in TXT format. The "pages" argument is an array with the pages to be included in the sitemap, similar to the _generateSiteMapXML_ method. Since the TXT sitemap contains only URLs, other options such as _lastmod_, _changefreq_, and _priority_ are ignored.

### setBaseURL($url)
Sets the base URL of the website. This will be used to generate URLs from file names. Example: _setBaseURL("https://mywebsite")_.

### setDestinationPath($path)
Sets the destination folder location for the generated sitemap(s). This is checked and removed from file names if present. Example: _setDestinationPath("..")_.

### setDefaultChangeFreq($freq)
Sets the default update frequency of files. This will be used in the XML sitemap. Example: _setDefaultChangeFreq("monthly")_.

### setDefaultPriority($priority)
Sets the default priority of files. This will be used in the XML sitemap. Example: _setDefaultPriority("0.5")_.

### setDefaultChangeFreqIndex($freq)
Sets the default update frequency of files containing the word "index" in the file name. This will be used in the XML sitemap. Example: _setDefaultChangeFreqIndex("weekly")_.

### setDefaultPriorityIndex($priority)
Sets the default priority of files containing the word "index" in the file name. This will be used in the XML sitemap. Example: _setDefaultPriorityIndex("0.8")_.

# Youtube

Checkout my YouTube channel for interesting videos: https://www.youtube.com/@ComputingMongoose/

# Website

Checkout my website: https://ComputingMongoose.github.io


