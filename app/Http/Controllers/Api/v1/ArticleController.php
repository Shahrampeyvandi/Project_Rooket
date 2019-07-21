<?php

namespace App\Http\Controllers\Api\v1;
use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ArticleController extends Controller
{
  
  public function articles()
  {
    
    // $authorize=$this->authorize('show-articles');
    // if($authorize){
    //   return response(['data'=>'unauthorized','status'=>403]);
    // }
    $articles=Article::select('title','description')->latest()->get();
    return response(['data'=> ['articles'=>$articles]]);
  }
  public function storeComment(Request $request)
  {
    
    $data=\Validator::make($request->all(),[
      'name'=>'required',
      'comment'=>'required'
    ]);
    // dd($data);
    if($data->fails()){
    
      return response(['error'=>$data->errors()->all()]);
    }
  
  
  }
  
}