
## File `/etc/apache2/sites-available/lucy.conf`

```apacheconfig
define ROOT "/home/user/lucy"
define SITE "lucy.local"

<VirtualHost *:80>
	ServerName ${SITE}
	ServerAlias *.${SITE}
	ServerAdmin admin@local

	DocumentRoot ${ROOT}
	DirectoryIndex index.php
	<Directory ${ROOT}>
		Require all granted

		# Allow local .htaccess to override Apache configuration settings
		AllowOverride all
	</Directory>

	<IfModule mod_headers.c>
	    # X-XSS-Protection
	    Header set X-XSS-Protection "1; mode=block"

	    # X-Frame-Options
	    Header always append X-Frame-Options SAMEORIGIN

	    # X-Content-Type nosniff
	    Header set X-Content-Type-Options nosniff
	</IfModule>

	CustomLog /var/log/apache2/lucy-access.log combined
	ErrorLog /var/log/apache2/lucy-error.log
	LogLevel warn
</VirtualHost>
```

## Enabled file :  `a2ensite lucy.conf && sudo service apache2 restart`