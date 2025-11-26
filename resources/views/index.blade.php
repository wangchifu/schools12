@extends('layouts.app')

@section('title','首頁')

@section('content')
<style>
    .table-hover tbody tr:hover {background-color: rgba(30, 144, 255, 0.2); /* 淡藍透明 */}
</style>
<section class="py-1">
    <div class="px-4 px-lg-5">
        資料更新：{{ $data_time }} <a href="{{ route('refresh') }}" class="btn btn-primary btn-sm">手動更新</a>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('index') }}">學校</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('teacher_select') }}">教職員</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student_select') }}">學生數統計</a>
            </li>
        </ul>
        <div class="d-flex">
            <select class="form-select my-2" style="width:200px;" name="area" id="area">
                <option value="all" {{ $area == "all" ? 'selected' : '' }}>全部鄉鎮市</option>
                @foreach($area_array as $k=>$v)
                    <option value="{{ $k }}" {{ $k == $area ? 'selected' : '' }}>{{ $k }}</option>            
                @endforeach
            </select>
            <select class="form-select my-2" style="width:200px;" name="school_type" id="school_type">
                <option value="all" {{ $school_type == "all" ? 'selected' : '' }}>全部</option>
                <option value="國民小學" {{ $school_type=="國民小學" ? 'selected' : '' }}>國小</option>
                <option value="國民中學" {{ $school_type=="國民中學" ? 'selected' : '' }}>國中</option>
            </select>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th nowrap>鄉鎮市</th>
                        <th nowrap>學校名稱</th>
                        <th nowrap>學校代碼</th>
                        <th nowrap>學校類別</th>
                        <!--
                        <th nowrap>地址</th>
                        <th nowrap>電話</th>
                        -->
                        <th nowrap>網站</th>                        
                    </tr>
                </thead>            
                <tbody id="school_list">
                    <?php $n=0; ?>
                    @foreach($area_array as $k1=>$v1)
                        @if(isset($school_data[$k1])) 
                            @foreach($school_data[$k1] as $k2=>$v2)
                                @foreach($v2 as $k3=>$v3)
                                <?php
                                    if($area != 'all'){
                                        if($k1 != $area) break;
                                    }
                                    if($school_type != 'all'){                                
                                        if($k2 != $school_type) break;                                
                                    }
                                    $n++; 
                                ?>

                                    <tr>
                                        <td>{{ $n }}</td>
                                        <td nowrap>{{ $k1 }}</td>
                                        <td nowrap>{{ $v3['schoolName'] }}</td>
                                        <td nowrap>{{ $k3 }}</td>
                                        <td nowrap>{{ $k2 }}</td>
                                        <!--
                                        <td nowrap>
                                            @if(isset($address_array[$k3]))
                                                {{ $address_array[$k3] }}
                                            @endif
                                        </td>
                                        <td></td>       
                                        -->                                                         
                                        <td nowrap>
                                            @if(isset($school2web[$k3]))                                         
                                                <a href="{{ $school2web[$k3] }}" target="_blank">網站</a>
                                            @endif
                                        </td>                                        
                                    </tr>
                                @endforeach
                            @endforeach
                        @endif
                    @endforeach                
                </tbody>
            </table>
        </div>        
    </div>    
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const areaSelect = document.getElementById('area');
    const schooltypeSelect = document.getElementById('school_type');

    function redirect() {
        const area = areaSelect.value || '全部鄉鎮市';
        const school_type = schooltypeSelect.value || 'all';
        // 注意 encodeURIComponent，避免中文或特殊字元造成問題
        window.location.href = `{{ route('index_select') }}/${encodeURIComponent(area)}/${encodeURIComponent(school_type)}`;
    }

    areaSelect.addEventListener('change', redirect);
    schooltypeSelect.addEventListener('change', redirect);
});
</script>
@endsection