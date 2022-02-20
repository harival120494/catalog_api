<?php
namespace App\Helper;

class Upload {
    static function uploadFoto($data)
    {
        $file = $data->file('foto');
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('foto'), $fileName);

        return $fileName;
    }

    static function uploadFotoProduct($data)
    {
        $file = $data->file('foto');
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('foto_products'), $fileName);

        return $fileName;
    }
}
