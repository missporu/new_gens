<?php
require_once('sys.php'); ?>
<div class="clearfix"></div><hr>
<div class="container">
    <div class="row">
        <div class="col-xs-2">
            <h1 class="text-info">
                <a href="/"><span class="glyphicon glyphicon-home"></span></a>
            </h1>
        </div>
        <div class="col-xs-8 text-center">
            <h1 class="text-danger"><?= $site->name ?></h1>
        </div>
        <div class="col-xs-2 text-right">
            <h1 class="text-info">
                <a href=""><span class="glyphicon glyphicon-refresh"></span></a>
            </h1>
        </div>
    </div>
</div>
<div class="clearfix"></div><hr>
<div class="clearfix"></div><?php
if (isset($_SESSION['err'])) { ?>
    <div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?= $_SESSION['err'] ?>
    </div><?php
    $_SESSION['err'] = NULL;
} ?>
<div class="clearfix"></div><?php
