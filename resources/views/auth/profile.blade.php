@extends('layouts.master')

@section('content')

<section class="content-header">
  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Profile Infomation</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="col-md-6">
    

      <!-- Widget: user widget style 1 -->
      <div class="box box-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-aqua-active">
          <h3 class="widget-user-username">{!! $profile['fullname'] !!}</h3>
          <h5 class="widget-user-desc">{!! $profile['username'] !!}</h5>
        </div>
        <div class="widget-user-image">
          <img alt="User Avatar" src="{!! asset('public/uploads/'.$profile['avatar']) !!}" class="img-circle">
          <a href="javascript:void(0)" id="btn-ava-edit">
            <span class="ie-ava-edit"><i class="fa fa-edit"></i> Change avatar</span>
          </a>
        </div>
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-6 border-right p-fullname">
              <div class="description-block">
                <h5 class="description-header text-left">Fullname</h5>
                <div>
                  <span class="description-text pull-left">{!! $profile['fullname'] !!}</span>
                  <a class="pull-right" href="javascript:void(0)" id="btn-fullname-edit">
                    <span class=""><i class="fa fa-edit"></i> Edit</span>
                  </a>
                  <div class="clearfix"></div>
                </div>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <div class="description-block p-email">
                <h5 class="description-header text-left">Email</h5>
                <div>
                  <span class="description-text pull-left">{!! $profile['email'] !!}</span>
                  <a class="pull-right" href="javascript:void(0)" id="btn-email-edit">
                    <span class=""><i class="fa fa-edit"></i> Edit</span>
                  </a>
                  <div class="clearfix"></div>
                </div>
              </div>
              <!-- /.description-block -->
            </div>
            
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.widget-user -->


      <!-- model edit avatar-->
      <div class="modal fade" id="modal-edit-avatar" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Change avatar</h4>
            </div>
            <div class="modal-body">
            
             <div class="ava-alert hidden alert">
               
             </div>
            <form method="post" action="{!! url('/changeAvatar') !!}" name="frm-avatar">
                {!! csrf_field() !!}
                <input type="hidden" name="userid" value="{!! Auth::user()->id !!}" />
                <div class="form-group">
                  <label for="img-avatar">Please choose avatar</label>
                  <input type="file" name="avatar" id="img-avatar" />
                  
              </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-info" id="btn-save-avatar">Save changes</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


      <!-- model edit fullname-->
      <div class="modal fade" id="modal-edit-fullname" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Change fullname</h4>
            </div>
            <div class="modal-body">
            
             <div class="fn-alert hidden alert">
               
             </div>
            <form method="post" action="{!! url('/changeFullname') !!}" name="frm-fullname">
                {!! csrf_field() !!}
                <input type="hidden" name="userid" value="{!! Auth::user()->id !!}" />
                <div class="form-group">
                  <input class="form-control" type="text" name="fullname" id="fullname" value="{!! $profile['fullname'] !!}" />
                  
              </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-info" id="btn-save-fullname">Save changes</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


      <!-- model edit email-->
      <div class="modal fade" id="modal-edit-email" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Change email</h4>
            </div>
            <div class="modal-body">
            
             <div class="email-alert hidden alert">
               
             </div>
            <form method="post" action="{!! url('/changeEmail') !!}" name="frm-email">
                {!! csrf_field() !!}
                <input type="hidden" name="userid" value="{!! Auth::user()->id !!}" />
                <div class="form-group">
                  <input class="form-control" type="email" name="email" id="email" value="{!! $profile['email'] !!}" />
                  
              </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-info" id="btn-save-email">Save changes</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

  </div>
</section>


@endsection
