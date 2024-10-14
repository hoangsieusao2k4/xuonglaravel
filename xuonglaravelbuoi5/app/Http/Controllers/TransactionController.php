<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    // Bắt đầu giao dịch
    public function startTransaction(Request $request)
    {
        if ($request->isMethod('post')) {
            // Nhận thông tin từ form
            $amount = $request->input('amount');
            $receiverAccount = $request->input('receiver_account');

            // Khởi tạo phiên giao dịch trong Session
            Session::put('transaction', [
                'amount' => $amount,
                'receiver_account' => $receiverAccount,
                'status' => 'initiated',
                'step' => 1
            ]);

            return redirect('/transaction/complete');
        }

        return view('transaction.start');
    }

    // Cập nhật giao dịch (dùng để tiếp tục từ điểm dừng)
    public function resumeTransaction()
    {
        $transaction = Session::get('transaction');

        return view('transaction.resume', ['transaction' => $transaction]);
    }

    // Hoàn thành giao dịch
    public function completeTransaction(Request $request)
    {
        if ($request->isMethod('post')) {
            $transaction = Session::get('transaction');

            if ($transaction && $transaction['status'] === 'initiated') {
                // Lưu thông tin giao dịch vào database
                \App\Models\Transaction::create([
                    'amount' => $transaction['amount'],
                    'receiver_account' => $transaction['receiver_account'],
                    'status' => 'completed'
                ]);

                // Xóa session giao dịch
                Session::forget('transaction');

                return redirect('/transaction/complete')->with('success', 'Transaction completed successfully!');
            }

            return redirect('/transaction/complete')->with('error', 'No active transaction or transaction already completed.');
        }

        return view('transaction.complete');
    }

    // Hủy giao dịch
    public function cancelTransaction()
    {
        // Xóa session giao dịch
        Session::forget('transaction');

        return redirect('/transaction/start')->with('message', 'Transaction cancelled successfully!');
    }
}
