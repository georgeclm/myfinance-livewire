<?php

namespace App\Http\Controllers;

use App\Http\Brick\Brick;
use App\Models\Brick as ModelsBrick;
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
        $url = "https://cdn.onebrick.io/sandbox-widget/?accessToken=" . $accessToken . "&redirect_url=https://epafroditusgeorge.com/brick/store-bank";
        return Redirect::to($url);
    }
    public function storeBankAcc(Request $request)
    {
        // $res = json_encode($request->all());
        // $json = json_decode($request, true);
        // $accessToken = $res[0]->accessToken;
        // $res = json_decode($request);
        ModelsBrick::create([
            'response' => json_encode($request->all())
        ]);
        // dd('test');
        // return redirect()->route('home');
        return "https://epafroditusgeorge.com";
    }
}
