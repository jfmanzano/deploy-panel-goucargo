<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FeedProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:feedproducts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alimentar la base de datos de productos de la API de GOUCARGO';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $response1 = Http::withHeaders([
                'x-globomatik-key' => "rln6FRB6RnR6fLVLGmhg"
            ])->get("https://webservice.goucargo.com/api/v2/products/descriptions");
            if ($response1->getStatusCode() == 200 || $response1->getStatusCode() == 201) {
                $result1 = $response1->json();
                $this->info('PROCESANDO PRODUCTOS...');
                foreach ($result1["products"] as $product => $productData) {
                    Producto::updateOrCreate(
                        [
                            "sku" => $productData["sku"]
                        ],
                        [
                            "sku" => $productData["sku"],
                            "description" => $productData["description"],
                            "EAN" => $productData["EAN"],
                            "PN" => $productData["PN"],
                            "stock" => 0
                        ]
                    );
                    $this->info($productData["sku"]);
                }
                $response2 = Http::withHeaders([
                    'x-globomatik-key' => "rln6FRB6RnR6fLVLGmhg"
                ])->get("https://webservice.goucargo.com/api/v2/products/stock?products=");
                if ($response2->getStatusCode() == 200 || $response2->getStatusCode() == 201) {
                    $result2 = $response2->json();
                    $this->info('PROCESANDO STOCK...');
                    foreach ($result2["products"] as $key => $value) {
                        Producto::where("sku", $key)->update([
                            "stock" => $value
                        ]);
                        $this->info($key . " - " . $value);
                    }
                }
                else{
                    $this->info($response2);
                    $controller = app(Controller::class);
                    $controller->sendErrorMail("command:feedproducts", $response2);
                    Log::error($response2);
                    return Command::FAILURE;
                }
            }
            else{
                $this->info($response1);
                $controller = app(Controller::class);
                $controller->sendErrorMail("command:feedproducts", $response1);
                Log::error($response1);
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $controller = app(Controller::class);
            $controller->sendErrorMail("command:feedproducts", $e);
            Log::error($e);
            return Command::FAILURE;
        }
        $this->info('FINALIZADO CON ÉXITO...');
        return Command::SUCCESS;
    }
}
