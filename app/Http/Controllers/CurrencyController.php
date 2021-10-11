<?php

namespace App\Http\Controllers;

use App\Repository\CurrencyRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function getCurrency(Request $request)
    {
        $requests = json_decode($request->getContent(), true);

        if( !isset($requests['src_currency_type']) || !isset($requests['dst_currency_type']) || !isset($requests['amount']) ) {
            return response()->json([
                'status' => 'error',
                'code' => '400',
                'message' => 'bad request',
            ]);
        }

        if( !CurrencyRepo::isCurrencyTypeValid($requests['src_currency_type']) ) {
            return response()->json([
                'status' => 'error',
                'code' => '400',
                'message' => 'bad request',
            ]);
        }

        if( !CurrencyRepo::isCurrencyTypeValid($requests['dst_currency_type']) ) {
            return response()->json([
                'status' => 'error',
                'code' => '400',
                'message' => 'bad request',
            ]);
        }

        if( !CurrencyRepo::isAmountValid($requests['amount']) ) {
            return response()->json([
                'status' => 'error',
                'code' => '400',
                'message' => 'bad request',
            ]);
        }

        $dstAmount = CurrencyRepo::getCurrency($requests['src_currency_type'], $requests['dst_currency_type'], $requests['amount']);

        if( is_null($dstAmount) ) {
            return response()->json([
                'status' => 'error',
                'code' => '500',
                'message' => 'something wrong has happened',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'code' => '200',
            'data' => ['dst_amount' => $dstAmount]
        ]);
    }

}