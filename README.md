# Catsquare

Yet another stupid hobby project. This application is intended for square cat pictures.

The rationale is simple: learn and finish! How? By building a project from scratch, in a language I haven't used professionally and where it's easy to make mistakes. The definition of done is when it's uploaded to a server.

Mistakes were made, and this code is not secure.

## Getting Started

To get started, FTP the files to the target server.

A `config.php` file is required before running the application. Replace the dots with proper values. This configuration will also imrpove the security of the session token.

```php
<?php
define("DB_HOSTNAME", "...");
define("DB_USERNAME", "...");
define("DB_PASSWORD", "...");
define("DB_NAME", "...");

define("SESSION_OPTIONS", [
    "name" => "__Host-SESSID",
    "cookie_path" => "/",
    "cookie_secure" => true,
    "cookie_httponly" => true,
    "cookie_samesite" => "Lax",
]);
```

It's highly recommended to create a `.htaccess` file. The contents below will restrict access to files and directories and add essential security headers. It requires HTTPS to be configured.

```
Options -Indexes

RedirectMatch 403 ^/includes(/.*)?$
RedirectMatch 403 ^/templates(/.*)?$
RedirectMatch 403 ^/\.
RedirectMatch 403 ^/config\.php$

RewriteEngine On
RewriteCond %{HTTPS} !=on
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

<IfModule mod_headers.c>
    Header always set Referrer-Policy "same-origin"
    Header always set Strict-Transport-Security "max-age=63072000; includeSubDomains"
    Header always set X-Frame-Options "DENY"
    Header always set X-Content-Type-Options "nosniff"
</IfModule>
```

This is PHP at its best — low barrier to entry and mistakes.
