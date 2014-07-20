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

- [ ] Fix type hints
- [x] Fix multiple implements [c4a9d89](https://github.com/stevelacey/php-renamespacer/commit/bd138f704eb7b2302d2ba6d05b52799ad9b6702d)
- [ ] Jam the namespace declaration in less lazily
- [ ] Avoid & warn about multi-class files
- [ ] Wrap up in Symfony\Console task
- [ ] Summarise and highlight problems such as multiple namespace candidates
- [ ] PHPUnit test against a couple of underscore namespaced libs (Twig & ?)
