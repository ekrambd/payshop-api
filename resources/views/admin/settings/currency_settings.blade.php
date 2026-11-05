@extends('admin_master')

@section('content')
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Currency Settings</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Currency Settings
                        </li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <section class="content">

        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">Currency Settings</h3>
            </div>

            <form action="{{ url('currency-settings-update') }}" method="POST">
                @csrf

                <div class="card-body">
                    <div class="row">

                        {{-- Parent Currency --}}
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="parent_currency">
                                    Parent Currency <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="parent_currency"
                                    id="parent_currency"
                                    class="form-control select2bs4"
                                    required>

                                    <option value="usd" {{ $setting->parent_currency == 'usd' ? 'selected' : '' }}>
                                        USD
                                    </option>

                                    <option value="jpy" {{ $setting->parent_currency == 'jpy' ? 'selected' : '' }}>
                                        JPY
                                    </option>

                                    <option value="sar" {{ $setting->parent_currency == 'sar' ? 'selected' : '' }}>
                                        SAR
                                    </option>

                                    <option value="bdt" {{ $setting->parent_currency == 'bdt' ? 'selected' : '' }}>
                                        BDT
                                    </option>

                                </select>

                                @error('parent_currency')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        {{-- USD --}}
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="usd_rate">
                                    USD Rate
                                </label>

                                <input
                                    type="text"
                                    id="usd_rate"
                                    name="usd_rate"
                                    class="form-control"
                                    value="{{ old('usd_rate',$setting->usd_rate) }}"
                                    placeholder="USD Rate">

                                @error('usd_rate')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="usd_symbol">
                                    USD Symbol
                                </label>

                                <input
                                    type="text"
                                    id="usd_symbol"
                                    name="usd_symbol"
                                    class="form-control"
                                    value="{{ old('usd_symbol',$setting->usd_symbol) }}"
                                    placeholder="$">

                                @error('usd_symbol')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>


                        {{-- JPY --}}
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="jpn_rate">
                                    JPY Rate
                                </label>

                                <input
                                    type="text"
                                    id="jpn_rate"
                                    name="jpn_rate"
                                    class="form-control"
                                    value="{{ old('jpn_rate',$setting->jpn_rate) }}"
                                    placeholder="JPY Rate">

                                @error('jpn_rate')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="jpn_symbol">
                                    JPY Symbol
                                </label>

                                <input
                                    type="text"
                                    id="jpn_symbol"
                                    name="jpn_symbol"
                                    class="form-control"
                                    value="{{ old('jpn_symbol',$setting->jpn_symbol) }}"
                                    placeholder="¥">

                                @error('jpn_symbol')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>


                        {{-- SAR --}}
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="ksa_riyal">
                                    SAR Rate
                                </label>

                                <input
                                    type="text"
                                    id="ksa_riyal"
                                    name="ksa_riyal"
                                    class="form-control"
                                    value="{{ old('ksa_riyal',$setting->ksa_riyal) }}"
                                    placeholder="SAR Rate">

                                @error('ksa_riyal')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="riyal_symbol">
                                    SAR Symbol
                                </label>

                                <input
                                    type="text"
                                    id="riyal_symbol"
                                    name="riyal_symbol"
                                    class="form-control"
                                    value="{{ old('riyal_symbol',$setting->riyal_symbol) }}"
                                    placeholder="﷼">

                                @error('riyal_symbol')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>


                        {{-- BDT --}}
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="bdt_rate">
                                    BDT Rate
                                </label>

                                <input
                                    type="text"
                                    id="bdt_rate"
                                    name="bdt_rate"
                                    class="form-control"
                                    value="{{ old('bdt_rate',$setting->bdt_rate) }}"
                                    placeholder="BDT Rate">

                                @error('bdt_rate')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="bdt_symbol">
                                    BDT Symbol
                                </label>

                                <input
                                    type="text"
                                    id="bdt_symbol"
                                    name="bdt_symbol"
                                    class="form-control"
                                    value="{{ old('bdt_symbol',$setting->bdt_symbol) }}"
                                    placeholder="৳">

                                @error('bdt_symbol')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        
                        
                        
                        {{-- UAE --}}
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="uae_rate">
                                    UAE Rate
                                </label>

                                <input
                                    type="text"
                                    id="uae_rate"
                                    name="uae_rate"
                                    class="form-control"
                                    value="{{ old('uae_rate',$setting->uae_rate) }}"
                                    placeholder="UAE Rate">

                                @error('uae_rate')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="bdt_symbol">
                                    UAE Symbol
                                </label>

                                <input
                                    type="text"
                                    id="uae_symbol"
                                    name="uae_symbol"
                                    class="form-control"
                                    value="{{ old('uae_symbol',$setting->uae_symbol) }}"
                                    placeholder="AED">

                                @error('uae_symbol')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>


                        <div class="col-md-12">
                            <button class="btn btn-primary">
                                Update
                            </button>
                        </div>

                    </div>
                </div>

            </form>

        </div>

    </section>

</div>
@endsection