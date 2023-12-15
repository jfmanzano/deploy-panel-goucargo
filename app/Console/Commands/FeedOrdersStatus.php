<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FeedOrdersStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:feedordersstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alimenta la tabla order_status';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $ordersCodes = Order::where('status', 1)->where('deleted_at', null)->groupBy('order_code')->pluck('order_code');
            if($ordersCodes != null){
                foreach ($ordersCodes as $orderCode) {
                    $this->info('PROCESANDO PEDIDO...' . $orderCode);
                    $user = Order::where('order_code', $orderCode)->where('deleted_at', null)->pluck('user')->first();
                    $apiKey = User::where('user', $user)->pluck('api_key')->first();
                    $url = env('URL_API') . '/api/v2/orders/' . $orderCode . '/status';
                    $response = Http::withHeaders([
                        'x-globomatik-key' => $apiKey
                    ])->get($url);
                    if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
                        $result = $response->json();
                        $orderCodeNav = $result["order"];
                        $serialNumber = $result["serialNumber"];
                        $shipping = $result["shipping"];
                        $status = $result["status"];
                        $statusText = $result["statusTxt"];
                        $trackingNumber = $result["trackingNumber"];
                        $this->info('ASIGNANDO TRACKING PEDIDO... ' . $orderCode);
                        Order::where("order_code", $orderCode)->where('deleted_at', null)->update(
                            [
                                "order_code" => $orderCode,
                                "order_code_nav" => $orderCodeNav,
                                "serial_number" => $serialNumber,
                                "shipping" => $shipping,
                                "status_nav" => $status,
                                "status_text" => $statusText,
                                "tracking_number" => $trackingNumber,
                                'status' => 2
                            ]
                        );
                        sleep(10);
                    }else{
                        $this->info($response);
                        $controller = app(Controller::class);
                        $controller->sendErrorMail("COMMAND:feedordersstatus", $response);
                        Order::where('order_code', $orderCode)->where('deleted_at', null)->update(['status' => 3]);
                        Log::error($response);
                        return Command::FAILURE;
                    }
                }
            }
        } catch (\Exception $e) {
            $controller = app(Controller::class);
            $controller->sendErrorMail("COMMAND:feedordersstatus", $e);
            $this->info('ERROR: reivsa el correo o los logs...');
            Log::error($e);
            return Command::FAILURE;
        }
        $this->info('FINALIZADO CON ÉXITO...');
        return Command::SUCCESS;
    }
}
