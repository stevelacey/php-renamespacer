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

- [ ] Fix global function references
- [ ] Fix up abnormalities we can't automate and run Twig test suite as part of ours
    Current state:

    ```
    FAILURES!
    Tests: 270, Assertions: 1040, Failures: 8, Errors: 93.
    ```
- [ ] PHPUnit test against a couple of underscore namespaced libs (Twig & ?)
- [ ] Attempt to fix predictable docblocks
- [ ] Jam the namespace declaration in less lazily
- [ ] Wrap up in Symfony\Console task
