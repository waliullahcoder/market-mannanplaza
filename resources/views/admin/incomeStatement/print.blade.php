@extends('admin.layouts.masterCustomPrint')

@section('content')
    <div class="print-header">
        @php
            $budget_type = '';
            if (request('budget_type') == 'Jamidari') {
                $budget_type = ' (জমিদারী)';
            } elseif (request('budget_type') == 'Electricity') {
                $budget_type = ' (বিদ্যুৎ)';
            } elseif (request('budget_type') == 'Service Charge') {
                $budget_type = ' (সার্ভিস চার্জ)';
            }
        @endphp
        <h4>কাসসাফ শপিং সেন্টার</h4>
        <p>মাসিক জমা খরচের হিসাব বিবরণী {{ $budget_type }}
            <br>
            {{ @$stitle }}
        </p>
    </div>

    <div id="pad-bottom"></div>
    <p class="mb-0">মাসঃ এপ্রিল ২০২৪ ইং</p>
    <table class="table table-bordered" id="report-table">
        <thead>
            <tr>
                <th class="text-center">ক্রঃ</th>
                <th>জমার বিবরন</th>
                <th>টাকা</th>
                <th class="text-center">ক্রঃ</th>
                <th>খরচের বিবরন</th>
                <th>টাকা</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sl = 0;
                $totalIncome = 0;
                $totalExpense = 0;
                $count = count($incomeLists);
                $count2 = count($expenseLists);
                if ($count >= $count2) {
                    $count_loop = $count;
                } else {
                    $count_loop = $count2;
                }
            @endphp
            @for ($i = 0; $i < $count_loop; $i++)
                @php
                    $totalIncome += @$incomeLists[$i]->amount ?? 0;
                    $totalExpense += @$expenseLists[$i]->amount ?? 0;
                    $sl++;
                @endphp
                <tr>
                    <td class="text-center">{{ @$incomeLists[$i] ? App\HelperClass::convertEnglishToBangla($sl) : '' }}</td>
                    <td>
                        @if (@$incomeLists[$i])
                            {{ @$incomeLists[$i]->headName . ' (' . App\HelperClass::convertEnglishToBangla(@$incomeLists[$i]->headCode) . ')' }}
                        @endif
                    </td>
                    <td>{{ @$incomeLists[$i] ? (@$incomeLists[$i]->amount > 0 ? App\HelperClass::convertEnglishToBangla(@$incomeLists[$i]->amount) : '(' . App\HelperClass::convertEnglishToBangla(abs(@$incomeLists[$i]->amount)) . ')') : '' }}
                    </td>
                    <td class="text-center">{{ @$expenseLists[$i] ? App\HelperClass::convertEnglishToBangla($sl) : '' }}</td>
                    <td>
                        @if (@$expenseLists[$i])
                            {{ @$expenseLists[$i]->headName . ' (' . App\HelperClass::convertEnglishToBangla(@$expenseLists[$i]->headCode) . ')' }}
                        @endif
                    </td>
                    <td>{{ @$expenseLists[$i] ? (@$expenseLists[$i]->amount > 0 ? App\HelperClass::convertEnglishToBangla(@$expenseLists[$i]->amount) : '(' . App\HelperClass::convertEnglishToBangla(abs(@$expenseLists[$i]->amount)) . ')') : '' }}
                    </td>
                </tr>
            @endfor
            <tr>
                <td class="align-right" colspan="2">সর্বমোট=</td>
                <td>{{ App\HelperClass::convertEnglishToBangla($totalIncome) }}</td>
                <td class="align-right" colspan="2">সর্বমোট=</td>
                <td>{{ App\HelperClass::convertEnglishToBangla($totalExpense) }}</td>
            </tr>
            <tr>
                <td class="align-right" colspan="5">সমাপণী স্থিতি=</td>
                @php
                    $total_summary = $totalIncome - $totalExpense;
                @endphp
                <td>{{ App\HelperClass::convertEnglishToBangla($total_summary > 0 ? App\HelperClass::convertEnglishToBangla($total_summary) : '(' . App\HelperClass::convertEnglishToBangla(abs($total_summary)) . ')') }}
                </td>
            </tr>
        </tbody>
    </table>
@endsection
