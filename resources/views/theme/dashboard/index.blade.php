@extends('theme.layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <!-- Website Analytics-->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        Application Analytics
                    </h5>

                </div>
                <div class="card-body pb-2">
                    <div class="d-flex justify-content-around align-items-center flex-wrap mb-4">
                        <div class="user-analytics text-center me-2">
                            <i class="bx bx-user me-1"></i>
                            <span>Total Student</span>
                            <div class="d-flex align-items-center mt-2">
                                <div class="chart-report" data-color="success" data-series="100">
                                </div>
                                <h3 class="mb-0">
                                    {{ $dashaboard_data->total_student }}
                                </h3>
                            </div>
                        </div>
                        <div class="sessions-analytics text-center me-2">
                            <i class="bx bx-user-circle me-1"></i>
                            <span>
                                Total Teacher
                            </span>
                            <div class="d-flex align-items-center mt-2">
                                <div class="chart-report" data-color="primary" data-series="100">
                                </div>
                                <h3 class="mb-0">
                                    {{ $dashaboard_data->total_teacher }}
                                </h3>
                            </div>
                        </div>
                        <div class="bounce-rate-analytics text-center">
                            <i class="bx bx-book me-1"></i>
                            <span>
                                Total Course
                            </span>
                            <div class="d-flex align-items-center mt-2">
                                <div class="chart-report" data-color="info" data-series="100">
                                </div>
                                <h3 class="mb-0">
                                    {{ $dashaboard_data->total_course }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <span>
                        <span class="fw-bold text-primary">Total Student</span> in this year by month
                    </span>
                    <div id="analyticsBarChart"></div>
                </div>
            </div>
        </div>

        <!-- Referral, conversion, impression & income charts -->
        <div class="col-lg-6 col-md-12">
            <div class="row">
                <!-- Referral Chart-->
                <div class="col-sm-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2 class="mb-1">€{{ $dashaboard_data->total_sales }}</h2>
                            <span class="text-muted">Total Sales</span>
                            <div id="referralLineChart"></div>
                        </div>
                    </div>
                </div>
                <!-- Conversion Chart-->
                <div class="col-sm-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-3">
                            <div class="conversion-title">
                                <h5 class="card-title mb-1">
                                    7 Days Sales
                                </h5>
                            </div>
                            <h2 class="mb-0">
                                €{{ $dashaboard_data->last_7_days_sales->sum('total_sales') }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <div id="conversionBarchart"></div>
                        </div>
                    </div>
                </div>
                <!-- Impression Radial Chart-->
                <div class="col-sm-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div id="impressionDonutChart"></div>
                        </div>
                    </div>
                </div>
                <!-- Growth Chart-->
                <div class="col-sm-6 col-12">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar">
                                                <span class="avatar-initial bg-label-primary rounded-circle"><i
                                                        class="bx bx-euro fs-4"></i></span>
                                            </div>
                                            <div class="card-info">
                                                <h6 class="card-title mb-0 me-2">
                                                    €{{ $dashaboard_data->last_month_total_sales }}</h6>
                                                <small class="text-muted">Last Month Sales</small>
                                            </div>
                                        </div>
                                        <div style="width: 100px" id="conversationChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar">
                                                <span class="avatar-initial bg-label-warning rounded-circle"><i
                                                        class="bx bx-euro fs-4"></i></span>
                                            </div>
                                            <div class="card-info">
                                                <h6 class="card-title mb-0 me-2">
                                                    €{{ $dashaboard_data->last_year_total_sales }}
                                                </h6>
                                                <small class="text-muted">Last Year Sales</small>
                                            </div>
                                        </div>
                                        <div style="width: 100px" id="incomeChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Referral, conversion, impression & income charts -->

        <!-- Activity -->
        {{-- <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Activity</h5>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-2">
                            <div class="avatar avatar-sm flex-shrink-0 me-3">
                                <span class="avatar-initial rounded-circle bg-label-primary"><i
                                        class="bx bx-cube"></i></span>
                            </div>
                            <div class="d-flex flex-column w-100">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Total Sales</span>
                                    <span class="text-muted">$2,459</span>
                                </div>
                                <div class="progress" style="height: 6px">
                                    <div class="progress-bar bg-primary" style="width: 40%" role="progressbar"
                                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-2">
                            <div class="avatar avatar-sm flex-shrink-0 me-3">
                                <span class="avatar-initial rounded-circle bg-label-success"><i
                                        class="bx bx-dollar"></i></span>
                            </div>
                            <div class="d-flex flex-column w-100">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Income</span>
                                    <span class="text-muted">$8,478</span>
                                </div>
                                <div class="progress" style="height: 6px">
                                    <div class="progress-bar bg-success" style="width: 80%" role="progressbar"
                                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-2">
                            <div class="avatar avatar-sm flex-shrink-0 me-3">
                                <span class="avatar-initial rounded-circle bg-label-warning"><i
                                        class="bx bx-trending-up"></i></span>
                            </div>
                            <div class="d-flex flex-column w-100">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Budget</span>
                                    <span class="text-muted">$12,490</span>
                                </div>
                                <div class="progress" style="height: 6px">
                                    <div class="progress-bar bg-warning" style="width: 80%" role="progressbar"
                                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-2">
                            <div class="avatar avatar-sm flex-shrink-0 me-3">
                                <span class="avatar-initial rounded-circle bg-label-danger"><i
                                        class="bx bx-check"></i></span>
                            </div>
                            <div class="d-flex flex-column w-100">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Tasks</span>
                                    <span class="text-muted">$184</span>
                                </div>
                                <div class="progress" style="height: 6px">
                                    <div class="progress-bar bg-danger" style="width: 25%" role="progressbar"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div> --}}
        <!--/ Activity -->

        <!-- Profit Report & Registration -->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Student</h6>
                        </div>
                        <div class="card-body d-flex align-items-end justify-content-between">
                            <div class="d-flex justify-content-between align-items-center gap-3 w-100 flex-wrap">
                                <div class="d-flex align-content-center mb-5">
                                    <div class="chart-report" data-color="primary" data-series="100"></div>
                                    <div class="chart-info">
                                        <h5 class="mb-0">{{ $dashaboard_data->today_student }}</h5>
                                        <small class="text-muted">Today</small>
                                    </div>
                                </div>
                                <div class="d-flex align-content-center mb-5">
                                    <div class="chart-report" data-color="info" data-series="100">
                                    </div>
                                    <div class="chart-info">
                                        <h5 class="mb-0">{{ $dashaboard_data->seven_days_student }}</h5>
                                        <small class="text-muted">7 Days</small>
                                    </div>
                                </div>
                                <div class="d-flex align-content-center mb-4">
                                    <div class="chart-report" data-color="secondary" data-series="100">
                                    </div>
                                    <div class="chart-info">
                                        <h5 class="mb-0">{{ $dashaboard_data->thirty_days_student }}</h5>
                                        <small class="text-muted">30 Days</small>
                                    </div>
                                </div>
                                <div class="d-flex align-content-center mb-4">
                                    <div class="chart-report" data-color="success" data-series="100">
                                    </div>
                                    <div class="chart-info">
                                        <h5 class="mb-0">{{ $dashaboard_data->one_year_student }}</h5>
                                        <small class="text-muted">1 Year</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Profit Report & Registration -->

        <!-- Sales -->
        <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-start justify-content-between">
                    <div class="card-title mb-0">
                        <h6 class="m-0 me-2">Sales</h6>
                    </div>

                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4">
                            <span class="text-primary me-2"><i class="bx bx-euro bx-sm"></i></span>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0 lh-1">Today</h6>
                                </div>
                                <div class="item-progress"> €{{ $dashaboard_data->today_sale }}</div>
                            </div>
                        </li>
                        <li class="d-flex mb-4">
                            <span class="text-primary me-2"><i class="bx bx-euro bx-sm"></i></span>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0 lh-1">7 Days</h6>
                                </div>
                                <div class="item-progress"> €{{ $dashaboard_data->seven_days_Sale }}</div>
                            </div>
                        </li>
                        <li class="d-flex mb-4">
                            <span class="text-primary me-2"><i class="bx bx-euro bx-sm"></i></span>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0 lh-1">30 Days</h6>
                                </div>
                                <div class="item-progress"> €{{ $dashaboard_data->thirty_days_Sale }}</div>
                            </div>
                        </li>
                        <li class="d-flex mb-3">
                            <span class="text-primary me-2"><i class="bx bx-euro bx-sm"></i></span>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0 lh-1">1 Year</h6>
                                </div>
                                <div class="item-progress"> €{{ $dashaboard_data->one_year_Sale }}</div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <!--/ Sales -->

        <!-- Growth Chart-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-4">
            <div class="card">
                <div class="card-body text-center">

                    <div id="growthRadialChart"></div>
                    <h6 class="mb-0 mt-5">{{ $dashaboard_data->previous_year_growth_rate }}% Growth in
                        {{ // previous year
                            date('Y', strtotime('-1 year')) }}</h6>
                    </h6>
                </div>
            </div>
        </div>
        <!-- Growth Chart-->

        <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-start justify-content-between">
                    <div class="card-title mb-0">
                        <h6 class="m-0 me-2">Course</h6>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4">
                            <span class="text-primary me-2"><i class="bx bx-up-arrow-alt bx-sm"></i></span>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0 lh-1">Today</h6>
                                </div>
                                <div class="item-progress">{{ $dashaboard_data->today_course }}</div>
                            </div>
                        </li>
                        <li class="d-flex mb-4">
                            <span class="text-primary me-2"><i class="bx bx-up-arrow-alt bx-sm"></i></span>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0 lh-1">7 Days</h6>
                                </div>
                                <div class="item-progress"> €{{ $dashaboard_data->seven_days_course }}</div>
                            </div>
                        </li>
                        <li class="d-flex mb-4">
                            <span class="text-primary me-2"><i class="bx bx-up-arrow-alt bx-sm"></i></span>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0 lh-1">30 Days</h6>
                                </div>
                                <div class="item-progress"> €{{ $dashaboard_data->thirty_days_course }}</div>
                            </div>
                        </li>
                        <li class="d-flex mb-3">
                            <span class="text-primary me-2"><i class="bx bx-up-arrow-alt bx-sm"></i></span>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0 lh-1">1 Year</h6>
                                </div>
                                <div class="item-progress"> €{{ $dashaboard_data->one_year_course }}</div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <!-- Finance Summary -->
        <div class="col-md-12 col-lg-12 mb-4 mb-md-">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center me-3">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">Last 5 Tracking History</h5>
                            <small class="text-muted">Last 5 Tracking History</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive pt-0">
                        <table class="datatables-basic table table-bordered">
                            <thead>
                                <tr>
                                    <th>sl</th>
                                    <th>Student Name</th>
                                    <th>Teacher Name</th>
                                    <th>Duration</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dashaboard_data->last_5_tracking_histories as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->user_name }}</td>
                                        <td>{{ $item->teacher_name }} </td>
                                        <td>
                                            {{ $item->hours }} Hours
                                            {{ $item->minutes }} Minutes
                                            {{ $item->seconds }} Seconds
                                        </td>
                                        <td> {{ $item->date }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- Finance Summary -->

        {{-- <!-- Activity Timeline -->
        <div class="col-md-5 col-lg-5 mb-0">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Activity Timeline</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="timelineWapper" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="timelineWapper">
                            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Activity Timeline -->
                    <ul class="timeline">
                        <li class="timeline-item timeline-item-transparent ps-4">
                            <span class="timeline-point timeline-point-primary"></span>
                            <div class="timeline-event pb-2">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">12 Invoices have been paid</h6>
                                    <small class="text-muted">12 min ago</small>
                                </div>
                                <p class="mb-2">Invoices have been paid to the company</p>
                                <div class="d-flex">
                                    <a href="javascript:void(0)" class="me-3">
                                        <img src="/assets/img/icons/misc/pdf.png" alt="PDF image" width="23"
                                            class="me-2" />
                                        <span class="fw-bold text-body">Invoices.pdf</span>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent ps-4">
                            <span class="timeline-point timeline-point-warning"></span>
                            <div class="timeline-event pb-2">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Client Meeting</h6>
                                    <small class="text-muted">45 min ago</small>
                                </div>
                                <p class="mb-2">Project meeting with john @10:15am</p>
                                <div class="d-flex flex-wrap">
                                    <div class="avatar me-3">
                                        <img src="/assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div>
                                        <h6 class="mb-0">John Doe (Client)</h6>
                                        <span class="text-muted">CEO of Pixinvent</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent ps-4">
                            <span class="timeline-point timeline-point-info"></span>
                            <div class="timeline-event pb-0">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Create a new project for client</h6>
                                    <small class="text-muted">2 Day Ago</small>
                                </div>
                                <p class="mb-2">5 team members in a project</p>
                                <div class="d-flex align-items-center avatar-group">
                                    <div class="avatar avatar-sm pull-up" data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom" data-bs-placement="top" title="Vinnie Mostowy">
                                        <img src="/assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div class="avatar avatar-sm pull-up" data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom" data-bs-placement="top" title="Marrie Patty">
                                        <img src="/assets/img/avatars/12.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div class="avatar avatar-sm pull-up" data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom" data-bs-placement="top" title="Jimmy Jackson">
                                        <img src="/assets/img/avatars/9.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div class="avatar avatar-sm pull-up" data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom" data-bs-placement="top" title="Kristine Gill">
                                        <img src="/assets/img/avatars/6.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div class="avatar avatar-sm pull-up" data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom" data-bs-placement="top" title="Nelson Wilson">
                                        <img src="/assets/img/avatars/14.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-end-indicator">
                            <i class="bx bx-check-circle"></i>
                        </li>
                    </ul>
                    <!-- /Activity Timeline -->
                </div>
            </div>
        </div>
        <!--/ Activity Timeline --> --}}
    </div>
@endsection



@section('script')
    <script>
        const dashboardData = @json($dashaboard_data);
        console.log(dashboardData);
        let cardColor, headingColor, axisColor, borderColor, shadeColor;

        if (isDarkStyle) {
            cardColor = config.colors_dark.cardColor;
            headingColor = config.colors_dark.headingColor;
            axisColor = config.colors_dark.axisColor;
            borderColor = config.colors_dark.borderColor;
            shadeColor = 'dark';
        } else {
            cardColor = config.colors.white;
            headingColor = config.colors.headingColor;
            axisColor = config.colors.axisColor;
            borderColor = config.colors.borderColor;
            shadeColor = 'light';
        }
        // Analytics - Bar Chart
        (function() {
            // Analytics - Bar Chart
            // --------------------------------------------------------------------
            const analyticsBarChartEl = document.querySelector('#analyticsBarChart'),
                analyticsBarChartConfig = {
                    chart: {
                        height: 225,
                        type: 'bar',
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '30%',
                            borderRadius: 3,
                            startingShape: 'rounded'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: [config.colors.primary, config.colors_label.primary],
                    series: [{
                        name: 'Total User',
                        data: dashboardData?.total_user_by_year_month.map((item) => item.total_user)
                    }],
                    grid: {
                        borderColor: borderColor,
                        padding: {
                            bottom: -8
                        }
                    },
                    xaxis: {
                        categories: dashboardData?.total_user_by_year_month.map((item) => item.month == 1 ? 'Jan' :
                            item
                            .month == 2 ? 'Feb' : item
                            .month == 3 ? 'Mar' : item.month == 4 ? 'Apr' : item.month == 5 ? 'May' : item.month ==
                            6 ? 'Jun' : item.month == 7 ? 'Jul' : item.month == 8 ? 'Aug' : item.month == 9 ?
                            'Sep' : item.month == 10 ? 'Oct' : item.month == 11 ? 'Nov' : 'Dec'),
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: axisColor
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 30,
                        tickAmount: 3,
                        labels: {
                            style: {
                                colors: axisColor
                            }
                        }
                    },
                    legend: {
                        show: false
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + ' Students';
                            }
                        }
                    }
                };
            if (typeof analyticsBarChartEl !== undefined && analyticsBarChartEl !== null) {
                const analyticsBarChart = new ApexCharts(analyticsBarChartEl, analyticsBarChartConfig);
                analyticsBarChart.render();
            }

            // Referral - Line Chart
            // --------------------------------------------------------------------
            const referralLineChartEl = document.querySelector('#referralLineChart'),
                referralLineChartConfig = {
                    series: [{
                        data: [0, 150, 25, 100, 15, 149, 50, 12, 130, 12]
                    }],
                    chart: {
                        height: 100,
                        parentHeightOffset: 0,
                        parentWidthOffset: 0,
                        type: 'line',
                        toolbar: {
                            show: false
                        }
                    },
                    markers: {
                        size: 6,
                        colors: 'transparent',
                        strokeColors: 'transparent',
                        strokeWidth: 4,
                        discrete: [{
                            fillColor: cardColor,
                            seriesIndex: 0,
                            dataPointIndex: 5,
                            strokeColor: config.colors.success,
                            strokeWidth: 4,
                            size: 6,
                            radius: 2
                        }],
                        hover: {
                            size: 7
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 4,
                        curve: 'smooth'
                    },
                    grid: {
                        show: false,
                        padding: {
                            top: -25,
                            bottom: -20
                        }
                    },
                    colors: [config.colors.success],
                    xaxis: {
                        show: false,
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false
                        }
                    },
                    legend: {
                        show: false
                    },

                };

            if (typeof referralLineChartEl !== undefined && referralLineChartEl !== null) {
                const referralLineChart = new ApexCharts(referralLineChartEl, referralLineChartConfig);
                referralLineChart.render();
            }

            // Conversion - Bar Chart
            // --------------------------------------------------------------------
            const conversionBarChartEl = document.querySelector('#conversionBarchart'),
                conversionBarChartConfig = {
                    chart: {
                        height: 95,
                        type: 'bar',
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '30%',
                            borderRadius: 3,
                            startingShape: 'rounded'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: [config.colors.primary, config.colors_label.primary],
                    series: [{
                        name: 'Total Sales',
                        data: dashboardData?.last_7_days_sales.map((item) => item.total_sales)
                    }],
                    grid: {
                        borderColor: borderColor,
                        padding: {
                            bottom: -8
                        }
                    },
                    xaxis: {
                        categories: dashboardData?.last_7_days_sales.map((item) => item.date),
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: axisColor
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 600,
                        tickAmount: 1,
                        yaxisBorder: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: 'transparent'
                            }
                        },
                    },
                    legend: {
                        show: false
                    },

                };

            if (typeof conversionBarChartEl !== undefined && conversionBarChartEl !== null) {
                const conversionBarChart = new ApexCharts(conversionBarChartEl, conversionBarChartConfig);
                conversionBarChart.render();
            }

            // Impression - Donut Chart
            // --------------------------------------------------------------------
            const impressionDonutChartEl = document.querySelector('#impressionDonutChart'),
                impressionDonutChartConfig = {
                    chart: {
                        height: 185,
                        fontFamily: 'IBM Plex Sans',
                        type: 'donut'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    grid: {
                        padding: {
                            bottom: -10
                        }
                    },
                    series: [dashboardData?.payment_in_cash, dashboardData?.payment_in_paypal, dashboardData
                        ?.payment_in_stripe
                    ],
                    labels: ['cash', 'paypal', 'stripe'],
                    stroke: {
                        width: 0,
                        lineCap: 'round'
                    },
                    colors: [config.colors.primary, config.colors.info, config.colors.warning],
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '90%',
                                labels: {
                                    show: true,
                                    name: {
                                        fontSize: '0.938rem',
                                        offsetY: 20
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '1.625rem',
                                        fontFamily: 'Rubik',
                                        fontWeight: '500',
                                        color: headingColor,
                                        offsetY: -20,
                                        formatter: function(val) {
                                            return val;
                                        }
                                    },
                                    total: {
                                        show: true,
                                        label: 'Impression',
                                        color: config.colors.secondary,
                                        formatter: function(w) {
                                            return w.globals.seriesTotals.reduce(function(a, b) {
                                                return a + b;
                                            }, 0);
                                        }
                                    }
                                }
                            }
                        }
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        horizontalAlign: 'center',
                        labels: {
                            colors: axisColor,
                            useSeriesColors: false
                        },
                        markers: {
                            width: 10,
                            height: 10,
                            offsetX: -3
                        }
                    }
                };

            if (typeof impressionDonutChartEl !== undefined && impressionDonutChartEl !== null) {
                const impressionDonutChart = new ApexCharts(impressionDonutChartEl, impressionDonutChartConfig);
                impressionDonutChart.render();
            }


            // Growth - Radial Bar Chart
            // --------------------------------------------------------------------
            const growthRadialChartEl = document.querySelector('#growthRadialChart'),
                growthRadialChartConfig = {
                    chart: {
                        height: 230,
                        fontFamily: 'IBM Plex Sans',
                        type: 'radialBar',
                        sparkline: {
                            show: true
                        }
                    },
                    grid: {
                        show: false,
                        padding: {
                            top: -25
                        }
                    },
                    plotOptions: {
                        radialBar: {
                            size: 100,
                            startAngle: -135,
                            endAngle: 135,
                            offsetY: 10,
                            hollow: {
                                size: '55%'
                            },
                            track: {
                                strokeWidth: '50%',
                                background: cardColor
                            },
                            dataLabels: {
                                value: {
                                    offsetY: -15,
                                    color: headingColor,
                                    fontFamily: 'Rubik',
                                    fontWeight: 500,
                                    fontSize: '26px'
                                },
                                name: {
                                    fontSize: '15px',
                                    color: config.colors.secondary,
                                    offsetY: 24
                                }
                            }
                        }
                    },
                    colors: [config.colors.danger],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'dark',
                            type: 'horizontal',
                            shadeIntensity: 0.5,
                            gradientToColors: [config.colors.primary],
                            inverseColors: true,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100]
                        }
                    },
                    stroke: {
                        dashArray: 3
                    },
                    series: [dashboardData?.current_year_growth_rate],
                    labels: ['Growth']
                };

            if (typeof growthRadialChartEl !== undefined && growthRadialChartEl !== null) {
                const growthRadialChart = new ApexCharts(growthRadialChartEl, growthRadialChartConfig);
                growthRadialChart.render();
            }


        })()
    </script>
@endsection
