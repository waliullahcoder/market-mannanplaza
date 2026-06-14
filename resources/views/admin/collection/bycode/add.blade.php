@extends('admin.layouts.master')

@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <div id="app">
        <form action="{{ route('collection.add.bycode') }}" method="GET">
            <input type="hidden" name="searched" value="true">
            <div class="card noprint">
                <div class="custom-card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="custom-card-title">{{ $title }}</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <label for="search_code" class="mt-2">Find By Code</label>
                        </div>
                        <div class="col-md-10">
                            <select class="form-control select2" name="search_code" id="search_code">
                                @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->Code }}" @if ($search_code == $tenant->Code) selected @endif>
                                        {{ $tenant->Code }} ({{ $tenant->Name }})</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>

                <div class="custom-card-footer">
                    <div class="row text-right">
                        <div class="col-md-4 col-6 offset-md-8 text-right">

                            <button type="submit" id="search" class="btn btn-outline-info btn-lg waves-effect mr-2"><i
                                    class="fa fa-search"></i>
                                Search</button>

                            <button type="button" id="save" onclick="$('#wbillForm').submit()"
                                class="btn btn-outline-info btn-lg waves-effect ml-2"><i class="fa fa-save"></i>
                                Save</button>

                        </div>

                    </div>
                </div>
            </div>
        </form>

        @if (count($bills) != 0)
            <form action="{{ route('collection.save.bycode') }}" method="POST" id="wbillForm">
                @csrf
                <div class="mt-5 report_div">
                    <table v-if="bills" class="table table-bordered table-striped table-custom">
                        <thead>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>
                                <input type="checkbox" name="all" id="all">
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($bills as $bill)
                                <tr id="tr_{{ $bill->id }}">
                                    <td>{{ $bill->CMonth }}</td>
                                    <td>{{ $bill->CYear }}</td>
                                   
                                    @php
                                        $now = date('Y-m-d');
                                        $startDate = date('2024-03-15');
                                        $lastDate = new Carbon(date('Y-m-d', strtotime('10-' . $bill->CMonth . '-' . $bill->CYear)));
                                        if (in_array($bill->CLASS_NAME, ['App\EbillCollection','App\ServiceChargeCollection'])) {
                                            $lastDate = $lastDate->addMonths(1);
                                        }
                                        if ($bill->CLASS_NAME == 'App\RentCollection') {
                                            $startDate = date('2024-06-10');
                                            if(Str::startsWith($bill->Client_Code, 'U3') || Str::startsWith($bill->Client_Code, 'u3')){
                                                $lastDate = $lastDate->addMonths(1);
                                            }
                                        }
                                    @endphp
                                     <td>
                                        @if ($bill->CLASS_NAME == 'App\ServiceChargeCollection')
                                            {{ optional($bill->utility)->name }}
                                        @else
                                            {{ $classToNormal[$bill->CLASS_NAME] }}
                                        @endif
                                    </td>
                                    <td>{{ $bill->Amount }}</td>
                                    <td>
                                        <input type="checkbox" class="checked_inputs" name="ids[]"
                                            value="{{ $bill->id }}" amount="{{ $bill->Amount }}">
                                        <input type="hidden" name="class_name[{{ $bill->id }}]"
                                            value="{{ $bill->CLASS_NAME }}">
                                       
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <span class="font-weight-bold float-right mt-2">Receive Date</span>
                                </td>
                                <td>
                                    <input type="text" class="form-control" readonly value="{{ date('d-m-Y') }}"
                                        style="opacity: 1 !important;">
                                    <input type="text" name="receive_date" class="form-control d-none add_datepicker">
                                </td>
                                <td>
                                    <span class="font-weight-bold float-right mt-2">Total</span>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="total" readonly
                                        style="opacity: 1 !important;">
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
        @endif
    </div>

    <script type="text/javascript">
        $(function() {
            let totalInputEl = $('#total');
            // Listen for click on toggle checkbox
            $('#all').click(function(event) {
                if (this.checked) {
                    // Iterate each checkbox
                    $('.checked_inputs:checkbox').each(function() {
                        this.checked = true;
                        checked();
                    });
                } else {
                    $('.checked_inputs:checkbox').each(function() {
                        this.checked = false;
                        checked();
                    });
                }
            });

            // on checkbox checked
            function checked(e) {
                let amount = 0;
                $('.checked_inputs:checkbox:checked').each(function() {
                    let valueEl = $(this);
                    var id = $(this).val();
                    amount += +valueEl.attr('amount');
                });
                totalInputEl.val(amount);
            }

            $('.checked_inputs').change(function(e) {
                e.preventDefault();
                checked(e);
            });
        });
    </script>


@endsection
