<table class="table responsive-table" id="add-products">
    <thead>
    <tr>
        <th></th>
        <th></th>
        <th>Código</th>
        <th>Cor</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="4"></td>
    </tr>
    </tfoot>
</table>


<script>
    $.fn.loadTableProducts('add-products','{{$order_id}}','{{route('order-items.search', $order_id)}}','{{csrf_token()}}');

</script>