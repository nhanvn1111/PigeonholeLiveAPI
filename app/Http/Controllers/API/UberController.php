<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pigeon as EloquentPigeon;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class UberController extends Controller
{
    public function submitOrder(Request $request)
    {
        //Hiện tại thời gian đang là UTC, nên khi nhập deadline cần tính toán trừ đi 7h
        $now = Carbon::now();
        $range = $request->range;
        $deadline = $request->deadline;
        $deadline = Carbon::parse($deadline);
        $allPigeon = EloquentPigeon::all();
        $cost = floatval($range * 2);
        $message = 'reject';
        $data = null;
        foreach ($allPigeon as $pigeon) {
            if ($pigeon->status == 0) {
                if ($pigeon->max_range >= $range) {
                    $timeNeedToDeli = floatval($range / $pigeon->speed);
                    $resultTimeNeedToDeli = $timeNeedToDeli * 60;
                    $timeEndDeli = $now->addMinute($resultTimeNeedToDeli);
                    $timeEndDowntime = $timeEndDeli->addHour($pigeon->downtime);

                    if ($timeEndDeli->lte($deadline)) {
                        $order = new Order();
                        $order->range_deli = $range;
                        $order->deadline = $deadline;
                        $order->time_end_deli = $timeEndDeli;
                        $order->time_end_downtime = $timeEndDowntime;
                        $order->pigeonId = $pigeon->id;
                        $order->cost = $cost;
                        if ($order->save()) {
                            $pigeon->status = 1;
                            $pigeon->save();
                            $message = 'success';
                            $data = $order;
                            break;
                        }
                        // Hoặc viết cronjob để update status của pigeon
                    }
                }
            }
        }
        $result = [
            'status'=> 200,
            'message'=> $message,
            'data' => $data
        ];
        return $result;
    }

    // public function findPigeone($deadline, $range){
    //     $allPigeon = DB::table("pigeon")
    //     ->where('status', EloquentPigeon::STATUS_AVAILABLE)
    //     ->where('max_range', $range)
    // }
}