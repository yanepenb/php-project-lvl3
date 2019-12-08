<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Validator;

class DomainController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function showAll()
    {
        $domains = DB::table('domains')->paginate(5);
    
        return view('domains', ['domains' => $domains]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'domain' => 'required|url'
        ]);
        
        if ($validator->fails()) {
            return view('index', ['errors' => $validator->errors()->all()]);
        }
    
        $date = Carbon::now();
        $domain = $request->input('domain');
        $id = DB::table('domains')->insertGetId([
                                            'name' => $domain,
                                            'updated_at' => $date,
                                            'created_at' => $date
                                        ]);
    
        return redirect()->route('domainId', ['id' => $id]);
    }

    public function showId($id)
    {
        $domain = DB::table('domains')->where('id', $id)->first();
    
        return view('domain', ['domain' => $domain]);
    }
}
