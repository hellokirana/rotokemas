<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type' => 'member', // default type
            'status' => 'pending', // menunggu verifikasi admin
            'founded_year' => ['nullable', 'string', 'max:255'],
            'company_address' => ['nullable', 'string'],
            'company_phone' => ['nullable', 'string', 'max:255'],
            'company_website' => ['nullable', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'contact_department' => ['nullable', 'string', 'max:255'],
            'contact_position' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'string', 'max:255'],
            'business_type' => ['nullable', 'string', 'max:255'],
            'total_employee' => ['nullable', 'string', 'max:255'],
            'printing_line_total' => ['nullable', 'string', 'max:255'],
            'process_printing' => ['nullable', 'string', 'max:255'],
            'process' => ['nullable', 'array'],
            'process.*' => ['string', 'max:255'],
            'anual_turnover' => ['nullable', 'string', 'max:255'],
            'film_production' => ['nullable', 'string', 'max:255'],
            'g-recaptcha-response' => 'required', // Validasi reCAPTCHA
        ]);
    }

    public function register(Request $request)
    {
        // Validasi input
        $this->validator($request->all())->validate();

        // Validasi reCAPTCHA
        $response = $request->input('g-recaptcha-response');
        $secret = env('RECAPTCHA_SECRET_KEY');

        // Kirim permintaan ke Google untuk memverifikasi reCAPTCHA
        $captchaResponse = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => $secret,
            'response' => $response,
        ]);

        $captchaData = $captchaResponse->json();

        // // Cek apakah reCAPTCHA valid
        if (!$captchaData['success']) {
            return back()->withErrors(['g-recaptcha-response' => 'CAPTCHA verification failed.']);
        }

        // Jika validasi berhasil, buat pengguna baru

        $user = $this->create($request->all());

        $user->sendEmailVerificationNotification();

        // Redirect to verification notice without logging in
        return redirect()->route('verification.notice')
            ->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    protected function create(array $data)
    {
        $user = User::create([
            'company_name' => $data['company_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => 'member', // default
            'status' => 'pending', // menunggu verifikasi admin
            'founded_year' => $data['founded_year'] ?? null,
            'company_address' => $data['company_address'] ?? null,
            'company_phone' => $data['company_phone'] ?? null,
            'company_website' => $data['company_website'] ?? null,
            'contact_name' => $data['contact_name'] ?? null,
            'contact_phone' => $data['contact_phone'] ?? null,
            'contact_department' => $data['contact_department'] ?? null,
            'contact_position' => $data['contact_position'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'business_type' => $data['business_type'] ?? null,
            'total_employee' => $data['total_employee'] ?? null,
            'printing_line_total' => $data['printing_line_total'] ?? null,
            'process_printing' => $data['process_printing'] ?? null,
            'process' => implode(', ', $data['process'] ?? []),
            'anual_turnover' => $data['anual_turnover'] ?? null,
            'film_production' => $data['film_production'] ?? null,
            'avatar' => $data['avatar'] ?? null,


        ]);

        // Jika Anda menggunakan sistem peran, pastikan ini sesuai dengan implementasi Anda
        $user->assignRole('member'); // Pastikan Anda memiliki metode assignRole di model User

        return $user;
    }
}
