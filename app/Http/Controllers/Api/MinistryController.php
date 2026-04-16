<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Ministry\Models\Ministry;
use App\Domains\Ministry\Models\MinistryJoinRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MinistryController extends Controller
{
    public function index(Request $request)
    {
        $ministries = Ministry::with(['leader', 'members'])->get();

        return response()->json($ministries);
    }

    public function show(Request $request)
    {
        $ministry = Ministry::with(['leader', 'members'])->findOrFail($request->route('ministry'));

        return response()->json($ministry);
    }
}