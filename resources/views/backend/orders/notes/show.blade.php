@forelse($notes as $note)
    <h4 class="underline"></h4>
    <button onclick="abreModal('{{$title_edit}}', '{{route('order-notes.edit', ['id' => $note->id, 'order_id' => $order->id])}}', 'order-notes', 2, 'true', 400, 200);" class="button blue-gradient float-right with-tooltip icon-plus-round compact" title="Mark as spam">{{$btn_edit}}</button>

    <h5 class="black">{{$note->name}}</h5>
    <p>{!! nl2br(e($note->description)) !!}</p>
@empty
    <div class="left-border grey">
        <p>Não existe observação para o pedido {{$order->id}}</p>
    </div>
@endforelse
