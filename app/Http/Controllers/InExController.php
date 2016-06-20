<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use Validator;
use App\Http\Requests;
use App\IeData;
use App\IeCat;
use Auth;
class InExController extends Controller
{
    /**
     * Home Page
     */
    public function index(){

    	$userid = Auth::user()->id;
        $ie_data = new IeData;
        if(count(Request::all())>0){
            if(null != Request::get('dstart') && null != Request::get('dend')){

                $ie_data = $ie_data->whereBetween('created_at', array(Request::get('dstart'), Request::get('dend')));
            }
            if(null != Request::get('cat')){
                $ie_data = $ie_data->where('cat_id', Request::get('cat'));
            }
            if(null != Request::get('text')){
                $ie_data = $ie_data->where('note', 'LIKE', '%'.Request::get('text').'%');
            }
        }
        $ie_data = $ie_data->where('ie_by', $userid)->with('IeCat')->orderBy('id', 'DESC')->get()->toArray();
    	$ie_cat = IeCat::where('cat_by', $userid)->with('IeData')->orderBy('id', 'DESC')->get()->toArray();
    	return view('inex.index', ['ie_data' => $ie_data, 'ie_cat'=>$ie_cat]);
    }
    /**
     * function: add new Category
     */
    
    public function addCat(){
    	$data = array('status' => '', 'msg' => 'Errors!!!');
        if(Request::ajax()){
            $cat_name = Request::get('cat_name');
            $cat_color = Request::get('cat_color');
            //validte
            $validate = Validator::make(Request::all(), [
                    'cat_name' => 'required|unique:ie_cat,cat_name',
                    'cat_color' => 'required'
                ], [
                    'cat_name.required' => 'Please enter Category Name!!!',
                    'cat_name.unique' => 'This Category Name really exists, please enter other Category Name!!!',
                    'cat_color.required' => 'Please choose Category Color!!!'

                ]);
            if($validate->fails()){
                $data['status'] = 'error';
                foreach ($validate->errors()->all() as $value) {
                	$data['msg'] .= "<br />".$value;
                }
                 
                return response()->json($data);
            }
            $cat = new IeCat;
            $cat->cat_name = $cat_name;
            $cat->color = $cat_color;
            $cat->level = 1;
            $cat->cat_by = Auth::user()->id;
            $cat->save();
            $data['status'] = 'success';
            $data['msg'] = "Add Category successfully!!!";
        }
        return response()->json($data);
    }
    /**
     * function: add new Income & Expenses Data
     */
    public function addIeData(){
    	$data = array('status' => '', 'msg' => 'Errors!!!');
        if(Request::ajax()){
            $ie_type = Request::get('ie_type');
            $amount = Request::get('amount');
            $note = Request::get('note');
            $cat_id = Request::get('cat_id');
            $ie_by = Auth::user()->id;
            //validte
            $validate = Validator::make(Request::all(), [
                    'ie_type' => 'required',
                    'amount' => 'required|numeric|min:1',
                    'cat_id' => 'required',
                ], [
                    'ie_type.required' => 'Please choose IE Type!!!',
                    'amount.required' => 'Please enter Amount!!!',
                    'amount.min' => 'Please enter amount > 0!!!',
                    'cat_id.required' => 'Please choose Category!!!',

                ]);
            if($validate->fails()){
                $data['status'] = 'error';
                foreach ($validate->errors()->all() as $value) {
                	$data['msg'] .= "<br />".$value;
                }
                 
                return response()->json($data);
            }
            $iedata = new IeData;
            $iedata->amount = $amount;
            $iedata->note = $note;
            $iedata->ie_type = $ie_type;
            $iedata->cat_id = $cat_id;
            $iedata->ie_by = $ie_by;
            $iedata->save();
            $data['status'] = 'success';
            $data['msg'] = "Add IE successfully!!!";
        }
        return response()->json($data);
    }
    /**
     * function: delete Category
     */
    public function delCat($id){
        $cat = IeCat::findOrFail($id);
        $cat->delete();
        return redirect()->route("inex");
    }
    /**
     * function: show info category
     */
    public function showInfoCat(){
        $data = array();
        if(Request::ajax()){
            $catid = Request::get('catid');
            $data = IeCat::select('id', 'cat_name', 'color')->find($catid)->toJson();
        }
        return response()->json($data);
    }
    /**
     * function: edit category
     */
    public function editCat(){
        $data = array('status' => '', 'msg' => 'Errors!!!');
        if(Request::ajax()){
            $cat_id = Request::get('cat_id');
            $cat_name = Request::get('cat_name');
            $color = Request::get('cat_color');
            $iecat = IeCat::find($cat_id);
            //validte
            $validate = Validator::make(Request::all(), [
                    'cat_name' => 'required',
                    'cat_color' => 'required',
                ], [
                    'cat_name.required' => 'Please enter category name!!!',
                    'color.required' => 'Please choose color!!!',

                ]);
            if($validate->fails()){
                $data['status'] = 'error';
                foreach ($validate->errors()->all() as $value) {
                    $data['msg'] .= "<br />".$value;
                }
                 
                return response()->json($data);
            }
            $iecat->cat_name = $cat_name;
            $iecat->color = $color;
            $iecat->save();
            $data['status'] = 'success';
            $data['msg'] = "Edit Category successfully!!!";
        }
        return response()->json($data);
    }
    /**
     * function: show info Income & expenses data
     */
    public function showInfoIeData(){
        $data = array();
        if(Request::ajax()){
            $ieid = Request::get('ieid');
            $data = IeData::find($ieid)->toJson();
        }
        return response()->json($data);
    }
    /**
     * function: edit Income & Expenses data
     */
    public function editIeData(){
        $data = array('status' => '', 'msg' => 'Errors!!!');
        if(Request::ajax()){
            $ie_id = Request::get('ie_id');
            $ie_type = Request::get('ie_type');
            $amount = Request::get('amount');
            $note = Request::get('note');
            $cat_id = Request::get('cat_id');
            $iedata = IeData::find($ie_id);
            //validte
             $validate = Validator::make(Request::all(), [
                    'ie_type' => 'required',
                    'amount' => 'required|numeric|min:1',
                    'cat_id' => 'required',
                ], [
                    'ie_type.required' => 'Please choose IE Type!!!',
                    'amount.required' => 'Please enter Amount!!!',
                    'amount.min' => 'Please enter amount > 0!!!',
                    'cat_id.required' => 'Please choose Category!!!',

                ]);
            if($validate->fails()){
                $data['status'] = 'error';
                foreach ($validate->errors()->all() as $value) {
                    $data['msg'] .= "<br />".$value;
                }
                 
                return response()->json($data);
            }
            $iedata->ie_type = $ie_type;
            $iedata->amount = $amount;
            $iedata->note = $note;
            $iedata->cat_id = $cat_id;
            $iedata->save();
            $data['status'] = 'success';
            $data['msg'] = "Edit IE data successfully!!!";
        }
        return response()->json($data);

    }
    /**
     * function: delete Income & Expenses data
     */
    public function delIeData($id){
        $iedata = IeData::findOrFail($id);
        $iedata->delete();
        return redirect()->route("inex");
    }
}
