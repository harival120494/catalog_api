<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ResponseRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Response;


class TransactionController extends Controller
{
    public $responseRepository;
    public $transactionRepository;

    public function __construct(ResponseRepository $res, TransactionRepository $tr)
    {
        $this->responseRepository = $res;
        $this->transactionRepository = $tr;
    }

    public function show()
    {
        try {
            $data = $this->transactionRepository->show();
            return $this->responseRepository->ResponseSuccess($data, '', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show_by_user($id)
    {
        try {
            $data = $this->transactionRepository->show_by_user($id);
            return $this->responseRepository->ResponseSuccess($data, '', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(Request $request)
    {
        try {

            $transaction_data = $request->only('product_id','user_id','jumlah','total');
            $data = $this->transactionRepository->create($transaction_data);
            return $this->responseRepository->ResponseSuccess($data, '', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id)
    {
        try {
            $save = $this->transactionRepository->delete($id);
            return $this->responseRepository->ResponseSuccess($save, null, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
