<!DOCTYPE html>
<html>

<head>
    <title>PDF Demo for Qdev</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.2.228/build/pdf.min.js"></script>
    <style>
        body {
            margin: 0;
            background-color: #dfdfdf;
            /* Grey background */
        }

        .center {
            text-align: center;
            /* center pages */
        }
    </style>
</head>

<body>
    <div id="pages" class="center"></div>
    <script>
        // download the pdf
        var pdfTask = pdfjsLib.getDocument("../../vipimo/public/file.pdf");
        // parse the get params
        var queryString = window.location.hash.split("#")[1];
        // default params
        var params = {
            pg: 1
        };
        var pagen = 0;
        // if get params are present
        if (queryString) {
            // update the default settings
            params = Object.assign(params, parseParams(queryString));
        }
        // Load the pages div from the DOM
        var pages = document.getElementById("pages");
        // handle the pdf once loaded (asyncronous)
        pdfTask.promise.then(function(pdf) {
            // globalize pdf
            window.pdf = pdf;
            // load the first page
            loadPage(pdf, parseInt(params.pg));
            pagen++;
        });
        // stores the page number of the page currently in the viewport
        var curpage = parseInt(params.pg) + pagen;
        // every half a second, check for scroll updates
        setInterval(function() {
            // if we're within 200px of the bottom of the page
            if (document.body.scrollHeight - (window.scrollY + window.innerHeight) < 200) {
                if (window.pdf != undefined) {
                    // load 5 more pages
                    for (var i = 0; i < 5; i++) {
                        loadPage(pdf, parseInt(params.pg) + pagen);
                        pagen++;
                    }
                }
            }
            // if the page in our viewport has changed, update the url
            if (curpage != parseInt(params.pg) + parseInt(window.scrollY /
                    (document.body.scrollHeight / pagen))) {
                curpage = parseInt(params.pg) + parseInt(window.scrollY /
                    (document.body.scrollHeight / pagen));
                window.location.hash = "#pg=" + curpage;
            }
        }, 500);

        // render `pg` from `pdf` and append it to the pages div
        function loadPage(pdf, pg) {
            pdf.getPage(pg).then(function(page) {
                var scale = 1.7;
                var viewport = page.getViewport({
                    scale: scale
                });
                var canvas = document.createElement('canvas');
                var context = canvas.getContext('2d');

                canvas.id = "page-" + pg;
                canvas.height += viewport.height;
                canvas.width = viewport.width;

                pages.appendChild(canvas);

                var renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext);
            });
        }

        // parses get params from a query string into an object
        function parseParams(queryString) {
            var query = {};
            var pairs = (queryString[0] === '?' ? queryString.substr(1) : queryString).split('&');
            for (var i = 0; i < pairs.length; i++) {
                var pair = pairs[i].split('=');
                query[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1] || '');
            }
            return query;
        }
    </script>
</body>

</html>