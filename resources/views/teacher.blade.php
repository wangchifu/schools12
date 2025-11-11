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
                <a class="nav-link" aria-current="page" href="{{ route('index') }}">學校</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('teacher_select') }}">教職員</a>
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
                        <th nowrap>校長</th>
                        <th nowrap>男教師</th>
                        <th nowrap>女教師</th>
                        <th nowrap>護理師</th>
                        <th nowrap>職員</th>
                        <th nowrap>工友</th>                    
                        <th nowrap>警衛</th>  
                        <th nowrap>小計</th>                  
                    </tr>
                </thead>
                <tbody id="school_list">
                    <?php 
                        $n=0; 
                        $t1 = 0;
                        $t2 = 0;
                        $t3 = 0;
                        $t4 = 0;
                        $t5 = 0;
                        $t6 = 0;
                        $t7 = 0;
                        $t8 = 0;
                    ?>
                    @foreach($area_array as $k1=>$v1)
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
                                $total = 0;
                            ?>

                                <tr>
                                    <td>{{ $n }}</td>
                                    <td nowrap>{{ $k1 }}</td>
                                    <td nowrap>{{ $v3['schoolName'] }}</td>
                                    <td nowrap>{{ $k3 }}</td>
                                    <td nowrap>{{ $k2 }}</td>
                                    <td>
                                        @if(isset($teacher_data[$k3]['校長']))
                                            <?php $total += $teacher_data[$k3]['校長']; ?>
                                            {{ $teacher_data[$k3]['校長'] }}
                                            <?php $t1 += $teacher_data[$k3]['校長']; ?>
                                        @endif                                    
                                    </td>
                                    <td>
                                        @if(isset($teacher_data[$k3]['boyNum']))
                                            <?php $total += $teacher_data[$k3]['boyNum']; ?>
                                            {{ $teacher_data[$k3]['boyNum'] }}
                                            <?php $t2 += $teacher_data[$k3]['boyNum']; ?>
                                        @endif
                                    </td>                                                                
                                    <td>
                                        @if(isset($teacher_data[$k3]['girlNum']))
                                            <?php $total += $teacher_data[$k3]['girlNum']; ?>
                                            {{ $teacher_data[$k3]['girlNum'] }}
                                            <?php $t3 += $teacher_data[$k3]['girlNum']; ?>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($teacher_data[$k3]['護理師']))
                                            <?php $total += $teacher_data[$k3]['護理師']; ?>
                                            {{ $teacher_data[$k3]['護理師'] }}
                                            <?php $t4 += $teacher_data[$k3]['護理師']; ?>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($teacher_data[$k3]['職員']))
                                            <?php $total += $teacher_data[$k3]['職員']; ?>
                                            {{ $teacher_data[$k3]['職員'] }}
                                            <?php $t5 += $teacher_data[$k3]['職員']; ?>
                                        @endif
                                    </td>                                                                
                                    <td>
                                        @if(isset($teacher_data[$k3]['工友']))
                                            <?php $total += $teacher_data[$k3]['工友']; ?>
                                            {{ $teacher_data[$k3]['工友'] }}
                                            <?php $t6 += $teacher_data[$k3]['工友']; ?>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($teacher_data[$k3]['警衛']))
                                            <?php $total += $teacher_data[$k3]['警衛']; ?>
                                            {{ $teacher_data[$k3]['警衛'] }}
                                            <?php $t7 += $teacher_data[$k3]['警衛']; ?>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $total }}
                                        <?php $t8 += $total; ?>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach     
                    <tr>
                        <td>小計</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $t1 }}</td>
                        <td>{{ $t2 }}</td>
                        <td>{{ $t3 }}</td>
                        <td>{{ $t4 }}</td>
                        <td>{{ $t5 }}</td>
                        <td>{{ $t6 }}</td>
                        <td>{{ $t7 }}</td>
                        <td>{{ $t8 }}</td>
                    </tr>           
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
        window.location.href = `{{ route('teacher_select') }}/${encodeURIComponent(area)}/${encodeURIComponent(school_type)}`;
    }

    areaSelect.addEventListener('change', redirect);
    schooltypeSelect.addEventListener('change', redirect);
});
</script>
@endsection