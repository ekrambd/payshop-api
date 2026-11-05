@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1>Delivery Charge Settings</h1>
        </div>
    </div>

    <section class="content">

        <div class="container-fluid">

            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">
                        Delivery Charge Configuration
                    </h3>
                </div>

                <form action="{{ url('/save-delivery-charge') }}" method="POST">

                    @csrf

                    <div class="card-body">

                        <div class="form-group">

                            <label>Inside City Charge (%)</label>

                            <input type="number"
                                   step="0.01"
                                   class="form-control"
                                   name="inside_city_charge"
                                   placeholder="Enter Inside City Charge"
                                   value="{{ $setting->inside_city_charge ?? '' }}"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>Outside City Charge (%)</label>

                            <input type="number"
                                   step="0.01"
                                   class="form-control"
                                   name="outside_city_charge"
                                   placeholder="Enter Outside City Charge"
                                   value="{{ $setting->outside_city_charge ?? '' }}"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>Per Weight Charge (Fixed)</label>

                            <input type="number"
                                   step="0.01"
                                   class="form-control"
                                   name="per_weight_charge"
                                   placeholder="Enter Charge Per Weight"
                                   value="{{ $setting->per_weight_charge ?? '' }}"
                                   required>

                            <small class="text-muted">
                                Example: Charge per KG.
                            </small>

                        </div>

                    </div>

                    <div class="card-footer">

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Save Settings
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>

</div>

@endsection