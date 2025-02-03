<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="submenu">
                    <a href="{{ route('home') }}"><i class="la la-dashboard"></i><span>{{ __('messages.Dashboard') }}</span></a>
                </li>

                <li class="submenu">
                    @if (Auth::user()->role_name=='Admin')
                        <span style="margin-left: 15px;">{{ __('messages.Name') }}: <span class="fw-bolder">{{ Auth::user()->name }}</span></span>
                        <hr>
                        <span style="margin-left: 15px;">{{ __('messages.Role_Name') }}:</span>
                        <span class="badge bg-success">{{ __('messages.Admin') }}</span>
                    @endif
                    @if (Auth::user()->role_name=='Employee')
                        <span style="margin-left: 15px;">{{ __('messages.Name') }}: <span class="fw-bolder">{{ Auth::user()->name }}</span></span>
                        <hr>
                        <span style="margin-left: 15px;">{{ __('messages.Role_Name') }}:</span>
                        <span class="badge bg-info">{{ __('messages.Employee') }}</span>
                    @endif
                    @if (Auth::user()->role_name=='Normal User')
                    <span style="margin-left: 15px;">{{ __('messages.Name') }}: <span class="fw-bolder">{{ Auth::user()->name }}</span></span>
                        <hr>
                        <span style="margin-left: 15px;">{{ __('messages.Role_Name') }}:</span>
                        <span class="badge bg-warning">{{ __('messages.Normal_User') }}</span>
                    @endif
                </li>

                @if (Auth::user()->role_name=='Admin')
                    <li class="sidebar-item  has-sub">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-hexagon-fill"></i>
                            <span>{{ __('messages.Maintenance') }}</span><span class="menu-arrow"></span>
                        </a>
                        <ul class="submenu">
                            <li class="submenu-item">
                                <a href="{{ route('userManagement') }}">{{ __('messages.User_Control') }}</a>
                                <a class="{{ set_active(['form/input/page']) }}" href="{{ route('form/input/page') }}">{{ __('messages.Employee_Form') }}</a>
                                <a href="{{ route('feedback/index') }}">{{ __('messages.User_Feedback') }}</a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li>
                    <a href="{{ route('editProfile') }}"><i class="la la-user"></i> <span>{{ __('messages.Personal_Information') }}</span></a>
                </li>

                <li class="submenu">
                    <a href="#"><i class="la la-file-alt"></i> <span>{{ __('messages.Forms') }}</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <a href="#"><i class="la la-file-image"></i> <span class=" {{ set_active(['form/update/page']) }}" href="{{ route('form/update/page') }}">{{ __('messages.Form_Upload_File') }}</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ set_active(['form/update/page']) }}" href="{{ route('form/update/page') }}">{{ __('messages.File_Upload') }}</a></li>
                            <li><a class="{{ set_active(['form/webcam/capture']) }}" href="{{ route('form/webcam/capture') }}">{{ __('messages.Capture_Image') }}</a></li>
                        </ul>
                        @if (Auth::user()->role_name=='Admin'||Auth::user()->role_name=='Employee')
                        <a href="#"><i class="la la-edit"></i> <span class=" {{ set_active(['form/builder']) }}" href="{{ route('form/builder') }}">{{ __('messages.Form_Builder') }}</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ set_active(['form/builder']) }}" href="{{ route('form/builder') }}">{{ __('messages.Add_Template') }}</a></li>
                            <li><a class="{{ set_active(['form/view/template']) }}" href="{{ route('form/view/template') }}">{{ __('messages.Template_List') }}</a></li>
                        </ul>
                        @endif
                    </ul>
                </li>
                @if (Auth::user()->role_name=='Admin'||Auth::user()->role_name=='Employee')
                <li class="submenu">
                    <a href="#"><i class="la la-font"></i> <span>{{ __('messages.OCR') }}</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ set_active(['view/upload/file']) }} {{ request()->is('download/file/*') ? 'active' : '' }}" href="{{ route('view/upload/file') }}">{{ __('messages.Recognize') }}</a></li>
                    </ul>
                </li>
                @endif

                <li class="submenu">
                    <a href="#"><i class="la la-pie-chart"></i> <span>{{ __('messages.Page_View') }}</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                    @if (Auth::user()->role_name=='Admin'||Auth::user()->role_name=='Employee')
                        <li><a class="{{ set_active(['form/page/view']) }} {{ request()->is('form/input/edit/*') ? 'active' : '' }}" href="{{ route('form/page/view') }}">{{ __('messages.Report_Employee_Form_Input') }}</a></li>
                        <li><a class="{{ set_active(['form/list']) }}" href="{{ route('form/list') }}">{{ __('messages.Report_Form_Response') }}</a></li>
                        @endif
                        <li><a class="{{ set_active(['view/upload/file']) }} {{ request()->is('download/file/*') ? 'active' : '' }}" href="{{ route('view/upload/file') }}">{{ __('messages.Report_Form_Upload_File') }}</a></li>
                    </ul>
                </li>

                @if (Auth::user()->role_name=='Employee'||Auth::user()->role_name=='Normal User')
                <li>
                    <a href="{{ route('feedback/create') }}"><i class="la la-inbox"></i> <span>{{ __('messages.Feedback') }}</span></a>
                </li>
                @endif

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->