<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index($area=null,$school_type=null)
    {
        if(empty($area)) $area='all';        
        if(empty($school_type)) $school_type='all';
        if(empty(session('school_data_array'))){
            // 1. 取得遠端 JSON
            $response = Http::get(env('SCHOOL_JSON'));
            if ($response->failed()) {
                return '抓取失敗';
            }
            // 2. 取得回傳內容
            $jsonContent = $response->body();
            $school_data_array = json_decode($jsonContent, true);        
            session(['school_data_array' => $school_data_array]);
            session(['data_time' => date('Y-m-d H:i:s')]);
        }

        if(empty(session('teacher_data_array'))){
            // 1. 取得遠端 JSON
            $response = Http::get(env('TEACHER_JSON'));
            if ($response->failed()) {
                return '抓取失敗';
            }
            // 2. 取得回傳內容
            $jsonContent = $response->body();
            $teacher_data_array = json_decode($jsonContent, true);        
            session(['teacher_data_array' => $teacher_data_array]);            
        }

        $area_array = config(env('SELECT_CITY').'.areas');
        $address_array = config(env('SELECT_CITY').'.school_address');

        foreach(session('school_data_array') as $key => $value){
            $school_data[$value['district']][$value['duration']][$key]['schoolName']=$value['schoolName'];
        }        
        $school2web = config(env('SELECT_CITY').'.school2web');                
        
        $data = [
            'area' => $area,
            'school_type' => $school_type,            
            'data_time' => session('data_time'),
            'area_array' => $area_array,
            'address_array' => $address_array,
            'school_data' => $school_data,    
            'school_data_array' => session('school_data_array'),   
            'school2web' => $school2web, 
        ];
        
        
        return view('index',$data);
    }

    public function teacher($area=null,$school_type=null)
    {
        if(empty($area)) $area='all';        
        if(empty($school_type)) $school_type='all';
        if(empty(session('school_data_array'))){
            // 1. 取得遠端 JSON
            $response = Http::get(env('SCHOOL_JSON'));
            if ($response->failed()) {
                return '抓取失敗';
            }
            // 2. 取得回傳內容
            $jsonContent = $response->body();
            $school_data_array = json_decode($jsonContent, true);        
            session(['school_data_array' => $school_data_array]);
            session(['data_time' => date('Y-m-d H:i:s')]);
        }

        if(empty(session('teacher_data_array'))){
            // 1. 取得遠端 JSON
            $response = Http::get(env('TEACHER_JSON'));
            if ($response->failed()) {
                return '抓取失敗';
            }
            // 2. 取得回傳內容
            $jsonContent = $response->body();
            $teacher_data_array = json_decode($jsonContent, true);        
            session(['teacher_data_array' => $teacher_data_array]);            
        }

        $area_array = config(env('SELECT_CITY').'.areas');

        foreach(session('school_data_array') as $key => $value){
            $school_data[$value['district']][$value['duration']][$key]['schoolName']=$value['schoolName'];
        }        
        foreach(session('teacher_data_array') as $key => $value){
            $teacher_data[$value['schoolNo']]['boyNum']=$value['boyNum'];
            $teacher_data[$value['schoolNo']]['girlNum']=$value['girlNum'];
            foreach($value['details'] as $k=>$v){
                $teacher_data[$value['schoolNo']][$k]=$v;
            }
        }
        $school2web = config(env('SELECT_CITY').'.school2web');                   

        $data = [
            'area' => $area,
            'school_type' => $school_type,            
            'data_time' => session('data_time'),
            'area_array' => $area_array,
            'school_data' => $school_data,
            'teacher_data' => $teacher_data,
            'school_data_array' => session('school_data_array'),   
            'teacher_data_array' => session('teacher_data_array'),   
            'school2web' => $school2web, 
        ];
        
        
        return view('teacher',$data);
    }

    public function student($area=null,$school_type=null)
    {
        if(empty($area)) $area='all';        
        if(empty($school_type)) $school_type='all';
        if(empty(session('school_data_array'))){
            // 1. 取得遠端 JSON
            $response = Http::get(env('SCHOOL_JSON'));
            if ($response->failed()) {
                return '抓取失敗';
            }
            // 2. 取得回傳內容
            $jsonContent = $response->body();
            $school_data_array = json_decode($jsonContent, true);        
            session(['school_data_array' => $school_data_array]);
            session(['data_time' => date('Y-m-d H:i:s')]);
        }

        if(empty(session('teacher_data_array'))){
            // 1. 取得遠端 JSON
            $response = Http::get(env('TEACHER_JSON'));
            if ($response->failed()) {
                return '抓取失敗';
            }
            // 2. 取得回傳內容
            $jsonContent = $response->body();
            $teacher_data_array = json_decode($jsonContent, true);        
            session(['teacher_data_array' => $teacher_data_array]);            
        }

        $area_array = config(env('SELECT_CITY').'.areas');

        foreach(session('school_data_array') as $key => $value){
            $school_data[$value['district']][$value['duration']][$key]['schoolName']=$value['schoolName'];
            $school_data[$value['district']][$value['duration']][$key]['boyNum']=$value['boyNum'];
            $school_data[$value['district']][$value['duration']][$key]['girlNum']=$value['girlNum'];
            $school_data[$value['district']][$value['duration']][$key]['totalNum']=$value['totalNum'];
            foreach($value['details'] as $k=>$v){
                list($grade) = explode("-", $k);
                if(!isset($details[$key][$grade]['boy'])) $details[$key][$grade]['boy'] = 0;
                if(!isset($details[$key][$grade]['girl'])) $details[$key][$grade]['girl'] = 0;
                if(!isset($details[$key][$grade]['total_class'])) $details[$key][$grade]['total_class'] = 0;
                $details[$key][$grade]['boy'] = $details[$key][$grade]['boy']+$v['boy'];
                $details[$key][$grade]['girl'] = $details[$key][$grade]['girl']+$v['girl'];
                $details[$key][$grade]['total_class']++;                
            };
            $school_data[$value['district']][$value['duration']][$key]['classNum']=count($details[$key]);
        }        
        $school2web = config(env('SELECT_CITY').'.school2web');
                
        $data = [
            'area' => $area,
            'school_type' => $school_type,            
            'data_time' => session('data_time'),
            'area_array' => $area_array,
            'school_data' => $school_data,    
            'school_data_array' => session('school_data_array'),   
            'school2web' => $school2web, 
            'details' => $details,
        ];
        
        
        return view('student',$data);
    }

    public function refresh()
    {        
        // 清除 session 中的學校資料
        session()->forget('school_data_array');
        session()->forget('teacher_data_array');        
        session()->forget('data_time');

        // 重新導向到首頁，觸發資料重新抓取
        return redirect()->route('index');
    }
}