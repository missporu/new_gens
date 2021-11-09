<style>
    .left-battle {
        background-color: #001d18;
    }
    .admin {
        font-weight: 800;
    }
</style>
<?php
$title='Война';
require_once('system/up.php');
_Reg();

/* Для заблокированных */
if ($set['block']==1) {
    header("Location: blok.php");
    exit();
}

$vrag_set=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='".$set['id_vrag']."' LIMIT 1");
$logi=_FetchAssoc("SELECT * FROM `user_voina` WHERE `id_user`='".$user_id."' AND `id_vrag`='".$vrag_set['id']."'  ORDER BY `id` DESC LIMIT 1");
$vraglimit = mysql_query("SELECT * FROM `user_set` WHERE `id` = '".$_GET['vrag']."' LIMIT 1");
$vrag_id = mysql_fetch_array($vraglimit);

switch ($_GET['case']) {
    default:
        if ($set['id_vrag']==0) {
            $_SESSION['err'] = 'Не выбран противник';
            header('Location: ?case=vrag');
            exit();
        } else {
            /* можно ловить исключения */
        } ?>
        <row>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center">
                <div class="row left-battle"><?=$user['login']?>
                    <img src="images/flags/<?=$set['side']?>.png" alt="Флаг" />
                    <img src="images/icons/vs.png" alt="vs" />
                    <img src="images/flags/<?=$vrag['side']?>.png" alt="Флаг" />
                    <?=$vrag_set['user']?><hr><?php
                    if (round(100 / ($vrag['max_hp'] / ($vrag['hp']))) > 100) {
                        $proc = 100;
                    } else {
                        $proc = round(100 / ($vrag['max_hp'] / ($vrag['hp'])));
                    } ?>
                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?=$proc ?>%; height: 18px; background-color: #f00; color: #000;"><?=$vrag['hp'] ?> hp
                    </div>
                </div>
                <div class="row text-center"><?php
                    if (empty($logi['rezult'])) {
                        header("Location: ?case=vrag");
                        exit();
                    }
                    if ($logi['rezult']=='nikto') {
                        if ($set['logo']=='on') { ?>
                            <img src="images/logotips/nikto.jpg" width="100%" alt="Ничья" class="img-responsive" /><hr><?php
                        } ?>
                        <h3 class="admin text-danger">Ничья !!!</h3><hr><?php
                    } elseif ($logi['rezult']=='win') {
                        if ($set['logo']=='on') { ?>
                            <img src="images/logotips/win.jpg" width="100%" alt="Победа" class="img-responsive" /><hr><?php
                        } ?>
                        <h3 class="admin text-info">Победа !!!</h3><hr><?php
                    } elseif ($logi['rezult']=='lose') {
                        
                    } ?>
                </div>
            </div>
            <!-- /.col-xs-12 col-sm-6 col-md-6 col-lg-6 -->
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-info">
                
            </div>
            <!-- /.col-xs-12 col-sm-6 col-md-6 col-lg-6 -->
        </row><?php
        echo ''.$vrag_set['user'].'';
        break;
}