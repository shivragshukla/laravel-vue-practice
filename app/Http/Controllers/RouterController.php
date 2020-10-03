<?php

namespace App\Http\Controllers;

use App\Router;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Rules\Hostname;
use App\Rules\MacAddress;

class RouterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routers = Router::all();
        return response()->json(
            [
                'status' => 'success',
                'routers' => $routers->toArray()
            ], 200);
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $data = $request->validate([
            'sapid'     => ["required", "numeric", "digits_between:1,18", "unique:routers"],
            'loopback'  => ["required", "ipv4", "unique:routers"],
            'hostname'  => ["required", "max:14", new Hostname, "unique:routers"],
            'mac_address' => ["required", "max:17", new MacAddress, "unique:routers"],
        ]);

        try {
            Router::create($data);
            return ['status'=>'success'];
        } catch (ModelNotFoundException $e) {
            return ['status'=>'error'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $router = Router::find($id);
        return response()->json(
            [
                'status' => 'success',
                'router' => $router->toArray()
            ], 200);
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
        //Validation
        $data = $request->validate([
            'sapid'     => ["required", "numeric", "digits_between:1,18", "unique:routers,sapid," .$id],
            'loopback'  => ["required", "ipv4", "unique:routers,loopback,".$id],
            'hostname'  => ["required", "max:14", new Hostname, "unique:routers,hostname,".$id],
            'mac_address' => ["required", "max:17", new MacAddress, "unique:routers,mac_address,".$id],
        ]);

        try {
            Router::find($id)->update($data);
            return ['status'=>'success'];
        } catch (ModelNotFoundException $e) {
            return ['status'=>'error'];
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Router::find($id)->delete();
            return ['status'=>'success'];
        } catch (ModelNotFoundException $e) {
            return ['status'=>'error'];
        }
    }
}
