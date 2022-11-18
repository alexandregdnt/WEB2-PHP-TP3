<?php

namespace App\Helpers;

class Printers
{
    public static function printInfo($sMsg): void
    {
        echo '<div class="alert info"><i class="uil uil-times alert__close" id="nav-close"></i><strong>Info : </strong> '.$sMsg.'</div>';
        // echo '<div class="alert alert-info"><strong>Info : </strong>'.$sMsg.'</div>';
    }

    public static function printSuccess($sMsg): void
    {
        echo '<div class="alert success"><i class="uil uil-times alert__close" id="nav-close"></i><strong>Succès : </strong> '.$sMsg.'</div>';
        // echo '<div class="alert alert-success"><strong>Succès : </strong>'.$sMsg.'</div>';
    }

    public static function printWarning($sMsg): void
    {
        echo '<div class="alert warning"><i class="uil uil-times alert__close" id="nav-close"></i><strong>Attention : </strong> '.$sMsg.'</div>';
        // echo '<div class="alert alert-warning"><strong>Attention : </strong>'.$sMsg.'</div>';
    }

    public static function printError($sMsg): void
    {
        echo '<div class="alert"><i class="uil uil-times alert__close" id="nav-close"></i><strong>Erreur : </strong> '.$sMsg.'</div>';
        // echo '<div class="alert alert-danger"><strong>Erreur : </strong>'.$sMsg.'</div>';
    }

    public static function printDay($sTime=null) {
        if ($sTime === null) {
            $sTime=time();
        }

        $aNameMonths[1] = 'janvier';
        $aNameMonths[2] = 'février';
        $aNameMonths[3] = 'mars';
        $aNameMonths[4] = 'avril';
        $aNameMonths[5] = 'mai';
        $aNameMonths[6] = 'juin';
        $aNameMonths[7] = 'juillet';
        $aNameMonths[8] = 'août';
        $aNameMonths[9] = 'septembre';
        $aNameMonths[10] = 'octobre';
        $aNameMonths[11] = 'novembre';
        $aNameMonths[12] = 'décembre';

        $aDays[0] = 'dimanche';
        $aDays[1] = 'lundi';
        $aDays[2] = 'mardi';
        $aDays[3] = 'mercredi';
        $aDays[4] = 'jeudi';
        $aDays[5] = 'vendredi';
        $aDays[6] = 'samedi';

        return date('h:i:s',$sTime).' le '.$aDays[date('w',$sTime)].', '.date('d',$sTime).' '.$aNameMonths[date('n',$sTime)].' '.date('Y',$sTime);
    }

}