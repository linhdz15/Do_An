<x-admin-layout>
    <div class="container">
        <div class="row  align-items-center justify-content-between">
            <div class="col-12 col-sm-12 page-title">
                <h3> Thống kê câu hỏi </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-16">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Thống kê nhập liệu câu hỏi</h5>
                    </div>
                    <div class="card-header">
                        <form method="GET" action="{{ route('admin.statistics') }}">
                            <h6 class="card-title pull-left">Tìm kiếm</h6>
                            <ul class="nav nav-pills card-header-pills pull-left ml-2">
                                <li class="nav-item ml-2">
                                    <div class="input-group">
                                        <input type="text" name="dates" class="form-control dates"
                                            value="{{ $dateRange }}" placeholder="Nhập ngày">
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <button class="btn btn-sm btn-primary ">
                                        <i class="fa fa-search"></i>
                                        <span class="text">Tìm kiếm</span>
                                    </button>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <div style="margin: 10px 0 0 20px;font-size: 25px; padding-bottom: 20px;">Tổng câu hỏi được tạo:
                        {{ number_format($totalQuestionNumber) }} câu
                    </div>
                    <table class="table table-bordered" id="#">
                        <thead>
                            <tr>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>Câu nhập liệu (phần - số câu tạo)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $email => $user)
                            <tr>
                                <td>
                                    {{ $user->first()->name }}
                                </td>
                                <td>
                                    {{ $email }}
                                </td>
                                <td>
                                    <div style="font-size: 20px;color: #e42c2c;text-align: center;">
                                        Tổng: {{ array_sum(array_column($user->toArray(), 'question_number'))}} câu
                                    </div>
                                    <div style="overflow-y: auto;">
                                        @foreach($user as $data)
                                        <a href="{{ 
                                                route('admin.curriculums.index', 
                                                    ['course' => $data['course_id'] ?? 0 ]
                                                ) 
                                            }}" target="_blank" style="text-decoration: none;">
                                            - {{ $data['title']}}
                                        </a>
                                        : {{ $data['question_number'] }} câu
                                        <br>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>