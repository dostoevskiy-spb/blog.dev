<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Rock CastleDescription: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20111127

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Тестовый блог</title>
    <link href="/css/style.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
    <link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
        <link href="/css/uniform.css" media="screen" rel="stylesheet" type="text/css"/>
        <link href="/css/style2.css" media="screen" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery.tools.js"></script>
    <script type="text/javascript" src="/js/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="/js/comment.js"></script>
        <link href="/js/fancybox/jquery.fancybox.css" type="text/css" rel="stylesheet" media="all">
    <script src="/js/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="/js/core.js" type="text/javascript"></script>
</head>
<body>
<div id="header" class="container">
    <div id="logo">
        <h1><a href="/">Тестовый блог</a></h1>
    </div>
    <div id="menu">
        <ul>
            <?
            use main\App;

            if (App::isAuthorized()) {
                ?>
                <li class="current_page_item"><a href="/user/logout">Выйти</a></li>
                <li><a href="/blog/create">Добавить запись</a></li>
            <? } else { ?>
                <li><a class="login fancybox.inline" href="#login-window">Вход</a></li>
            <? } ?>
        </ul>
    </div>
</div>
    <div id="splash-wrapper">
        <div id="splash">
            <h2>Самописный блог</h2>

            <p>
                Этот блог сделан без использования фреймворков. Только самописный код. HTML-шаблон взят с сайта бесплатных шаблонов. Автор - Ламзин Павел.
            </p>
        </div>
    </div>
<!-- end #header -->
<div id="wrapper">
    <div id="wrapper2">
        <div id="wrapper-bgtop">
            <div id="page">
                <div id="content">
                    <?= $content ?>
                    <div style="clear: both;">&nbsp;</div>
                </div>
                <!-- end #content -->
                <!--<div id="sidebar">
                    <div id="sidebar-bgtop">
                        <div id="sidebar-bgbtm">
                            <ul>
                                <li>
                                    <div id="search" >
                                        <form method="get" action="#">
                                            <div>
                                                <input type="text" name="s" id="search-text" value="" />
                                                <input type="submit" id="search-submit" value="GO" />
                                            </div>
                                        </form>
                                    </div>
                                    <div style="clear: both;">&nbsp;</div>
                                </li>
                                <li>
                                    <h2>Aliquam tempus</h2>
                                    <p>Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.</p>
                                </li>
                                <li>
                                    <h2>Categories</h2>
                                    <ul>
                                        <li><a href="#">Aliquam libero</a></li>
                                        <li><a href="#">Consectetuer adipiscing elit</a></li>
                                        <li><a href="#">Metus aliquam pellentesque</a></li>
                                        <li><a href="#">Suspendisse iaculis mauris</a></li>
                                        <li><a href="#">Urnanet non molestie semper</a></li>
                                        <li><a href="#">Proin gravida orci porttitor</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <h2>Blogroll</h2>
                                    <ul>
                                        <li><a href="#">Aliquam libero</a></li>
                                        <li><a href="#">Consectetuer adipiscing elit</a></li>
                                        <li><a href="#">Metus aliquam pellentesque</a></li>
                                        <li><a href="#">Suspendisse iaculis mauris</a></li>
                                        <li><a href="#">Urnanet non molestie semper</a></li>
                                        <li><a href="#">Proin gravida orci porttitor</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <h2>Archives</h2>
                                    <ul>
                                        <li><a href="#">Aliquam libero</a></li>
                                        <li><a href="#">Consectetuer adipiscing elit</a></li>
                                        <li><a href="#">Metus aliquam pellentesque</a></li>
                                        <li><a href="#">Suspendisse iaculis mauris</a></li>
                                        <li><a href="#">Urnanet non molestie semper</a></li>
                                        <li><a href="#">Proin gravida orci porttitor</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>-->
                <!-- end #sidebar -->
                <div style="clear: both;">&nbsp;</div>
            </div>
            <!-- end #page -->
        </div>
    </div>
</div>
<div id="footer">
    <div class="content">
        <p>Тестовый блог. Автор - Ламзин Павел. 2014 год.</p>
    </div>
</div>
<!-- end #footer -->
<div class="login-window" id="login-window" style="display: none;">
    <div class="title">Вход. Логин - admin. Пароль- admin</div>
    <div class="form">
        <form id="login-form" action="/user/login" method="post">
            <input placeholder="Введите ваши логин" name="username" id="username" type="text"/>
            <input placeholder="и пароль" name="password" id="password" type="password"/>
            <input type="submit" name="" value="Войти"/>
        </form>
    </div>
</div>
</body>
</html>
