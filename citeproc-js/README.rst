======
README
======
-----------
citeproc-js
-----------

:author: Frank Bennett
:date: 2014.04.05

This is an effort to implement a full-featured standalone CSL
processor in Javascript, for use by the Zotero project, and by other
sites and platforms that can benefit from a standard method of
formatting citation data.

The demo page and test suite are the best routes to explore the
behavior of the processor, in that order. To set up the archive
for either, install the processor locales with the following
command::

   git clone git://github.com/fbennett/locales.git locale

(The official CSL locales live elsewhere, [#]_ but you'll want to use this set
for processor testing. Note the explicit target directory "locale" [singular]
following the repository address.)

To run the test suite, you need to add the standard test fixtures.
To do so, enter the directory ./tests/fixtures, and issue the 
following command::

  hg clone http://bitbucket.org/bdarcus/citeproc-test std

(Again, note the explicit target directory, "std", following the repository
address.)

For other details, see the manual, either in the ./manual subdirectory under the
name citeproc-doc.rst, or online at
http://gsl-nagoya-u.net/http/pub/citeproc-doc.html for details of this
program.

.. [#] http://github.com/citation-style-language/locales

Hope all goes well. If you have problems, post a note to the issue
tracker.

FB
