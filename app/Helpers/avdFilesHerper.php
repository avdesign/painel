<?php
use Illuminate\Contracts\Filesystem\Factory as fileFactory;

use Barryvdh\DomPDF\Facade as PDF;

/**
 * Abrir PDF no browser
 * @var $order array
 * @return  json
 */
if (! function_exists('printerOrderPdf')) {
    function printerOrderPdf($order) {

        $pdf_url  = 'storage/pdf/order';
        $factory = app(fileFactory::class);
        $diskAccesses = $factory->disk('local');

        $name = md5($order->id) . md5($order->user_id).'.pdf';
        $year = date('Y', strtotime($order->created_at));
        $file = url("{$pdf_url}/{$year}/{$order->user_id}/{$name}");
        $path    = "public/pdf/order/{$year}/{$order->user_id}/{$name}";



        if ($diskAccesses->exists($path)) {
            $success = true;
            $message = 'Imprimir PDF';
            $pdf = $file;

        } else {
            $success = false;
            $message = 'O PDF não foi localizado, atualize o pedido.';
            $pdf = '';
        }
        $out = array(
            "success" => $success,
            "message" => $message,
            "pdf" => $pdf
        );

        if ($diskAccesses->exists($path)) {
            $out['taget'] =  "_blank";

            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Imprimiu o pedido:'.$order->id)
            );
        }

        return response()->json($out);

    }
}

/**
 * Gerar arquivos pdf dor order.
 *
 * @var string str
 * @return  void
 */
if (! function_exists('generateOrderPdf')) {
    function generateOrderPdf($order, $configImages, $method){


        $photo_url = 'storage/';
        $pdf_url   = 'storage/pdf/order';
        $disk_pdf  = storage_path('app/public/pdf/order');
        $view_pdf  = 'backend.orders.pdf';

        $items = $order->items;
        $notes = $order->notes;
        $year = date('Y', strtotime($order->created_at));
        $shippings = $order->shippings;

        $image = $configImages;

        $name = md5($order->id) . md5($order->user_id).'.pdf';
        $path = "{$disk_pdf}/{$year}/{$order->user_id}";
        $file = "{$path}/{$name}";

        $route = url("{$pdf_url}/{$year}/{$order->user_id}/{$name}");

        if ($method == 'store') {

            if ( !file_exists($path) ) {
                Storage::makeDirectory($path, 0777, true);
            }
        }

        if (file_exists($file)) {
            $delete = unlink($file);
        }

        $pdf = PDF::loadView("{$view_pdf}", compact(
            'order', 'items', 'notes', 'shippings', 'image', 'photo_url'
        ));
        $pdf->save($file);

        return $route;
    }
}

/**
 * Criar arquivo txt dos acessos dos usuário administrativos.
 *
 * @var string str
 * @return  void
 */
if (! function_exists('generateAccessesTxt')) {
	function generateAccessesTxt($str){
		$factory = app(fileFactory::class);		
		$admin   = auth()->guard('admin')->user();
		$path    = 'Accesses/'.$admin->id.'/'.date('d-m-Y').'.txt'; 

		$diskAccesses = $factory->disk('local');
		if ($diskAccesses->exists($path)) {
			$diskAccesses->append($path, $str); 
		} else {
			$diskAccesses->put($path, $str);
		}

	}
}

/**
 * Lista os acessos dos usuário administrativos.
 *
 * @var int $id user
 * @return files txt
 */
if (! function_exists('listAccessTxt')) {
	function listAccessTxt($id){
		$factory = app(fileFactory::class);
		$path    = 'Accesses/'.$id;			
		$files   = $factory->allFiles($path);
		rsort($files);
		return $files;
	}
}


/**
 * $ac: abrir, excluir e excluir-todos os arquivos.
 * $path: Caminho relativo do arquivo.
 * $nome: Nome do usuário.
 * $dir: Dieretorio gravação do arquivo.
 * @var  string $ac string $path string $nome string $dir
 */

if (! function_exists('actionsTxt')) {
	function actionsTxt($ac, $path, $name, $id){
		$factory = app(fileFactory::class);
		$exists  = $factory->exists($path);
		if ($ac == 'delete-all') {
			$acao = $factory->deleteDirectory($path, $preserve = false);
			generateAccessesTxt(date('H:i:s').' Excluiu todos os arquivos de acessos de '.$name);
			$success = true;
			$message = 'Os arquivos dos acessos foram exluidas.';
		} else {
			if ($exists) {
				if ($ac == 'open') {

					$str  = substr($path, -14);
					$date = substr($str, 0, 10);
					$text = nl2br(utf8_encode($factory->get($path)));
					print('<h5 class="anthracite underline">'.$name.' - Data: '.$date.'</h5>');
					print(nl2br($text));
					$success=''; 
					$message='';
				} elseif ($ac == 'delete') {
					$acao = $factory->delete($path);
					$file = substr($path, -14);
					generateAccessesTxt(date('H:i:s').' Excluiu o arquivo de acesso: '.$file.' de '.$name);
					$success = true;
					$message = "O arquivo {$file} foi exluido.";
				}
			} else {
				$success = false;
				$message = 'Este arquivo não existe.';
			}
		}

        $out = array(
            "success" => $success,
            "message" => $message
        );

		return $out;
	}	
}

