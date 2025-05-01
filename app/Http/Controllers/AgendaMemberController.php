<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaMemberController extends Controller
{
    public function index()
    {
        $agendas = Agenda::orderBy('waktu_acara', 'desc')->get();
        return view('data.agenda-member.index', compact('agendas'));
    }
}
