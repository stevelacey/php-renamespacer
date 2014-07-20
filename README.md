PHP Renamespacer
================

An **unfinished** poor-man's namespace to actual namespace converter

http://philsturgeon.uk/blog/2014/07/deprecate-psr0

Install
-------

```sh
git clone git@github.com:stevelacey/php-renamespacer.git
cd php-renamespacer
composer install
```

Test
----

```sh
./php-renamespacer ./vendor/twig/twig
```

TODO
----

- [ ] Fix method param type hints
- [ ] Fix multiple inherits
- [ ] Jam the namespace declaration in less lazily
- [ ] Avoid & warn about multi-class files
- [ ] Wrap up in Symfony\Console task
- [ ] Summarise and highlight problems such as multiple namespace candidates
- [ ] PHPUnit test against a couple of underscore namespaced libs (Twig & ?)
