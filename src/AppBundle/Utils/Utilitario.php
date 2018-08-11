<?php
/**
 * Created by PhpStorm.
 * User: vitor_000
 * Date: 23/09/2017
 * Time: 10:36
 */

namespace AppBundle\Utils;

use AppBundle\Utils\Upload;

class Utilitario
{

    /* Envia foto evento */
    public function enviarFoto($imagem, $storeFolder){

        $handle = new Upload($imagem);

        //$handle->upload($imagem);

        if ($handle->uploaded) {

            $this_upload = array();

            $handle->file_auto_rename   = true;
            $handle->image_resize       = true;
            //$handle->image_ratio        = true;
            $handle->image_y            = 400;
            $handle->image_x            = 600;

            $handle->Process($storeFolder);

            if ($handle->processed) {
                $this_upload['large'] = $handle->file_dst_name;
            }


        }
        $handle->clean();
        $handle->file_dst_name;

        return $handle->file_dst_name;

    }

    /* Envia foto evento */
    public function enviarFotoDestaqueThumb($imagem, $storeFolder){

        $handle = new Upload($imagem);

        //$handle->upload($imagem);

        if ($handle->uploaded) {

            $this_upload = array();

            $handle->file_auto_rename   = true;
            $handle->image_resize       = true;
            //$handle->image_ratio        = true;
            $handle->image_y            = 400;
            $handle->image_x            = 600;

            $handle->Process($storeFolder);

            if ($handle->processed) {
                $this_upload['large'] = $handle->file_dst_name;
            }

            $handle->file_auto_rename   = true;
            $handle->image_resize       = true;
            //$handle->image_ratio        = true;
            $handle->image_y            = 100;
            $handle->image_x            = 100;

            $handle->Process($storeFolder.'/thumb/');

            if ($handle->processed) {
                $this_upload['small'] = $handle->file_dst_name;
            }

            // Foto Destaque
            $handle->file_auto_rename   = true;
            $handle->image_resize       = true;
            //$handle->image_ratio        = true;
            $handle->image_y            = 130;
            $handle->image_x            = 175;

            $handle->Process($storeFolder.'/destaque/');

            if ($handle->processed) {
                $this_upload['medium'] = $handle->file_dst_name;
            }

        }
        $handle->clean();
        $handle->file_dst_name;

        return $handle->file_dst_name;

    }

    public function splitGetLastWord($simbolToSplit, $stringToSplit){
        return substr($stringToSplit, strrpos($stringToSplit, $simbolToSplit) + 1);
    }

}