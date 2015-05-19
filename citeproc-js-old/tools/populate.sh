#!/bin/bash

./test.py -Z
cp citeproc_zotero.js ~/src/zotero-processor/chrome/content/citeproc.js
mv citeproc_zotero.js ~/src/zotero/chrome/content/zotero/xpcom/citeproc.js
