<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

	public function __construct()
	{

        view()->share('akisubnavurl', route('aki.users.index'));
        view()->share('akisubnavtitle', 'Users');

        $akisubnav = [];

        $akisubnavform = '
        <form class="form-inline my-2 my-lg-0">
          <a href="' . action('\AkiCreative\AkiForms\UserController@create') . '" class="btn btn-success my-2 my-sm-0">ADD</a>
        </form>
        ';

        view()->share('akisubnav', $akisubnav);

        view()->share('akisubnavform', $akisubnavform);

	}

	public function index(){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $rows = User::on($db)->where('email', '!=', 'info@akicreative.net')->orderBy('name', 'ASC')->get();

        $data['rows'] = $rows;

		return view('akiforms::users.index', $data);

	}

    public function create(){

        $data['centercolumn'] = 8;

        return view('akiforms::users.create', $data);
                
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required|min:6'
        ]);

        $t = new User;

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $t->setConnection($db);
        
        $t->name = $request->input('name');
        $t->email = $request->input('email');
        $t->password = Hash::make($request->input('password'));

        $t->save();

        return redirect()->route('aki.users.edit', [$t->id]);


    }

    public function edit($id){

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $p = User::on($db)->find($id);

        if(empty($p)){

            return redirect()->route('aki.users.index');

        }

        $data['centercolumn'] = 10;

        $data['user'] = $p;

        return view('akiforms::users.update', $data);
                
    }

    public function update($id, Request $request){

        $check = User::where('email', $request->input('email'))->where('id', '!=', $id)->first();

        if(!empty($check)){

            return back()->withInput()->with('pagemessage', 'The email is already in use!');
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'min:6'
        ]);

        $db = config('akiforms.connection.akitextblock', config('database.default'));

        $p = User::on($db)->find($id);
        
        $p->name = $request->input('name');
        $p->email = $request->input('email');

        if($request->input('password') != ''){

            $p->password = Hash::make($request->input('password'));

        }

        if(auth()->user()->aki_admin){

            $p->aki_admin = $request->input('aki_admin');
        }

        $p->save();

        return redirect()->route('aki.users.index')->with('pagemessage', 'The user information was saved.');
                
    }

    public function destroy($id, Request $request){



    }

}