<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\User;
use App\Models\EncryptedFile;
use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $pageTitle = "Dashboard";
        $user = Auth::user();
        $userCount = User::count();
        $payment = Payment::query();
        if($user->role == 'user'){
            $payment->where('user_id', $user->id);
        }
        $paymentCount = $payment->count();
        $files = EncryptedFile::query();
        if($user->role == 'user'){
            $files->where('user_id', $user->id);
        }
        $filesCount = $files->where('is_paid',1)->count();
        return view('dashboard.index', compact('userCount', 'paymentCount','pageTitle','filesCount'));
    }
    public function paymentHistory(){
        $pageTitle = 'Payment History';
        $submenu=[
            'route'=>"dashboard.payment.history",
            'title'=>'Dashboard'
        ];
        $user = Auth::user();
        $history = Payment::query();
        if($user->role == 'user'){
            $history->where('user_id', $user->id);
        }
        $paymentHistory = $history->get();
        return view('dashboard.payment_history', compact('paymentHistory','pageTitle','submenu'));
    }
    public function users(){
        $this->authorize('is-admin');
        $pageTitle= "All Users";
        $users = User::all();
        return view('dashboard.users.index', compact('users','pageTitle'));
    }
}
