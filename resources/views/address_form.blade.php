@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form class="form-horizontal" method="post" action="{{ route('purchase_number_form') }}">
                    @csrf
                    <h2>Address</h2>

                    <div class="form-group">
                        <label for="inputFullName" class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputFullName" name="full_name"
                                placeholder="Full Name" required>
                        </div>
                        <x-error name="full_name" />
                    </div>

                    <div class="form-group">

                        <label for="inputAddressLine1" class="col-sm-2 control-label">Street Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputAddressLine1" name="street"
                                placeholder="852 Bastin Drive" required>
                        </div>
                        <x-error name="street" />
                    </div>

                    <div class="form-group">
                        <label for="inputCityTown" class="col-sm-2 control-label">City / Town</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputCityTown" name="city" placeholder="City"
                                required>
                        </div>
                        <x-error name="city" />
                    </div>

                    <div class="form-group">
                        <label for="inputStateProvinceRegion" class="col-sm-2 control-label">State/Region</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputStateProvinceRegion" name="region"
                                placeholder="State/province/area" required>
                        </div>
                        <x-error name="region" />
                    </div>
                    <input type="hidden" name="country_code" value="{{ $country_code }}" required>
                    <input type="hidden" name="number" value="{{ $number }}" required>

                    <div class="form-group">
                        <label for="inputZipPostalCode" class="col-sm-2 control-label">Zip / Postal Code</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputZipPostalCode" name="postal_code"
                                placeholder="Zip / Postal Code" required>
                        </div>
                        <x-error name="postal_code" />
                    </div>
                    <input type="submit" class="btn btn-success mt-2">
                </form>
            </div>
        </div>
    </div>
@endsection
