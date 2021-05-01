# PHP-ErqPlorer

This is a files explorer PHP script created for [free.fr](https://www.free.fr) perso pages.

## Configuration

Open `.ftp-erqplorer.php` and modify these config variables :
- `hideStartingWithDotDirectories` : Hide directories starting with a dot (`.git`)
- `hideStartingWithDotFiles` : Hide files starting with a dot (`.gitignore`)
- `exactFileSize` : Don't round file size (`1 KB` => `1337 B`)
- `dateFormat` : Change the date format

## Installation

Put these 2 files in the FTP root directory :
- `.ftp-erqplorer.php`
- `.htaccess`

It works!
