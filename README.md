# Bachelor's thesis - ENAI interactive database of materials

### Accesses
Admin login page: dev.academicintegrity.eu/wp\
Google analytics: NONE SO FAR (only basic in wordpress administartion)

### Planned frameworks:
- [ ] CodeIgniter 4 = PhP framework, database, input and file operations, verification
- [ ] Bootstrap = CSS framework, easier designing of page for multiple screen layouts and devices

### Thesis goals (detailed at the end of readme):
- [ ] Write down the decision process of framework selection
- [ ] Write down the needed configuration steps for CI4
- [ ] Short introduction of MVC used by CI4
- [ ] Create and present new functional requiremens
- [ ] Write down analysis of previous data model and present new data model as a result
- [ ] Create and present new theme of materials page
- [ ] Create and present new admin page (not connected to WordPress)

### Project goals:
- [ ] user research (ask each category what they expect from the system: UNI students, UNI teachers, admins)
- [ ] (O) use google analytics to improve base pages
- [ ] Keep original functionality (except select few: comments,...)
- [ ] Frequented materials
- [ ] Material scoring (stars/views/downloads)
- [ ] Easier searching (keywords, fulltext)
- [ ] Easier material edits in administration (it was hard when editing uploaded files)
- [ ] Material overview in administration
- [ ] Optimization for mobile phones (UI, not needed in administration)
- [ ] Documentation

#### Old documentation:
```
See the previous bachelor's thesis by Leoš Lang (folder old-docs).
```

#### Contacts with PM and TL:
PM: Bc. Zita = should be easy till December, after which there are no guarantees\
TL: Tomáš Foltýnek = every 2 weeks, starting at 23.09.2022

### Detailed notes:
------------------------------------------------------------------------------
##### Framework selection
There are many PhP frameworks free to use, however only one is needed. For that\
I needed to reduce the possible selection. Criteria were the following:\
- lightweight (it's only for one page afterall)\
- MVC (easy to work with)\
- easy to learn + has good documentation\
- built-in security features\
- capable of providing admin access page (for file management)\
- capable of easier database operations\
- PHP 8+ support
- under active development/support\
Under such rules I've taken a look at the current PhP framework popularity list\
from several sources and inspected the top few frameworks for meeting the criteria:\
- Laravel\
- Symfony\
- CodeIgniter\
- FuelPhP\
- Slim\
- CakePhP\
- Phalcon

##### Configuration of CI4
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

##### MVC

##### Functional requirement (connected to project goals)

##### Data models

##### Materials page

##### Admin page
------------------------------------------------------------------------------