<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <li>
            <a href="{{ url('/teacher/dashboard') }}">
                <div class="pull-left"><i class="ti-home"></i><span
                        class="right-nav-text">{{trans('main_trans.Dashboard')}}</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        <!-- menu title -->
        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">{{trans('main_trans.Programname')}} </li>

        <!-- الاقسام-->
        <li>
            <a href="{{route('Sections.index')}}"><i class="fa fa-sitemap"></i></i><span
                    class="right-nav-text">{{trans('main_trans.sections')}}</span></a>
        </li>


        <!-- الطلاب-->
        <li>
            <a href="{{route('Students.index')}}"><i class="fa fa-graduation-cap"></i></i></i><span
                    class="right-nav-text">{{trans('main_trans.students')}}</span></a>
        </li>

        <!-- الاختبارات-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Exams-icon">
                <div class="pull-left"><i class="fa fa-check-square"></i><span class="right-nav-text">{{trans('Students_trans.Tests')}}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Exams-icon" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('Quizzes.index')}}">{{trans('Students_trans.List_of_tests')}}</a> </li>
                <li> <a href="{{route('questions.index')}}">{{trans('Students_trans.List_of_questions')}}</a> </li>
            </ul>
        </li>

        <!-- Online classes-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Onlineclasses-icon">
                <div class="pull-left"><i class="fa fa-laptop"></i><span class="right-nav-text">{{trans('main_trans.Onlineclasses')}}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Onlineclasses-icon" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('online_classes.index')}}">{{trans('Students_trans.Online_classes')}}</a> </li>
            </ul>
        </li>



        <!-- sections-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Attendance-icon">
                <div class="pull-left"><i class="fa fa-id-card"></i><span class="right-nav-text">{{trans('main_trans.Attendance')}}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Attendance-icon" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('Attendance.index')}}">{{trans('main_trans.list_students')}} </a> </li>

            </ul>
        </li>


        <!-- الملف الشخصي-->
        <li>
            <a href=""><i class="fa fa-cogs"></i><span class="right-nav-text">{{trans('main_trans.Profile')}} </span></a>
        </li>

    </ul>
</div>