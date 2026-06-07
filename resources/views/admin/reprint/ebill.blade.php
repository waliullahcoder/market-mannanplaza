@extends('admin.layouts.master')

@section('content')
    <form action="{{ route($formLink) }}" method="POST" target="_blank">
        @csrf

        <div class="card noprint">
            <div class="custom-card-header">
                <div class="row">
                    <div class="col-md-10">
                        <h4 class="custom-card-title">{{ $title }}</h4>
                    </div>

                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-4">
                        <label for="Client_Code">Client Code</label>
                        <select class="form-control select2" name="client_code" id="search_code">
                            <option value="">Select An Client</option>
                            @foreach ($tenants as $tenant)
                                <option value="{{ $tenant->Code }}">{{ $tenant->Code }} ({{ $tenant->Name }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="month">Month</label>
                        <select class="form-control select2" id="CMonth" name="CMonth">
                            <option value="January" @if ('January' == date('F', strtotime(now())))
                                selected
                            @endif>January</option>
                            <option value="February" @if ('February' == date('F', strtotime(now())))
                                selected
                            @endif>February</option>
                            <option value="March" @if ('March' == date('F', strtotime(now())))
                                selected
                            @endif>March</option>
                            <option value="April" @if ('April' == date('F', strtotime(now())))
                                selected
                            @endif>April</option>
                            <option value="May" @if ('May' == date('F', strtotime(now())))
                                selected
                            @endif>May</option>
                            <option value="June" @if ('June' == date('F', strtotime(now())))
                                selected
                            @endif>June</option>
                            <option value="July" @if ('July' == date('F', strtotime(now())))
                                selected
                            @endif>July</option>
                            <option value="August" @if ('August' == date('F', strtotime(now())))
                                selected
                            @endif>August</option>
                            <option value="September" @if ('September' == date('F', strtotime(now())))
                                selected
                            @endif>September</option>
                            <option value="October" @if ('October' == date('F', strtotime(now())))
                                selected
                            @endif>October</option>
                            <option value="November" @if ('November' == date('F', strtotime(now())))
                                selected
                            @endif>November</option>
                            <option value="December" @if ('December' == date('F', strtotime(now())))
                                selected
                            @endif>December</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="year">Year</label>
                        <select class="form-control select2" id="CYear" name="CYear">
                            @for ($i = 2015; $i <= 2055; $i++)
                                <option value="{{ $i }}" @if ($i == date('Y', strtotime(now())))
                                selected
                            @endif>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                
            </div>

            <div class="custom-card-footer">
                <div class="col-md-3 offset-md-9">
                    <button type="submit" class="btn btn-outline-info btn-lg buttonAddEdit float-right">{{ $buttonName }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection
