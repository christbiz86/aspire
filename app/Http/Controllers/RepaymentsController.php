<?php

namespace App\Http\Controllers;

use App\Loans;
use App\Repayments;
use Illuminate\Http\Request;

class RepaymentsController extends Controller
{

    public function index(){
        $data = Repayments::all();
        foreach($data as $key => $value){
            $data[$key]['loans'] = Loans::find($value->loansId)->first();
            $data[$key]['user'] = Loans::find($value->loansId)->getUserId;
        }
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function show($id){
        $data = Repayments::where('loansId',$id)->get();
        foreach($data as $key => $value){
            $data[$key]['loans'] = Loans::find($value->loansId)->first();
            $data[$key]['user'] = Loans::find($value->loansId)->getUserId;
        }
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function store(request $request){
        try{
            $repayments = new Repayments();
            $loans = Loans::find($request->loansId)->first();
            if($loans->status == 'paid'){
                $loans['user'] = Loans::find($request->loansId)->getUserId;
                return response()->json([
                    'message' => 'Loans already paid!',
                    'data' => $loans
                ]);
            } else {
                $repayments->loansId = $request->loansId;
                $repayments->save();
                $msg = 'Repayment received!';

//                update status already paid all repayment
                $count_payment = Repayments::where('loansId',$request->loansId)->count();
                if($count_payment == $loans->duration){
                    $loans->status = 'paid';
                    $loans->save();
                    $msg = 'Loans already paid!';
                }
                return response()->json([
                    'message' => $msg,
                    'data' => $repayments
                ]);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
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
