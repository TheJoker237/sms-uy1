<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class="{{set_active(['setting/page'])}}">
                    <a href="{{ route('setting/page') }}">
                        <i class="fas fa-cog"></i> 
                        <span>Settings</span>
                    </a>
                </li>
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                <li class="submenu {{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-shield-alt"></i>
                        <span>User Management</span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('list/users') }}" class="{{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">List Users</a></li>
                    </ul>
                </li>
                @endif

                <li class="submenu {{set_active(['student/list','student/grid','student/add/page'])}} {{ (request()->is('student/edit/*')) ? 'active' : '' }} {{ (request()->is('student/profile/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-graduation-cap"></i>
                        <span> Students</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('student/list') }}"  class="{{set_active(['student/list','student/grid'])}}">Student List</a></li>
                        <li><a href="{{ route('student/add/page') }}" class="{{set_active(['student/add/page'])}}">Student Add</a></li>
                    </ul>
                </li>

                <li class="submenu  {{set_active(['teacher/add','teacher/list','teacher/grid','teacher/edit'])}} {{ (request()->is('teacher/edit/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-chalkboard-teacher"></i>
                        <span> Teachers</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('teacher/list') }}" class="{{set_active(['teacher/list','teacher/grid'])}}">Teacher List</a></li>
                        <li><a href="{{ route('teacher/add') }}" class="{{set_active(['teacher/add'])}}">Teacher Add</a></li>
                    </ul>
                </li>
                <li class="submenu  {{set_active(['filiere/add','filiere/list','filiere/edit'])}}">
                    <a href="#"><i class="fas fa-book-reader"></i>
                        <span> Filieres</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('filiere/list') }}" class="{{set_active(['filiere/list'])}}">Filiere List</a></li>
                    </ul>
                </li>

                <li class="submenu  {{set_active(['course/list'])}} {{ (request()->is('course/edit/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-book"></i>
                        <span> Courses</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('course/list') }}" class="{{set_active(['course/list'])}}">Course List</a></li>
                    </ul>
                </li>

                <li class="submenu  {{set_active(['examen/add','examen/list','examen/edit'])}} {{ (request()->is('examen/edit/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-book-reader"></i>
                        <span> Examens</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('examen/list') }}" class="{{set_active(['examen/list'])}}">Examen List</a></li>
                        <li><a href="{{ route('examen/add') }}" class="{{set_active(['examen/add'])}}">Examen Add</a></li>
                    </ul>
                </li>
                
                <li class="submenu {{set_active(['note/add','note/list','note/edit'])}} ">
                    <a href="#"><i class="fas fa-building"></i>
                        <span> Notes</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('note/list') }}" class="{{set_active(['note/list'])}}">Note List</a></li>
                        <li><a href="{{ route('note/add') }}" class="{{set_active(['note/add'])}}">Note Add</a></li>
                    </ul>
                </li>
                <li class="submenu {{set_active(['requete/add','requete/list','requete/edit'])}}">
                    <a href="#"><i class="fas fa-book-reader"></i>
                        <span> Requêtes</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('requete/list') }}"  class="{{set_active(['requete/list'])}}">Requêtes List</a></li>
                        <li><a href="{{ route('requete/add') }}" class="{{set_active(['requete/add'])}}">Requêtes Add</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>