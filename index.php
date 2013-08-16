<?php
/*
 * FrescoCMS
 * ---------
 * Questo è l'ingresso principale del sito web per ogni richiesta da parte dei
 * visitatori che non sia soddisfatta da file già esistenti.
 * Questo è l'unico file con estensione .php a cui può accedere direttamente
 * l'utente.
 * Vedi il file .htaccess per maggiori dettagli.
 * ---------
 * 
 * Importa la configurazione del CMS
 */
require("config.php");
/*
 * Controlla se il sito è in manutenzione, per mettere il sito in modalità
 * manutenzione è sufficente modificare la variabile MANUTENZIONE in config.php
 * e impostarla su true oppure inserire un file html chiamato manutenzione.html
 * all'interno della root del sito.
 */
if(MANUTENZIONE||file_exists("manutenzione.html")){
    if(file_exists("themes/".TEMA."/manutenzione.html")&&!file_exists("manutenzione.html"))include("themes/".TEMA."/manutenzione.html");
    elseif(file_exists("manutenzione.html"))include("manutenzione.html");
    else echo "<h1>Sito in manutenzione</h1><p>Ripassa tra un po'...<p>";
    exit();
}
/*
 * Se il sito si trova in una sottocartella del dominio SITE_DIRECTORY assumera
 * come valore il nome della cartella preceduto e seguito da "/", se non si
 * trova in una sottocartella assumerà come valore "/".
 */
if(!defined('SITE_DIRECTORY'))define('SITE_DIRECTORY',str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('index.php','',$_SERVER['PHP_SELF'])));
/*
 * Carica la classe principale ed esegue la sua funzione __construct.
 */
require_once "includes/main.php";
$fresco=new Fresco();