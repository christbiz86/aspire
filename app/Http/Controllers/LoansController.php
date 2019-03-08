<?php

namespace App\Http\Controllers;

use App\Loans;
use Illuminate\Http\Request;

class LoansController extends Controller
{

    public function index(){
        $data = Loans::all();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function show($id){
        try {
            $data = Loans::find($id)->first();
            $data['user'] = Loans::find($id)->getUserId;
            return response()->json([
                'message' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(request $request){
        $loans = new Loans();
        $loans_status = Loans::where('status','active')->where('userId',$request->userId)->get();
        if(count($loans_status) > 0){
            return response()->json([
                'message' => 'Loans declined!',
                'data' => $loans_status
            ]);
        } else {
            $loans->userId = $request->userId;
            $loans->amount = $request->amount;
            $loans->arrangementFee = $request->arrangementFee;
            $loans->repayment = $request->arrangementFee + ($request->amount / $request->duration);
            $loans->interest = $request->interest;
            $loans->duration = $request->duration;
            $loans->status = $request->status;
            $loans->save();
            return response()->json([
                'message' => 'Loans saved!',
                'data' => $loans
            ]);
        }
    }

    public function update(request $request, $id){
        return response()->json([
            'message' => 'empty function!',
        ]);
    }

    public function destroy($id){
        return response()->json([
            'message' => 'empty function!',
        ]);
    }

}
