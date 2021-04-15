<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return IlluminateHttpResponse
     */
    public function index()
    {
        $expenses = Expense::all();
        return response()->json($expenses);
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  IlluminateHttpRequest  $request
     * @return IlluminateHttpResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'description' => 'required' //optional if you want this to be required
        ]);
        $expense = Expense::create($request->all());
        return response()->json(['message'=> 'expense created', 
        'expense' => $expense]);
    }
    /**
     * Display the specified resource.
     *
     * @param  AppExpense  $expense
     * @return IlluminateHttpResponse
     */
    public function show(Expense $expense)
    {
        return $expense;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  AppExpense  $expense
     * @return IlluminateHttpResponse
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  IlluminateHttpRequest  $request
     * @param  AppExpense  $expense
     * @return IlluminateHttpResponse
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'description' => 'required' //optional if you want this to be required
        ]);

        $input = $request->all();
        $expense->fill($input)->save();
        
        return response()->json([
            'message' => 'expense updated!',
            'expense' => $expense
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  AppExpense  $expense
     * @return IlluminateHttpResponse
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return response()->json([
            'message' => 'expense deleted'
        ]);
    }

    public function all()
    {
        $client = new Client(['base_uri' => 'https://jsonplaceholder.typicode.com/']);

        $response = $client->get('posts/2');

        $results = $response->getBody();
        $results = json_decode($results);
        
        return response()->json(["status" => 200, "data"=> $results]);
    }

    public function addPost(Request $request)
    {
        $client = new Client(['base_uri' => 'https://jsonplaceholder.typicode.com/']);

        $response = $client->post('posts', ['form_params' => [
            'name' => $request->name,
            'age' => $request->age,
            'address' => $request->address
        ]]);
           
        $results = $response->getBody();
        $results = json_decode($results);
        
        return response()->json(["status" => 200, "data"=> $results]);
    }
}