<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\AuthRepository;
use App\Repositories\ResponseRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Helper\Upload;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public $responseRepository;
    public $authRepository;
    public $userRepository;

    public function __construct(ResponseRepository $res, AuthRepository $auth, UserRepository $ur)
    {
        $this->responseRepository = $res;
        $this->authRepository = $auth;
        $this->userRepository = $ur;
    }

    public function register(Request $request)
    {
        try {
            $file_path='';
            if($request->file('foto')){
                $upload = Upload::uploadFoto($request);
                $file_path = 'foto/'.$upload;
            }
            $requestData = $request->only('email', 'password','role','status','name','tempatLahir','tglLahir','no_hp','alamat');
            $save = $this->authRepository->register($requestData, $file_path);
            return $this->responseRepository->ResponseSuccess($save, 'Registrasi User berhasil!', Response::HTTP_OK);

        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function login(Request $request)
    {
        try {
            $requestData = $request->only('email', 'password');
            $data = $this->authRepository->login($requestData);
            return $this->responseRepository->ResponseSuccess($data->original, '', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show()
    {
        try {
            $data = $this->userRepository->show();
            return $this->responseRepository->ResponseSuccess($data, '', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id)
    {
        try {
            $data = $this->userRepository->read($id);
            return $this->responseRepository->ResponseSuccess($data, '', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $file_path='';
            if($request->isImagePicker == 'true'){
                if($request->file('foto')){
                    $upload = Upload::uploadFoto($request);
                    $file_path = 'foto/'.$upload;
                }
            }

            $requestData = $request->only('name','tempatLahir','tglLahir','no_hp','alamat','isImagePicker');
            $save = $this->userRepository->update($requestData, $id, $file_path);
            return $this->responseRepository->ResponseSuccess($save, null, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id)
    {
        try {
            $save = $this->userRepository->delete($id);
            return $this->responseRepository->ResponseSuccess($save, null, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function change_foto(Request $request, $id)
    {
        try {
            $data = $this->userRepository->read($id);
            File::delete(public_path($data->foto));
            $file_path='';
            if($request->file('foto')){
                $upload = Upload::uploadFoto($request);
                $file_path = 'foto/'.$upload;
            }
            $save = $this->userRepository->change_foto($id, $file_path);
            return $this->responseRepository->ResponseSuccess($save, null, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
