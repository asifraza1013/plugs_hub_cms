<div class="row align-items-center" v-cloak>
    <div :class="item.pulse"></div>
    <div class="col ml-1">
        <small> @{{ item.last_status }}</small><br />
        <small> @{{ item.time }}</small>
        <h5 class="mb-0">
            <a href="#!">#@{{ item.id }} @{{ item.client_email }}</a>
        </h5>
        <small>@{{ item.client }}</small><br />
        <small>@{{ item.price }}</small><br />

    </div>
    <div class="col-12">
        <a class="btn btn-sm btn-primary btn-block" :href="item.link">{{ __('Details')}}</a>
    <!--<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default">
      {{ __('Details')}}
    </button> -->
    </div>

  </div>