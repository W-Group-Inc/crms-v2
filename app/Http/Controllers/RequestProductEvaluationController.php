<?php

namespace App\Http\Controllers;
use App\Activity;
use App\FileActivity;
use App\ProductEvaluation;
use App\Client;
use App\PriceCurrency;
use App\ProductApplication;
use App\ProjectName;
use App\RequestProductEvaluation;
use App\RpeDetail;
use App\RpeFile;
use App\RpePersonnel;
use App\SalesApprovers;
use App\SalesUser;
use App\TransactionApproval;
use App\TransactionLogs;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Models\Audit;
use RealRashid\SweetAlert\Facades\Alert;


class RequestProductEvaluationController extends Controller
{
    // List
    public function index(Request $request)
    {   
        $search = $request->input('search');
        $open = $request->open;
        $close = $request->close;
        $request_product_evaluations = RequestProductEvaluation::with(['client', 'product_application'])
        ->when($request->has('open') && $request->has('close'), function($query)use($request) {
            $query->whereIn('Status', [$request->open, $request->close]);
        })
        ->when($request->has('open') && !$request->has('close'), function($query)use($request) {
            $query->where('Status', $request->open);
        })
        ->when($request->has('close') && !$request->has('open'), function($query)use($request) {
            $query->where('Status', $request->close);
        })
        ->where(function ($query) use ($search){
            $query->where('RpeNumber', 'LIKE', '%' . $search . '%')
            ->orWhere('CreatedDate', 'LIKE', '%' . $search . '%')
            ->orWhere('DueDate', 'LIKE', '%' . $search . '%')
            ->orWhereHas('client', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('product_application', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            })
            ->orWhere('RpeResult', 'LIKE', '%' . $search . '%');
        })
        ->orderBy('id', 'desc')->paginate(10);
        $clients = Client::where('PrimaryAccountManagerId', auth()->user()->user_id)
        ->orWhere('SecondaryAccountManagerId', auth()->user()->user_id)
        ->get();
        // $users = User::all();
        $loggedInUser = Auth::user(); 
        $role = $loggedInUser->role;
        $withRelation = $role->type == 'LS' ? 'localSalesApprovers' : 'internationalSalesApprovers';
        if (($role->description == 'International Sales - Supervisor') || ($role->description == 'Local Sales - Supervisor')) {
            $salesApprovers = SalesApprovers::where('SalesApproverId', $loggedInUser->id)->pluck('UserId');
            $primarySalesPersons = User::whereIn('id', $salesApprovers)->orWhere('id', $loggedInUser->id)->get();
            $secondarySalesPersons = User::whereIn('id', $salesApprovers)->orWhere('id', $loggedInUser->id)->get();
            
        } else {
            $primarySalesPersons = User::with($withRelation)->where('id', $loggedInUser->id)->get();
            $secondarySalesPersons = User::whereIn('id', $loggedInUser->salesApprovers->pluck('SalesApproverId'))->get();
        }
        $price_currencies = PriceCurrency::all();
        $project_names = ProjectName::all();

        $product_applications = ProductApplication::all();
        return view('product_evaluations.index', compact('request_product_evaluations','clients', 'product_applications',  'price_currencies', 'project_names', 'search' , 'open', 'close', 'primarySalesPersons', 'secondarySalesPersons')); 
    }

    public function store(Request $request)
    {
        $user = Auth::user(); 
        $salesUser = SalesUser::where('SalesUserId', $user->user_id)->first();
        $type = $salesUser->Type == 2 ? 'IS' : 'LS';
        $year = Carbon::parse($request->input('CreatedDate'))->format('y');
        $lastEntry = RequestProductEvaluation::where('RpeNumber', 'LIKE', "RPE-{$type}-%")
                    ->orderBy('id', 'desc')
                    ->first();
        $lastNumber = $lastEntry ? intval(substr($lastEntry->RpeNumber, -4)) : 0;
        $newIncrement = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $rpeNo = "RPE-{$type}-{$year}-{$newIncrement}";

        $productEvaluationData = RequestProductEvaluation::create([
            'RpeNumber' => $rpeNo,
            'CreatedDate' => $request->input('CreatedDate'),
            'DueDate' => $request->input('DueDate'),
            'ClientId' => $request->input('ClientId'),
            'ApplicationId' => $request->input('ApplicationId'),
            'PotentialVolume' => $request->input('PotentialVolume'),
            'TargetRawPrice' => $request->input('TargetRawPrice'),
            'ProjectNameId' => $request->input('ProjectNameId'),
            'PrimarySalesPersonId' => $request->input('PrimarySalesPersonId'),
            'SecondarySalesPersonId' => $request->input('SecondarySalesPersonId'),
            'Priority' => $request->input('Priority'),
            'AttentionTo' => $request->input('AttentionTo'),
            'UnitOfMeasureId' => $request->input('UnitOfMeasureId'),
            'CurrencyId' => $request->input('CurrencyId'),
            'SampleName' => $request->input('SampleName'),
            'Supplier' => $request->input('Supplier'),
            'ObjectiveForRpeProject' => $request->input('ObjectiveForRpeProject'),
            'Status' =>'10',
            'Progress' => '10',
        ]);
                    return redirect()->back()->with('success', 'Base prices updated successfully.');
    }
    public function update(Request $request, $id)
    {
        $rpe = RequestProductEvaluation::with(['client', 'product_application'])->findOrFail($id);
        $rpe->DueDate = $request->input('DueDate');
        $rpe->ClientId = $request->input('ClientId');
        $rpe->ApplicationId = $request->input('ApplicationId');
        $rpe->PotentialVolume = $request->input('PotentialVolume');
        $rpe->TargetRawPrice = $request->input('TargetRawPrice');
        $rpe->ProjectNameId = $request->input('ProjectNameId');
        $rpe->PrimarySalesPersonId = $request->input('PrimarySalesPersonId');
        $rpe->SecondarySalesPersonId = $request->input('SecondarySalesPersonId');
        $rpe->Priority = $request->input('Priority');
        $rpe->AttentionTo = $request->input('AttentionTo');
        $rpe->UnitOfMeasureId = $request->input('UnitOfMeasureId');
        $rpe->CurrencyId = $request->input('CurrencyId');
        $rpe->SampleName = $request->input('SampleName');
        $rpe->Supplier = $request->input('Supplier');
        $rpe->ObjectiveForRpeProject = $request->input('ObjectiveForRpeProject');
        $rpe->Status = $request->input('Status');
        $rpe->save();
        return redirect()->back()->with('success', 'RPE updated successfully');
    }

    public function destroy($id)
    {
        try {
            $basePrice = RequestProductEvaluation::findOrFail($id); 
            $basePrice->delete();  
            return response()->json(['success' => true, 'message' => 'Request deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete Request.'], 500);
        }
    }

    public function view($id)
    {
        $requestEvaluation = RequestProductEvaluation::with(['client', 'product_application'])->findOrFail($id);
        $rpeNumber = $requestEvaluation->id;
        $RequestNumber = $requestEvaluation->RpeNumber;
        $clientId = $requestEvaluation->ClientId;
        $RpeSupplementary = RpeDetail::where('RequestProductEvaluationId', $rpeNumber)->get();
        $assignedPersonnel = RpePersonnel::where('RequestProductEvaluationId', $rpeNumber)->get();
        $rndPersonnel = User::whereHas('rndUsers')->get();
        $activities = Activity::where('TransactionNumber', $RequestNumber)->get();
        $rpeFileUploads = RpeFile::where('RequestProductEvaluationId', $rpeNumber)->get();
        $clients = Client::where('PrimaryAccountManagerId', auth()->user()->user_id)
        ->orWhere('SecondaryAccountManagerId', auth()->user()->user_id)
        ->get();
        $users = User::wherehas('localsalespersons')->get();
        $rpeTransactionApprovals  = TransactionApproval::where('TransactionId', $id)
        ->where('Type', '20')
        ->get();
        
        $transactionLogs = TransactionLogs::where('Type', '30')
        ->where('TransactionId', $rpeNumber)
        ->get();

        $audits = Audit::where('auditable_id', $rpeNumber)
        ->whereIn('auditable_type', [RequestProductEvaluation::class, RpeDetail::class, RpePersonnel::class, RpeFile::class])
        ->get();

        $mappedAudits = $audits->map(function ($audit) {
            $details = '';
            if ($audit->auditable_type === 'App\RpeFile') {
                $details = $audit->event . " " . 'RPE Files';
            } elseif ($audit->auditable_type === 'App\RpeDetail') {
                $details = $audit->event . " " . 'RPE Supplementary';
            } elseif ($audit->auditable_type === 'App\RpePersonnel') {
                $details = $audit->event . " " . 'RPE R&D Personnel';
            } elseif ($audit->auditable_type === 'App\RequestProductEvaluation') {
                $details = $audit->event . " " . 'Request Product Evaluation';
                // if (isset($audit->new_values['Progress']) && $audit->new_values['Progress'] == 20) {
                //     $details = "Approve sample request entry";
                // } elseif (isset($audit->new_values['Progress']) && ($audit->new_values['Progress'] == 30 || $audit->new_values['Progress'] == 80)) {
                //     $details = "Approve sample request entry";
                // } elseif (isset($audit->new_values['Progress']) && $audit->new_values['Progress'] == 35) {
                //     $details = "Receive sample request entry";
                // } elseif (isset($audit->new_values['Progress']) && $audit->new_values['Progress'] == 55) {
                //     $details = "Pause sample request transaction." . isset($audit->new_values['Remarks']);
                // } elseif (isset($audit->new_values['Progress']) && $audit->new_values['Progress'] == 50) {
                //     $details = "Start sample request transaction";
                // } else {
                //     $details = $audit->event . " " . 'Sample Request';
                // }
            }
            return (object) [
                'CreatedDate' => $audit->created_at,
                'full_name' => $audit->user->full_name,
                'Details' => $details,
            ];
        });
    
        $mappedLogs = $transactionLogs->map(function ($log) {
            return (object) [
                'CreatedDate' => $log->ActionDate,
                'full_name' => $log->historyUser->full_name,
                'Details' => $log->Details,
            ];
        });
    
        $mappedLogsCollection = collect($mappedLogs);
        $mappedAuditsCollection = collect($mappedAudits);
    
        $combinedLogs = $mappedLogsCollection->merge($mappedAuditsCollection);
        return view('product_evaluations.view', compact('requestEvaluation', 'rpeTransactionApprovals', 'RpeSupplementary', 'assignedPersonnel','rndPersonnel','activities', 'clients','users','rpeFileUploads', 'combinedLogs'));
    }

    public function addSupplementary(Request $request)
    {
        RpeDetail::create([
                'RequestProductEvaluationId' => $request->input('rpe_id'),
                'UserId' => auth()->user()->user_id,
                'DetailsOfRequest' => $request->input('details_of_request'),

            ]);
            return back();
    }

    public function editSupplementary(Request $request, $id)
    {
        $rpeDetail = RpeDetail::findOrFail($id);
        $rpeDetail->DetailsOfRequest = $request->input('details_of_request');
        $rpeDetail->save();
        return back();
    }

    public function deleteRpeDetails($id)
    {
        try { 
            $rpeDetail = RpeDetail::findOrFail($id); 
            $rpeDetail->delete();  
            return response()->json(['success' => true, 'message' => 'Supplementary Detail deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete supplementary detail.'], 500);
        }
    }

    public function assignPersonnel(Request $request)
    {
        RpePersonnel::create([
            'RequestProductEvaluationId' => $request->input('rpe_id'),
            'CreatedDate' => now(), 
            'PersonnelType' => 20,
            'PersonnelUserId' => $request->input('RndPersonnel'),
            ]);
            return back();
    }
    public function editPersonnel(Request $request, $id)
    {
        $rpePersonnel = RpePersonnel::findOrFail($id);
        $rpePersonnel->PersonnelUserId = $request->input('RndPersonnel');
        $rpePersonnel->save();
        return back();
    }
    public function deleteSrfPersonnel($id)
    {
        try { 
            $rpePersonnel = RpePersonnel::findOrFail($id); 
            $rpePersonnel->delete();  
            return response()->json(['success' => true, 'message' => 'Assigned Personnel deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete Assigned Personnel.'], 500);
        }
    }


    public function deleteActivity($id)
    {
        try { 
            $activity = Activity::findOrFail($id); 
            $activity->delete();  
            return response()->json(['success' => true, 'message' => 'File deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete File.'], 500);
        }
    }
    public function uploadFile(Request $request)
    {
        $files = $request->file('rpe_file');
        $names = $request->input('name');
        $rpeId = $request->input('rpe_id');
        
        if ($files) {
            foreach ($files as $index => $file) {
            $name = $names[$index];
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/rpeFiles', $fileName);
            $fileUrl = '/storage/rpeFiles/' . $fileName;       
            $uploadedFile = new RpeFile();
            $uploadedFile->RequestProductEvaluationId = $rpeId;
            $uploadedFile->Name = $name;
            $uploadedFile->Path = $fileUrl;
            $uploadedFile->save();
            }
        }
        
        return redirect()->back()->with('success', 'File(s) Stored successfully');
    }

    public function editFile(Request $request, $id)
    {
        $rpeFile = RpeFile::findOrFail($id);
        if ($request->has('name')) {
            $rpeFile->Name = $request->input('name');
        }
        if ($request->hasFile('rpe_file')) {
            $file = $request->file('rpe_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/rpeFiles', $fileName);
            $fileUrl = '/storage/rpeFiles/' . $fileName;

            $rpeFile->Path = $fileUrl;
        }

        $rpeFile->save();

        return redirect()->back()->with('success', 'File updated successfully');
    }
    public function deleteFile($id)
    {
        try { 
            $rpeFile = RpeFile::findOrFail($id); 
            $rpeFile->delete();  
            return response()->json(['success' => true, 'message' => 'Assigned Personnel deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete Assigned Personnel.'], 500);
        }
    }

    public function CancelRpe($id)
    {
        $cancelRpe = RequestProductEvaluation::find($id);    
        if ($cancelRpe) {
            $cancelRpe->Status = '50'; 
        }
            $cancelRpe->save();
            return back();
    }

    public function CloseRpe($id)
    {
        $closeRpe = RequestProductEvaluation::find($id);    
        if ($closeRpe) {
            $closeRpe->Status = '30'; 
        }
            $closeRpe->save();
            return back();
    }

}