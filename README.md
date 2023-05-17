# Bachelor's thesis - ENAI interactive database of materials

## Information

- thesis = folder containing the attached thesis
- materials = folder with the application

## Configuration of CI4
Development was done using XAMPP and its Apache and MySQL server.\
Because of that there was a need to modify the default 'httpd.conf' file:

1) add extension
```
extesion=intl
```

2) add module
```
LoadModule rewrite_module modules/mod_rewrite.so
```

2) add httdocs directory ruleset
```
#
# CodeIgniter requirement
#
<Directory "/opt/lamp/apache2/htdocs">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

3) edit the root directory:
```
DocumentRoot "C:/Programs/xampp/htdocs/materials/public"
<Directory "C:/Programs/xampp/htdocs/materials/public">
```

For direct configuration of the framework, the env file had to be renamed to\
.env and following modifications made:
```
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost/'
```
