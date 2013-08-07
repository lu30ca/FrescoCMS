<?php $this->getHeader();?>
<div id="container">
    <h1><?php $this->printTitle();?></h1>
    <i><?php $this->printEmail();?></i>
    <div class="content">
        <?php $this->printContent();?>
    </div>
</div>
<?php $this->getFooter();?>