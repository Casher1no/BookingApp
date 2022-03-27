<?php
namespace App\Services\Apartments\Post;

use App\Database;
use Carbon\Carbon;

class PostApartmentService
{
    public function execute(PostApartmentRequest $request):void
    {
        $selectDates = $request->getDatesFromTo();
        $postInfo = $request->getApartmentInfo();

        $from = "";
        if ($selectDates[0] == "") {
            $from = explode(" ", Carbon::now()->toDateTimeString())[0];
        } else {
            $from = $selectDates[0];
        }

        $to = "";
        if ($selectDates[1] == "") {
            $to = null;
        } else {
            $to = $selectDates[1];
        }
        
        Database::connection()->insert('apartments', [
            'user_id'=> $request->getId(),
            'title'=>$postInfo[0],
            'description'=>$postInfo[1],
            'address'=>$postInfo[2],
            'select_from'=>$from,
            'select_to'=>$to,
            'cost'=> $postInfo[3]
            ]);
    }
}
