<?php
namespace App\Repositories;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionRepository {
    public function show()
    {
        $select = [
            't.id',
            'ui.name',
            'p.nama_product',
            'p.harga',
            'p.foto',
            't.jumlah',
            't.total',
            't.created_at'
        ];
        return DB::table('transactions as t')
                ->select($select)
                ->leftJoin('products as p','p.id','=','t.product_id')
                ->leftJoin('user_informations as ui','ui.user_id','=','t.user_id')
                ->orderBy('t.created_at', 'desc')
                ->get();
    }

    public function show_by_user($id)
    {
        $select = [
            't.id',
            'ui.name',
            'p.nama_product',
            'p.harga',
            'p.foto',
            't.jumlah',
            't.total',
            't.created_at'
        ];
        return DB::table('transactions as t')
                ->select($select)
                ->leftJoin('products as p','p.id','=','t.product_id')
                ->leftJoin('user_informations as ui','ui.user_id','=','t.user_id')
                ->where('t.user_id', $id)
                ->orderBy('t.created_at', 'desc')
                ->get();
    }


    public function create(array $data)
    {
        $transaksi_data = [
            'product_id' => $data['product_id'],
            'user_id'    => $data['user_id'],
            'jumlah'     => $data['jumlah'],
            'total'      => $data['total'],
        ];
        $save = Transaction::create($transaksi_data);
        if($save)
        {
            return Transaction::find($save->id);
        }
        else
        {
            return response()->json(['message'=>'Gagal menyimpan transaksi']);
        }
    }

    public function delete($id)
    {
        $updated = Transaction::destroy($id);
        if($updated) {
            return 'Berhasil di hapus';
        }
        else {
            return 'Gagal menghapus data';
        }
    }
}
