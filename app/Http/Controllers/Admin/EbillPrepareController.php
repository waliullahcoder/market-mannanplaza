<?php

namespace App\Http\Controllers\Admin;

use App\UnitSetup;
use Carbon\Carbon;
use App\FloorSetup;
use App\SetupRates;
use App\SetupProject;
use App\EbillCollection;
use App\WbillCollection;
use App\ServiceChargeCollection;
use App\PositionInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EbillPrepareController extends Controller
{
    public function generateSerialNo()
    {
        $curr_serial_no = (int) EbillCollection::max('SerialNo');
        return $curr_serial_no + 1;
    }

    public function index()
    {
        // $data = EbillCollection::where('SerialNo', 100951)->get();
        // foreach($data as $item){
        //     $amount = ($item->UsesUnit + 45) * 22;
        //     $item->update([
        //         'LossUnit' => 45,
        //         'Amount' => $amount,
        //     ]);
        // }

        $title = "Electric Bill List";
        $searchFormLink = "ebill.prepare.search";
        $printFormLink  = "tenant.report.print";
        $data = (object)[
            'ebill_list' => EbillCollection::groupBy('SerialNo')->orderBy('billing_month', 'desc')->with(['position_holder'])->get(),
        ];

        return view('admin.prepare.ebill.index', compact(['title', 'searchFormLink', 'printFormLink', 'data']));
    }

  //   public function print($id)
  //   {
  //       $title = "Utility Collection Print";
  //       $searchFormLink = "tenant.report.search";
  //       $printFormLink  = "tenant.report.print";

  //       // get month and year and unit and floor
  //       $parameters = EbillCollection::where('serialNo', $id)->with(['position_holder'])->get();

  //       $ids = [];

  //       foreach ($parameters as $p) {
  //           array_push($ids, $p->Client_Code);
  //       }

  //       $data = (object)[
  //           'bills' => [],
  //           'copies' => ['Office Copy', 'Client Copy'],
  //           'project' => SetupProject::findOrFail(1),
  //           'unit_prices' => UnitSetup::all(),
  //       ];

  //       // fetch Ebill
  //       $ebills = EbillCollection::where('serialNo', $id)->whereIn('Client_Code', $ids)->with(['position_holder'])->get();

  //       foreach ($ebills as $ebill) {
  //           $data->bills[$ebill->position_holder->Code][0] = $ebill;

  //           $data->bills[$ebill->position_holder->Code]['tenant'] = $ebill->position_holder;
  //           $data->bills[$ebill->position_holder->Code]['billCode'] = $ebill->CMonth . '-' . $ebill->CYear . '-' . $ebill->position_holder->ID;

  //           $data->bills[$ebill->position_holder->Code]['month'] = $ebill->CMonth;
  //           $data->bills[$ebill->position_holder->Code]['year'] = $ebill->CYear;
  //       }

  //       // fetch Wbill
  //       $wbills = WbillCollection::where('CMonth', $parameters[0]->CMonth)
  //           ->where('CYear', $parameters[0]->CYear)
  //           ->whereIn('Client_Code', $ids)->with(['position_holder'])
  //           ->get();

  //       foreach ($wbills as $wbill) {
  //           $data->bills[$wbill->position_holder->Code][1] = $wbill;
  //       }

  //       // fetch service charge
  //       // $sbills = ServiceChargeCollection::where('CMonth', $parameters[0]->CMonth)
  //       //     ->where('CYear', $parameters[0]->CYear)->whereIn('Client_Code', $ids)->with(['position_holder'])->get();
  //       $sbills = ServiceChargeCollection::where('SerialNo', $id)->get(); 
  //          $code="";
  //          $clientname="";
  //       foreach ($sbills as $key => $sbill) {
  //           if (!is_null($sbill->position_holder)) {
  //               $data->bills[$sbill->position_holder->Code][2] = [$sbill];
  //           } else {
  //               $holder_code = PositionInformation::where('Code', $sbill->Client_Code)->first()->Code;
  //               $data->bills[$holder_code][2] = [$sbill];
  //           }
		// 	$code= $sbill->Client_Code;
		// 	$clientname=PositionInformation::where('Code', $sbill->Client_Code)->first()->Name;
  //       }
  //       $client=PositionInformation::where('Code', $code)->first();
		// $electbill = EbillCollection::where('Client_Code', $code)->with(['position_holder'])->first();
  //       $waterbill = WbillCollection::where('Client_Code', $code)->with(['position_holder'])->first();
    
  //       return view('admin.prepare.ebill.print', compact(['title', 'sbills','code','clientname','electbill','waterbill','client','searchFormLink', 'printFormLink', 'data']));
  //   }

	public function print($id)
{
    $title = "Utility Collection Print";
    $searchFormLink = "tenant.report.search";
    $printFormLink  = "tenant.report.print";

    $parameters = EbillCollection::where('serialNo', $id)
        ->with('position_holder')
        ->get();

    if ($parameters->isEmpty()) {
        return back()->with('error', 'No Bill Found For Serial No : ' . $id);
    }

    $firstParameter = $parameters->first();

    $ids = $parameters->pluck('Client_Code')->toArray();

    $data = (object)[
        'bills' => [],
        'copies' => ['Office Copy', 'Client Copy'],
        'project' => SetupProject::findOrFail(1),
        'unit_prices' => UnitSetup::all(),
    ];

    // Electric Bill
    $ebills = EbillCollection::where('serialNo', $id)
        ->whereIn('Client_Code', $ids)
        ->with('position_holder')
        ->get();

    foreach ($ebills as $ebill) {

        if (!$ebill->position_holder) {
            continue;
        }

        $code = $ebill->position_holder->Code;

        $data->bills[$code][0] = $ebill;
        $data->bills[$code]['tenant'] = $ebill->position_holder;
        $data->bills[$code]['billCode'] =
            $ebill->CMonth . '-' .
            $ebill->CYear . '-' .
            $ebill->position_holder->ID;

        $data->bills[$code]['month'] = $ebill->CMonth;
        $data->bills[$code]['year'] = $ebill->CYear;
    }

    // Water Bill
    $wbills = WbillCollection::where('CMonth', $firstParameter->CMonth)
        ->where('CYear', $firstParameter->CYear)
        ->whereIn('Client_Code', $ids)
        ->with('position_holder')
        ->get();

    foreach ($wbills as $wbill) {

        if (!$wbill->position_holder) {
            continue;
        }

        $data->bills[$wbill->position_holder->Code][1] = $wbill;
    }

    // Service Charge
    $sbills = ServiceChargeCollection::where('SerialNo', $id)->get();

    $code = '';
    $clientname = '';

    foreach ($sbills as $sbill) {

        if ($sbill->position_holder) {

            $holderCode = $sbill->position_holder->Code;

            $data->bills[$holderCode][2][] = $sbill;

            $code = $sbill->Client_Code;
            $clientname = $sbill->position_holder->Name ?? '';
        } else {

            $position = PositionInformation::where('Code', $sbill->Client_Code)->first();

            if ($position) {

                $holderCode = $position->Code;

                $data->bills[$holderCode][2][] = $sbill;

                $code = $position->Code;
                $clientname = $position->Name;
            }
        }
    }

    $client = null;
    $electbill = null;
    $waterbill = null;

    if (!empty($code)) {

        $client = PositionInformation::where('Code', $code)->first();

        $electbill = EbillCollection::where('Client_Code', $code)
            ->with('position_holder')
            ->latest('id')
            ->first();

        $waterbill = WbillCollection::where('Client_Code', $code)
            ->with('position_holder')
            ->latest('id')
            ->first();
    }

    return view(
        'admin.prepare.ebill.print',
        compact(
            'title',
            'sbills',
            'code',
            'clientname',
            'electbill',
            'waterbill',
            'client',
            'searchFormLink',
            'printFormLink',
            'data'
        )
    );
}

    public function add(Request $request)
    {
        $bills = [];
        $rate = 0;
        $sunit = 0;
        $sfloor = 0;
        $CMonth = 0;
        $CYear = 0;
        $PaidDate = 0;

        if ($request->searched) {
            $sunit = $request->unit;
            $sfloor = $request->floor;
            $CMonth = $request->CMonth;
            $CYear = $request->CYear;

            if ($request->search_code) {
                $tenants =  PositionInformation::where('status', 1)->where('Code', $request->search_code)->orderBy('PositionNo', 'asc')->get();
            } else {
                $tenants = PositionInformation::where('status', 1)->where('Unit', $sunit)->where('Floor', $sfloor)->orderBy('PositionNo', 'asc')->get();
            }

            foreach ($tenants as $tenant) {
                $bills[$tenant->ID] = $tenant;
                $bills[$tenant->ID]->last_unit = EbillCollection::where('Client_Code', $tenant->Code)->orderBy('id', 'desc')->first();
            }

            $rate = SetupRates::where('type', 'ebill')->first()->rate;
        }

        $bills = (object)$bills;
        $bills = json_encode($bills);

        $title = "Add Electric Bill";
        $searchFormLink = "ebill.prepare.search";
        $printFormLink  = "tenant.report.print";

        $data = (object)[
            'floors' => FloorSetup::select(['name'])->get(),
            'units' => UnitSetup::select(['name'])->get(),
            'serial_no' =>  $this->generateSerialNo(),
            'current_time' => Carbon::now(),
        ];

        $tenants = PositionInformation::select(['Code', 'Name'])->get();

        return view('admin.prepare.ebill.add', compact(['tenants', 'PaidDate', 'CYear', 'CMonth', 'title', 'searchFormLink', 'printFormLink', 'data', 'bills', 'rate', 'sunit', 'sfloor']));
    }

    public function addindividual()
    {
        $title = "Add Electric Bill Individual";
        $formLink = "ebill.prepare.save.individual";
        $buttonName = "Ebill Posting";
        $serial_no = $this->generateSerialNo();

        $tenants = PositionInformation::where('status', 1)->select(['Code', 'Name'])->get();

         $rate = SetupRates::where('type', 'ebill')->first()->rate??0;
        return view('admin.prepare.ebill.add_individual', compact(['tenants','rate', 'title', 'formLink', 'buttonName', 'serial_no']));
    }

    public function addReading(Request $request)
    {

        $bills = [];
        $rate = 0;

        $sunit = 0;
        $sfloor = 0;
        $CMonth = 0;
        $CYear = 0;
        $PaidDate = 0;

        if ($request->searched) {
            $sunit = $request->unit;
            $sfloor = $request->floor;
            $CMonth = $request->CMonth;
            $CYear = $request->CYear;
            $PaidDate = $request->PaidDate;

            if ($request->search_code) {
                $tenants =  PositionInformation::where('status', 1)->where('Code', $request->search_code)
                    ->orderBy('PositionNo')
                    ->get();
            } else {
                $tenants = PositionInformation::where('status', 1)->where('Unit', $sunit)->where('Floor', $sfloor)
                    ->orderBy('PositionNo')
                    ->get();
            }

            foreach ($tenants as $tenant) {
                $bills[$tenant->ID] = $tenant;
                $bills[$tenant->ID]->last_unit = EbillCollection::where('Client_Code', $tenant->Code)->orderBy('id', 'desc')->first();
            }

            $rate = SetupRates::where('type', 'ebill')->first()->rate;
        }

        $bills = (object)$bills;
        // $bills = json_encode($bills);

        $title = "Electric Bill Reading Sheet";
        $searchFormLink = "ebill.prepare.search";
        $printFormLink  = "tenant.report.print";

        $data = (object)[
            'floors' => FloorSetup::select(['name'])->get(),
            'units' => UnitSetup::select(['name'])->get(),
            // 'serial_no' =>  $this->generateSerialNo(),
            'current_time' => Carbon::now(),
        ];

        return view('admin.prepare.ebill.ebill_reading', compact(['PaidDate', 'CYear', 'CMonth', 'title', 'searchFormLink', 'printFormLink', 'data', 'bills', 'rate', 'sunit', 'sfloor']));
    }

    public function save(Request $request)
    {
        DB::transaction(function () use ($request) {
            $serial_no = $this->generateSerialNo();

            foreach ($request->codes as $code) {
                if ($request->last_unit[$code] < $request->prev_unit[$code]) {
                    return back()->with('error', 'Last unit must be greater than or equal previous unit!');
                }
                if ($request->last_unit[$code] == null || $request->last_unit[$code] == '') {
                    return back()->with('error', 'Please type in all last unit');
                }
            }

            foreach ($request->codes as $code) {

                $position_holder = PositionInformation::where('Code', $code)->first();

                $check = EbillCollection::where('Client_Code', $position_holder->Code)->where('CMonth', $request->CMonth)->where('CYear', $request->CYear)->first();
                if ($check == null) {
                    EbillCollection::create([
                        'Client_Code' => $code,
                        'CMonth' => $request->CMonth,
                        'CYear' => $request->CYear,
                        'billing_month' => date('Y-m-d', strtotime('01-' . $request->CMonth . '-' . $request->CYear)),
                        'PreviousUnit' => $request->prev_unit[$code],
                        'LastUnit' => $request->last_unit[$code],
                        'LossUnit' => $request->loss_unit[$code] ?? 0,
                        'UsesUnit' => $request->uUnit[$code],
                        'SerialNo' => $serial_no,
                        'Amount' => $request->bill[$code],
                        'PaidDate' => date('Y-m-d h:i:s', strtotime($request->PaidDate)),
                        'PositionNo' => $position_holder->PositionNo,
                        'Project_ID' => 1,
                        'CreateBy' => Auth::user()->name,
                    ]);
                }
            }
        });

        return redirect(route('ebill.prepare.index'));
    }


    public function saveIndividual(Request $request)
    {
        $client = PositionInformation::where('Code',  $request->client_code)->first();

        $exists = EbillCollection::where('CYear', $request->CYear)
            ->where('CMonth', $request->CMonth)
            ->where('Client_Code', $request->client_code)
            ->first();

        if ($exists) {
            return back()->with('error', 'Already Added');
        }

        if ($request->old_reading > $request->new_reading) {
            return back()->with('error', 'Last unit must be greater than or equal previous unit!');
        }

        EbillCollection::create([
            'Client_Code' => $request->client_code,
            'CMonth' =>  $request->CMonth,
            'CYear' =>  $request->CYear,
            'billing_month' => date('Y-m-d', strtotime('01-' . $request->CMonth . '-' . $request->CYear)),
            'Amount' => $request->amount,
            'PreviousUnit' => $request->old_reading,
            'LastUnit' => $request->new_reading,
            'UsesUnit' => $request->new_reading - $request->old_reading,
            'SerialNo' =>  $this->generateSerialNo(),
            'PaidDate' => date('Y-m-d h:i:s', strtotime($request->paid_date)),
            'PositionNo' =>  $client->PositionNo,
            'Project_ID' => 1,
            'CreateBy' => Auth::user()->name,
        ]);


        return redirect(route('ebill.prepare.index'))->with('msg', 'Successfully Added');
    }

    public function view($id)
    {
        $title = "View Electric Bill";
        $searchFormLink = "ebill.prepare.search";
        $printFormLink  = "tenant.report.print";

        $data = (object)[
            'bills' => EbillCollection::where('SerialNo', $id)->get(),
        ];

        return view('admin.prepare.ebill.view', compact(['title', 'searchFormLink', 'printFormLink', 'data']));
    }

    public function delete(Request $request)
    {
        EbillCollection::where('serialNo', $request->ebill)->delete();
    }

    public function deleteIndividual(Request $request)
    {
        EbillCollection::where('id', $request->bill_id)->delete();
        return back();
    }

    public function getEbillInfo(Request $request)
    {
        if ($request->ajax()) {

            // fetch old reading
            $last_unit = EbillCollection::where('Client_Code', $request->client_code)->orderBy('id', 'desc')->first();

            if ($last_unit == null) {
                $last_unit = $last_unit['LastUnit'] = 0;
            }

            // get ebill rates
            $rate = SetupRates::where('type', 'ebill')->first()->rate;

            $data = [
                'last_unit' => $last_unit,
                'rate' => $rate,
            ];

            return $data;
        }
    }
}
