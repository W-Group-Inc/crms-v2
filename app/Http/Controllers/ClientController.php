<?php

namespace App\Http\Controllers;
use App\Client;
use App\Address;
use App\Country;
use App\User;
use App\PaymentTerms;
use App\Region;
use App\Area;
use App\BusinessType;
use App\Contact;
use App\FileClient;
use App\Industry;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Current List
    public function index(Request $request)
    {   
        // $clients = Client::with(['industry'])->where('Status', '2')->orderBy('Id', 'desc')->get();
        // if(request()->ajax())   
        // {
        //     return datatables()->of($clients)
        //             ->addColumn('action', function ($data) {
        //                 $viewButton = '<a type="button" href="' . route("client.view", ["id" => $data->id]) . '" name="view" id="' . $data->id . '" class="edit btn btn-success">View</a>';
        //                 $editButton = '<a type="button" href="' . route("client.edit", ["id" => $data->id]) . '" name="edit" id="' . $data->id . '" class="edit btn btn-primary">Edit</a>';
        //                 return $viewButton . '&nbsp;&nbsp;' . $editButton;
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);
        // }
        // return view('clients.index', compact('clients'));
        $request->session()->put('last_client_page', url()->full());
        $search = $request->input('search');
        $clients = Client::with(['industry', 'userById', 'userByUserId', 'userByUserId2'])
                        ->where('Status', '2')
                        ->where(function ($query) use ($search) {
                            $query->where('Type', 'LIKE', '%' . $search . '%')
                                ->orWhere('BuyerCode', 'LIKE', '%' . $search . '%')
                                ->orWhere('Name', 'LIKE', '%' . $search . '%')
                                ->orWhereHas('userById', function ($q) use ($search) {
                                    $q->where('full_name', 'LIKE', '%' . $search . '%');
                                })
                                ->orWhereHas('userByUserId', function ($q) use ($search) {
                                    $q->where('full_name', 'LIKE', '%' . $search . '%');
                                })
                                ->orWhereHas('userByUserId2', function ($q) use ($search) {
                                    $q->where('full_name', 'LIKE', '%' . $search . '%');
                                })
                                ->orWhereHas('industry', function ($q) use ($search) {
                                    $q->where('Name', 'LIKE', '%' . $search . '%');
                                });        
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(10);
        
        return view('clients.index', [
            'search' => $search,
            'clients' => $clients,
        ]);
    }

    // Prospect List
    public function prospect(Request $request)
    {   
        // $clients = Client::with(['industry'])->where('Status', '1')->orderBy('Id', 'desc')->get();
        // if(request()->ajax())   
        // {
        //     return datatables()->of($clients)
        //             ->addColumn('action', function ($data) {
        //                 $viewButton = '<a type="button" href="' . route("client.view", ["id" => $data->id]) . '" name="view" id="' . $data->id . '" class="edit btn btn-success">View</a>';
        //                 $editButton = '<a type="button" href="' . route("client.edit", ["id" => $data->id]) . '" name="edit" id="' . $data->id . '" class="edit btn btn-primary">Edit</a>';
        //                 return $viewButton . '&nbsp;&nbsp;' . $editButton;
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);
        // }
        // return view('clients.prospect', compact('clients')); 
        $request->session()->put('last_client_page', url()->full());
        $search = $request->input('search');
        $clients = Client::with(['industry', 'userById', 'userByUserId', 'userByUserId2'])
                        ->where('Status', '1')
                        ->where(function ($query) use ($search) {
                            $query->where('Type', 'LIKE', '%' . $search . '%')
                                ->orWhere('BuyerCode', 'LIKE', '%' . $search . '%')
                                ->orWhere('Name', 'LIKE', '%' . $search . '%')
                                ->orWhereHas('userById', function ($q) use ($search) {
                                    $q->where('full_name', 'LIKE', '%' . $search . '%');
                                })
                                ->orWhereHas('userByUserId', function ($q) use ($search) {
                                    $q->where('full_name', 'LIKE', '%' . $search . '%');
                                })
                                ->orWhereHas('userByUserId2', function ($q) use ($search) {
                                    $q->where('full_name', 'LIKE', '%' . $search . '%');
                                })
                                ->orWhereHas('industry', function ($q) use ($search) {
                                    $q->where('Name', 'LIKE', '%' . $search . '%');
                                });        
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(10);
        
        return view('clients.prospect', [
            'search' => $search,
            'clients' => $clients,
        ]);
    }

    // Archived List
    public function archived(Request $request)
    {   
        // $clients = Client::with(['industry'])->where('Status', '5')->orderBy('Id', 'desc')->get();
        // if(request()->ajax())   
        // {
        //     return datatables()->of($clients)
        //             ->addColumn('action', function ($data) {
        //                 $viewButton = '<a type="button" href="' . route("client.view", ["id" => $data->id]) . '" name="view" id="' . $data->id . '" class="edit btn btn-success">View</a>';
        //                 $editButton = '<a type="button" href="' . route("client.edit", ["id" => $data->id]) . '" name="edit" id="' . $data->id . '" class="edit btn btn-primary">Edit</a>';
        //                 return $viewButton . '&nbsp;&nbsp;' . $editButton;
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);
        // }
        // return view('clients.archived', compact('clients')); 
        $request->session()->put('last_client_page', url()->full());
        $search = $request->input('search');
        $clients = Client::with(['industry', 'userById', 'userByUserId', 'userByUserId2'])
                        ->where('Status', '5')
                        ->where(function ($query) use ($search) {
                            $query->where('Type', 'LIKE', '%' . $search . '%')
                                ->orWhere('BuyerCode', 'LIKE', '%' . $search . '%')
                                ->orWhere('Name', 'LIKE', '%' . $search . '%')
                                ->orWhereHas('userById', function ($q) use ($search) {
                                    $q->where('full_name', 'LIKE', '%' . $search . '%');
                                })
                                ->orWhereHas('userByUserId', function ($q) use ($search) {
                                    $q->where('full_name', 'LIKE', '%' . $search . '%');
                                })
                                ->orWhereHas('userByUserId2', function ($q) use ($search) {
                                    $q->where('full_name', 'LIKE', '%' . $search . '%');
                                })
                                ->orWhereHas('industry', function ($q) use ($search) {
                                    $q->where('Name', 'LIKE', '%' . $search . '%');
                                });        
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(10);
        
        return view('clients.archived', [
            'search' => $search,
            'clients' => $clients,
        ]);
    }
    
    // Create
    public function create()
    {
        $data = [
            'clients'           => Client::all(),
            'users'             => User::all(),
            'payment_terms'     => PaymentTerms::all(),
            'regions'           => Region::all(),
            'countries'         => Country::all(),
            'areas'             => Area::all(),
            'business_types'    => BusinessType::all(),
            'industries'        => Industry::all(),
            'buyerCode'         => 'BCODE-' . now()->format('Ymd-His'),
        ];
        
        return view('clients.create', $data);
    }

    public function getRegions(Request $request)
    {
        $type = $request->input('type');
        $regions = Region::where('Type', $type)->get(['id', 'name']); // Adjust field names if needed
        return response()->json($regions);
    }

    public function getAreas(Request $request)
    {
        $regionId = $request->input('regionId');
        $areas = Area::where('RegionId', $regionId)->get(['id', 'name']); // Adjust field names if needed
        return response()->json($areas);
    }

    // Store
    public function store(Request $request)
    {
        $rules = [
            'BuyerCode'                 => 'required|string|max:255',
            'PrimaryAccountManagerId'   => 'required|string',
            'Name'                      => 'required|string|max:255',
            'Type'                      => 'required|string|max:255',
            'ClientRegionId'            => 'required|string',
            'ClientAreaId'              => 'required|string',
            'ClientCountryId'           => 'required|string',        
            'ClientAreaId'              => 'required|string|max:255',
            'BusinessTypeId'            => 'required|string|max:255',
            'AddressType'               => 'required|array',
            'AddressType.*'             => 'required|string|max:255',
            'Address'                   => 'required|array',
            'Address.*'                 => 'required|string|max:255',
        ];  

        $customMessages = [
            'PrimaryAccountManagerId.required'  => 'The primary account manager field is required.',
            'Name.required'                     => 'The company name is required.',
            'ClientRegionId.required'           => 'The region field is required.',
            'ClientCountryId.required'          => 'The country field is required.',
            'ClientAreaId.required'             => 'The area field is required.',
            'BusinessTypeId.required'           => 'The business type is required.',
            'ClientIndustryId.required'         => 'The industry is required.',
            'AddressType.*.required'            => 'Each address type is required.',
            'Address.*.required'                => 'Each address is required.'
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->toArray()]);
        }
        // Create client
        $client = Client::create($request->only([
            'BuyerCode', 'PrimaryAccountManagerId', 'SapCode', 'SecondaryAccountManagerId',
            'Name', 'TradeName', 'TaxIdentificationNumber', 'TelephoneNumber', 'PaymentTermId',
            'FaxNumber', 'Type', 'Website', 'ClientRegionId', 'Email', 'ClientCountryId',
            'Source', 'ClientAreaId', 'BusinessTypeId', 'ClientIndustryId'
        ]));
        
        // Handle addresses if provided
        if ($request->has('AddressType') && $request->has('Address')) {
            foreach ($request->AddressType as $key => $addressType) {
                if (!empty($addressType) && !empty($request->Address[$key])) {
                    Address::create([
                        'CompanyId' => $client->id,
                        'AddressType' => $addressType,
                        'Address' => $request->Address[$key]
                    ]);
                }
            }
        }
       
        // Return success message
        return response()->json(['success' => 'Data Added Successfully.']);
    }

    // Edit
    public function edit($id)
    {
        $data = Client::findOrFail($id);
        $addresses = Address::where('CompanyId', $id)->get();
        $contacts = Contact::where('CompanyId', $id)->get();
        $files = FileClient::where('ClientId', $id)->get();
        $users = User::where('is_active', '1')->whereNull('deleted_at')->get();
        // dd($addresses);
        $collections = [
            'business_types' => BusinessType::all(),
            'payment_terms' => PaymentTerms::all(),
            'regions' => Region::all(),
            'countries' => Country::all(),
            'areas' => Area::all(),
            'industries' => Industry::all()
        ];
        
        return view('clients.edit', array_merge([
            'data' => $data,
            'users' => $users,
            'addresses' => $addresses,
            'contacts' => $contacts,
            'files' => $files
        ], $collections));
    }

    // Update
    public function update(Request $request, $id)
    {
        $rules = [
            'BuyerCode'                 => 'required|string|max:255',
            'PrimaryAccountManagerId'   => 'required|string',
            'Name'                      => 'required|string|max:255',
            'Type'                      => 'required|string|max:255',
            'ClientRegionId'            => 'required|string',
            'ClientAreaId'              => 'required|string',
            'ClientCountryId'           => 'required|string',
            'BusinessTypeId'            => 'required|string|max:255',
            'AddressIds'                => 'array', // Validate address IDs
            'AddressIds.*'              => 'nullable|integer|exists:clientcompanyaddresses,id',
            'AddressType'               => 'array|required',
            'AddressType.*'             => 'required|string|max:255',
            'Address'                   => 'array|required',
            'Address.*'                 => 'required|string|max:255',
        ];

        $customMessages = [
            'PrimaryAccountManagerId.required'  => 'The primary account manager field is required.',
            'Name.required'                     => 'The company name is required.',
            'ClientRegionId.required'           => 'The region field is required.',
            'ClientCountryId.required'          => 'The country field is required.',
            'ClientAreaId.required'             => 'The area field is required.',
            'BusinessTypeId.required'           => 'The business type is required.',
            'ClientIndustryId.required'         => 'The industry is required.',
            'AddressIds.*.exists'               => 'The address ID is invalid.',
            'AddressType.*.required'            => 'Each address type is required.',
            'Address.*.required'                => 'Each address is required.'
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->toArray()]);
        }

        // Update client details
        $client = Client::findOrFail($id);
        $client->update($request->only([
            'BuyerCode', 'PrimaryAccountManagerId', 'SapCode', 'SecondaryAccountManagerId',
            'Name', 'TradeName', 'TaxIdentificationNumber', 'TelephoneNumber', 'PaymentTermId',
            'FaxNumber', 'Type', 'Website', 'ClientRegionId', 'Email', 'ClientCountryId',
            'Source', 'ClientAreaId', 'BusinessTypeId', 'ClientIndustryId'
        ]));

        // Handle addresses
        if ($request->has('AddressType') && $request->has('Address')) {
            foreach ($request->AddressType as $key => $addressType) {
                if (!empty($addressType) && !empty($request->Address[$key])) {
                    $addressId = $request->AddressIds[$key] ?? null;
                    if ($addressId) {
                        // Update existing address
                        $address = Address::findOrFail($addressId);
                        $address->update([
                            'AddressType' => $addressType,
                            'Address' => $request->Address[$key]
                        ]);
                    } else {
                        // Create new address
                        Address::create([
                            'CompanyId' => $client->id,
                            'AddressType' => $addressType,
                            'Address' => $request->Address[$key]
                        ]);
                    }
                }
            }
        }

        // Return success message
        return response()->json(['success' => 'Data Updated Successfully.']);
    }

    // View
    public function view($id) 
    {
        $data = Client::with('activities')->findOrFail($id);
        $addresses = Address::where('CompanyId', $id)->get();
        $users = User::all();
        $payment_terms = PaymentTerms::find($data->PaymentTermId);
        $regions = Region::find($data->ClientRegionId);
        $countries = Country::find($data->ClientCountryId);
        $areas = Area::find($data->ClientAreaId);
        $business_types = BusinessType::find($data->BusinessTypeId);
        $industries = Industry::find($data->ClientIndustryId);

        $primaryAccountManager = $users->firstWhere('user_id', $data->PrimaryAccountManagerId) ?? $users->firstWhere('id', $data->PrimaryAccountManagerId);
        $secondaryAccountManager = $users->firstWhere('user_id', $data->SecondaryAccountManagerId) ?? $users->firstWhere('id', $data->SecondaryAccountManagerId);

        // Ensure secondaryAccountManager is null if not found
        if (is_null($data->SecondaryAccountManagerId)) {
            $secondaryAccountManager = null;
        }

        $activities = $data->activities;

        return view('clients.view', compact(
            'data', 'primaryAccountManager', 'secondaryAccountManager', 'payment_terms', 
            'regions', 'countries', 'areas', 'business_types', 'industries', 'addresses', 'activities'
        ));
    }

    // Activate Client
    public function activateClient($id) 
    {
        $client = Client::findOrFail($id);

        $client->Status = '2';
        $client->save();

        return response()->json(['message' => 'Client status updated to current successfully!']);
    }
    
    // Prospect Client
    public function prospectClient(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $client->Status = '1';
        $client->save();

        return response()->json(['message' => 'Client status updated to prospect successfully!']);
    }

    // Delete Client
    public function delete($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully!']);
    }

    // Archived Client
    public function archivedClient($id)
    {
        $client = Client::findOrFail($id);

        $client->Status = '5';
        $client->save();

        return response()->json(['message' => 'Client status updated to archived successfully!']);
    }

    // Add File
    public function addFiles(Request $request)
    {
        $clientId = $request->ClientId;
        $fileNames = $request->FileName;
        $files = $request->file('Path');

        // Check if file names and files are both arrays and not empty
        if (!is_array($fileNames) || !is_array($files) || empty($fileNames) || empty($files)) {
            return response()->json(['error' => 'No files or file names provided'], 400);
        }

        try {
            foreach ($files as $index => $file) {
                // Check if the file is valid
                if ($file && $file->isValid()) {
                    $fileClient = new FileClient;
                    $fileClient->ClientId = $clientId;
                    $fileClient->FileName = $fileNames[$index];

                    // Generate a unique file name and move the file
                    $fileName = time().'_'.$file->getClientOriginalName();
                    $file->move(public_path('attachments'), $fileName);

                    // Save the file path to the database
                    $fileClient->Path = "/attachments/" . $fileName;
                    $fileClient->save();
                }
            }

            return response()->json(['success' => 'Files successfully uploaded']);
        } catch (\Exception $e) {
            // Return a JSON response with an error message
            return response()->json(['error' => 'Error uploading files', 'message' => $e->getMessage()], 500);
        }
    }

    // Edit File
    public function editFile(Request $request, $id)
    {
        // Find the file client by ID
        $fileClient = FileClient::findOrFail($id);

        // Update the file client details
        $fileClient->FileName = $request->FileName;

        // Check if a new file is uploaded
        if ($request->hasFile('Path')) {
            $file = $request->file('Path');
            if ($file && $file->isValid()) {
                // Generate a unique file name and move the file
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('attachments'), $fileName);

                // Update the file path
                $fileClient->Path = "/attachments/" . $fileName;
            }
        }

        // Save the updated file client
        $fileClient->save();

        return response()->json(['success' => 'File updated successfully']);
    }

    // Delete File
    public function deleteFile($id)
    {
        $contact = FileClient::findOrFail($id);
        $contact->delete();

        return response()->json(['message' => 'File deleted successfully!']);
    }

}
