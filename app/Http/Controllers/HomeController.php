<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\History;
use App\Models\Invoice;
use App\Models\Privacy;
use App\Models\Teacher;
use App\Models\Terms;
use App\Models\User;
use App\Models\UserCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function dashboard()
    {

        $dashaboard_data =  new \stdClass();
        $dashaboard_data->total_student = User::where('role', 'user')->count();
        $dashaboard_data->total_course = Course::count();
        $dashaboard_data->total_teacher = Teacher::count();


        $total_user_by_year_month = User::selectRaw('count(*) as total_user, YEAR(created_at) year, MONTH(created_at) month')
            ->where('role', 'user')
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('year', 'month')
            ->get();

        $dashaboard_data->total_user_by_year_month = $total_user_by_year_month;


        $previous_year = Carbon::now()->subYear()->format('Y');
        $current_year = Carbon::now()->format('Y');

        $total_previous_year_user = User::where('role', 'user')
            ->whereYear('created_at', $previous_year)
            ->count();

        $total_current_year_user = User::where('role', 'user')
            ->whereYear('created_at', $current_year)
            ->count();

        $current_year_growth_rate = 0;
        if ($total_previous_year_user > 0) {
            $current_year_growth_rate = (($total_current_year_user - $total_previous_year_user) / $total_previous_year_user) * 100;
        }
        $previous_year_growth_rate = 0;
        if ($total_current_year_user > 0) {
            $previous_year_growth_rate = (($total_current_year_user - $total_previous_year_user) / $total_current_year_user) * 100;
        }

        $dashaboard_data->current_year_growth_rate = $current_year_growth_rate;
        $dashaboard_data->previous_year_growth_rate = $previous_year_growth_rate;


        $total_sales = Invoice::sum('total');

        $dashaboard_data->total_sales = $total_sales;

        $last_7_days_sales = Invoice::selectRaw('sum(total) as total_sales, DATE(created_at) date')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->get();

        $dashaboard_data->last_7_days_sales = $last_7_days_sales;

        $last_7_days_total_sales = Invoice::where('created_at', '>=', Carbon::now()->subDays(7))->sum('total');
        $dashaboard_data->last_7_days_total_sales = $last_7_days_total_sales;


        $dashaboard_data->payment_in_cash = Invoice::where('payment_method', 'cash')->sum('total');
        $dashaboard_data->payment_in_paypal = Invoice::where('payment_method', 'paypal')->sum('total');
        $dashaboard_data->payment_in_stripe = Invoice::where('payment_method', 'stripe')->sum('total');

        $dashaboard_data->last_month_total_sales = Invoice::where('created_at', '>=', Carbon::now()->subMonth())->sum('total');
        $dashaboard_data->last_year_total_sales = Invoice::where('created_at', '>=', Carbon::now()->subYear())->sum('total');


        $last_5_tracking_histories = History::orderBy('id', 'desc')->take(5)->get();
        // add user name
        foreach ($last_5_tracking_histories as $history) {
            $history->user_name = User::where('id',  $history->user)->first()->name;
            $history->hours = floor($history->duration / 3600000);
            $history->minutes = floor(($history->duration / 60000) % 60);
            $history->seconds = floor(($history->duration / 1000) % 60);
            $history->teacher_name = Teacher::where('id',  $history->teacher)->first()->name;
        }

        $dashaboard_data->last_5_tracking_histories = $last_5_tracking_histories;


        $today_sales = Invoice::whereDate('created_at', Carbon::today())->sum('total');
        $dashaboard_data->today_sales = $today_sales;

        $today_students = User::whereDate('created_at', Carbon::today())->where('role', 'user')->count();
        $dashaboard_data->today_students = $today_students;


        $today_student = User::whereDate('created_at', Carbon::today())->where('role', 'user')->count();
        $dashaboard_data->today_student = $today_student;

        $seven_days_student = User::where('created_at', '>=', Carbon::now()->subDays(7))->where('role', 'user')->count();
        $dashaboard_data->seven_days_student = $seven_days_student;

        $thirty_days_student = User::where('created_at', '>=', Carbon::now()->subDays(30))->where('role', 'user')->count();
        $dashaboard_data->thirty_days_student = $thirty_days_student;

        $one_year_student = User::where('created_at', '>=', Carbon::now()->subYear())->where('role', 'user')->count();
        $dashaboard_data->one_year_student = $one_year_student;

        $today_sale = Invoice::whereDate('created_at', Carbon::today())->sum('total');
        $dashaboard_data->today_sale = $today_sale;
        $seven_days_Sale = Invoice::where('created_at', '>=', Carbon::now()->subDays(7))->sum('total');
        $dashaboard_data->seven_days_Sale = $seven_days_Sale;
        $thirty_days_Sale = Invoice::where('created_at', '>=', Carbon::now()->subDays(30))->sum('total');
        $dashaboard_data->thirty_days_Sale = $thirty_days_Sale;
        $one_year_Sale = Invoice::where('created_at', '>=', Carbon::now()->subYear())->sum('total');
        $dashaboard_data->one_year_Sale = $one_year_Sale;

        $today_course = UserCourse::whereDate('created_at', Carbon::today())->count();
        $dashaboard_data->today_course = $today_course;
        $seven_days_course = UserCourse::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $dashaboard_data->seven_days_course = $seven_days_course;
        $thirty_days_course = UserCourse::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $dashaboard_data->thirty_days_course = $thirty_days_course;
        $one_year_course = UserCourse::where('created_at', '>=', Carbon::now()->subYear())->count();
        $dashaboard_data->one_year_course = $one_year_course;





        return view('theme.dashboard.index', compact('dashaboard_data'));
    }



    public function home()
    {
        return redirect()->route('admin.dashboard');
    }

    public function privacy()
    {
        $privacy = Privacy::first();
        return view('privacy', compact('privacy'));
    }
    public function terms()
    {

        $terms = Terms::first();
        return view('terms', compact('terms'));
    }
}
