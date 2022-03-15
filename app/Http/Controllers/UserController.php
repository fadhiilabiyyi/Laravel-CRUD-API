<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Libraries\BaseApi;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Halaman User';

        $users = (new BaseApi)->index('/user');
        $api = new BaseApi;

        $users = $api->index('/user');
        $pages = ceil($users['total']/$users['limit']);

        $datass = [];
        for ($i = 1; $i < $pages; $i++) {
            array_push($datass, $api->index('/user', ['page' => $i])['data']);
        }

        $datas = [];
        for ($i = 0; $i < count($datass); $i++) {
            foreach ($datass[$i] as $value) {
                array_push($datas, $value);
            }
        }

        return view('users.index', compact('datas', 'title'));

        // return view('users.index', [
        //     'users' => $users,
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create | User";

        return view('users.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$payload = [
            'firstName' => $request->input('firstName'),
            'lastName' => $request->input('lastName'),
            'email' => $request->input('email'),
        ];
        
        $baseApi = new BaseApi;
        $response = $baseApi->create('/user/create', $payload);
        
        // Handle jika request API nya gagal
        // Di blade nanti bisa ditambahkan toast alert
        if ($response->failed()) {
            // $response->json agar response dari API bisa di akses sebagai array
            $errors = $response->json('data');
        
            foreach ($errors as $key => $msg) {
                $messages = "$key : $msg";
            }
            
            // Return failed
            $request->session()->flash('failed', "Data gagal disimpan, $messages");

            return redirect('user');
        }

        // Return success 
        $request->session()->flash('success', 'Data berhasil disimpan');
        
        return redirect('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //kalian bisa coba untuk dd($response) untuk test apakah api nya sudah benar atau belum
        //sesuai documentasi api detail user akan menshow data detail seperti `email` yg tidak dimunculkan di api list index
        $title = "Edit | User";

        $baseApi = new BaseApi;

        $response = $baseApi->detail('/user', $id);

        return view('users.edit', compact('title'))->with([
            'user' => $response->json()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payload = [
            'firstName' => $request->input('firstName'),
            'lastName' => $request->input('lastName')
        ];
        
        $response = (new BaseApi)->update('/user', $id, $payload);

        if ($response->failed()) {
            $errors = $response->json('data');
    
            foreach ($errors as $key => $msg) {
                $messages = "$key : $msg";
            }

            // Return failed 
            $request->session()->flash('failed', "Data gagal diperbarui, $messages");
    
            return redirect('user');
        }
        
        // Return success
        $request->session()->flash('success', 'Data berhasil diperbarui');

        return redirect('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $response = (new BaseApi)->delete('/user', $id);

        if ($response->failed()) {
            // Return failed
            $request->session()->flash('failed', 'Data gagal dihapus');

            return redirect('user');
        }

        // Return success
        $request->session()->flash('success', 'Data berhasil dihapus');

        return redirect('user');
    }
}