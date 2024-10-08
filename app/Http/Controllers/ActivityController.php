<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Client;
use App\Contact;
use App\FileActivity;
use App\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Collective\Html\FormFacade as Form;
use RealRashid\SweetAlert\Facades\Alert;

class ActivityController extends Controller
{
    // List
    public function index(Request $request)
    {   
        $status = $request->query('status'); // Get the status from the query parameters

        $userId = Auth::id(); 
        $userByUser = Auth::user()->user_id; 

        $activities = Activity::with(['client'])
            ->when($request, function($query) use ($request, $userId, $userByUser) {
                $status = $request->input('status');
                if ($status == '10') {
                    $query->where('Status', '10')
                        ->where(function($query) use ($userId, $userByUser) {
                            $query->where('SecondaryResponsibleUserId', $userId)
                                ->orWhere('PrimaryResponsibleUserId', $userId)
                                ->orWhere('PrimaryResponsibleUserId', $userByUser)
                                ->orWhere('SecondaryResponsibleUserId', $userByUser);
                        });
                } else {
                    $query->where('Status', $status);
                }
            })
            ->when($request, function($query) use ($request, $userId, $userByUser) {
                $status = $request->input('status');
                if ($status == '20') {
                    $query->where('Status', '20')
                        ->where(function($query) use ($userId, $userByUser) {
                            $query->where('SecondaryResponsibleUserId', $userId)
                                ->orWhere('PrimaryResponsibleUserId', $userId)
                                ->orWhere('PrimaryResponsibleUserId', $userByUser)
                                ->orWhere('SecondaryResponsibleUserId', $userByUser);
                        });
                } else {
                    $query->where('Status', $status);
                }
            })
            ->when($request->has('open') && $request->has('close'), function($query)use($request) {
                $query->whereIn('Status', [$request->open, $request->close]);
            })
            ->when($request->has('open') && !$request->has('close'), function($query)use($request) {
                $query->where('Status', $request->open);
            })
            ->when($request->has('close') && !$request->has('open'), function($query)use($request) {
                $query->where('Status', $request->close);
            })
            ->when($request->search, function($query)use($request) {
                $query->where('ActivityNumber', 'LIKE', '%'. $request->search.'%')
                    ->orWhere('ScheduleFrom', 'LIKE', '%'.$request->search.'%')
                    ->orWhereHas('client', function($query)use($request) {
                        $query->where('Name', 'LIKE', '%'. $request->search.'%');
                    })
                    ->orWhere('Title', 'LIKE', '%'.$request->search.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $clients = Client::all();
        $contacts = Contact::all();
        $users = User::where('is_active', '1')->get();
        $currentUser = Auth::user();
        $open = $request->open;
        $close = $request->close;
        $search = $request->search;

        return view('activities.index', compact('activities', 'clients', 'contacts', 'users', 'currentUser', 'open', 'close', 'search')); 
    }

    // Store
    public function store(Request $request) 
    {
        $request->validate([
            'path.*' => 'mimes:jpg,pdf,docx,png'
        ]);

        $activityNumber = null;
        if (auth()->user()->department_id == 38)
        {
            $checkActivity = Activity::select('ActivityNumber')->where('ActivityNumber', 'LIKE', "%ACT-LS%")->orderBy('ActivityNumber', 'desc')->first();
            $count = substr($checkActivity->ActivityNumber, 10);
            $totalCount = $count + 1;
            $deptCode = 'LS';
            
            $activityNumber = 'ACT'.'-'.$deptCode.'-'.date('y').'-'.$totalCount;
        }

        if (auth()->user()->department_id == 5)
        {
            $checkActivity = Activity::select('ActivityNumber')->where('ActivityNumber', 'LIKE', "%ACT-IS%")->orderBy('ActivityNumber', 'desc')->first();
            $count = substr($checkActivity->ActivityNumber, 10);
            $totalCount = $count + 1;
            $deptCode = 'IS';
            
            $activityNumber = 'ACT'.'-'.$deptCode.'-'.date('y').'-'.$totalCount;
        }
        
        $activity = new Activity; 
        $activity->Type = $request->Type;
        $activity->ActivityNumber = $activityNumber;
        $activity->RelatedTo = $request->RelatedTo;
        $activity->ClientId = $request->ClientId;
        $activity->TransactionNumber = $request->TransactionNumber;
        $activity->ClientContactId = $request->ClientContactId;
        $activity->ScheduleFrom = $request->ScheduleFrom;
        $activity->PrimaryResponsibleUserId = $request->PrimaryResponsibleUserId;
        $activity->ScheduleTo = $request->ScheduleTo;
        $activity->SecondaryResponsibleUserId = $request->SecondaryResponsibleUserId;
        $activity->Title = $request->Title;
        $activity->DateClosed = $request->DateClosed;
        $activity->Description = $request->Description;
        $activity->Status = 10;
        $activity->save();
        
        $attachments = $request->file('path');
        foreach($attachments as $attachment)
        {
            $name = time().'_'.$attachment->getClientOriginalName();
            $attachment->move(public_path().'/activity_attachment/', $name);

            $file_name = '/activity_attachment/'.$name;
            
            $activityFiles = new FileActivity;
            $activityFiles->activity_id = $activity->id;
            $activityFiles->path = $file_name;
            $activityFiles->save();
        }
        
        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }
    
    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'path.*' => 'mimes:jpg,pdf,docx,png'
        ]);

        $activity = Activity::findOrFail($id);
        $activity->Type = $request->Type;
        $activity->RelatedTo = $request->RelatedTo;
        $activity->ClientId = $request->ClientId;
        $activity->TransactionNumber = $request->TransactionNumber;
        $activity->ClientContactId = $request->ClientContactId;
        $activity->ScheduleFrom = $request->ScheduleFrom;
        $activity->PrimaryResponsibleUserId = $request->PrimaryResponsibleUserId;
        $activity->ScheduleTo = $request->ScheduleTo;
        $activity->SecondaryResponsibleUserId = $request->SecondaryResponsibleUserId;
        $activity->Title = $request->Title;
        $activity->DateClosed = $request->DateClosed;
        $activity->Description = $request->Description;
        $activity->Status = $request->Status;
        $activity->Response = $request->Response;
        $activity->save();
        
        if ($request->has('path'))
        {
            $attachments = $request->file('path');
            foreach($attachments as $attachment)
            {
                $name = time().'_'.$attachment->getClientOriginalName();
                $attachment->move(public_path().'/activity_attachment/', $name);
    
                $file_name = '/activity_attachment/'.$name;
                
                $activityFiles = FileActivity::findOrFail($activity->id);
                $activityFiles->activity_id = $activity->id;
                $activityFiles->path = $file_name;
                $activityFiles->save();
            }
        }

        Alert::success('Successfully Update')->persistent('Dismiss');
        return back();
    }

    // View
    public function view($id)
    {
        $data = Activity::findOrFail($id);
        $users = User::all();

        // Retrieve the contact and handle null case
        $contact = Contact::find($data->ClientContactId);
        $contactName = $contact ? $contact->ContactName : 'N/A';
        $contactEmail = $contact ? $contact->EmailAddress : 'N/A';
        $contactMobile = $contact ? $contact->PrimaryMobile : 'Mobile not found';
        $contactSkype = $contact ? $contact->Skype : 'Skype not found';

        // Retrieve the client and handle null case
        $client = Client::find($data->ClientId);
        $clientName = $client->Name;
        $clientTelephone = $client->TelephoneNumber;

        // Find the primary and secondary responsible users
        $primaryResponsible = $users->firstWhere('user_id', $data->PrimaryResponsibleUserId) ?? $users->firstWhere('id', $data->PrimaryResponsibleUserId);
        $secondaryResponsible = $users->firstWhere('user_id', $data->SecondaryResponsibleUserId) ?? $users->firstWhere('id', $data->SecondaryResponsibleUserId);

        return view('activities.view', compact('data', 'primaryResponsible', 'secondaryResponsible', 'clientName', 'contactName', 'contactEmail', 'clientTelephone', 'contactMobile'));
    }

    public function refreshClientContact(Request $request)
    {
        $clientContact = Contact::where('CompanyId', $request->client_id)->get();
        
        $clientContactOptions = $clientContact->pluck('ContactName', 'id')->toArray();
        
        return Form::select('ClientContactId', $clientContactOptions, null, array('class' => 'form-control'));
    }

    public function close(Request $request)
    {
        $activity = Activity::findOrFail($request->id);
        $activity->status = 20;
        $activity->DateClosed = date('Y-m-d');
        $activity->save();

        return array('message' => 'Successfully Closed');
    }

    public function open(Request $request)
    {
        $activity = Activity::findOrFail($request->id);
        $activity->status = 10;
        $activity->save();

        return array('message' => 'Successfully Open');
    }

    public function delete($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();
    
        Alert::success('Successfully Deleted')->persistent('Dismiss');
        return back();
    }

    public function editClientContact(Request $request)
    {
        $client = Client::findOrFail($request->clientId);
        $clientContacts = Contact::where('CompanyId', $client->id)->get();
        
        $clientContactOptions = $clientContacts->pluck('ContactName', 'id')->toArray();
        
        return Form::select('ClientContactId', $clientContactOptions, null, array('class' => 'form-control'));
    }
}