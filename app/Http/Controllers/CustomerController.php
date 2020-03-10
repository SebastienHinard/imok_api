<?php

namespace App\Http\Controllers;


use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * REPRESENTS CUSTOMER COLUMN IN DATABASE
 *
 * Class CustomerController
 * @package App\Http\Controllers
 */
class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * GET ALL CUSTOMERS
     * @return JsonResponse
     */
    public function getAll()
    {
        return response()->json([
            'customers' => Customer::all()
        ], 200);
    }

    /**
     * GET A CUSTOMER BY ITS ID
     * @param $id
     * @return JsonResponse
     */
    public function getOneById($id)
    {
        try{
            $customer = Customer::findOrFail($id);
            return response()->json([
                'customer' => $customer
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'This user does not exist'
            ],404);
        }
    }

    /**
     * GET A CUSTOMER WHERE LIKE IN NAME OR MAIL
     * @param $arg
     * @return JsonResponse
     */
    public function getWhere($arg)
    {
        try{
            $customer = Customer::where('firstname', 'like', '%' . $arg . '%')
                                ->orWhere('lastname', 'like', '%' . $arg . '%')
                                ->orWhere('mail', 'like', '%' . $arg . '%')
                                ->get();
            return response()->json([
                'customer' => $customer
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'No match'
            ],404);
        }
    }


    /**
     * CREATE A NEW CUSTOMER
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request){


        $this->validate($request,[
            'firstname' => 'string|required',
            'lastname' => 'string|required',
            'street' => 'string|required',
            'complement' => 'string',
            'phone' => 'string|required',
            'mail' => 'required|email',
            'id_marital_status' => 'Integer|required',
            'id_cities' => 'Integer|required',
            'civility' => 'string|required',
            'birthdate' => 'date|required',
        ]);

        try{

            $customer = new Customer();

            $customer->firstname = $request->input('firstname');
            $customer->lastname = $request->input('lastname');
            $customer->street = $request->input('street');
            $customer->complement = $request->input('complement');
            $customer->phone = $request->input('phone');
            $customer->mail = $request->input('mail');
            $customer->id_marital_status = $request->input('id_marital_status');
            $customer->id_cities = $request->input('id_cities');
            $customer->civility = $request->input('civility');
            $customer->birthdate = $request->input('birthdate');
            $customer->date_register = new \DateTime();
            $customer->save();

            return response()->json([
                'message' => 'CREATED',
                'customer' => $customer
            ],201);

        }catch(\Exception $e){

            return response()->json([
                'message' => 'User could not be created'
            ],409);
        }

    }


    /**
     * UPDATE A CUSTOMER
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update($id, Request $request){

        try{
            $customer = Customer::findOrFail($id);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'This user does not exist'
            ],404);
        }

        $this->validate($request,[
            'firstname' => 'string',
            'lastname' => 'string',
            'street' => 'string',
            'complement' => 'string',
            'phone' => 'string',
            'mail' => 'email',
            'id_marital_status' => 'Integer',
            'id_cities' => 'Integer',
            'civility' => 'string',
            'birthdate' => 'date',
        ]);

        try{
            $customer->firstname = $request->input('firstname') ?? $customer->firstname;
            $customer->lastname = $request->input('lastname') ?? $customer->lastname;
            $customer->street = $request->input('street') ?? $customer->street;
            $customer->complement = $request->input('complement') ?? $customer->complement;
            $customer->phone = $request->input('phone') ?? $customer->phone;
            $customer->mail = $request->input('mail') ?? $customer->mail;
            $customer->id_marital_status = $request->input('id_marital_status') ?? $customer->id_marital_status;
            $customer->id_cities = $request->input('id_cities') ?? $customer->id_cities;
            $customer->civility = $request->input('civility') ?? $customer->civility;
            $customer->birthdate = $request->input('birthdate') ?? $customer->birthdate;
            $customer->save();

            return response()->json([
                'message' => 'UPDATED',
                'customer' => $customer
            ],201);

        }catch(\Exception $e){

            return response()->json([
                'message' => 'User could not be updated'
            ],409);
        }


    }

}
