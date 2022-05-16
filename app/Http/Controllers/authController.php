<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;


class authController extends Controller
{
    public function halamanlogin(){
        return view ('login');
    }

    public function login(Request $request){
        // $data = User::where('email',$request->email)->firstOrFail();
        // if($data){
        //     if(Hash::check($request->password,$data->password)){
        //         session(['berhasil_login' => true]);
        //         return redirect('/dashboard');
        //     }
        // }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('/dashboard');
        }
        return redirect('/')->with('message','Email atau password salah!');
}
    //tampil data user
    public function tampil(){
        return User::all();
        // $data = DB::table('user')->paginate(5);
        // Paginator::useBootstrap();
        // return view('user',['user' => $data]);
        
    }

    //tampilan tambah data user
    public function tambah(){
        return view('user-tambah');
    }

    //simpan data user
    public function simpan(Request $request){
        $validator = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required',
            'email'=>'required',
            'password'=>'required',
            ],
            [
                'name.required' => 'Nama user tidak boleh kosong!',
                'name.max' => 'Nama user melebihi batas!',
    
                'role.required' => 'Role harus diisi!',
    
                'email.required' => 'Alamat email tidak boleh kosong!',
                'email.unique' => 'Alamat email telah digunakan!',

                'password.required' => 'Password tidak boleh kosong!',
            ]
        );

        $user = User::create([
            'name'=>$request->get('name'),
            'role'=>$request->get('role'),
            'email'=>$request->get('email'),
            'password'=> bcrypt($request->get('password')),
            'remember_token' => Str::random(60),
            ]);

    }

    //tampil edit profile
    public function edit($id){
        $user = DB::table('user')->where('id',$id)->first();
        return view('user-edit',['user' => $user]);
        // return view('user-edit');
    }

    //update data profile
    public function update(Request $request, $id){
       
    $validator = $request->validate([
        'name' => 'required|string|max:100',
        'role'=>'required|string',
        'required|unique:user,email,$id',
        // 'password'=>'required',
        
        
        ],
        [
            'name.required' => 'Nama tidak boleh kosong!',
            'name.max' => 'Nama melebihi batas!',
            
            'role.required' => 'Role tidak boleh kosong!',

            'email.required' => 'Alamat email tidak boleh kosong!',
            'email.unique' => 'Alamat email telah digunakan!',

            // 'password.required' => 'Password tidak boleh kosong!',


        ]
    );
    $user = User::where('id',$id)->update([
                'name'=>$request->get('name'),
                'role'=>$request->get('role'),
                'email'=>$request->get('email'),
                'password'=> bcrypt($request->get('password')),
                'remember_token' => Str::random(60),

                // Input Gambar
                'gambar' => $request->get->file('gambar'),
                $name = 'gambar'->getClientOriginalName(),
                $gambar->move('images/post', $name),
                $post->gambar = $name,
                
            ]);

    // $post = new User();
    // $post->name = $request->name;
    // $post->role = $request->role;
    // $post->email = $request->email;
    // $post->password = Hash::make($request->password);
    
    // // Input Gambar
    // if($request->file('gambar')){
    //     $gambar = $request->file('gambar');
    //     $name = $gambar->getClientOriginalName();
    //     $gambar->move('images/post', $name);
    //     $post->gambar = $name;
    // }
    // $post->update();    
            
     return redirect()->route('edit-user',$id)->with('message-update','Data berhasil diupdate!');
}

    //hapus data user
    public function hapus($id){
        $user = User::where('id',$id)->delete();
        return redirect()->back()->with('message-hapus','Data berhasil dihapus!');
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect ('/');
    }

}
