<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Gift;
use App\Http\Requests\Gift\GiftUpdateRequest;
use App\Http\Requests\Gift\GiftStoreRequest;
class GiftController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function create()
    {
        return view('gift.create');
    }

    public function edit(Gift $gift)
    {
        if (! Gate::allows('update-gift', $gift)) {
            abort(403);
        }
        return view('gift.edit', ['gift' => $gift]);
    }

    public function update(GiftUpdateRequest $request)
    {
        $param = $request->input();
        $gift = Gift::find($param["id"]);
        if (empty($gift)) {
            abort(404);
        }

        if (! Gate::allows('update-gift', $gift)) {
            abort(403);
        }

        $gift->url = $param["url"];
        $gift->memo = $param["memo"];
        $gift->priority = $param["priority"];
        $gift->save();
        return redirect()->route('home');
    }

    public function store(GiftStoreRequest $request)
    {
        $value = $request->input();
        $value['userId'] = Auth::user()->id;
        Gift::create($value);
        return redirect()->route('home');
    }

    public function destroy(Gift $gift)
    {
        if (! Gate::allows('update-gift', $gift)) {
            abort(403);
        }
        $gift->delete();
        return redirect()->route('home');
    }
}
