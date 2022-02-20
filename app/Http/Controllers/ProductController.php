<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ResponseRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Response;
use App\Helper\Upload;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{
    public $responseRepository;
    public $productRepository;

    public function __construct(ResponseRepository $res, ProductRepository $pr)
    {
        $this->responseRepository = $res;
        $this->productRepository = $pr;
    }



    public function show()
    {
        try {
            $data = $this->productRepository->show();
            return $this->responseRepository->ResponseSuccess($data, '', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(Request $request)
    {
        try {
            $file_path='';
            if($request->file('foto')){
                $upload = Upload::uploadFotoProduct($request);
                $file_path = 'foto_products/'.$upload;
            }

            $product_data = $request->only('nama_product','sku','desc','harga','stock');
            $data = $this->productRepository->create($product_data, $file_path);
            return $this->responseRepository->ResponseSuccess($data, '', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function read($id)
    {
        try {
            $data = $this->productRepository->read($id);
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
                $data = $this->productRepository->read($id);
                File::delete(public_path($data->foto));
                if($request->file('foto')){
                    $upload = Upload::uploadFotoProduct($request);
                    $file_path = 'foto_products/'.$upload;
                }
            }

            $product_data = $request->only('nama_product','sku','desc','harga','stock','isImagePicker');
            $save = $this->productRepository->update($product_data, $id, $file_path);
            return $this->responseRepository->ResponseSuccess($save, null, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id)
    {
        try {
            $save = $this->productRepository->delete($id);
            return $this->responseRepository->ResponseSuccess($save, null, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function change_foto(Request $request, $id)
    {
        try {
            $data = $this->productRepository->read($id);
            File::delete(public_path($data->foto));
            $file_path='';
            if($request->file('foto')){
                $upload = Upload::uploadFotoProduct($request);
                $file_path = 'foto_products/'.$upload;
            }
            $save = $this->productRepository->change_foto($id, $file_path);
            return $this->responseRepository->ResponseSuccess($save, null, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
