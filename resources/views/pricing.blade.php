@extends('layouts.main')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-6">
      <p>PHONE NUMBERS</p>
      <div class="card">
        <h5 class="card-header">Phone number</h5>
        <div class="card-body">
          <form method="POST" action="{{ route('phone_number_price') }}">
            @csrf
            <div class="form-group">
              <label for="phone_number">Country</label>
              <select class="form-control" name="iso2" required>
              <option value="">Select</option>
                @foreach($phoneCountries as $country)
                <option value="{{ $country->isoCountry }}"
                  @if(isset($selectedCountry) && $selectedCountry == $country->isoCountry)
                  selected @endif >{{ $country->country }}</option>
                @endforeach
              </select>
              <small id="numberHelp" class="form-text text-muted">Select the
                country of choice.</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@if(isset($available_number) && count($available_number) > 0)
<div class="card mt-4">
  <h5 class="card-header">Available Number</h5>
  <div class="card-body">
    <table class="table">
      <tr>
        <th scope="col">Number</th>
        <th scope="col">Voice</th>
        <th scope="col">SMS</th>
        <th scope="col">MMS</th>
        <th scope="col">Price</th>
        <th scope="col">Action</th>
      </tr>
      @foreach($available_number as $key => $number)
      <tr>
        <td>{{ $number->phoneNumber }}</td>
        <td> {{ $number->capabilities['voice'] ? 'Yes' : 'No' }}</td>
        <td> {{ $number->capabilities['SMS'] ? 'Yes' : 'No' }}</td>
        <td> {{ $number->capabilities['MMS'] ? 'Yes' : 'No' }}</td>
        <td>{{ $price->phoneNumberPrices[0]['base_price'] }}</td>
        <td><a href="/purchase_number/{{$number->phoneNumber}}/{{ $selectedCountry ?? '' }}" type="button">Buy now</a></td>

      </tr>
      @endforeach
    </table>

  </div>
</div>
@endif
@endsection