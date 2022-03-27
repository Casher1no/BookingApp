<?php
namespace App\Services\Apartments\Update;

use App\Database;

class UpdateApartmentService
{
    public function execute(UpdateApartmentRequest $request):void
    {
        Database::connection()->update("apartments", [
            'title' => $request->getInfo()[0],
            'description' => $request->getInfo()[1],
            'address' => $request->getInfo()[2],
            'select_to' => $request->getInfo()[3],
            'select_from' => $request->getInfo()[4],
            'cost' => $request->getInfo()[5]
        ], ['id' => $request->getId()]);
    }
}
