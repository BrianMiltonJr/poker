<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositStoreRequest;
use App\Models\Deposit;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $deposits = Deposit::all();

        return view('deposit.index', compact('desposits'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('deposit.create');
    }

    /**
     * @param \App\Http\Requests\DepositStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepositStoreRequest $request)
    {
        $deposit = Deposit::create($request->validated());

        return redirect()->route('deposit.index');
    }
}
