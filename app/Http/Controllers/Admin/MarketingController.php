<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use App\Models\ProductQuery;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Jobs\SendMarketingSMSJob;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class MarketingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductQuery::selectRaw("
                MIN(id) as id,
                phone,
                MAX(name) as name,  -- or use MIN(name)
                MAX(email) as email,  -- or use MIN(email)
                MIN(created_at) as created_at
            ")
                ->groupBy("phone")
                ->orderBy("created_at", "desc");

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("checkbox", function ($row) {
                    return '<div class="form-check">
                    <input id="jobCheckbox' . $row->id . '" class="form-check-input job-checkbox me-3" type="checkbox" value="' . $row->id . '" name="jobCheckbox[]">
                </div>';
                })
                ->addColumn("action", function ($row) {
                    return '
                    <div class="btn-group">
                        <a href="javascript:void(0);" class="btn btn-sm btn-secondary sendSms d-flex align-items-center" data-id="' . $row->id . '">
                            <i class="bx bx-message-dots me-1"></i>SMS
                        </a>
                    </div>
                ';
                })
                ->rawColumns(["checkbox", "action"])
                ->make(true);
        }

        $data = [
            "active" => 'marketing',
        ];
        return view("admin.marketing.index", $data);
    }

    // public function sendSMSSelectedUsers(Request $request)
    // {
    //     $request->validate([
    //         "ids" => "required",
    //         "message" => "required|string",
    //     ]);

    //     $ids = explode(",", $request->ids);
    //     $message = $request->message;

    //     $users = ProductQuery::whereIn("id", $ids)->get();

    //     foreach ($users as $user) {

    //         if (!$user->phone) {
    //             continue;
    //         }

    //         // if (!preg_match('/^(\+61|0)[2-478](\d{8})$/', $user->phone)) {
    //         //     continue;
    //         // }

    //         $message = str_replace("{customer_name}", $user->name, $message);
    //         SendMarketingSMSJob::dispatch($user->phone, $message);
    //     }

    //     return response()->json([
    //         "status" => "success",
    //         "message" => "SMS sent successfully"
    //     ]);
    // }




    public function sendSMSSelectedUsers(Request $request)
    {
        $request->validate([
            "ids" => "required",
            "message" => "required|string",
        ]);

        $ids = explode(",", $request->ids);
        $message = $request->message;

        $users = ProductQuery::whereIn("id", $ids)->get();

        foreach ($users as $user) {

            if (!$user->phone) {
                continue;
            }

             if (!preg_match('/^(\+61|0)[2-478](\d{8})$/', $user->phone)) {
                 continue;
             }

            $message = str_replace("{customer_name}", $user->name, $message);
            $client = new Client();

            $username = env("TOUCH_SMS_USER_NAME");
            $password = env("TOUCH_SMS_PASSWORD");

            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode("$username:$password"),
            ];

            $body = json_encode([
                "reject_duplicates_by_recipient" => false,
                "messages" => [
                    [
                        "to" => $user->phone,
                        "from" => env("TOUCH_SMS_FROM"),
                        "body" => $message
                    ]
                ]
            ]);

            try {
                $response = $client->request('POST', 'https://app.touchsms.com.au/api/v2/sms', [
                    'headers' => $headers,
                    'body' => $body,
                ]);
                Log::info($response->getBody()->getContents());
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        return response()->json([
            "status" => "success",
            "message" => "SMS sent successfully"
        ]);
    }










    public function sendSMSAllUsers(Request $request)
    {
        $request->validate([
            "message" => "required|string",
        ]);

        $users = ProductQuery::selectRaw("
                    MIN(id) as id,
                    phone,
                    ANY_VALUE(name) as name,
                    ANY_VALUE(email) as email,
                    MIN(created_at) as created_at
                ")
            ->groupBy("phone")
            ->orderBy("created_at", "desc")->get();

        foreach ($users as $user) {

            if (!$user->phone) {
                continue;
            }

            // if (!preg_match('/^(\+61|0)[2-478](\d{8})$/', $user->phone)) {
            //     continue;
            // }

            $message = str_replace("{customer_name}", $user->name, $request->message);

            dispatch(new SendMarketingSMSJob($user->phone, $message));
        }

        return response()->json([
            "status" => "success",
            "message" => "SMS sent successfully"
        ]);
    }
}
