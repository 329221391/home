<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <script src="//cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="css/ns-default.css" />
        <link rel="stylesheet" type="text/css" href="css/ns-style-growl.css" />
        <script src="js/modernizr.custom.js"></script>
        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    <style type="text/css">
        
        .ns-effect-jelly {
            }

    </style>

    </head>

        

    <body class="color-9">
        <div class="container">
            <!-- Top Navigation -->
            <div class="codrops-top clearfix">
                <a class="codrops-icon codrops-icon-prev" href="http://tympanus.net/Development/SelectInspiration/"><span>Previous Demo</span></a>
                <a class="codrops-icon codrops-icon-drop" href="http://tympanus.net/codrops/?p=19415"><span>Back to the Codrops Article</span></a>
            </div>
            <header class="codrops-header">
            </header>
            <div class="main clearfix">
                <div class="column">
                    <p class="small">Click on the button to show the notification:</p>
                    <button id="notification-trigger" class="progress-button">
                        <span class="content">Show Notification</span>
                        <span class="progress"></span>
                    </button>
                </div>
                <div class="column">
                    <nav class="codrops-demos">
                        <h3>Growl-like</h3>
                        <div>
                            <a href="index.html">Scale</a>
                            <a class="current-demo" href="growl-jelly.html">Jelly</a>
                            <a href="growl-slide.html">Slide in</a>
                            <a href="growl-genie.html">Genie</a>
                        </div>
                        <h3>Attached</h3>
                        <div>
                            <a href="attached-flip.html">Flip</a>
                            <a href="attached-bouncyflip.html">Bouncy Flip</a>
                        </div>
                        <h3>Top Bar</h3>
                        <div>
                            <a href="bar-slidetop.html">Slide On Top</a>

                            <a href="bar-exploader.html">Expanding Loader</a>
                        </div>
                        <h3>Other</h3>
                        <div>
                            <button id="asdfasf">dianji</button>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- Related demos -->
        </div><!-- /container -->
        <script src="/js/classie.js"></script>
        <script src="/js/notificationFx.js"></script>

        <script>
            (function() {
                var notification = new NotificationFx({
                    message : '<p>Hello there! I\'m a classic notification but I have some elastic jelliness thanks to <a href="http://bouncejs.com/">bounce.js</a>. </p>',
                    layout : 'growl',
                    effect : 'jelly',
                    type : 'notice', // notice, warning, error or success
                    onClose : function() {
                       
                    }
                });

                $('.ns-effect-jelly').css('position', 'absolute');
                $('.ns-effect-jelly').css('width', '300');
                $('.ns-effect-jelly').css('height', '200');
                $('.ns-effect-jelly').css({ "left": "50px", "top":"150px"});
               
                

                

                notification.show(); return;

            })();
        </script>
    </body>
</html>