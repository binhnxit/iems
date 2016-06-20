<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    @if(Auth::check())
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{!! asset('public/uploads/'.Auth::user()->avatar) !!}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{!! Auth::user()->fullname !!}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    @endif

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="active treeview">
        <a href="{!! url('/inex') !!}">
          <i class="fa fa-dashboard"></i> <span>IE Managements</span> 
        </a>
      </li>

      <li class="header">LABELS</li>
      <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>