<?php

namespace App\Http\Controllers;

use App\PositionInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RentIncrementController extends Controller
{
    public function GetIncrementTenantList(Request $request)
    {
        $title = "Rent Increment";
        $matchedTenants = [];
        if ($request->searched) {
            $request->validate([
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            // date('Y-m-d', strtotime($request->start_date))
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);

            $tenants = PositionInformation::select(['id', 'Code', 'Name', 'Unit', 'Floor', 'PositionNo', 'PositionNo', 'Agg0ne', 'AggTwo', 'incrRate', 'EndDate', 'RentRate', 'PositionSize'])
                ->get();

            foreach ($tenants as $tenant) {

                // if no endDate
                if ($tenant->EndDate == "0000-00-00 00:00:00") {
                    continue;
                }

                // if null year of increment in tenant
                if (!$tenant->AggTwo) {
                    continue;
                }

                // if null ratio of increment in tenant
                if (!$tenant->incrRate) {
                    continue;
                }

                $tenantStartDate = Carbon::parse($tenant->EndDate);
                $tenantIncrementDate = $tenantStartDate->addYears($tenant->AggTwo);

                if ($tenantIncrementDate > $start_date && $tenantIncrementDate < $end_date) {
                    $matchedTenants[] = $tenant;
                }
            }
        }

        return view('admin.rent_increment.index', compact(['title', 'matchedTenants']));
    }

    public function UpdateTenantRent(Request $request)
    {
        $request->validate([
            'positionIds' => 'required',
        ]);

        foreach ($request->positionIds as $positionId) {
            $tenant = PositionInformation::find($positionId);

            if (!$tenant) {
                continue;
            }

            $tenantStartDate = Carbon::parse($tenant->EndDate);
            $tenantIncrementDate = $tenantStartDate->addYears($tenant->AggTwo);
            $newAmount =  $tenant->Agg0ne + (($tenant->Agg0ne) / 100) * $tenant->incrRate;
            $tenant->update([
                'RentRate' => ($newAmount / $tenant->PositionSize),
                'Agg0ne' => round($newAmount),
                'EndDate' => $tenantIncrementDate->format('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->route('admin.index')->with('success', 'Rent updated successfully');
    }

    public function autoIncrement()
    {

        $start_date = Carbon::now()->subDays(5);
        $end_date = Carbon::now();

        $tenants = PositionInformation::all();

        foreach ($tenants as $tenant) {

            // if no endDate
            if ($tenant->EndDate == "0000-00-00 00:00:00") {
                continue;
            }

            // if null year of increment in tenant
            if (!$tenant->AggTwo) {
                continue;
            }

            // if null ratio of increment in tenant
            if (!$tenant->incrRate) {
                continue;
            }

            $tenantStartDate = Carbon::parse($tenant->EndDate);
            $tenantIncrementDate = $tenantStartDate->addYears($tenant->AggTwo);

            if ($tenantIncrementDate > $start_date && $tenantIncrementDate < $end_date) {

                $tenantStartDate = Carbon::parse($tenant->EndDate);
                $tenantIncrementDate = $tenantStartDate->addYears($tenant->AggTwo);


                $incrRate = ($tenant->RentRate / 100) * $tenant->incrRate;

                $newRentRate = $tenant->RentRate + $incrRate;

                $tenant->update([
                    'RentRate' => $newRentRate,
                    'Agg0ne' => $tenant->PositionSize * $newRentRate,
                    'EndDate' => $tenantIncrementDate->format('Y-m-d H:i:s'),
                ]);
            }
        }

        return "OK";
    }
}
