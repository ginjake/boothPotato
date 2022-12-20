<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Gift;
use App\Http\Requests\GiftRequest;
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

    public function edit($id)
    {
        $gift = Gift::find($id);
        if (empty($gift)) {
            abort(404);
        }
        if ($gift->userId != Auth::user()->id) {
            abort(403);
        }
        return view('gift.edit', ['gift' => $gift]);
    }

    public function update(GiftRequest $request)
    {
        $param = $request->input();
        $gift = Gift::find($param["id"]);
        if (empty($gift)) {
            abort(404);
        }
        if ($gift->userId != Auth::user()->id) {
            abort(403);
        }
        $gift->url = $param["url"];
        $gift->memo = $param["memo"];
        $gift->priority = $param["priority"];
        $gift->save();
        return redirect()->route('home');
    }

    public function store(GiftRequest $request)
    {
        $value = $request->input();
        $value['userId'] = Auth::user()->id;
        Gift::create($value);
        return redirect()->route('home');
    }

    public function destroy($id)
    {
        $gift = Gift::find($id);
        if ($gift->userId != Auth::user()->id) {
            abort(403);
        }
        $gift->delete();
        return redirect()->route('home');
    }
}
