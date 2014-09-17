<!DOCTYPE html>
<!--[if IE 7 ]>    <html lang="en" class="no-js lt-ie9 ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js lt-ie9 ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
    <title>Citation Builder | NCSU Libraries</title>
    <!--#include virtual="/sites/all/themes/ncsulib_foundation/templates/includes/head.html" -->
    <!-- // <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script> -->
    <script type="text/javascript" src="./citeproc-js/xmldom.js"></script>
    <script type="text/javascript" src="./citeproc-js/citeproc.js"></script>
    <script src="scripts/citation.js"></script>
    <script src="scripts/fields.js"></script>
    <script src="scripts/app.js"></script>
    <script src="scripts/data.js"></script>
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
                        <div id="form-container"></div>
                        <!--?php include './includes/form.php'; ?-->

                        <div id="citation-modal" class="reveal-modal row" data-reveal data-reveal-id="citation-modal">
                            <div id="citation-content"></div>
                            <a class="close-reveal-modal">&#215;</a>
                        </div>

                    </div>

                    <aside class="medium-3 columns sidebar">

                        <div class="sidebar">
                            <h2>This is a sidebox (h2)</h2>
                            <ul>
                                <li><a href="#">That is our most modestly</a></li>
                                <li><a href="#">priced receptacle</a></li>
                                <li><a href="#">Malesuada suscipit malesuada</a></li>
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
