<?php

namespace App\Http\Controllers;

use App\Http\Brick\Brick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BrickController extends Controller
{
    public function getAccessToken()
    {
        $connect = new Brick;
        $res = $connect->getAccessToken();
        return $res->data->access_token;
    }
    public function getInstitutionList()
    {
        $connect = new Brick;
        $res = $connect->InstitutionList();
        dd($res->data);
        return $res->data->access_token;
    }
    public function brickWidget()
    {
        $accessToken = $this->getAccessToken();
        // dd($accessToken);
        $url = "https://cdn.onebrick.io/sandbox-widget/v1/?accessToken=" . $accessToken . "&redirect_url=https://epafroditusgeorge.com/brick/store-bank";
        return Redirect::to($url);
    }
    public function storeBankAcc()
    {
        dd(request()->all());
        return response()->json(['success' => true, 'message' => 'Pocket have been created'], 200);
    }
}
