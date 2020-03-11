<?php


namespace App\Http\Controllers;


use App\Models\City;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{

    /**
     * CityController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * GET CITY BY ID
     * @param $id
     * @return JsonResponse
     */
    public function getById($id){
        try{
            $city = City::findOrFail($id);
            return response()->json([
                'city' => $city
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'No result'
            ],404);
        }
    }



    /**
     * GET CITY BY ATTRIBUTE (ex ID, NAME, LAT ..)
     * @param $attr
     * @param $arg
     * @return JsonResponse
     */
    public function getByAttr($attr,$arg){
        try{
            $cities = City::where($attr, '=', $arg )->get();
            return response()->json([
                'cities' => $cities
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'No result'
            ],404);
        }
    }


    /**
     * SEARCH CITIES BY ZIPCODE OR NAME
     * @param $arg
     * @return JsonResponse
     */
    public function search($arg){
        if(strlen($arg)<2){
            return response()->json([
                'message' => 'Search argument must be at least 3 characters long'
            ],404);
        }
        try {
            $cities = City::where('zip_code', 'like', $arg . '%')
                        ->orWhere('name', 'like', '%' . $arg . '%')
                        ->take(20)
                        ->get();
            return response()->json([
                'cities' => $cities
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'No result'
            ], 404);
        }
    }

}
