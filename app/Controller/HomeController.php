<?php
namespace App\Controller;

use App\View;
use App\Database;
use App\Redirect;
use App\Model\Apartment;

class HomeController
{
    public function home():View
    {
        $apartmentsQuery = Database::connection()
        ->createQueryBuilder()
        ->select('*')
        ->from('apartments')
        ->fetchAllAssociative();


        
        
        
        $apartments = [];
        foreach ($apartmentsQuery as $apartment) {
            $apartments[] = new Apartment(
                $apartment['title'],
                $apartment['description'],
                $apartment['address'],
                $apartment['select_from'],
                $apartment['select_to'],
            );
        }

        return new View("Home/index", [
            "apartments" => $apartments
        ]);
    }
    public function add():View
    {
        return new View('Home/post');
    }
    public function post():Redirect
    {
        if ($_POST["select_from"] == "") {
            $to = $_POST['to'] == "" ? null : $_POST['to'];
            Database::connection()->insert('apartments', [
            'title'=>$_POST['title'],
            'description'=>$_POST['description'],
            'address'=>$_POST['address'],
            'select_to'=>$to
        ]);
        } else {
            $from = $_POST['from'] == "" ? null : $_POST['from'];
            $to = $_POST['to'] == "" ? null : $_POST['to'];
            Database::connection()->insert('apartments', [
            'title'=>$_POST['title'],
            'description'=>$_POST['description'],
            'address'=>$_POST['address'],
            'select_from'=>$from,
            'select_to'=>$to
            ]);
        }
        return new Redirect("/");
    }
}
