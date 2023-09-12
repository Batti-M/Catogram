<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $search =  User::query()->when($request->input('search'), function ($query, $search) {
            $query->where('username', 'LIKE', "%{$search}%");
        });

        return response()->json($search->get());
    }
}
