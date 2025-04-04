<?php

namespace App\Exports;

use App\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProspectClientExport implements WithHeadings, FromCollection, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if (auth()->user()->role->type == "LS") {
            return Client::with(['industry', 'userById', 'userById2', 'userByUserId2'])
            ->where('Status', 2)
            ->where('Type', 1)
            ->orderBy('id', 'desc')
            ->get();
        } elseif (auth()->user()->role->type == "IS") {
            return Client::with(['industry', 'userById', 'userById2', 'userByUserId2'])
            ->where('Status', 2)
            ->where('Type', 2)
            ->orderBy('id', 'desc')
            ->get();
        } else {
            return Client::with(['industry', 'userById', 'userById2', 'userByUserId2'])
            ->where('Status', 2)
            ->orderBy('id', 'desc')
            ->get();
        }
    }

    public function headings(): array
    {
        return [
            'Type',
            'Industry',
            'Buyer Code',
            'Name',
            'Primary Account Manager',
            'Secondary Account Manager',
            'Contact Person',
            'Address',
            'Contact #',
            'Email'
        ];
    }
    
    public function map($currentClient): array
    {
        $type = $currentClient->Type == "1" ? "Local" : ($currentClient->Type == "2" ? "International" : "N/A");

        // Determine primary account manager's full name
        $primaryAccount = $currentClient->userById->full_name ?? $currentClient->userByUserId->full_name ?? 'N/A';

        // Determine secondary account manager's full name
        $secondaryAccount = $currentClient->userById2->full_name ?? $currentClient->userByUserId2->full_name ?? 'N/A';

        $contacts = $currentClient->contacts->pluck('ContactName')->toArray();
        $client_contacts = implode("\n", $contacts);
        
        $address = $currentClient->addresses->pluck('Address')->toArray();
        $client_address = implode("\n", $address);

        $contact_number_array = [];
        foreach($currentClient->contacts as $contact)
        {
            $contact_no = ($contact->PrimaryMobile ?? 'NA').'/'.($contact->SecondaryMobile ?? 'NA');
            $contact_number_array[] = $contact_no;
        }

        $client_contact_no = implode("\n",  $contact_number_array);
        
        $email = $currentClient->contacts->pluck('EmailAddress')->toArray();
        $email_address = implode("\n", $email);
        return [
            $type,
            $currentClient->industry->Name ?? 'N/A',
            $currentClient->BuyerCode ?? 'N/A',
            $currentClient->Name ?? 'N/A',
            $primaryAccount,
            $secondaryAccount,
            $client_contacts,
            $client_address,
            $client_contact_no,
            $email_address
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('G')->setWidth(40);
        $sheet->getColumnDimension('H')->setWidth(40);
        $sheet->getColumnDimension('I')->setWidth(40);
        $sheet->getColumnDimension('J')->setWidth(40);
        return [
            'G' => ['alignment' => ['wrapText' => true]],
            'H' => ['alignment' => ['wrapText' => true]],
            'I' => ['alignment' => ['wrapText' => true]],
            'J' => ['alignment' => ['wrapText' => true]],
        ];
    }
}
