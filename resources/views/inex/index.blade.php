@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Control panel</small>
</h1>
<ol class="breadcrumb">
    <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">InEx Managements</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="col-md-6 no-padding">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">InEX Managements</h3>
          <div class="box-tools pull-right">
            <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-plus"></i></button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body inex-data">
            <div class="col-md-12 box-menu">
                <div class="h-line">
                    <div class="col-sm-2 form-group">
                        <a href="javascript:void(0)" id="btn-add-iedata" class="btn btn-info"><i class="fa fa-plus"></i> Add</a>
                    </div>
                    <div class="col-sm-5 form-group">
                        <select class="form-control" name="s-cat-id">
                            <option value="0">All Category</option>
                            @foreach($ie_cat as $key => $cat_item)
                            @if(Request::get('cat') == $cat_item['id'])
                            <option selected="selected" value="{!! $cat_item['id'] !!}" class="bg-{!! $cat_item['color'] !!}">{!! $cat_item['cat_name'] !!}</option>
                            @else
                            <option value="{!! $cat_item['id'] !!}" class="bg-{!! $cat_item['color'] !!}">{!! $cat_item['cat_name'] !!}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                     <div class="col-sm-5 form-group">
                        <input class="form-control inline" type="text" name="s-text" value="{!! Request::get('text') !!}" placeholder="Search..." />
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="h-line">
                    <div class="col-sm-10 form-group col-md-8 col-md-offset-2">
                        <button class="btn btn-primary btn-sm daterange" data-toggle="tooltip" title="Date range"><i class="fa fa-calendar"></i></button>
                        From 
                            <span id="dstart" class="label label-info">
                                @if(Request::get('dstart')) {!! Request::get('dstart') !!} 
                                @else 
                                    YYYY-MM-DD
                                @endif
                            </span> 
                        to 
                            <span id="dend" class="label label-info">
                                @if(Request::get('dend')) {!! Request::get('dend') !!}
                                @else 
                                    YYYY-MM-DD
                                @endif
                            </span>
                        <input type="hidden" name="dstart" value="{!! Request::get('dstart') !!}">
                        <input type="hidden" name="dend" value="{!! Request::get('dend') !!}">
                        
                    </div>
                   
                    <div class="col-sm-2 form-group col-md-2">
                        <input type="hidden" name="s-url" value="{!! url('/inex') !!}">
                        <a href="javascript:void(0)" id="btn-filter" class="btn btn-default"><i class="fa fa-search"></i> Filter</a>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>
            <div class="clearfix"></div>
            <?php 
              // echo "<pre>";
              // print_r($ie_data);die();
            ?>
            <ul class="list-ie list-group">
                @foreach($ie_data as $key => $ie_item)
                <?php 
                  $lebel = "";
                ?>
                @if($ie_item['ie_type']==1)
                  <?php 
                    $lebel = "success";
                  ?>
                @else
                  <?php 
                  $lebel = "danger";
                ?>
                @endif
                <li class="list-group-item list-group-item-{!! $lebel !!}">
                    <div class="line">
                        <h4 class="ie-cat pull-left"><input type="checkbox" class="flat-red"> <span class="label label-{!! $ie_item['ie_cat']['color'] !!}">{!! $ie_item['ie_cat']['cat_name'] !!}</span></h4>
                        <p class="ie-amount pull-right">{!! number_format($ie_item['amount'], 0, '.', '.') !!}.000đ</p>
                        <div class="clearfix"></div>
                    </div>
                    <div class="line">
                        <p class="ie-date pull-left">
                        @if(strtotime($ie_item['created_at']) > strtotime('-1 week'))
                        {!! \Carbon\Carbon::createFromTimeStamp(strtotime($ie_item['created_at']))->diffForHumans() !!}
                        @else
                          {!! date('d-M-Y', strtotime($ie_item['created_at'])) !!}
                        @endif

                        </p>
                        <p class="ie-note pull-right">{!! $ie_item['note'] !!}</p>
                        <div class="clearfix"></div>
                    </div>
                    <div class="ie-edit animated zoomIn">
                        <a ieid="{!! $ie_item['id'] !!}" href="javascript:void(0)" class="btn btn-info btn-xs btn-edit-iedata"><i class="fa fa-edit"></i></a> -- 
                        <a href="{!! url('/inex/delIeData', $ie_item['id']) !!}" onClick="return confirm('Are you sure???')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </li>
                @endforeach
               
                
            </ul>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div> <!-- end col-md-6 -->
    <div class="col-md-1 no-padding"></div>
    <!-- cat ie -->
    <div class="col-md-5 no-padding">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">IE Category</h3>
          <div class="box-tools pull-right">
            <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-plus"></i></button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body inex-cat">
            <p>
                <a href="javascript:void(0)" id="btn-add-cat" class="btn btn-success"><i class="fa fa-plus"></i> Add</a>
            </p>
           
            <ul class="list-cat list-group">

                @foreach($ie_cat as $key => $cat_item)
                <li class="list-group-item list-group-item-{!! $cat_item['color'] !!}">
                    <div class="line">
                        <h4 class="ie-cat pull-left">{!! $cat_item['cat_name'] !!}</h4>
                        <div class="pull-right ie-edit animated zoomIn">
                            <a href="javascript:void(0)" catid="{!! $cat_item['id'] !!}" class="btn btn-info btn-xs btn-edit-cat"><i class="fa fa-edit"></i></a>
                            <a href="{!! url('/inex/delCat', $cat_item['id']) !!}" onclick="return confirm('Are you sure???')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <p class="ie-num-item">{!! count($cat_item['ie_data']) !!} item</p>
                    <div class="clearfix"></div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    </div>
</section><!-- /.content -->


<!-- modal   -->
<section>
    <!-- model add cat-->
      <div class="modal fade" id="modal-add-cat" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Add new Category IE</h4>
            </div>
            <div class="modal-body">
            
             <div class="add-cat-alert hidden alert">
               
             </div>
                <form class="form-horizontal" method="post" action="{!! url('/inex/addCat') !!}" name="frm-add-cat">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="cat_name" class="col-sm-3 control-label">Category Name</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="cat_name" id="cat_name" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cat_color" class="col-sm-3 control-label">Category Color</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="cat_color" id="cat_color">
                              <option value="" class="">--Choose--</option>
                              <option value="primary" class="bg-primary">Primary</option>
                              <option value="success" class="bg-success">Success</option>
                              <option value="danger" class="bg-danger">Danger</option>
                              <option value="info" class="bg-info">Info</option>
                              <option value="warning" class="bg-warning">Warning</option>
                            </select>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-info" id="btn-modal-add-cat">Add</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      <!-- end modal add cat -->


      <!-- model edit cat-->
      <div class="modal fade" id="modal-edit-cat" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Edit Category IE</h4>
            </div>
            <div class="modal-body">
            
             <div class="edit-cat-alert hidden alert">
               
             </div>
                <form class="form-horizontal" method="post" action="{!! url('/inex/editCat') !!}" name="frm-edit-cat">
                    {!! csrf_field() !!}
                    <input type="hidden" name="catid" value="" />
                    <div class="form-group">
                        <label for="cat_name" class="col-sm-3 control-label">Category Name</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="cat_name" id="cat_name" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cat_color" class="col-sm-3 control-label">Category Color</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="cat_color" id="cat_color">
                              <option value="" class="">--Choose--</option>
                              <option value="primary" class="bg-primary">Primary</option>
                              <option value="success" class="bg-success">Success</option>
                              <option value="danger" class="bg-danger">Danger</option>
                              <option value="info" class="bg-info">Info</option>
                              <option value="warning" class="bg-warning">Warning</option>
                            </select>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-info" id="btn-modal-edit-cat">Save</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      <!-- end modal edit cat -->



      <!-- model add IE Data-->
      <div class="modal fade" id="modal-add-iedata" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Add new IE</h4>
            </div>
            <div class="modal-body">
            
             <div class="add-iedata-alert hidden alert">
               
             </div>
                <form class="form-horizontal" method="post" action="{!! url('/inex/addIeData') !!}" name="frm-add-iedata">
                    {!! csrf_field() !!}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="ie-2" class="col-xs-5 text-right">Expenses</label>
                            <div class="col-xs-2 text-center">
                                <input class="flat-red" type="radio" name="ie_type" id="ie-2" value="2" checked />
                                <input class="flat-red" type="radio" name="ie_type" id="ie-1" value="1" />
                                
                            </div>
                            <label for="ie-1" class="col-xs-5 text-left">Income</label>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                              <input type="text" class="form-control" placeholder="Amount..." aria-describedby="basic-addon2" id="amount" name="amount">
                              <span class="input-group-addon" id="basic-addon2">.000</span>
                            </div>
                        </div>
                        <div class="form-group">
                              <input type="text" name="note" class="form-control" placeholder="Note..." id="note">
                        </div>
                        <div class="form-group">
                            <h4>IE Category</h4>
                            @foreach($ie_cat as $key => $cat_item)
                            <div class="col-xs-6 col-sm-3">
                                <input class="flat-red" type="radio" id="cat-{!! $cat_item['id'] !!}" name="cat_id" value="{!! $cat_item['id'] !!}" />
                                <label for="cat-{!! $cat_item['id'] !!}">{!! $cat_item['cat_name'] !!}</label>
                            </div>
                            @endforeach
                        </div>
                        
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-info" id="btn-modal-add-iedata">Add</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      <!-- end modal add IE Data -->



      <!-- model edit IE Data-->
      <div class="modal fade" id="modal-edit-iedata" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Edit IE</h4>
            </div>
            <div class="modal-body">
            
             <div class="edit-iedata-alert hidden alert">
               
             </div>
                <form class="form-horizontal" method="post" action="{!! url('/inex/editIeData') !!}" name="frm-edit-iedata">
                    {!! csrf_field() !!}
                    <input type="hidden" name="ieid" value="" />
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="eie-2" class="col-xs-5 text-right">Expenses</label>
                            <div class="col-xs-2 text-center">
                                <input class="" type="radio" name="ie_type" id="eie-2" value="2" />
                                <input class="" type="radio" name="ie_type" id="eie-1" value="1"  />
                                
                            </div>
                            <label for="eie-1" class="col-xs-5 text-left">Income</label>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                              <input type="text" class="form-control" placeholder="Amount..." aria-describedby="basic-addon2" id="amount" name="amount">
                              <span class="input-group-addon" id="basic-addon2">.000</span>
                            </div>
                        </div>
                        <div class="form-group">
                              <input type="text" name="note" class="form-control" placeholder="Note..." id="note">
                        </div>
                        <div class="form-group">
                            <h4>IE Category</h4>
                            @foreach($ie_cat as $key => $cat_item)
                            <div class="col-xs-6 col-sm-3">
                                <input class="" type="radio" name="cat_id" id="ecat-{!! $cat_item['id'] !!}" value="{!! $cat_item['id'] !!}" />
                                <label for="ecat-{!! $cat_item['id'] !!}">{!! $cat_item['cat_name'] !!}</label>
                            </div>
                            @endforeach
                        </div>
                        
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-info" id="btn-modal-edit-iedata">Save</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      <!-- end modal edit IE Data -->

</section>
<!-- end modal -->
@endsection
