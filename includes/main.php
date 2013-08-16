<?php
require_once 'includes/db.php';
class Fresco{
    //Contenitore classe Db
    private $db;
    //Tipo della pagina richiesta(home,utente,articolo,pagina...)
    private $req_type;
    //Id del contenuto richiesto
    private $req_id;
    //Array contenente il contenuto
    private $content;
    //Array contente l'elenco di pagine del menù
    private $menu;
    /***
     * Metodo eseguito in automatico una volta istanziata la classe,
     * avvia la connessione al database e il dispatcher.
     */
    public function __construct(){
        $this->db=new MysqliDb();
        $this->dispatch($this->getRequest());
        $this->content=$this->getContent($this->req_type,$this->req_id);
        require_once 'themes/'.TEMA.'/'.$this->req_type.'.php';
    }
    /***
     * Restituisce l'id e il tipo di pagina per le funzioni di rendering, importa
     * la pagina corretta del template e gestisce gli errori.
     */
    private function dispatch($req){
        $req=$this->db->escape($req);
        if($req==null||$req=='index.php'){//Restituisce l'home page, ATTENZIONE: Aggiungere altre pagine home per i vecchi articoli. Oppure risolvere il problema con ajax e javascript facendoli aggiungere sulla stessa pagina (più elegante).
            $this->req_type='home';
        }
        elseif(substr($req,0,1)=="&"){
            if($this->req_id=$this->isUser(substr($req,1)))$this->req_type='utente';
            else $req=404;
        }elseif(substr($req,0,6)=="eventi"&&(substr($req,6)==null||substr($req,6,1)=="/")){
            if(substr($req,7)==null){
                $this->req_type='eventi';
            }elseif(!substr($req,7)==null){
                if($this->req_id=$this->isEvent(substr($req,7)))$this->req_type='evento';
                else $req=404;
            }
        }elseif($this->req_id=$this->isArticle($req))$this->req_type='articolo';
        elseif($this->req_id=$this->isPage($req))$this->req_type='pagina';
        else $req=404;
        if($req==404)$this->req_type='404';
    }
    /***
     * Estrapola e restituisce la parte di url che ci interessa per capire che
     * contenuto ci viene richiesto.
     */
    private function getRequest(){
        return str_replace(str_replace('index.php','',$_SERVER['PHP_SELF']),'',$_SERVER['REQUEST_URI']);
    }
    /***
     * Controlla se un utente esiste, restituisce il suo id.
     */
    private function isUser($a){
        $nameSurnameN=preg_split('/(?=[A-Z0-9])/',$a, -1, PREG_SPLIT_NO_EMPTY);
        if($nameSurnameN[1]==null)return 0;
        else{
            $result=$this->db
                    ->where('nome', $nameSurnameN[0])
                    ->where('cognome',$nameSurnameN[1])
                    ->get('utenti','id');
            if($nameSurnameN[2]==null)$n=0;
            else $n=$nameSurnameN[2]-1;
            return $result[$n][id]?$result[$n][id]:0;
        }
    }
    /***
     * Controlla se un articolo esiste, restituisce il suo id.
     */
    private function isArticle($a){
        $a=str_replace('-',' ',$a);
        $result=$this->db
                    ->where('titolo',$a)
                    ->get('contenuti','id,layout_pagina');
        if(!$result[0][layout_pagina])return $result[0][id];
        else return 0;
    }
    /***
     * Controlla se una pagina esiste, restituisce il suo id.
     */
    private function isPage($a){
        $a=str_replace('-',' ',$a);
        $result=$this->db
                    ->where('titolo',$a)
                    ->get('contenuti','id,layout_pagina');
        if($result[0][layout_pagina])return $result[0][id];
        else return 0;
    }
    /***
     * Controlla se un evento esiste, restituisce il suo id.
     */
    private function isEvent($a){
        $a=str_replace('-',' ',$a);
        $result=$this->db
                    ->where('titolo',$a)
                    ->get('eventi','id');
        return $result[0][id]?$result[0][id]:0;
    }
    /***
     * Include l'header all'interno della pagina.
     */
    public function getHeader(){
        require_once 'themes/'.TEMA.'/header.php';
    }
    /***
     * Include il footer all'interno della pagina.
     */
    public function getFooter(){
        require_once 'themes/'.TEMA.'/footer.php';
    }
    /*
     * Estrae il contenuto per la pagina attuale.
     */
    public function getContent($type,$id){
        switch($type){
            case "home":
                $result=$this->db
                    ->where('layout_pagina','0')
                    ->get('contenuti','titolo, contenuto, data, autore, commenti, numero_commenti, importanza, immagine');
                break;
            case "utente":
                $result=$this->db
                    ->where('id',$id)
                    ->get('utenti','nome, cognome, mostra_email, email, immagine, descrizione, strumenti');
                break;
            case "eventi":
                $result=$this->db
                    ->get('eventi','titolo, data_inizio, data_fine, descrizione, immagine');
                break;
            case "evento":
                $result=$this->db
                    ->where('id',$id)
                    ->get('eventi','titolo, data_inizio, data_fine, descrizione, immagine');
                break;
            case "articolo":
                $result=$this->db
                    ->where('id',$id)
                    ->get('contenuti','titolo, contenuto, data, autore, commenti, numero_commenti, importanza, immagine');
                break;
            case "pagina":
                $result=$this->db
                    ->where('id',$id)
                    ->get('contenuti','titolo, contenuto, commenti, numero_commenti, immagine');
                break;
            case "404":
                break;
        }
        return $this->content=$result;
    }
    /***
     * Restituisce il titolo per la pagina attuale.
     */
    public function pageTitle(){
        switch($this->req_type){
            case "home":
                break;
            case "utente":
                $title=$this->content[0][nome].' '.$this->content[0][cognome];
                break;
            case "eventi":
                $title='Eventi';
                break;
            case "evento":
            case "articolo":
            case "pagina":
                $title=$this->content[0][titolo];
                break;
            case "404":
                $title='Pagina non trovata';
                break;
        }
        print $title=$title?$title.' | '.SITE_NAME:SITE_NAME;
    }
    public function printTitle($num=0){
        if($this->req_type=='utente')print $this->content[0][nome].' '.$this->content[0][cognome];
        else print $this->content[$num][titolo];        
    }
    public function printContent($num=0){
        if($this->req_type=='utente'||$this->req_type=='evento'||$this->req_type=='eventi')print $this->content[$num][descrizione];
        else print $this->content[$num][contenuto];
    }
    public function printAutor($num=0){
        $res=$this->db
                ->where('id',$this->content[$num][autore])
                ->get('utenti','nome, cognome');
        print $res[0][nome].' '.$res[0][cognome];
    }
    public function printDate($num=0){
        if($this->req_type=='evento'||$this->req_type=='eventi'){
            print 'Inizio: '.$this->content[$num][data_inizio].' Fine: '.$this->content[$num][data_fine].'.';
        }else print $this->content[$num][data];
    }
    public function printEmail(){
        if($this->content[0][mostra_email]==1)print $this->content[0][email];
    }
    public function printComment($type,$id){
        
    }
    public function printUrl($num=0,$type){
        switch($type){
            case 'autore':
                $res=$this->db
                    ->where('id',$this->content[$num][autore])
                    ->get('utenti','nome, cognome, numero');
                $url='&'.$res[0][nome].$res[0][cognome].$res[0][numero];
                break;
            case 'evento':
                $url='eventi/'.str_replace(' ','-',$this->content[$num][titolo]);
                break;
            default:
                $url=str_replace(' ','-',$this->content[$num][titolo]);
        }
        print 'http://'.$_SERVER['SERVER_NAME'].SITE_DIRECTORY.$url;
    }
}