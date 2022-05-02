<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashoutStoreRequest;
use App\Models\Cashout;
use Illuminate\Http\Request;

class CashoutController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cashouts = Cashout::all();

        return view('cashout.index', compact('cashouts'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('cashout.create');
    }

    /**
     * @param \App\Http\Requests\CashoutStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashoutStoreRequest $request)
    {
        $cashout = Cashout::create($request->validated());

        return redirect()->route('cashout.index');
    }
}
