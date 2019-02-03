<?php

namespace App\Http\Controllers;

use App\Record;
use CloudConvert\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['store']]);
    }


    public function index()
    {
        $records = Record::all();
        return view('record.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function convert($url)
    {
        $api = new Api("BIqX2Heum88iC9YOVPJIvqTZ1xbsqhoGmfy5MV3DdovqjM8hojolhfI1uoTAuYzK");

        $status = $api->convert([
            "inputformat" => "mp3",
            "outputformat" => "wav",
            "input" => "upload",
            "file" => fopen($url, 'r'),
        ])->wait()->downloadAll('./audio/');
        return $status;
    }

    public function create()
    {
        //
        $date = date("Y-m-d");
        return view('record.create', compact(['date']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $formInput = $request->except(['file']);
        $this->validate($request, [
            //'file' => 'file|mimes:wav|max:1000000',
            'file' => 'required|mimes:mpga',

        ]);

        //gets all files from request
        $file = $request->file('file');
        //required if files from input exists
        if ($file) {
            //creates unique file name
            $fileName = $file->getClientOriginalName();
            $filename = pathinfo($fileName, PATHINFO_FILENAME);
            //just takes file extension
            $ext = $file->getClientOriginalExtension();
            //filename to store
            $fullname = md5(uniqid($filename));
            $fileToStore = $fullname . '.' . $ext;
            //$path = $request->file('image')->storeAs('public/publisher_img', $fileToStore);
            //end of file name generation
            $file->move('audio', $fileToStore);
            $url = public_path('audio/'.$fileToStore);
            $fileWav = $fullname.'.wav';
            $this->convert($url);
            $formInput['file'] = $fileWav;
        }
        $model = new Record();
        $model->file = $formInput['file'];
        $check = $model->save();

        //$check = Record::create($formInput);
        if ($check) {
            return response()->json(
                [
                    'msg' => 'success'
                ],
                201);
        }
        return response()->json(
            [
                'msg' => 'Something went wrong'
            ],
            404);


        //return redirect('/record')->with('success', 'Добавлен элемент');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = Record::find($id);
        //$file = public_path('test.wav');
//        $categories = Category::pluck('title', 'id');
        return view('record.show', compact(['record']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Record::find($id);


        $model->delete();
        return redirect('/')->with('success', 'Element is Deleted');
    }
}
