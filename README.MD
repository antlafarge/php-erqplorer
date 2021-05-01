# PHP-ErqPlorer

This is a files explorer PHP script created for [free.fr](https://www.free.fr) perso pages.

## Configuration

Open `.erqplorer.php` and modify these config variables :
- `hideStartingWithDotDirectories` : Hide directories starting with a dot (`.git`)
- `hideStartingWithDotFiles` : Hide files starting with a dot (`.gitignore`)
- `exactFileSize` : Don't round file size (`1 KB` => `1337 B`)
- `dateFormat` : Change the date format

## Installation

Put these 2 files in the FTP root directory :
- `.erqplorer.php`
- `.htaccess`

## Installation in a sub-directory

If you don't want to install the script in the root directory of your website, put the script in the sub-directory you want.  
You will serve the sub-directories and the files of this directory.  
To do that, you have to modify the `.htaccess` to target the new path to the `.erqplorer.php` script file :

    ErrorDocument 403 /path/to/.erqplorer.php
    ErrorDocument 404 /path/to/.erqplorer.php
