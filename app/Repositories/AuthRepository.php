<?php
namespace App\Repositories;
use App\Models\User;
use App\Models\UserInformations;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthRepository {
    public function register(array $data, $file_path)
    {
        $data_user = [
            'email' => $data['email'],
            'role' => $data['role'],
            'status' => $data['status'],
            'password' => Hash::make($data['password'])
        ];
        $save = User::create($data_user);

        if($save->id > 0)
        {
            $data_information = [
                'user_id'       => $save->id,
                'name'          => $data['name'],
                'tempatLahir'   => $data['tempatLahir'],
                'tglLahir'      => $data['tglLahir'],
                'no_hp'         => $data['no_hp'],
                'alamat'        => $data['alamat'],
                'foto'          =>$file_path
            ];

            if(UserInformations::create($data_information))
            {
                $select = [
                    'u.email',
                    'u.password',
                    DB::raw('CASE WHEN u.status = 1 THEN "Active" ELSE "Nonactive" END as status'),
                    'ui.name',
                    'ui.tempatLahir',
                    'ui.tglLahir',
                    'ui.no_hp',
                    'ui.alamat',
                    'ui.foto'
                ];
                return DB::table('users as u')
                            ->select($select)
                            ->leftJoin('user_informations as ui','u.id','=','ui.user_id')
                            ->where('u.id','=', $save->id)
                            ->first();
            }
            else{
                return response()->json(['message'=>'Gagal menyimpan informasi detail user']);
            }
        }
        else{
            return response()->json(['message'=>'Gagal data user']);
        }
    }


    public function login(array $data)
    {
        $result = User::where('email', $data['email'])->first();
        if($result)
        {
            if (Hash::check($data['password'], $result->password)) {
                if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                    $user = Auth::user();
                    $result->token_type = 'Bearer';
                    $result->token = $user->createToken('catalog')->accessToken;
                    return response()->json($result, 200);
                }
                else{
                    return response()->json(['message'=>'Unauthorized']);
                }
            }
            else{
                return response()->json(['message'=>'Password yang di masukkan salah']);
            }
        }
        else
        {
            return response()->json(['message'=>'E-mail tidak terdaftar']);
        }
    }
}
