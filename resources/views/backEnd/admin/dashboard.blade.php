@extends('backEnd.layouts.master')
@section('title','Dashboard')
@section('content')
<!-- Start Content-->
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="main_part">
                @if(Auth::user()->dashboard==1)
                <div class="overview_inner">
                    <div class="overview_item overview_item_background_up">
                        <h5>Total Income</h5>
                        <p>${{$total_income}}</p>
                        <h6>{!! $income_report !!}</h6>

                        <!--img src="{{asset('public/backend')}}/assets/images/TinyAreaChart.png" alt="" class="shaddow_img"-->
                    </div>
                    <div class="overview_item  overview_item_background_up">
                        <h5>Earning In This Month</h5>
                        <p>${{$monthly_income}}</p>
                        <h6>{!!$earn_report !!}</h6>

                        <!--img src="{{asset('public/backend')}}/assets/images/TinyAreaChart.png" alt="" class="shaddow_img"-->
                    </div>
                    <div class="overview_item  overview_item_background_up">
                        <h5>Earning Today</h5>
                        <p>${{$today_income}}</p>
                        <h6>{!! $todayearn_report !!} </h6>

                        <!--img src="{{asset('public/backend')}}/assets/images/TinyAreaChart.png" alt="" class="shaddow_img"-->
                    </div>
                    <div class="overview_item  overview_item_background_up">
                        <h5>Refund/Cancel</h5>
                        <p>${{$cancel_payment}}</p>
                        <h6><span class="red_c">{!! $todaycancel_report !!}</h6>

                        <!--img src="{{asset('public/backend')}}/assets/images/TinyAreaChart.png" alt="" class="shaddow_img"-->
                    </div>
                </div>
                @endif
                <div class="overview_head">
                    <h4>ORDER STATISTICS</h4>
                </div>
                <div class="overview_inner">
                    <div class="overview_item  overview_item_background_down">
                        <h5>Completed Order</h5>
                        <p>{{$complete_order}}</p>
                        <h6>{!! $complete_report !!}</h6>

                        <!--img src="{{asset('public/backend')}}/assets/images/downwave.png" alt="" class="shaddow_img shaddow_img2"-->
                    </div>
                    <div class="overview_item overview_item_background_down">
                        <h5>Active Order</h5>
                        <p>{{$active_order}}</p>
                        <h6>{!! $active_report !!}</h6>

                        <!--img src="{{asset('public/backend')}}/assets/images/downwave.png" alt="" class="shaddow_img shaddow_img2"-->
                    </div>
                    <div class="overview_item overview_item_background_down">
                        <h5>Unpaid Order</h5>
                        <p>{{$unpaid_order}}</p>
                        <h6>{!! $todayupcancel_report !!}</h6>

                        <!--img src="{{asset('public/backend')}}/assets/images/downwave.png" alt="" class="shaddow_img shaddow_img2"-->
                    </div>
                    <div class="overview_item overview_item_background_down">
                        <h5>Cancel Order</h5>
                        <p>{{$cancel_order}}</p>
                        <h6><span class="red_c"> {!! $todayorcancel_report !!}</h6>

                        <!--img src="{{asset('public/backend')}}/assets/images/downwave.png" alt="" class="shaddow_img shaddow_img2"-->
                    </div>
                </div>

            </div>
        </div>
    </div>     
    <div class="row">
        @if(Auth::user()->dashboard==1)
        <div class="col-sm-8">
            <div class="yearly-chart">
                <div class="chart-head">
                    <p>Income Reports</p>
                </div>
                <div class="chart-body">
                    <div id="monthly_chart"></div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-sm-4">
            <div class="traffic-chart">
                <div class="chart-head">
                    <p>Total Site Traffic</p>
                </div>
                <div class="chart-body">
                    <h2>24,000</h2>
                    <p><img src="{{asset('public/backend')}}/assets/images/north.png" alt="">15.21% Since Last Month</p>
                      <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>  
</div> 
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data for the chart
    var data = {
      datasets: [{
        data: [10, 20, 30],
        backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],
        hoverBackgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"]
      }]
    };

    // Configuration options
    var options = {
      responsive: true
    };

    // Create the chart
    var ctx = document.getElementById("myChart").getContext("2d");
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: data,
      options: options
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
       var options = {
          series: [{
          name: 'Sale',
          data: [
                @for ($month = 1; $month <= 12; $month++)
                @php
                    $amount = App\Models\Order::whereMonth('created_at','=',$month)->sum('total');
                @endphp
                {{ $amount }},
                @endfor
            ],
        }],
          chart: {
          type: 'bar',
          height: 290
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded',
            borderRadius: 8
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: [
            @for ($month = 1; $month <= 12; $month++)
                @php
                    $date = \Carbon\Carbon::create(null, $month, null)->format('M');
                @endphp
                "{{ $date }}",
            @endfor
            ],
        },
        yaxis: {
          title: {
            text: ''
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val 
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#monthly_chart"), options);
        chart.render();
  </script>
@endsection