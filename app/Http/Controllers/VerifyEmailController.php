<?php

namespace App\Http\Controllers;

use App\Http\Requests\Email\EmailVerificationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function init(EmailVerificationRequest $request) {
        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return redirect(env('FRONT_URL') . '/email/verify/already-success');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect(env('FRONT_URL') . '/email/verify/success');

    }

    public function resend(Request $request) {
        $user = User::whereEmail($request->get('email'))->first();
        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Đã gửi lại email xác nhận!']);
    }
}
