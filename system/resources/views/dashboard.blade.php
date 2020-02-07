@extends('shared._layout')
@section('PageTitle', 'Dashboard')
@section('header')
<!-- Bagian Header -->

@endsection

@section('content')
<div class="row mt-4">
        <div class="col-12 col-lg-6 col-xl-3">
          <div class="card gradient-purpink">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-white">$4530</h4>
                <span class="text-white">Revenue</span>
              </div>
			  <div class="align-self-center"><span id="dash-chart-1"></span></div>
            </div>
            </div>
          </div>
        </div>
		<div class="col-12 col-lg-6 col-xl-3">
          <div class="card gradient-scooter">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-white">2500</h4>
                <span class="text-white">Total Orders</span>
              </div>
			  <div class="align-self-center"><span id="dash-chart-2"></span></div>
            </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-3">
          <div class="card gradient-ibiza">
            <div class="card-body">
              <div class="media">
			  <div class="media-body text-left">
                <h4 class="text-white">7850</h4>
                <span class="text-white">Comments</span>
              </div>
               <div class="align-self-center"><span id="dash-chart-3"></span></div>
            </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-3">
          <div class="card gradient-ohhappiness">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-white">3524</h4>
                <span class="text-white">Total Views</span>
              </div>
			  <div class="align-self-center"><span id="dash-chart-4"></span></div>
            </div>
            </div>
          </div>
        </div>
      </div><!--End Row-->

@endsection


@section('footer')
<!-- Footer Script -->

@endsection