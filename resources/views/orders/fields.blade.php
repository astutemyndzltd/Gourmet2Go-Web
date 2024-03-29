@if($customFields)
    <h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">


    <div class="form-group row">
        {!! Form::label('id', trans('lang.order_id'), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            <p>#{!! $order->id !!}</p>
        </div>
    </div>


    <!-- User Id Field -->
    <input type="hidden" name="user_id" value="{{ $order->user_id }}">

    {{-- <div class="form-group row ">
        {!! Form::label('user_id', trans("lang.order_user_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            <input type="hidden" name="user_id" id="hdnUserId">
            {!! Form::select('user_id', $user, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_user_id_help") }}</div>
        </div>
    </div> --}}

    @if($order->order_type !== 'Pickup')
        <!-- Driver Id Field -->
        <div class="form-group row ">
            {!! Form::label('driver_id', trans("lang.order_driver_id"),['class' => 'col-3 control-label text-right']) !!}
            <div class="col-9">
                {!! Form::select('driver_id', $driver, null, ['data-empty'=>trans("lang.order_driver_id_placeholder"),'class' => 'select2 not-required form-control']) !!}
                <div class="form-text text-muted">{{ trans("lang.order_driver_id_help") }}</div>
            </div>
        </div>
    @endif

    <!-- Order Status Id Field -->
    <div class="form-group row ">
        {!! Form::label('order_status_id', trans("lang.order_order_status_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('order_status_id', $orderStatus, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_order_status_id_help") }}</div>
        </div>
    </div>

    <!-- Status Lasts For Field -->
    <?php 
        $status = $order->orderStatus->status;
        $display = $status == 'Preparing' || $status == 'On the Way' ? 'flex' : 'none';
        $lastsFor = isset($order->statusDetails->lasts_for) ? $order->statusDetails->lasts_for : null;
        $disabled = $status == 'Preparing' || $status == 'On the Way';

        $range = range(5, 60, 5);
        $duration = new stdClass();
        foreach($range as $value) $duration->$value = $value . ' minutes';
    ?>

    <div class="form-group row status-duration-container" style="display:{{ $display }};">
        {!! Form::label('status_duration', 'Estimated Time', ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('status_duration', $duration, $lastsFor, ['class' => 'select2 form-control', 'disabled' => $disabled ]) !!}
            <div class="form-text text-muted">Estimated time to complete the phase</div>
        </div>
    </div>

    <!-- Payment Status Field -->
    <input type="hidden" name="status" value="{{ $order->payment->status }}">

    {{-- <div class="form-group row ">
        {!! Form::label('status', trans("lang.payment_status"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('status',
            [
            'Waiting for Client' => trans('lang.order_pending'),
            'Not Paid' => trans('lang.order_not_paid'),
            'Paid' => trans('lang.order_paid'),
            ]
            , isset($order->payment) ? $order->payment->status : '', ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.payment_status_help") }}</div>
        </div>
    </div> --}}

    <!-- 'Boolean active Field' -->

    <input type="hidden" value="{{ $order->active }}" name="active">

    {{-- <div class="form-group row ">
        {!! Form::label('active', trans("lang.order_active"),['class' => 'col-3 control-label text-right']) !!}
        <div class="checkbox icheck">
            <label class="col-9 ml-2 form-check-inline">
                {!! Form::hidden('active', 0) !!}
                {!! Form::checkbox('active', 1, null) !!}
            </label>
        </div>
    </div> --}}

</div>

<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">

    <!-- Tax Field -->

    <input type="hidden" name="tax" value="{{ $order->tax }}">            

    {{-- <div class="form-group row ">
        {!! Form::label('tax', trans("lang.order_tax"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('tax', null,  ['class' => 'form-control', 'step'=>"any",'placeholder'=>  trans("lang.order_tax_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.order_tax_help") }}
            </div>
        </div>
    </div> --}}

    <!-- delivery_fee Field -->
    <input type="hidden" name="delivery_fee" value="{{ $order->delivery_fee }}">
        
    {{-- <div class="form-group row ">
        {!! Form::label('delivery_fee', trans("lang.order_delivery_fee"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('delivery_fee', null,  ['class' => 'form-control','step'=>"any",'placeholder'=>  trans("lang.order_delivery_fee_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.order_delivery_fee_help") }}
            </div>
        </div>
    </div> --}}

    <!-- Hint Field -->
    <div class="form-group row">
        {!! Form::label('hint', trans("lang.order_hint"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::textarea('hint', null, ['class' => 'form-control', 'placeholder' => trans("lang.order_hint_placeholder")  ]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_hint_help") }}</div>
        </div>
    </div>

</div>
@if($customFields)
    <div class="clearfix"></div>
    <div class="col-12 custom-field-container">
        <h5 class="col-12 pb-4">{!! trans('lang.custom_field_plural') !!}</h5>
        {!! $customFields !!}
    </div>
@endif
<!-- Submit Field -->
<div class="form-group col-12 text-right">
    <button type="submit" class="btn btn-{{setting('theme_color')}}"><i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.order')}}</button>
    <a href="{!! route('orders.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
