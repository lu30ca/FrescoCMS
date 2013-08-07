<?php $this->getHeader();?>
<div id="container">
    <?php for($num=0; $num<count($this->content); $num++):?>
    <article>
        <h3><?php $this->printTitle($num);?></h3>
        <small><?php $this->printDate($num);?></small>
        <div class="content">
            <?php $this->printContent($num);?>
        </div>
    </article>
    <?php endfor;?>
</div>
<?php $this->getFooter();?>