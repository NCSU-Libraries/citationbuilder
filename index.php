<!DOCTYPE html>
<!--[if IE 7 ]>    <html lang="en" class="no-js lt-ie9 ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js lt-ie9 ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
    <title>Citation Builder | NCSU Libraries</title>
    <!--#include virtual="/sites/all/themes/ncsulib_foundation/templates/includes/head.html" -->
    <script type="text/javascript" src="./citeproc-js/xmldom.js"></script>
    <script type="text/javascript" src="./citeproc-js/citeproc.js"></script>
    <script src="scripts/datepicker.js"></script>
    <script src="scripts/citation.js"></script>
    <script src="scripts/app.js"></script>
    <script src="scripts/data.js"></script>
    <script src="scripts/data-storage.js"></script>
    <link rel="stylesheet" href="styles/app.css" />
</head>
<body>

    <div class="off-canvas-wrap">
        <div class="inner-wrap">

            <!-- HEADER: do not remove -->
            <!--#include virtual="/sites/all/themes/ncsulib_foundation/templates/includes/header.html" -->

            <div id="content" role="document" class="page">
                <main id="main-content" role="main" class="row l-main">

                    <!-- MAIN CONTENT HERE -->

                    <div class="medium-9 columns main">
                        <h1>Citation Builder</h1>

                        <?php include './includes/citation-select.php'; ?>

                        <div id="form-container">
                            <?php
                                $csl_array = array('apa','chicago-author-date','council-of-science-editors-author-date','modern-language-association','modern-language-association-8');
                                $medium_array = array('book','chapter','magazine','newspaper','article-journal','website');
                                foreach($medium_array as $med){
                                    print '<div class="form-parent" id="'.$med.'">';
                                        foreach($csl_array as $csl){
                                            print '<div class="form-child '.$csl.'">';
                                                include './includes/'.$med.'/'.$csl.'.html';
                                            print '</div>';
                                        }
                                    print '</div>';
                                }
                            ?>
                            <!-- <p><small>Miss the old <a href="/citationbuilder/old/">Citation Builder?</a></small></p> -->
                        </div>


                        <div id="citation-modal" class="reveal-modal row" data-reveal data-reveal-id="citation-modal">
                            <div id="citation-content"></div>
                            <a class="close-reveal-modal">&#215;</a>
                        </div>


                        <p>The Citation Builder is based on the following citation manuals:</p>

                        <ul>
                            <li>American Psychological Association 6th edition</li>
                            <li>Modern Language Association 7th edition</li>
                            <li>Modern Language Association 8th edition</li>
                            <li>Chicago Manual of Style 16th edition (author-date)</li>
                            <li>Council of Science Editors, Name-Year (author-date)</li>
                        </ul>


                    </div>


                    <aside class="medium-3 columns sidebar">

                        <div class="sidebar">
                            <h2>Citation Resources</h2>
                            <ul>
                                <li><a href="/tools-citation">Citation tools</a></li>
                                <li><a href="/do/reference-management">Citation management</a></li>
                            </ul>
                        </div>

                    </aside>

                    <!--- end content -->
                </main>
            </div> <!-- end .page -->
            <!-- FOOTER: do not remove -->
            <!--#include virtual="/sites/all/themes/ncsulib_foundation/templates/includes/footer.html" -->
        </div> <!-- end .inner-wrap -->
    </div> <!-- end .off-canvas-wrap -->
</body>
</html>
