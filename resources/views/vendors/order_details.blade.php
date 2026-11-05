@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1>Order Details</h1>
        </div>
    </div>

    <section class="content">

        <div class="card card-info">

            <div class="card-header">
                <h3 class="card-title">Order Information</h3>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Order ID</label>
                            <input type="text"
                                   class="form-control"
                                   value="#{{ $order->id }}"
                                   readonly>
                        </div>

                        <div class="form-group">
                            <label>Invoice No</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $order->invoice_no }}"
                                   readonly>
                        </div>

                        <div class="form-group">
                            <label>Customer Name</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $order->user->name ?? $order->user_name }}"
                                   readonly>
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $order->user_phone }}"
                                   readonly>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $order->user_email }}"
                                   readonly>
                        </div>

                    </div>

                    <div class="col-md-6">

                    <form id="changeOrderStatusForm">

                        <div class="form-group">

                            <label>Order Status</label>

                            <select class="form-control select2bs4" id="order_status" name="status">

                                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>
                                    Pending
                                </option>

                                <option value="Awaiting Payment" {{ $order->status == 'Awaiting Payment' ? 'selected' : '' }}>
                                    Awaiting Payment
                                </option>

                                <option value="Payment Received" {{ $order->status == 'Payment Received' ? 'selected' : '' }}>
                                    Payment Received
                                </option>

                                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>
                                    Processing
                                </option>

                                <option value="Packed" {{ $order->status == 'Packed' ? 'selected' : '' }}>
                                    Packed
                                </option>

                                <option value="Shipped / Dispatched" {{ $order->status == 'Shipped / Dispatched' ? 'selected' : '' }}>
                                    Shipped / Dispatched
                                </option>

                                <option value="In Transit" {{ $order->status == 'In Transit' ? 'selected' : '' }}>
                                    In Transit
                                </option>

                                <option value="Out for Delivery" {{ $order->status == 'Out for Delivery' ? 'selected' : '' }}>
                                    Out for Delivery
                                </option>

                                <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>
                                    Delivered
                                </option>

                                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>
                                    Completed
                                </option>

                                <option value="On Hold" {{ $order->status == 'On Hold' ? 'selected' : '' }}>
                                    On Hold
                                </option>

                                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>

                                <option value="Refunded" {{ $order->status == 'Refunded' ? 'selected' : '' }}>
                                    Refunded
                                </option>

                                <option value="Failed" {{ $order->status == 'Failed' ? 'selected' : '' }}>
                                    Failed
                                </option>

                                <option value="Returned" {{ $order->status == 'Returned' ? 'selected' : '' }}>
                                    Returned
                                </option>

                                <option value="Return to Sender (RTO)" {{ $order->status == 'Return to Sender (RTO)' ? 'selected' : '' }}>
                                    Return to Sender (RTO)
                                </option>

                            </select>

                        </div>

                        <div class="form-group">
                           <button type="submit" class="btn btn-success">Change Order Status</button> 
                        </div>

                    </form>

                        <div class="form-group">
                            <label>Date</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $order->date }}"
                                   readonly>
                        </div>

                        <div class="form-group">
                            <label>Time</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $order->time }}"
                                   readonly>
                        </div>

                        <div class="form-group">
                            <label>Country</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $order->user_country }}"
                                   readonly>
                        </div>

                        <div class="form-group">
                            <label>City</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $order->user_city }}"
                                   readonly>
                        </div>

                    </div>

                </div>

                <div class="form-group">

                    <label>Shipping Address</label>

                    <textarea class="form-control"
                              rows="3"
                              readonly>{{ $order->user_address }}</textarea>

                </div>

                <hr>

                <h4 class="mb-3">

                    Ordered Products

                </h4>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="bg-light">

                        <tr>

                            <th width="70">Image</th>

                            <th>Product</th>

                            <th width="120">Price</th>

                            <th width="120">Discount</th>

                            <th width="40">Unit</th>

                            <th width="40">Qty</th>

                            <th width="120">Total</th>

                        </tr>

                        </thead>

                        <tbody>

                        @php

                            $grandTotal = 0;

                        @endphp

                        @foreach($products as $product)

                            @php

                                $price = $product->purchase_price;

                                $unit = $product->unit->unit_name;

                                $discount = $product->purchase_discount;

                                $qty = $product->qty;

                                $subtotal = $price * $qty;

                                $grandTotal += $subtotal;

                            @endphp

                            <tr>

                                <td>

                                    <img src="{{ asset($product->featured_image) }}"
                                         width="70"
                                         class="img-thumbnail">

                                </td>

                                <td>

                                    <strong>

                                        {{ $product->product_name }}

                                    </strong>

                                    @if($product->variants->count())

                                        <hr class="my-2">

                                        @foreach($product->variants as $variant)

                                            <div class="mb-1">

                                                <strong>

                                                    {{ $variant->variant_name }}

                                                </strong>

                                                :

                                                @foreach($variant->productVariants as $value)

                                                    <span class="badge badge-info">

                                                        {{ $value->variant_value }}

                                                    </span>

                                                @endforeach

                                            </div>

                                        @endforeach

                                    @endif

                                </td>

                                <td>

                                    {{ number_format($price,2) }}

                                </td>

                                <td>

                                    {{ number_format($discount,2) }}

                                </td>

                                <td>

                                    {{$unit}}

                                </td>

                                <td>

                                    {{ $qty }}

                                </td>

                                <td>

                                    {{ number_format($subtotal,2) }}

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                        <tfoot>

                            <tr>

                                <th colspan="5" class="text-right">

                                    Grand Total

                                </th>

                                <th>

                                    {{ number_format($grandTotal,2) }}

                                </th>

                            </tr>

                            <div class="row mt-3">

                                <div class="col-md-4">

                                  <form id="changeDeliveryType">

                                   <div class="form-group">

                                    <label><b>Delivery Type</b></label>

                                    <select class="form-control select2bs4" id="delivery_type">

                                        <option value="" selected="" disabled="">Select Delivery Type</option>

                                        <option value="inside" selected="">Inside City</option>

                                        {{-- <option value="outside">Outside City</option> --}}

                                    </select>

                                  </div>

                                  <div class="form-group d-none">

                                    <button type="submit" class="btn btn-success">Change Place Type</button>

                                  </div>

                                 </form>

                                </div>

                            </div>

                            <br>

                            <table class="table table-bordered">

                                <tr>

                                    <th width="250">Product Total</th>

                                    <td>
                                        {{$order->current_symbol}} <span id="grand_total">{{ number_format($grandTotal,2,'.','') }}</span>
                                    </td>

                                </tr>

                                <tr>

                                    <th>Delivery Charge</th>

                                    <td>
                                        {{$order->current_symbol}} <span id="delivery_charge">{{$order->delivery_charge}}</span>
                                    </td>

                                </tr>


                                <tr>

                                    <th>Final Total</th>

                                    <td>

                                        <strong>

                                            {{-- {{$order->current_symbol}} <span id="final_total">{{ number_format($grandTotal,2,'.','')+$order->delivery_charge }}</span> --}}

                                            {{$order->current_symbol}} <span id="grand_total">{{ number_format($grandTotal,2,'.','') }}</span>

                                        </strong>

                                    </td>

                                </tr>

                            </table>

                        </tfoot>

                    </table>

                </div>

                <a href="{{ url('/my-orders') }}"
                   class="btn btn-secondary mt-3">

                    <i class="fas fa-arrow-left"></i>

                    Back

                </a>

            </div>

        </div>

    </section>

</div>

@endsection

@push('scripts')
 <script>
   $(document).ready(function(){
    let finalTotal;
       $(document).on('submit','#changeOrderStatusForm',function(e){
          e.preventDefault();
          if(confirm('Do you want to change the status?'))
          {   
              let order_id = "{{$order->id}}";
              let status = $('#order_status').val();

              $.ajax({

                url: "{{url('/edit-order-status')}}",

                     type:"POST",
                     data:{'order_id':order_id, 'status':status},
                     dataType:"json",
                     success:function(data) {

                        toastr.success(data.message);

                        window.location.reload();

                },
                                
            });
          }   
          
       });


       // $(document).on('change', '#delivery_type', function () {

       //      let grandTotal = parseFloat("{{ $grandTotal }}");

       //      let insideCharge = parseFloat("{{ $deliveryCharge->inside_city_charge ?? 0 }}");

       //      let outsideCharge = parseFloat("{{ $deliveryCharge->outside_city_charge ?? 0 }}");

       //      let charge = 0;

       //      if ($(this).val() == 'inside') {

       //          charge = (grandTotal * insideCharge) / 100;

       //      } else if ($(this).val() == 'outside') {

       //          charge = (grandTotal * outsideCharge) / 100;

       //      }

       //      finalTotal=grandTotal + charge;

       //      $('#delivery_charge').text(charge.toFixed(2));

       //      $('#final_total').text(finalTotal.toFixed(2));

       //  });

       // //changeDeliveryType

       // $(document).on('submit','#changeDeliveryType',function(e){
       //    e.preventDefault();
       //    if(confirm('Are you sure?'))
       //    {   
       //        let order_id = "{{$order->id}}";
       //        let value = $('#delivery_type').val();
       //        let orderTotal = finalTotal;

       //        $.ajax({

       //          url: "{{url('/edit-order-place-type')}}",

       //               type:"POST",
       //               data:{'order_id':order_id, 'place_type':value, 'order_total':orderTotal},
       //               dataType:"json",
       //               success:function(data) {

       //                  toastr.success(data.message);

       //                  window.location.reload();

       //          },
                                
       //      });
       //    }   
          
       // }); 



    });
 </script>   
@endpush