<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Braintree_Transaction;

class BrainTreeController extends Controller
{
    public function pay (Request $request) {
        $result = Braintree_Transaction::sale(
            [
                'amount' => '10.00',
                'paymentMethodNonce' => 'fake-valid-nonce',
                'options' => [
                'submitForSettlement' => True
            ],
            'customer' => [
                'firstName' => 'Fuck me',
                'email' => 'fuckmeeee@gmail.com'
            ]
        ]);
        return $result;
    }
}
