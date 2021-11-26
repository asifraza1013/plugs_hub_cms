<?php

namespace App\Http\Controllers;

use App\ChargerBox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChargerInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // function __construct()
    // {
    //      $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:user-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    // }

    public function index(Request $request)
    {
        $chargers = ChargerBox::orderBy('id','ASC')->paginate(20);
        return view('chargerBox.index',compact('chargers'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Charger Box';
        return view('chargerBox.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'required',
            'type' => 'required|string',
            'status' => 'required|in:Active,Inactive'
        ]);

        $image = null;
        if($request->hasFile('image')){
            $image=$this->saveImageVersions(
                'uploads/',
                $request->image,
                [
                    ['name'=>'large','w'=>590,'h'=>400],
                    //['name'=>'thumbnail','w'=>300,'h'=>300],
                    ['name'=>'medium','w'=>295,'h'=>200],
                    ['name'=>'thumbnail','w'=>200,'h'=>200]
                ]
            );
        }

        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'image' => $image,
            'status' => $request->status,
        ];

        $user = ChargerBox::create($data);

        return redirect()->route('chargerbox.index')
                        ->with('success','Charger Box created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $charger = ChargerBox::find($id);

        return view('chargerBox.edit',compact('charger'));
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
        $this->validate($request, [
            'name' => 'required|string',
            'image' => 'nullable',
            'type' => 'required|string',
            'status' => 'required|in:Active,Inactive'
        ]);

        $image = null;
        if($request->hasFile('image')){
            $image=$this->saveImageVersions(
                'uploads/',
                $request->image,
                [
                    ['name'=>'large','w'=>590,'h'=>400],
                    //['name'=>'thumbnail','w'=>300,'h'=>300],
                    ['name'=>'medium','w'=>295,'h'=>200],
                    ['name'=>'thumbnail','w'=>200,'h'=>200]
                ]
            );
        }
        Log::info("image ".$image);
        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
        ];
        if($image) {
            $data['image'] = $image;
        }
        $user = ChargerBox::find($id);
        $user->update($data);

        return redirect()->route('chargerbox.index')
                        ->with('success','Charger Box updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
