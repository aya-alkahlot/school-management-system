<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <li>
            <a href="{{ route('dashboard.parents') }}">
                <div class="pull-left"><i class="ti-home"></i><span
                        class="right-nav-text">{{trans('main_trans.Dashboard')}}</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        <!-- menu title -->
        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">{{trans('main_trans.Programname')}} </li>


        <!-- الابناء-->
        <li>
            <a href="{{ route('sons.index') }}"><i class="fa fa-user"></i><span
                    class="right-nav-text">{{ trans('Parent_trans.Children') }}</span></a>
        </li>

        <!-- تقرير الحضور والغياب-->
        <li>
            <a href="{{route('sons.attendances')}}"><i class="fa fa-book"></i><span
                    class="right-nav-text">{{trans('Students_trans.Attendance_and_absence_report') }}</span></a>
        </li>

        <!-- تقرير المالية-->
        <li>
            <a href="{{route('sons.fees')}}"><i class="fa fa-file-text icon"></i><span
                    class="right-nav-text">{{ trans('Parent_trans.Financial_report') }}</span></a>
        </li>


        <!-- Settings-->
        <li>
            <a href="{{route('profile.show.parent')}}"><i class="fa fa-cogs"></i><span
                    class="right-nav-text">{{ trans('main_trans.Profile') }}</span></a>
        </li>

    </ul>
</div>