Package Skeleton
================
- [Installation](#installation)
- [Usage](#usage)
- [Testing](#testing)
- [Author](#author)


Installation
------------

First, clone the repository and cd into newly created directory:

``` bash
git clone https://github.com/jszemplinski/simple_rss_fetch.git

cd simple_rss_fetch
```


Then, install all required dependencies listed in `composer.json`:

`php composer.phar install`


Usage
-----

* Simple mode - get RSS/Atom data from `URL` and save it to `PATH`.csv file. Any data
previously stored in `PATH`.csv will be overriden!

``` bash
php src/console.php csv:simple URL PATH
```

* Extended mode - get RSS/Atom data from `URL` and save it to `PATH`.csv file. It will
be appended to previously stored data in that file. `PATH`.csv file needs to exist before executing
this command!

``` bash
php src/console.php csv:extended URL PATH
```

Testing
-------

``` bash
$ phpunit
```


Author
-------
Jacek Szempliński (j.szemplinski@wp.eu)
