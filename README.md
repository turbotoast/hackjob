# HackJob

HackJob consists of a couple of PHP classes which loosely resemble a framework.
The basic idea was to aggregate functionality to easily and quickly create small sites which lean on the content heavy with a bit of business custom application logic.

I'm trying to keep the requirements to run it to a minimum in order to be able to deploy it to your friendly neighborhood webhost.

HackJob is made, maintained and sometimes ignored by Jörn Meyer

## Installation

To install HackJob for your project, pull it into a folder called, for example, `lib`.  
Afterwards, a little bit of setup is necessary.

    cd /your/project/dir
    cp lib/hackjob/setup/htaccess.tpl .htaccess
    cp lib/hackjob/setup/index.php.tpl index.php
    cp -R lib/hackjob/setup/conf conf
    
Now, tweak the files you just created (`.htacacess`, `index.php` and all files in `conf`) to your liking, et voilà!