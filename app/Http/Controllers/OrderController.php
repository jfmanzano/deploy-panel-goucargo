<?php

namespace App\Http\Controllers;

use App\Models\OrderLines;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Producto;


class OrderController extends Controller
{
    public function create()
    {
        return view("create-order");
    }

    public function index($status = null)
    {
        $user = Auth::user()->user;
        $rol = Auth::user()->rol;
        if ($status != null) {
            $processedOrders = ($rol == 1) ? (Order::where("status", $status)->where('deleted_at', null)->pluck('order_code')) : (Order::where("status", $status)->where('deleted_at', null)->where("user", $user)->pluck('order_code'));
        } else {
            $processedOrders = Order::where('deleted_at', null)->pluck('order_code');
        }
        $processedOrderStatus = [];
        if (isset($processedOrders)) {
            foreach ($processedOrders as $order_code) {
                array_push($processedOrderStatus, Order::where("order_code", $order_code)->where('deleted_at',null)->get());
            }
        }
        return view("order-status", compact("processedOrderStatus"));
    }

    public function store(Request $request)
    {
        $array = [];
        foreach ($request->request as $key => $item) {
            $array[$key] = $item;
        }
        $request->validate([
            "order_code" => ["required", "string", "min:5"],
            "client_order_code" => ["required", "string", "min:5"],
            "order_comments" => ["nullable", "string"],
            "dropshipping" => ["required", "in:0,1"],
            "send_to_name" => ["required", "string", "min:5"],
            "send_to_address" => ["required", "string", "min:5"],
            "send_to_zipcode" => ["required", "string", "min:1"],
            "send_to_village_neighborhood" => ["required", "string", "min:5"],
            "send_to_city" => ["required", "string", "min:3"],
            "send_to_phone_number" => ["required", "string", "min:9"],
            "send_to_person" => ["required", "string", "min:3"],
            "transport_code" => ["required", "in:1060,2000,888,537,2070,902,904"],
            "delivery_note_type" => ["required", "in:0,1,2,3,4"],
            "packaging_type" => ["required", "in:0,1,2"]
        ]);
        $error = false;
        $codesError = "";
        try {
            $accountName = Auth::user()->user;
            if (!Order::where("order_code", $array["order_code"])->count()) {
                Order::create([
                    "order_code" => $array["order_code"],
                    "client_order_code" => $array["client_order_code"],
                    "order_comments" => $array["order_comments"],
                    "dropshipping" => $array["dropshipping"],
                    "send_to_name" => $array["send_to_name"],
                    "send_to_address" => $array["send_to_address"],
                    "send_to_zipcode" => $array["send_to_zipcode"],
                    "send_to_village_neighborhood" => $array["send_to_village_neighborhood"],
                    "send_to_city" => $array["send_to_city"],
                    "send_to_phone_number" => $array["send_to_phone_number"],
                    "send_to_person" => $array["send_to_person"],
                    "transport_code" => $array["transport_code"],
                    "delivery_note_type" => $array["delivery_note_type"],
                    "packaging_type" => $array["packaging_type"],
                    'order_code_nav' => null,
                    'serial_number' => null,
                    'shipping' => null,
                    'status_nav' => null,
                    'status_text' => null,
                    'tracking_number' => null,
                    "status" => 0,
                    "user" => $accountName
                ]);
            } else {
                $error = true;
                $codesError .= $array["order_code"] . "\n";
            }
            for ($x = 0; $x < ((count($array) - 15) / 3); $x++) {
                if (!OrderLines::where("sku", $array["sku" . $x])->where("order_code", $array["order_code"])->count()) {
                    OrderLines::create([
                        "order_code" => $array["order_code"],
                        "sku" => $array["sku" . $x],
                        "quantity" => $array["quantity" . $x],
                        "comment" => $array["comment" . $x]
                    ]);
                } else {
                    $error = true;
                    $codesError .= $array["order_code"] . "\t-\t" . $array["sku" . $x] . "\n";
                }
            }
            if ($error) {
                Alert::warning('ORDER CODE OR SKU REPEATED', "$codesError")->persistent('Dismiss');
            } else {
                Alert::success('ORDERS CREATED SUCCESSFULLY', '');
            }
        } catch (\Exception $e) {
            $this->sendErrorMail($accountName, $e);
            Alert::warning('ERROR CREATING ORDER', '');
            return redirect("create-order");
        }
        return redirect()->route("order-status", '0');
    }

    public function storeOrderExcel(Request $request)
    {
        $accountName = Auth::user()->user;
        $templateID = Auth::user()->template_id;
        $template = Template::where('id', $templateID)->first();

        $customerFields = explode(';', $template->customer_fields);
        $ownFields = explode(';', $template->own_fields);

        $file = $request->file("archivo_excel");
        if (isset($file)) {
            $extension = $file->getClientOriginalExtension();
            if ($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') {
                $spreadsheet = IOFactory::load($file);
                $hoja = $spreadsheet->getActiveSheet();
                $data = $hoja->toArray();
                try {
                    $error = false;
                    $codesError = "";
                    $columnas = [];
                    for ($i = 0; $i < sizeof($customerFields); $i++) {
                        for ($y = 0; $y < sizeof($data[0]); $y++) {
                            if ($customerFields[$i] == $data[0][$y]) {
                                $columnas[$y] = $ownFields[$i];
                            }
                        }
                    }
                    $datos = [];
                    for ($i = 1; $i < sizeof($data); $i++) {
                        for ($y = 0; $y < sizeof($data[$i]); $y++) {
                            if ($data[$i][$y] == null) {
                                continue;
                            }
                            if (isset($columnas[$y])) {
                                if ($columnas[$y] == "send_to_name" && $templateID == 2) {
                                    $datos[$i][$columnas[$y]] = $data[$i][$y-1] . " " . $data[$i][$y];
                                } else {
                                    $datos[$i][$columnas[$y]] = $data[$i][$y];
                                }
                            }
                        }
                    }
                    foreach ($datos as $fila) {
                        if (!Order::where("order_code", $fila["order_code"])->where('deleted_at', null)->count()) {
                            $order = new Order;
                            foreach ($fila as $key => $value) {
                                if ($key == 'sku' || $key == 'quantity' || $key == 'comment') {
                                    continue;
                                }
                                $order->$key = $value;
                            }
                            $order->client_order_code = $fila["order_code"];
                            if($templateID == 2){
                                $order->send_to_person = $fila["send_to_name"];
                            }
                            $order->dropshipping = 1;
                            $order->transport_code = ($accountName == "HUDL") ? (214) : (58);
                            $order->delivery_note_type = 4;
                            $order->packaging_type = 1;
                            $order->order_code_nav = null;
                            $order->serial_number = null;
                            $order->shipping = null;
                            $order->status_nav = null;
                            $order->status_text = null;
                            $order->tracking_number = null;
                            $order->status = 0;
                            $order->user = $accountName;
                            $order->save();
                        }
                        $sku = Producto::where('PN', $fila["sku"])->pluck('sku')->first();
                        if (!OrderLines::where("sku", $sku)->where("order_code", $fila["order_code"])->count()) {
                            $order = new OrderLines;
                            foreach ($fila as $key => $value) {
                                if ($key != 'sku' && $key != 'quantity' && $key != 'order_code') {
                                    continue;
                                }
                                $order->comment = "";
                                if ($key == "sku") {
                                    $order->$key = $sku;
                                } else {
                                    $order->$key = $value;
                                }
                            }
                            $order->save();
                        } else {
                            $error = true;
                            $codesError .= $fila["order_code"] . "\t-\t" . $fila["sku"] . "\n";
                        }
                    }
                    if ($error) {
                        Alert::warning('ORDER CODE OR SKU REPEATED', "$codesError")->persistent('Dismiss');
                    } else {
                        Alert::success('ORDERS CREATED SUCCESSFULLY', '');
                    }
                } catch (\Exception $e) {
                    $this->sendErrorMail($accountName, $e);
                    Alert::warning('ERROR CREATING ORDERS', '');
                    return redirect("create-order");
                }
            } else {
                Alert::warning('WRONG FILE EXTENSION', '');
            }
        } else {
            Alert::warning('FILE NOT FOUND', '');
        }
        return redirect('create-order');
    }
    public function deletedAt($id)
    {
        $orderCode = Order::where('id',$id)->pluck('order_code')->first();
        Order::where('id', $id)->update([
            'deleted_at' => now()
        ]);
        OrderLines::where('order_code',$orderCode)->delete();
        Alert::success('ORDER DELETED SUCCESSFULLY', '');
        return redirect()->back();
    }
}
