<?php
namespace App\Repositories;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class ProductRepository {
    public function show()
    {
        return Products::where('status', 1)->orderBy('nama_product','asc')->get();
    }

    public function create(array $data, $file_path)
    {
        $product_data = [
            'nama_product' => $data['nama_product'],
            'sku'       => $data['sku'],
            'stock'     => $data['stock'],
            'status'    => 1,
            'desc'      => $data['desc'],
            'harga'      => $data['harga'],
            'foto'      => $file_path
        ];
        $save = Products::create($product_data);
        if($save)
        {
            return Products::find($save->id);
        }
        else
        {
            return response()->json(['message'=>'Gagal menyimpan product']);
        }
    }

    public function read($id)
    {
        return Products::find($id);
    }

    public function update(array $data, $id, $file_path)
    {
        $product_data = [];
        if($data['isImagePicker'] == 'true'){
            $product_data = [
                'nama_product'  => $data['nama_product'],
                'sku'           => $data['sku'],
                'desc'          => $data['desc'],
                'harga'         => $data['harga'],
                'stock'         => $data['stock'],
                'foto'          => $file_path
            ];
        }
        else{
            $product_data = [
                'nama_product'  => $data['nama_product'],
                'sku'           => $data['sku'],
                'desc'          => $data['desc'],
                'harga'         => $data['harga'],
                'stock'         => $data['stock']
            ];
        }
        $updated = DB::table('products')
                    ->where('id', $id)
                    ->update($product_data);
        if($updated) {
            return Products::find($id)->first();
        }
        else {
            return 'Gagal update data';
        }
    }

    public function delete($id)
    {
        $updated = DB::table('products')
                    ->where('id', $id)
                    ->update(['status'=>0]);
        if($updated) {
            return Products::find($id)->first();
        }
        else {
            return 'Gagal update data';
        }
    }


    public function change_foto($id, $file_path)
    {
        $updated = DB::table('products')
                    ->where('id', $id)
                    ->update(['foto'=>$file_path]);
        if($updated) {
            return Products::find($id)->first();
        }
        else {
            return 'Gagal mengganti foto';
        }
    }
}
