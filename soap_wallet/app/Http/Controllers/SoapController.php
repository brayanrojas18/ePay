<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Wallet;
use App\Models\PendingPayment;
use App\Models\Pay;
use Illuminate\Http\Request;
use SoapClient;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SoapController extends Controller
{   
    
    public function registerClient(Request $request)
    {
        try {
            $request->validate([
                'document' => 'required|unique:clients,document',
                'names' => 'required|string',
                'email' => 'required|email|unique:clients,email',
                'phone' => 'required|string',
            ]);

            $client = Client::create([
                'document' => $request->document,
                'names' => $request->names,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return $this->response(true, '00', 'Client registered successfully', $client);

        } catch (\Exception $e) {
            return $this->response(false, '01', $e->getMessage(), null);
        }
    }

    public function rechargeWallet(Request $request)
    {
        try {
            $request->validate([
                'document' => 'required|exists:clients,document',
                'phone' => 'required|exists:clients,phone',
                'amount' => 'required|numeric|min:1',
            ]);
    
            $client = Client::where('document', $request->document)
                ->where('phone', $request->phone)
                ->first();
    
            if (!$client) {
                return $this->response(false, '02', 'Client not found', null);
            }
    
            $wallet = Wallet::where('client_id', $client->id)->first();
    
            if (!$wallet) {
                $wallet = Wallet::create([
                    'client_id' => $client->id,
                    'balance' => 0,
                ]);
            }
    
            $wallet->balance += $request->amount;
            $wallet->save();
    
            $data = [
                'client_id' => $client->id,
                'balance' => $wallet->balance,
            ];
    
            return $this->response(true, '00', 'Wallet recharged successfully', $data);
    
        } catch (\Exception $e) {
            return $this->response(false, '01', $e->getMessage(), null);
        }
    }

    public function pay(Request $request)
    {
        try {
            $request->validate([
                'document' => 'required|exists:clients,document',
                'phone' => 'required|exists:clients,phone',
                'amount' => 'required|numeric|min:1',
                'product' => 'required|string',
            ]);

            $client = Client::where('document', $request->document)
                ->where('phone', $request->phone)
                ->first();

            if (!$client) {
                return $this->response(false, '02', 'Client not found', null);
            }

            $wallet = Wallet::where('client_id', $client->id)->first();

            if (!$wallet || $wallet->balance < $request->amount) {
                return $this->response(false, '03', 'Insufficient funds', null);
            }

            $token = rand(100000, 999999);
            // Simular session activa
            $sessionId = "e1a4337e-aa60-4870-94e5-82a4b844c3ca";

            PendingPayment::create([
                'session_id' => $sessionId,
                'client_id' => $client->id,
                'amount' => $request->amount,
                'product' => $request->product,
                'token' => $token,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Mail::raw("Your confirmation token is: $token", function ($message) use ($client) {
                $message->to($client->email)
                        ->subject('Payment Confirmation Token');
            });

            $data = [
                'session_id' => $sessionId,
                'message' => 'Token sent to email',
            ];

            return $this->response(true, '00', 'Token generated and sent', $data);

        } catch (\Exception $e) {
            return $this->response(false, '01', $e->getMessage(), null);
        }
    }

    public function confirmPayment(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|numeric',
            ]);

            // Simular session activa
            $sessionId = "e1a4337e-aa60-4870-94e5-82a4b844c3ca";

            $transaction = PendingPayment::where('session_id', $sessionId)
            ->where('token', $request->token)
            ->first();

            if (!$transaction) {
                return $this->response(false, '04', 'Invalid session or token', null);
            }

            $client = Client::find($transaction->client_id);
            $wallet = Wallet::where('client_id', $client->id)->first();

            if ($wallet->balance < $transaction->amount) {
                return $this->response(false, '03', 'Insufficient funds', null);
            }

            $wallet->balance -= $transaction->amount;
            $wallet->save();

            Pay::create([
                'client_id' => $transaction->client_id,
                'amount' => $transaction->amount,
                'product' => $transaction->product,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            PendingPayment::where('session_id', $sessionId)
            ->where('token', $request->token)
            ->delete();
        

            return $this->response(true, '00', 'Payment confirmed and balance updated', [
                'new_balance' => $wallet->balance
            ]);

        } catch (\Exception $e) {
            return $this->response(false, '01', $e->getMessage(), null);
        }
    }

    public function checkBalance(Request $request)
    {
        try {
            $request->validate([
                'document' => 'required|exists:clients,document',
                'phone' => 'required|exists:clients,phone',
            ]);

            $client = Client::where('document', $request->document)
                ->where('phone', $request->phone)
                ->first();

            if (!$client) {
                return $this->response(false, '02', 'Client not found', null);
            }

            $wallet = Wallet::where('client_id', $client->id)->first();

            if (!$wallet) {
                return $this->response(false, '05', 'Wallet not found', null);
            }

            $data = [
                'balance' => $wallet->balance,
            ];

            return $this->response(true, '00', 'Balance retrieved successfully', $data);

        } catch (\Exception $e) {
            return $this->response(false, '01', $e->getMessage(), null);
        }
    }

    private function response($success, $error_code, $error_message, $data)
    {
        return [
            'success' => $success,
            'error_code' => $error_code,
            'error_message' => $error_message,
            'data' => $data,
        ];
    }
}
