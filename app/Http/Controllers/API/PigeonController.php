<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Pigeon;
use Illuminate\Http\Request;
use App\Repository\Pigeons\PigeonRepository;
use App\Services\Pigeons\PigeonService;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PigeonResource;

class PigeonController extends BaseController
{

    protected $pigeonRepository;
    protected $pigeonService;

    public function __construct(
        PigeonRepository $pigeonRepository,
        PigeonService $pigeonService,
    ) {
        $this->pigeonRepository = $pigeonRepository;
        $this->pigeonService = $pigeonService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pigeon = $this->pigeonService->getAll();
    
        return $this->sendResponse(PigeonResource::collection($pigeon), 'Pigeon retrieved successfully.');
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'speed' => 'required',
            'max_range' => 'required',
            'cost' => 'required',
            'downtime' => 'required',
           
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $pigeon = $this->orderService->create($input);

        return $this->sendResponse(new PigeonResource($pigeon), 'Pigeon created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pigeon  $pigeon
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pigeons = $this->pigeonService->getById($id);
  
        if (is_null($pigeons)) {
            return $this->sendError('Pigeons not found.');
        }
   
        return $this->sendResponse(new PigeonResource($pigeons), 'Pigeons retrieved successfully.');
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pigeon  $pigeon
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'speed' => 'required',
            'max_range' => 'required',
            'cost' => 'required',
            'downtime' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $id = $input['id'];
        $pigeon = $this->pigeonService->getById($id);
        if (is_null($pigeon)) {
            return $this->sendError('Pigeon not found.');
        }
        $pigeon->name = $input['name'];
        $pigeon->speed = $input['speed'];
        $pigeon->max_range = $input['max_range'];
        $pigeon->cost = $input['cost'];
        $pigeon->downtime = $input['downtime'];
        $pigeon->save();
   
        return $this->sendResponse(new PigeonResource($pigeon), 'Pigeon updated message successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pigeon  $pigeon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $pigeon = $this->pigeonService->getById($id);
        if (is_null($pigeon)) {
            return $this->sendError('Pigeon not found.');
        }
        $pigeon->delete();
        return $this->sendResponse([], 'Pigeon deleted successfully.');
    }
}
