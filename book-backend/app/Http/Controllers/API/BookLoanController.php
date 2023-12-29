<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\BookLoan;

class BookLoanController extends Controller
{

    public function __construct(){
        $this->middleware("auth:sanctum");
    }

    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        //
       $id = auth()->user()->id;

       $bookLoans = DB::table('books')->join('book_loans','books.id','=','book_loans.book_id')->select('books.name','book_loans.*')->where('book_loans.user_id',$id)->latest()->get();
        return response()->json([
            'status'=>true,
            'books'=>$bookLoans,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'book_id'=>'required',
            'user_id'=>'required',
            'loan_date'=>'required',
            'due_date'=>'required',
            'loan_date'=>'required',
            'return_date'=>'nullable',
            'extended'=>'nullable',
            'extension_date'=>'nullable',
            'penalty_amount'=>'nullable',
            'penalty_status'=>'nullable',
            'status'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Validation failed',
                'errors'=>$validator->errors()
            ],401);
        }

        $input = $request->all();
        BookLoan::create($input);
        return response()->json([
            'status'=>true,
            'message'=>'Book loan completed successfully'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookLoan $bookLoan)
    {
        //

        $response = [
            'status'=>true,
            'bookloan'=>$bookLoan
        ];

        return response()->json($response,200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookLoan  $bookLoan)
    {
        //
        $validator = Validator::make($request->all(),[
            'extended'=>'required',
            'extension_date'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Validation failed',
                'errors'=>$validator->errors(),
            ],401);
        }

        $input = $request->all();
        $bookLoan->update($input);
        return response()->json([
            'status'=>true,
            'message'=>'Loan updated successfully😁',
        ],200);
    }

}
