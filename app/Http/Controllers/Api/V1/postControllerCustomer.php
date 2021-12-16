<?php

namespace App\Http\Controllers\Api\V1;

use App\Customer;
use App\Commun;
use App\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class postControllerCustomer extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new \stdClass;

        $isDni = isset($request->dni) && strlen($request->dni) > 0? true : false;
        $isRegion = isset($request->region) && intval($request->region) !== 0 ? true : false;
        $isCommon = isset($request->commun) && intval($request->commun) !== 0 ? true : false;
        $isName = isset($request->name) && strlen($request->name) > 0 ? true : false;
        $isLastName = isset($request->lastName) && strlen($request->lastName)? true : false;
        $isEmail = isset($request->email) && filter_var($request->email, FILTER_VALIDATE_EMAIL) !== false ? true : false;
        $isStatus = isset($request->status)  && ($request->status === 'A' || $request->status === 'I') ? true : false;

        switch ($isRegion && $isCommon && $isName && $isLastName && $isEmail && $isStatus && $isDni) {
            case true:
                $existComReg = Commun::where(['id_com' => $request->commun], ['id_reg' => $request->region])->first();
                $existRegion = Region::where(['id_reg' => $request->region])->first();
                if ((!is_null($existComReg) && $existComReg->status !== 'trash') && (!is_null($existRegion) && $existRegion->status !== 'trash')) {
                    $customer = new Customer();
                    $customer->dni = $request->dni;
                    $customer->id_reg = intval($request->region);
                    $customer->id_com = intval($request->commun);
                    $customer->email = $request->email;
                    $customer->name = $request->name;
                    $customer->last_name = $request->lastName;
                    if (isset($request->address)) {
                        $customer->address = $request->address;
                    }
                    $customer->date_reg = now();
                    $customer->status = $request->status;
                    try {
                        if ($customer->save()) {
                            $data->message = "Row saved";
                            $data->success = true;
                        } else {
                            $data->message = "Error not save";
                            $data->success = false;
                        }
                    } catch (\Exception $e) {
                        $data->message = "Error - " . $e->getCode();
                        $data->success = false;
                    } 
                    
                } else {
                    $data->message = "Error - Region or Common not exist";
                    $data->success = false;
                }
                break;
            case false:
                $data->message = (!$isDni ? "Error - DNI. " : "") . (!$isRegion ? "Error - Region. " : "") . (!$isCommon ? "Error - Common. " : "") . (!$isName ? "Error - Name. " : "") .
                (!$isLastName ? "Error - LastName. " : "") . (!$isEmail ? "Error - Email. " : "") . (!$isStatus ? "Error - Status. " : "");
                $data->success = false;
                break;
        }
        return response()->json($data);
    }

    public function showCustomer(Request $request) {
        $data = new \stdClass;

        $isDni = isset($request->dni) && strlen($request->dni) > 0? true : false;
        $isEmail = isset($request->email) && filter_var($request->email, FILTER_VALIDATE_EMAIL) !== false ? true : false;
        
        if ($isDni || $isEmail) {
            $dataSend = $isDni ? ['dni' => $request->dni] : ['email' => $request->email];
            $rowCustumer = Customer::where($dataSend)->where('status' , '=', 'A')->first();
            if (!is_null($rowCustumer)) {
                $rowCommune = Commun::where(['id_reg' => $rowCustumer->id_reg] ,['id_com' => $rowCustumer->id_com])->first();
                $rowRegion = Region::where(['id_reg' => $rowCustumer->id_reg])->first();
                $data->name = $rowCustumer->name;
                $data->lastName = $rowCustumer->last_name;
                $data->address = $rowCustumer->address;
                $data->region = $rowRegion->description;
                $data->commune = $rowCommune->description;
                $data->success = true;
            } else {
                $data->message = "not found";
                $data->success = false;
            }
        } else {
            $data->message = (!$isDni ? "Error - DNI. " : "") . (!$isEmail ? "Error - Email. " : "");
            $data->success = false;
        }
        return response()->json($data);
    }

    public function deleteCustomer(Request $request) {
        $data = new \stdClass;

        $isDni = isset($request->dni) && strlen($request->dni) > 0? true : false;

        if ($isDni) {
            $customer = Customer::find($request->dni);
            if ($customer->status !== 'trash') {
               $customer->status = 'trash'; 
               try {
                    if ($customer->save()) {
                        $data->message = "Row deleted";
                        $data->success = true;
                    } else {
                        $data->message = "Error not save";
                        $data->success = false;
                    }
                } catch (\Exception $e) {
                    $data->message = "Error - " . $e->getCode();
                    $data->success = false;
                } 
            } else {
                $data->message = "Registro no existente";
                $data->success = false;
            }
        } else {
            $data->message = (!$isDni ? "Error - DNI. " : "");
            $data->success = false;
        } 

        return response()->json($data);
    }
}
