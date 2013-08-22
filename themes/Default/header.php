<html>
    <head>
        <title><?php $this->pageTitle();?></title>
        <meta charset='utf-8'>
    </head>
    <body>
        <header>
            <img id='logo-img'/>
            <hgroup>
                <h2>Scuola di musica</h2>
                <h1>"G. Frescobaldi"</h1>
            </hgroup>
            <div id="menu-top">
                <?php for($num=0; $num<count($this->menu); $num++):?>
                <li><a href="<?php $this->printUrl($num,'menu');?>"><?php $this->printMenuItem($num);?></a></li>
                <?php endfor;?>
            </div>
        </header>