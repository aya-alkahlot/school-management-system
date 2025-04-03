<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <li>
            <a href="{{ url('/dashboard') }}">
                <div class="pull-left"><i class="ti-home"></i><span
                        class="right-nav-text">{{trans('main_trans.Dashboard')}}</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        <!-- menu title -->
        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">{{trans('main_trans.Programname')}} </li>
        <!-- المواد الدراسية -->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#subjects-icon">
                <div class="pull-left"><i class="fa fa-bookmark"></i><span
                        class="right-nav-text">{{ trans('main_trans.Study_materials') }}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="subjects-icon" class="collapse" data-parent="#sidebarnav">
                <li>
                    <a href="{{ route('student.subjects.index') }}">{{ trans('Students_trans.Subject_List') }}</a>
                </li>
            </ul>
        </li>

        <!-- الحصص الأونلاين -->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#online-classes-icon">
                <div class="pull-left"><i class="fa fa-laptop"></i><span
                        class="right-nav-text">{{ trans('Students_trans.Online_class') }}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="online-classes-icon" class="collapse" data-parent="#sidebarnav">
                <li>
                    <a
                        href="{{ route('student.online_classes.index') }}">{{ trans('Students_trans.Online_classe_list') }}</a>
                </li>
            </ul>
        </li>


        <!-- المكتبة -->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#library-menu">
                <div class="pull-left">
                    <i class="fa fa-book"></i>
                    <span class="right-nav-text">{{ trans('main_trans.library') }}</span>
                </div>
                <div class="pull-right">
                    <i class="ti-plus"></i>
                </div>
                <div class="clearfix"></div>
            </a>
            <ul id="library-menu" class="collapse" data-parent="#sidebarnav">
                <!-- قائمة الكتب المدرسية -->
                <li>
                    <a href="{{ route('student.library.index') }}">
                        <i class="fa fa-book"></i>
                        <span class="right-nav-text">{{ trans('Students_trans.List_of_school_books') }}</span>
                    </a>
                </li>


            </ul>
            <!-- الامتحانات-->
        <li>
            <a href="{{route('student_exams.index')}}"><i class="fa fa-check-square"></i><span
                    class="right-nav-text">{{ trans('Students_trans.Tests') }}</span></a>
        </li>


        <!-- Settings-->
        <li>
            <a href="{{ route('profile.index') }}"><i class="fa fa-id-card"></i><span class="right-nav-text">{{ trans('main_trans.Profile') }}
                </span></a>
        </li>

</div>