<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionStoreRequest;
use App\Models\Transfers;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfers=Transfers::all();
        return response($transfers,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionStoreRequest $request)
    {

        try{

        $senderUser = User::findOrFail($request['sender_user_id']);
        $receiverUser = User::findOrFail($request['receiver_user_id']);
        $value=$request['transferred_value'];

        if($senderUser->id!=$receiverUser->id){
            if($senderUser->checkUserTypeTransfer()){
                if($senderUser->checkBalance($value)){
                    return Transfers::makeTransfer($senderUser,$receiverUser,$value);
                }else{
                    return response('Você não tem saldo suficiente para efetuar essa transferência.', 401);
                }
            }else{
                return response('Lojistas não podem enviar dinheiro. Entre em contato com o suporte.', 401);
            }
        }else{
            return response("O usuário não pode transferir para ele mesmo.", 422);
            }
        }catch (Exception $e){
            return response($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
