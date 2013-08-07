<?php $this->getHeader();?>
<div id="container">
    <article>
        <h1><?php $this->printTitle();?></h1>
        <small><?php $this->printDate();?></small>
        <div class="content">
            <?php $this->printContent();?>
        </div>
    </article>
</div>
<?php $this->getFooter();?>