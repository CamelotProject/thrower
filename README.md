Camelot Throwable
==============

This library provides utility functions to help simplify menial tasks.

The Camelot team believes the PHP error reporting system is a mistake. Many
built-in functions utilize it, leading to inconsistent results and head
scratching.

This library provides some wrappers around some of these functions. Our code
should always throw exceptions instead of triggering errors/warnings/notices
(excluding deprecation warnings).
