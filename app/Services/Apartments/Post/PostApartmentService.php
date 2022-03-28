<?php
namespace App\Services\Apartments\Post;

use Carbon\Carbon;
use App\Repositories\Apartments\Post\Model\Apartment;
use App\Services\Apartments\Post\PostApartmentRequest;
use App\Repositories\Apartments\Post\PostApartmentRepository;
use App\Repositories\Apartments\Post\PdoPostApartmentRepository;

class PostApartmentService
{
    private PostApartmentRepository $apartmentRepository;

    public function __construct()
    {
        $this->apartmentRepository = new PdoPostApartmentRepository();
    }

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
        

        $apartment = new Apartment(
            $request->getId(),
            $postInfo[0],
            $postInfo[1],
            $postInfo[2],
            $from,
            $to,
            (int)$postInfo[3],
        );
 
        $this->apartmentRepository->insert($apartment);
    }
}
