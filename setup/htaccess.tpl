Options +FollowSymLinks
RewriteEngine On
RewriteBase /

RewriteRule public/.*	- [L]
RewriteRule .*$	index.php