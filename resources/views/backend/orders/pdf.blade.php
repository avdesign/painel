<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{env('DT_NAME')}} | Pedido N&deg; {{$order->id}}</title>
    <style>.wrapped{display: block; border: 1px solid #cccccc; padding: 10px; -webkit-border-radius: 7px; -moz-border-radius: 7px; border-radius: 7px;}.wrapped, .boxed{background: #f6f6f6; color: #666666; border-color: #cccccc;}h4{font-size: 16px; line-height: 19px; margin: 5px 0 15px;}.margin-bottom{margin-bottom: 16px !important;}.table-header + .table{border-top: 0;}.table > thead, .table > tbody > tr > th, .table > tfoot > tr > th{text-align: left;}.table > thead > tr > th, .table > thead > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td{padding: 9px 10px; border: 1px solid #cccccc; -webkit-box-shadow: inset 1px 0 0 rgba(255, 255, 255, 0.85), inset 0 1px 0 rgba(255, 255, 255, 0.85); -moz-box-shadow: inset 1px 0 0 rgba(255, 255, 255, 0.85), inset 0 1px 0 rgba(255, 255, 255, 0.85); box-shadow: inset 1px 0 0 rgba(255, 255, 255, 0.85), inset 0 1px 0 rgba(255, 255, 255, 0.85);}.table-header + .table > thead > tr > th, .table-header + .table > thead > tr > td{border-top: 0;}.table > tbody > tr > th, .table > tbody > tr > td{padding: 9px 10px; border-top: 1px solid #e6e6e6; border-left: 1px dotted #cfcfcf;}/* Even rows styling */ .table > tbody > tr:nth-child(even){background: #f7f7f7;}.table > tbody > tr.even{background: #f7f7f7;}/* Hover styling */ .table > tbody > tr:hover{background: #f0f0f0;}.table > tbody > tr.row-drop > th, .table > tbody > tr.row-drop > td, .table > tbody > tr > .cell-drop{border-top: 0;}/* Padding adjust */ th.low-padding, td.low-padding{line-height: 24px !important; padding: 5px 5px 4px 5px !important;}td.button-height, th.button-height{padding: 8px 10px 8px 10px !important;}/* Simple table style */ .simple-table{width: 100%; background-color: #ffffff;}.simple-table > thead > tr > th, .simple-table > thead > tr > td, .simple-table > tfoot > tr > th, .simple-table > tfoot > tr > td{color: black; padding: 8px 12px;}.simple-table > thead > tr > th, .simple-table > thead > tr > td{font-weight: bold; font-size: 15px;}.simple-table > tfoot > tr > th, .simple-table > tfoot > tr > td{border-top: 1px solid #cccccc;}.simple-table > tbody > tr > th, .simple-table > tbody > tr > td{padding: 8px 12px; color: #333333; border-top: 1px solid #e6e6e6;}.simple-table > tbody > tr:first-child > th, .simple-table > tbody > tr:first-child > td{border-top-color: #cccccc;}.simple-table > thead, .simple-table > tbody > tr > th, .simple-table > tfoot > tr > th{text-align: left;}/* Even rows styling */ .simple-table > tbody > tr:nth-child(even){background: #f7f7f7;}.simple-table > tbody > tr.even{background: #f7f7f7;}/* Hover styling */ .simple-table > tbody > tr:hover{background: #f0f0f0;}.no-margin-bottom{margin-bottom: 0 !important;}.float-left{float: left;}.float-right{float: right;}.clear-left{clear: left;}.clear-right{clear: right;}.clear-both{clear: both;}.underline{padding-bottom: 0.15em; border-bottom: 1px solid #cccccc;;}.align-left{text-align: left;}.align-center{text-align: center;}.align-right{text-align: right;}</style>
</head>
<body>



<div class="wrapped margin-bottom">
    <h4 class="no-margin-bottom">
        <span class="float-right">Pedido: {{$order->id}} </span>
        <img src="{{asset('backend/img/logo/logo-pdf.png')}}" width="100px">
    </h4>
    <span class="float-right">
        Data: {{date('d/m/Y H:i', strtotime($order->created_at))}}
    </span>
    <div class="underline"></div>
    <h3 class="no-margin-bottom"> {{$order->user->profile->name}}: {{$order->user_id}}</h3>
    <span class="float-right">
        @forelse($order->user->adresses()->orderBy('id', 'desc')->where('delivery', 1)->limit(1)->get() as $delivery)
            Endereço: {{$delivery->address}} , {{$delivery->number}}<br>
            @if($delivery->complement != '')
                Complemento: {{$delivery->complement}}<br>
            @endif
            Bairro: {{$delivery->district}}<br>
            Cidade: {{$delivery->city}} - {{$delivery->state}} <br>
            CEP: {{$delivery->zip_code}}
        @empty

        @endforelse
    </span>

    <div class="align-left">

        @if($order->user->type_id == 1)

            Razão Social: {{$order->user->last_name}}<br>
            Nome Fantasia: {{$order->user->first_name}}<br>
            CNPJ: {{$order->user->document1}}<br>
            Inscrição Estadual: {{$order->user->document2}}<br>
            Telefones: {{$order->user->cell}}
            @if($order->user->phone != '(00)0000-00000')
                - {{$order->user->phone}}
            @endif
            <br><br>
            <strong>Vendedor: {{$order->user->admin}}</strong>
            <br>
        @else
            Nome: {{$order->user->first_name}} {{$order->user->last_name}}<br>
            CPF: {{$order->user->document1}}<br>
            RG: {{$order->user->document2}}<br>
            Telefones: {{$order->user->cell}}
            @if($order->user->phone != '(00)0000-00000')
              - {{$order->user->phone}}
            @endif
            <br><br>
            <strong>Vendedor: {{$order->user->admin}}</strong>
            <br>
        @endif
    </div>

</div>
<table class="simple-table">

    <thead>
    <tr>
        <th scope="col"width="10%" ></th>
        <th scope="col">Descrição do Produto</th>
        <th scope="col" width="10%" class="align-center">Qtd.</th>
        <th scope="col" width="30%" class="align-right">SubTotal</th>
    </tr>
    </thead>
    <tfoot>

    </tfoot>

    <tbody>
    @php $total_cash=0; $total_card=0; @endphp
    @forelse($items as $item)
        @php
         $total_cash += $item->price_cash * ($item->quantity * $item->unit);
         $total_card += $item->price_card * ($item->quantity * $item->unit);
        @endphp
        <tr>
            <td><img src="{{url($photo_url.$image->path.$item->image)}}"></td>
            <td>
                {{$item->name}}<br>
                Código: {{$item->code}}<br>
                Cor: {{$item->color}} &nbsp; &nbsp; N&deg; {{$item->grid}}<br>
                @if($item->kit == 1)
                    @if($order->configFormPayment->id == 1)
                        {{$item->kit_name}} {{intval($item->unit)}} {{$item->measure}}: {{setReal($item->price_cash * $item->unit)}}<br>
                        Valor Und: {{setReal($item->price_cash)}}<br>
                    @else
                        {{$item->kit_name}} {{$item->kit_unit}} {{$item->measure}}: {{setReal($item->price_card * $item->unit)}}<br>
                        Valor Und: {{setReal($item->price_cash)}}<br>
                    @endif
                @else
                    @if($order->configFormPayment->id == 1)
                        Valor: {{setReal($item->price_cash)}}<br>
                    @else
                        Valor: {{setReal($item->price_card)}}<br>
                    @endif
                @endif
            </td>
            <td class="align-center">{{$item->quantity}}</td>
            @if($order->configFormPayment->id == 1)
                <td class="align-right">{{setReal($item->price_cash * ($item->quantity * $item->unit))}}</td>
            @else
                <td class="align-right">{{setReal($item->price_card * ($item->quantity * $item->unit))}}</td>
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="4">Não tem nenhum produto registrado.</td>
        </tr>
    @endforelse

    <tr bgcolor="#e9e9e9">
        <td><strong>{{$order->configFormPayment->label}}</strong></td>
        <td colspan="2">
            <strong>{{$order->configStatusPayment->label}}</strong><br>
        </td>
        <td class="align-right">
            @if($order->configFormPayment->id == 1)
                <p><b>SubToral:</b> {{setReal($total_cash)}}</p>
            @else
                <p><b>SubToral:</b> {{setReal($total_card)}}</p>
            @endif
            <p>Frete: {{setReal($order->freight)}}</p>
            @if($order->tax >= '1.00')
                <p>Taxa: {{setReal($order->tax)}}</p>
            @endif
            @if($order->discount >= '1.00')
                <p>Desconto: {{setReal($order->discount)}}</p>
            @endif
            @if($order->configFormPayment->id == 1)
                <p><b>TOTAL:</b> {{setReal(($total_cash + $order->freight + $order->tax) - $order->discount)}}</p>
            @else
                <p><b>TOTAL:</b> {{setReal(($total_card + $order->freight + $order->tax) - $order->discount)}}</p>
            @endif
        </td>
    </tr>

    @if(count($notes) >= 1)
        <tr>
            <td colspan="4">
                <p><strong>Obsevações:</strong></p>
                @foreach($notes as $note)
                    <p><strong>{{$note->name}}:</strong> {{$note->description}}</p>
                @endforeach
            </td>
        </tr>
    @endif
    @if(count($shippings) >=1 )
        <tr>
            <td colspan="4">
                @foreach($shippings as $shipping)
                    <p><strong>Método de Envio: {{$shipping->configShipping->name}}</strong></p>
                    @if(!empty($shipping->status))
                        <p><strong>Status:</strong> {{$shipping->status}}</p>
                    @endif
                    @if(!empty($shipping->code))
                        <p><strong>Código de Rastreamento:</strong> {{$shipping->code}}</p>
                    @endif
                    @if(!empty($shipping->url))
                        <p><strong>Link do Rastreamento:</strong> {{$shipping->url}}</p>
                    @endif
                    @if(!empty($shipping->name))
                        <p><strong>Transportadora:</strong> {{$shipping->name}}</p>
                    @endif
                    @if(!empty($shipping->phone))
                        <p><strong>Telefone da Transportadora:</strong> {{$shipping->phone}}</p>
                    @endif

                    @if(!empty($shipping->note))
                        <p>Nota:{!! nl2br(e($shipping->note)) !!}</p>
                    @endif
                @endforeach
            </td>
        </tr>
    @endif
    </tbody>
</table>
</body>
</html>
