<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $books = Book::all();
        $response = [
            'success'=>true,
            'books'=>$books,
        ];
        return response()->json($response,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
      try{
        $validator =  Validator::make($request->all(),[
            'name'=>'required',
            'publisher'=>'required',
            'isbn'=>'required',
            'category'=>'required',
            'sub_category'=>'required',
            'description'=>'required',
            'pages'=>'integer',
            'image'=>'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'added_by'=>'integer'
        ]);

        if($validator->fails()){
            $response = [
                'status'=>false,
                'message'=>'Validation error',
                'errors'=>$validator->errors(),

            ];

            return response()->json($response,401);
        }

        $input = $request->all();

        if($image = $request->file('image')){
            $path = 'public/images';
            $filename = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->storeAs($path,$filename);
            $input['image']=$filename;
        }

        Book::create($input);
        $response= [
            'status'=>true,
            'message'=>'Book created successfully',
        ];

        return response()->json($response,200);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage(),
            ]
            ,500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
        $response = [
            'status'=>true,
            'book'=>$book
        ];

        return response()->json($response,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
      try{

        $validator =  Validator::make($request->all(),[
            'name'=>'required',
            'publisher'=>'required',
            'isbn'=>'required',
            'category'=>'required',
            'sub_category'=>'required',
            'description'=>'required',
            'pages'=>'integer',
            'added_by'=>'integer'
        ]);

        if($validator->fails()){
            $response = [
                'status'=>false,
                'message'=>'Validation error',
                'errors'=>$validator->errors(),

            ];

            return response()->json($response,401);
        }


        $input = $request->all();

       $book->update($input);

        $response = [
            'status'=>true,
            'message'=>'Book updated successfully',
        ];

        return response()->json($response,200);
    }catch(\Throwable $th){
        return response()->json([
            'status'=>false,
            'message'=>$th->getMessage(),
        ]
        ,500);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
      //delete image from images folder
      Storage::delete('public/images/',$book->image);
      $book->delete();
      $response = [
        'success'=>true,
        'message'=>'Book deleted successfully',
      ];
      return response()->json($response,200);
    }
}
