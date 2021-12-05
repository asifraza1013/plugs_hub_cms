@if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner') || auth()->user()->hasRole('driver'))
<div class="card-footer py-4">
    <h6 class="heading-small text-muted mb-4">{{ __('Actions') }}</h6   >
    <nav class="justify-content-end" aria-label="...">
    @role('admin')
        <script>
            function setSelectedOrderId(id){
                $("#form-assing-driver").attr("action", "/updatestatus/assigned_to_driver/"+id);
            }
        </script>
        @if($order->status->pluck('alias')->last() == "just_created")
            <a href="{{ url('updatestatus/accepted_by_admin/'.$order->id) }}" class="btn btn-primary">{{ __('Accept') }}</a>
            <a href="{{ url('updatestatus/rejected_by_admin/'.$order->id) }}" class="btn btn-danger">{{ __('Reject') }}</a>
            <a href="" class="btn btn-danger float-right"
            data-toggle="modal" data-target="#exampleModal"
            >{{ __('Manage Order Price') }}</a>
        @elseif($order->status->pluck('alias')->last() == "accepted_by_restaurant"&&$order->delivery_method.""!="2")
            <button type="button" class="btn btn-primary" onClick=(setSelectedOrderId({{ $order->id }}))  data-toggle="modal" data-target="#modal-asign-driver">{{ __('Assign to driver') }}</button>
        @else
            <p>{{ __('No actions for you right now!') }}</p>
       @endif
    @endrole
    @role('owner')
        @if($order->status->pluck('alias')->last() == "accepted_by_admin")
            <a href="{{ url('updatestatus/accepted_by_restaurant/'.$order->id) }}" class="btn btn-primary">{{ __('Accept') }}</a>
            <a href="{{ url('updatestatus/rejected_by_restaurant/'.$order->id) }}" class="btn btn-danger">{{ __('Reject') }}</a>
        @elseif($order->status->pluck('alias')->last() == "assigned_to_driver"||$order->status->pluck('alias')->last() == "accepted_by_restaurant")
            <a href="{{ url('updatestatus/prepared/'.$order->id) }}" class="btn btn-primary">{{ __('Prepared') }}</a>
        @elseif(config('app.allow_self_deliver')&&$order->status->pluck('alias')->last() == "accepted_by_restaurant")
            <a href="{{ url('updatestatus/prepared/'.$order->id) }}" class="btn btn-primary">{{ __('Prepared') }}</a>
        @elseif(config('app.allow_self_deliver')&&$order->status->pluck('alias')->last() == "prepared")
            <a href="{{ url('updatestatus/delivered/'.$order->id) }}" class="btn btn-primary">{{ __('Delivered') }}</a>
        @elseif($order->status->pluck('alias')->last() == "prepared"&&$order->delivery_method.""=="2")
            <a href="{{ url('updatestatus/delivered/'.$order->id) }}" class="btn btn-primary">{{ __('Delivered') }}</a>

        @else
            <p>{{ __('No actions for you right now!') }}</p>
        @endif
    @endrole
    @role('driver')
        @if($order->status->pluck('alias')->last() == "prepared")
            <a href="{{ url('updatestatus/picked_up/'.$order->id) }}" class="btn btn-primary">{{ __('Picked Up') }}</a>
        @elseif($order->status->pluck('alias')->last() == "picked_up")
            <a href="{{ url('updatestatus/delivered/'.$order->id) }}" class="btn btn-primary">{{ __('Delivered') }}</a>
        @else
            <p>{{ __('No actions for you right now!') }}</p>
        @endif
    @endrole
    </nav>
</div>
@endif
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Manage Delivery Cost</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('order.update.delivery.cost') }}" method="POST">
              @csrf
              <label for="" class="mt-2">Delivery Cost</label>
              <input type="cost" class="form-control form-control-alternative" name="cost" value="{{ $order->delivery_price }}">
              <input type="hidden" name="order" value="{{ $order->id }}">
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Change Now</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
