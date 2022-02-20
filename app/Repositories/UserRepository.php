<?php
namespace App\Repositories;
use App\Models\User;
use App\Models\UserInformations;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserRepository {
    public function show()
    {
        $select = [
            'u.id',
            'u.email',
            'u.password',
            'ui.name',
            DB::raw('CASE WHEN u.status = 1 THEN "Active" ELSE "Nonactive" END as status'),
            'ui.tempatLahir',
            'ui.tglLahir',
            'ui.no_hp',
            'ui.alamat',
            'ui.foto'
        ];
        return DB::table('users as u')
                    ->select($select)
                    ->leftJoin('user_informations as ui','u.id','=','ui.user_id')
                    ->where('u.status', 1)
                    ->orderBy('ui.name', 'asc')
                    ->get();
    }

    public function read($id)
    {
        $select = [
            'u.id',
            'u.email',
            'u.password',
            'ui.name',
            DB::raw('CASE WHEN u.status = 1 THEN "Active" ELSE "Nonactive" END as status'),
            'ui.tempatLahir',
            'ui.tglLahir',
            'ui.no_hp',
            'ui.alamat',
            'ui.foto'
        ];
        return DB::table('users as u')
                    ->select($select)
                    ->leftJoin('user_informations as ui','u.id','=','ui.user_id')
                    ->where('u.id','=', $id)
                    ->first();
    }

    public function update(array $data, $id, $file_path)
    {

        $data_information = [];
        if($data['isImagePicker'] == 'true'){
            $data_information = [
                'name'          => $data['name'],
                'tempatLahir'   => $data['tempatLahir'],
                'tglLahir'      => $data['tglLahir'],
                'no_hp'         => $data['no_hp'],
                'alamat'        => $data['alamat'],
                'foto'          => $file_path
            ];
        }
        else{
            $data_information = [
                'name'          => $data['name'],
                'tempatLahir'   => $data['tempatLahir'],
                'tglLahir'      => $data['tglLahir'],
                'no_hp'         => $data['no_hp'],
                'alamat'        => $data['alamat']
            ];
        }


        $updated = DB::table('user_informations')
                    ->where('user_id', $id)
                    ->update($data_information);
        if($updated) {
            return UserInformations::where('user_id',$id)->first();
        }
        else {
            return 'Gagal update data';
        }
    }

    public function delete($id)
    {
        $updated = DB::table('users')
                    ->where('id', $id)
                    ->update(['status'=>0]);
        if($updated) {
            return User::find($id)->first();
        }
        else {
            return 'Gagal update data';
        }
    }

    public function change_foto($id, $file_path)
    {
        $updated = DB::table('user_informations')
                    ->where('id', $id)
                    ->update(['foto'=>$file_path]);
        if($updated) {
            return UserInformations::find($id)->first();
        }
        else {
            return 'Gagal mengganti foto';
        }
    }
}
