@extends('admin_master')

@section('content')
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1 class="m-0">Add/Edit Variant</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ url('/products') }}">All Product</a>
                        </li>

                        <li class="breadcrumb-item active">
                            Add/Edit Variant
                        </li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <section class="content">

        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">Add/Edit Variant</h3>
            </div>

            <form action="{{ route('variants.product.save') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <input type="hidden"
                       name="product_id"
                       value="{{ $product->id }}">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-12">

                            @foreach($variants as $variant)

                            <div class="card">

                                <div class="card-header bg-info text-light">
                                    <h5 class="card-title">
                                        {{ $variant->variant_name }}
                                    </h5>
                                </div>

                                <div class="card-body">

                                    <div class="table-responsive">

                                        <button type="button"
                                                class="btn btn-success float-right my-2 add-new-value"
                                                data-id="{{ $variant->id }}">

                                            <i class="fa fa-plus"></i>
                                            Add New

                                        </button>

                                        <table class="table table-bordered table-striped">

                                            <thead>
                                            <tr>
                                                <th>Value</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>

                                            <tbody id="variant_values_{{ $variant->id }}">

                                            @if(count($variant->productVariants) == 0)

                                                <tr>

                                                    <td>
                                                        <input type="text"
                                                               class="form-control"
                                                               name="variant_values[{{ $variant->id }}][]"
                                                               placeholder="Value">
                                                    </td>

                                                    <td>
                                                        <input type="file"
                                                               class="form-control"
                                                               name="images[{{ $variant->id }}][]">
                                                    </td>

                                                    <td>
                                                        <button type="button"
                                                                class="btn btn-danger btn-sm"
                                                                disabled>
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>

                                                </tr>

                                            @else

                                                @foreach($variant->productvariants as $pv)

                                                <tr id="variant_id_{{$pv->id}}">

                                                    <td>
                                                        <input type="text"
                                                               class="form-control"
                                                               name="variant_values[{{ $variant->id }}][]"
                                                               value="{{ $pv->variant_value }}">
                                                    </td>


                                                    <td>

                                                        @if($pv->image)

                                                            <a href="{{ asset($pv->image) }}"
                                                               target="_blank">

                                                                <img src="{{ asset($pv->image) }}"
                                                                     alt="Variant Image"
                                                                     style="
                                                                        width:70px;
                                                                        height:70px;
                                                                        object-fit:cover;
                                                                        border-radius:6px;
                                                                        border:1px solid #ddd;
                                                                     ">

                                                            </a>

                                                            <br><br>

                                                        @endif

                                                        <input type="file"
                                                               class="form-control"
                                                               name="images[{{ $variant->id }}][]">

                                                    </td>


                                                    <td>

                                                        <input type="hidden"
                                                               name="productvariant_ids[{{ $variant->id }}][]"
                                                               value="{{ $pv->id }}">

                                                        <button type="button"
                                                                class="btn btn-danger btn-sm remove-variant-permanant"
                                                                data-id="{{ $pv->id }}">

                                                            <i class="fa fa-trash"></i>

                                                        </button>

                                                    </td>

                                                </tr>

                                                @endforeach

                                            @endif

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                            @endforeach

                        </div>


                        <div class="form-group w-100 px-2">

                            <button type="submit"
                                    class="btn btn-primary">

                                Submit

                            </button>

                            <a href="{{ url('/products') }}"
                               class="btn btn-warning text-light">

                                Go to previous

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </section>

</div>
@endsection


@push('scripts')

<script>

$(document).ready(function(){

    $(document).on('click','.add-new-value',function(e){

        e.preventDefault();

        let id = $(this).data('id');

        let html = `
        <tr>

            <td>

                <input type="text"
                       class="form-control"
                       name="variant_values[${id}][]"
                       placeholder="Value">

            </td>

            <td>

                <input type="file"
                       class="form-control"
                       name="images[${id}][]">

            </td>

            <td>

                <button type="button"
                        class="btn btn-danger btn-sm remove-variant">

                    <i class="fa fa-trash"></i>

                </button>

            </td>

        </tr>`;

        $('#variant_values_'+id).append(html);

    });



    $(document).on('click','.remove-variant',function(e){

        e.preventDefault();

        $(this).closest('tr').remove();

    });



    $(document).on('click','.remove-variant-permanant',function(e){

        e.preventDefault();

        let variant_id = $(this).data('id');

        if(confirm('Do you want to delete this ?'))
        {

            $.ajax({

                url: "{{ url('/delete-variant') }}/"+variant_id,

                type: "GET",

                dataType: "json",

                success:function(data){

                    toastr.success(data.message);

                    $('#variant_id_'+variant_id).remove();

                }

            });

        }

    });

});

</script>

@endpush