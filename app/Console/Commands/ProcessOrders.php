<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderLines;
use App\Models\User;
use Illuminate\Console\Command;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:processorders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pasar los pedidos de la tabla orders a navision';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $orderCode = Order::where('status', 0)->where('deleted_at', null)->groupBy('order_code')->pluck('order_code')->first();
            if (!empty($orderCode)) {
                $lines = OrderLines::where('order_code', $orderCode)->get();
                $order = Order::where('order_code', $orderCode)->where('deleted_at', null)->first();
                $products = '[';
                $user = "";
                foreach ($lines as $line) {
                    $sku = $line->sku;
                    $quantity = $line->quantity;
                    $montaje = 0;
                    $comment = ($line->comment == null) ? ("") : ($line->comment);
                    $product = '{' . '"sku"' . ':' . '"' . $sku . '"' . ',' . '"qty"' . ':' . '"' . $quantity . '"' . ',' . '"montaje"' . ':' . '"' . $montaje . '"' . ',' . '"comentario"' . ':' . '"' . $comment . '"' . '},';
                    $products .= $product;
                }
                $products = substr($products, 0, -1);
                $products .= ']';
                $user = $order->user;
                $apiKey = User::where('user', $user)->pluck('api_key')->first();
                $response = Http::withHeaders([
                    'x-globomatik-key' => $apiKey,
                    "Content-type" => "application/json",
                    "Server" => "API Globomatik",
                    "Cache-Control" => "no-cache",
                ])->post(env('URL_API') . "/api/v2/orders", [
                    "products" => $products,
                    "codPedidoCliente" => $order->order_code,
                    "codPedidoClienteFinal" => $order->client_order_code,
                    "observaciones" => $order->order_comments,
                    "dropshipping" => $order->dropshipping,
                    "envioANombre" => $order->send_to_name,
                    "envioADireccion" => $order->send_to_address,
                    "envioACp" => $order->send_to_zipcode,
                    "envioAPoblacion" => $order->send_to_village_neighborhood,
                    "envioAProvincia" => $order->send_to_city,
                    "envioATelefono" => $order->send_to_phone_number,
                    "envioAAtencion" => $order->send_to_person,
                    "codTransporte" => $order->transport_code,
                    "tipoAlbaran" => $order->delivery_note_type,
                    "tipoEmbalaje" => $order->packaging_type
                ]);
                if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
                    Order::where('order_code', $orderCode)->where('deleted_at', null)->update([
                        'status' => 1
                    ]);
                } else {
                    $this->info($response);
                    $controller = app(Controller::class);
                    $controller->sendErrorMail("command:processorders", "Pedido $orderCode tiene un error -> " . $response);
                    Log::error($response);
                    Order::where('order_code', $orderCode)->where('deleted_at', null)->update(['status' => 3]);
                    return "command:processorders" . " Pedido $orderCode tiene un error -> " . $response;
                }
            }
        } catch (\Exception $e) {
            $controller = app(Controller::class);
            $controller->sendErrorMail("command:processorders", "Pedido $orderCode tiene un error -> " . $e);
            Log::error($e);
            Order::where('order_code', $orderCode)->where('deleted_at', null)->update(['status' => 3]);
            return "command:processorders" . " Pedido $orderCode tiene un error -> " . $e;
        }
        $this->info("PEDIDO " . $orderCode . " PROCESADO CON ÉXITO");
        return 'OK';
    }
}
