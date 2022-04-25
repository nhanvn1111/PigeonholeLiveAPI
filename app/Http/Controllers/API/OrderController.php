<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Repository\Orders\OrderRepository;
use App\Services\Orders\OrderService;
use App\Repository\Pigeons\PigeonRepository;
use App\Services\Pigeons\PigeonService;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\OrderResource;
use App\Models\Pigeon;
use Carbon\Carbon;
class OrderController extends BaseController
{

    protected $orderRepository;
    protected $orderService;
    protected $pigeonRepository;
    protected $pigeonService;

    public function __construct(
        OrderRepository $orderRepository,
        OrderService $orderService,
        PigeonRepository $pigeonRepository,
        PigeonService $pigeonService,
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
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
        $order = $this->orderService->getAll();
        return $this->sendResponse(OrderResource::collection($order), 'Order retrieved successfully.');
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
   
        $validator = Validator::make($input, [
            'range_deli' => 'required',
            'deadline'=> 'required',
            'time_end_deli' => 'required',
            'pigeonId'=> 'required',
            'cost'=>'required',
           
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        
        $fee = 2;// this has define with requiment
        $now = Carbon::now();
        $range = $request->range;
        $deadline = $request->deadline;
        $deadline = Carbon::parse($deadline);
        $allPigeon = $this->pigeonService->getPigeoneWithStatus(Pigeon::STATUS_AVAILABLE);
        $cost = floatval($range * $fee);
        $message = 'Order reject';

        foreach ($allPigeon as $pigeon) {
            if ($pigeon->status == 0) {
                if ($pigeon->max_range >= $range) {
                    $timeNeedToDeli = floatval($range / $pigeon->speed);
                    $resultTimeNeedToDeli = $timeNeedToDeli * 60;
                    $timeEndDeli = $now->addMinute($resultTimeNeedToDeli);
                    $timeEndDowntime = $timeEndDeli->addHour($pigeon->downtime);

                    if ($timeEndDeli->lte($deadline)) {
                        $oderCreate = [
                            'range_deli' => $input['range_deli'],
                            'deadline' => $input['deadline'],
                            'time_end_deli' => $input['time_end_deli'],
                            'time_end_downtime' => $timeEndDowntime,
                            'pigeonId' => $input['pigeonId'],
                            'cost' => $cost
                        ];
                        $order = $this->orderService->create($oderCreate);
                        if ($order) {
                            $pigeon->status = Pigeon::STATUS_BUSY;
                            $pigeon->save();
                            $message = 'Order created successfully.';
                            
                            return $this->sendResponse(new OrderResource($order), $message);
                        }

                    }
                }
            }
        }
        return $this->sendResponse(NULL, $message);
   
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orders = $this->orderService->getById($id);
  
        if (is_null($orders)) {
            return $this->sendError('Order not found.');
        }
   
        return $this->sendResponse(new OrderResource($orders), 'Orders retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $input = $request->all();
   
       
        $validator = Validator::make($input, [
            'range_deli'=>'required',
            'deadline'=> 'required',
            'time_end_deli'=> 'required',
            'time_end_downtime'=> 'required',
            'pigeonId'=> 'required',
            'id'=> 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $id = $input['id'];
        $order = $this->orderService->getById($id);
        if (is_null($order)) {
            return $this->sendError('Order not found.');
        }
        $order->range_deli = $input['range_deli'];
        $order->deadline = $input['deadline'];
        $order->time_end_deli = $input['time_end_deli'];
        $order->time_end_downtime = $input['time_end_downtime'];
        $order->pigeonId = $input['pigeonId'];
        $order->save();
   
        return $this->sendResponse(new OrderResource($order), 'Order updated successfully.');
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $order = $this->orderService->getById($id);
        if (is_null($order)) {
            return $this->sendError('Order not found.');
        }
        $order->delete();
        return $this->sendResponse([], 'Order deleted successfully.');
    }
}
