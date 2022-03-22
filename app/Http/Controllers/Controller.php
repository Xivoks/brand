<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getDB(){
        $users = DB::select('select * from users');
        return response()->json($users, 200);
    }
    public function accountNumber()
    {
        $account_number = '##########################';
        $length_number = strlen($account_number);
        if ($length_number % 4 == 2) {
            #### rozwiązanie pierwsze ####
            $separate_number_one = substr($account_number, 0, 2) . " " . implode(" ", str_split(substr($account_number, 2), 4));

            #### rozwiązanie drugie ####
            $separate_number_two = preg_replace('/(^.{2})*(.{4})/', '$1 $2', $account_number);
            #### rozwiązanie trzecie ####
            $separate_number_three = substr($account_number, 0, 2) . ' ';
            for ($i = 2; $i < $length_number - 4; $i += 4) {
                $separate_number_three .= substr($account_number, $i, 4) . ' ';
            }
            $separate_number_three .= substr($account_number, $length_number - 4, 4);
        }
        #### usuwanie spacji ####
        $without_whitespace = str_replace(' ', '', $separate_number_three);
        return response()->json($separate_number_one, 200);
    }
}

