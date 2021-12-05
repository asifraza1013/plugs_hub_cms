@if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner') || auth()->user()->hasRole('driver'))
    @role('admin')
    <script>
        function setSelectedOrderId(id){
            $("#form-assing-driver").attr("action", "updatestatus/assigned_to_driver/"+id);
        }
    </script>
    <td>
        @if($order->status->pluck('alias')->last() == "just_created")
            <a href="{{'updatestatus/accepted_by_admin/'.$order->id }}" class="btn btn-success btn-sm order-action">{{ __('Accept') }}</a>
            <a href="{{'updatestatus/rejected_by_admin/'.$order->id }}" class="btn btn-danger btn-sm order-action">{{ __('Reject') }}</a>
        @elseif($order->status->pluck('alias')->last() == "accepted_by_admin" || $order->status->pluck('alias')->last() == "assigned_to_driver" || $order->status->pluck('alias')->last() == "request_to_accept" || $order->status->pluck('alias')->last() == "rejected_by_driver")

            @if ($order->status->pluck('alias')->last() == "assigned_to_driver" || $order->status->pluck('alias')->last() == "request_to_accept" || $order->status->pluck('alias')->last() == "rejected_by_driver")
            <button type="button" class="btn btn-primary btn-sm order-action" onClick=(setSelectedOrderId({{ $order->id }}))  data-toggle="modal" data-target="#modal-asign-driver">{{  __('Change driver') }}</a>
            @else    
            <button type="button" class="btn btn-primary btn-sm order-action" onClick=(setSelectedOrderId({{ $order->id }}))  data-toggle="modal" data-target="#modal-asign-driver">{{ __('Assign to driver') }}</a>
            @endif
        @endif
    </td>
    @endrole
    @role('driver')
    <td>
       @if($order->status->pluck('alias')->last() == "prepared")
            <a href="{{'updatestatus/picked_up/'.$order->id }}" class="btn btn-primary btn-sm order-action">{{ __('Picked Up') }}</a>
        @elseif($order->status->pluck('alias')->last() == "picked_up")
            <a href="{{'updatestatus/delivered/'.$order->id }}" class="btn btn-primary btn-sm order-action">{{ __('Delivered') }}</a>
        @endif
    </td>
    @endrole
@endif
