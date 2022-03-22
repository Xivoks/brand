<?php

namespace App\Http\Controllers;

use App\Models\Shifts;
use App\Models\User;
use App\Models\Users;
use App\Models\Estates;
use Illuminate\Http\Request;


class ShiftController extends Controller
{
    public function create()
    {
        return view('index');
    }

    public function index()
    {
        date_default_timezone_set("Europe/Warsaw");
        $employee=Users::all();
        $substitute = Shifts::all();
        $tempChangesUnique = [];
        $todayDate = date("Y-m-d");
        foreach ($substitute as $substituteData) {
            if ($substituteData->date_from == $todayDate) {
                $estatesIdList = Estates::select('id')->where('supervisor_user_id', $substituteData->user_id)->get();
                foreach ($estatesIdList as $idEstate) {
                    $estateUpdateElement = Estates::find($idEstate->id);
                    $estateUpdateElement->supervisor_user_id = $substituteData->substitute_user_id;
                    $estateUpdateElement->update();
                }
            } else if ($substituteData->date_to == $todayDate) {
                $tempChangesNoUnique=[];
                $charList = $substituteData->temp_changes;
                for ($i = 0; $i < strlen($charList); $i++) {
                    if ($charList[$i] == ':') {
                        $indexOfChar = $i + 1;
                        $idNumber = $charList[$indexOfChar];
                        while ($charList[$indexOfChar++] != '}') {
                            if ($charList[$indexOfChar] != '}') {
                                $idNumber .= $charList[$indexOfChar];
                            }
                        }
                        array_push($tempChangesNoUnique, intval($idNumber));
                    }
                }
                $tempChangesUnique=array_unique($tempChangesNoUnique);
                foreach ($tempChangesUnique as $idEstatesFromTempChanges){
                        $updateEstates = Estates::find($idEstatesFromTempChanges);
                        $updateEstates->supervisor_user_id = $substituteData->user_id;
                        $updateEstates->update();
                }
            }
        }

        return view('index', compact('employee', 'substitute', 'tempChangesUnique'));
    }

    public function store(Request $request)
    {
        $insertNewVacation = new Shifts();
        $insertNewVacation->user_id = $request->input('user_id');
        $insertNewVacation->substitute_user_id = $request->input('substitute_user_id');
        $insertNewVacation->date_from = $request->input('date_from');
        $insertNewVacation->date_to = $request->input('date_to');
        $insertNewVacation->temp_changes = Estates::select('id')->where('supervisor_user_id', $request->input('user_id'))->get();
        $insertNewVacation->save();
        return redirect()->back()->with('status', 'Pomyślnie dodano urlop');
    }
}
