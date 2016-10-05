<?php
/**
* @author Dmitry Porozhnyakov
*/
?>
<?      if( !empty( $data::$top_publication ) ):
        ?>
        <div class="bg-color-blueDark  padding10-20 fg-color-white">
             <?=$data::$top_publication,"\r\n";?>
        </div>
<?      endif;
        ?>
        <div class="errors error-bar" id="cookieWarning">
            <?=$data::$second_service_name;?> активно использует cookies.<br />
            Функционал сайта ограничен. Пожалуйста, включите хранение cookie-файлов в своём браузере.
        </div>
        <noscript>
            <div class="errors error-bar">
                <?=$data::$second_service_name;?> интенсивно использует JavaScript.<br />
                Функционал сайта ограничен. Пожалуйста, включите JavaScript в настройках обозревателя.
            </div>
        </noscript>
        <!--[if lt IE 9]>
            <div class="errors info-bar">
                Вы используете устаревший браузер. Рекомендуем обновиться до более новой версии.
            </div>
        <![endif]-->