<?php $this->getHeader();?>
<div id="container">
    <?php for($num=0; $num<count($this->content); $num++):?>
    <article>
        <h3><a href="<?php $this->printUrl($num);?>"><?php $this->printTitle($num);?></a></h3>
        <small><?php $this->printDate($num);?></small>
        <div class="content">
            <?php $this->printContent($num);?>
        </div>
        <i><a href="<?php $this->printUrl($num,'autore');?>"><?php $this->printAutor($num);?></a></i>
    </article>
    <?php endfor;?>
</div>
<?php $this->getFooter();?>