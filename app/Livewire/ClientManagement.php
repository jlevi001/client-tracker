<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ClientManagement extends Component
{
    use WithFileUploads, WithPagination;

    // Search and filters
    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Modal state
    public $showAddModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showImportModal = false;

    // Form fields
    public $clientId;
    public $account_number;
    public $company_name;
    public $trading_name;
    public $website;
    public $email;
    public $phone;
    public $mobile;
    public $address_line_1;
    public $address_line_2;
    public $city;
    public $state;
    public $zip_code;
    public $country = 'United States';
    public $billing_address_same = true;
    public $billing_address_line_1;
    public $billing_address_line_2;
    public $billing_city;
    public $billing_state;
    public $billing_zip_code;
    public $billing_country;
    public $payment_terms = 'net30';
    public $tax_id;
    public $status = 'active';
    public $notes;
    public $default_hourly_rate = 130.00;

    // Hosting & Domain fields
    public $hosting_provider;
    public $hosting_managed_by;
    public $domain_registrar;
    public $domain_registrar_other;
    public $dns_managed_elsewhere = false;
    public $dns_provider;

    // CSV Import
    public $csvFile;
    public $csvPreviewData = [];
    public $csvErrors = [];
    public $csvCreateCount = 0;
    public $csvUpdateCount = 0;
    public $showCsvPreview = false;
    
    // Progress tracking
    public $isProcessing = false;
    public $progressCurrent = 0;
    public $progressTotal = 0;
    public $progressMessage = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected function rules()
    {
        return [
            'company_name' => 'required|string|max:255',
            'trading_name' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:255',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:10',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:50',
            'billing_address_line_1' => 'nullable|string|max:255',
            'billing_address_line_2' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:255',
            'billing_state' => 'nullable|string|max:10',
            'billing_zip_code' => 'nullable|string|max:20',
            'billing_country' => 'nullable|string|max:50',
            'payment_terms' => 'required|in:net15,net30,net45,net60,due_on_receipt',
            'tax_id' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,suspended',
            'notes' => 'nullable|string',
            'default_hourly_rate' => 'required|numeric|min:0|max:9999.99',
            'hosting_provider' => 'nullable|string|max:100',
            'hosting_managed_by' => 'nullable|in:lingo,client',
            'domain_registrar' => 'nullable|string|max:100',
            'domain_registrar_other' => 'nullable|string|max:100',
            'dns_managed_elsewhere' => 'boolean',
            'dns_provider' => 'nullable|string|max:100',
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function closeAddModal()
    {
        $this->showAddModal = false;
        $this->resetForm();
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->clientId = null;
    }

    public function closeImportModal()
    {
        $this->showImportModal = false;
        $this->resetImportState();
    }

    public function openEditModal($id)
    {
        $this->resetForm();
        $client = Client::findOrFail($id);
        
        $this->clientId = $client->id;
        $this->account_number = $client->account_number;
        $this->company_name = $client->company_name;
        $this->trading_name = $client->trading_name;
        $this->website = $client->website;
        $this->email = $client->email;
        $this->phone = $client->phone;
        $this->mobile = $client->mobile;
        $this->address_line_1 = $client->address_line_1;
        $this->address_line_2 = $client->address_line_2;
        $this->city = $client->city;
        $this->state = $client->state;
        $this->zip_code = $client->zip_code;
        $this->country = $client->country;
        $this->billing_address_same = $client->billing_address_same;
        $this->billing_address_line_1 = $client->billing_address_line_1;
        $this->billing_address_line_2 = $client->billing_address_line_2;
        $this->billing_city = $client->billing_city;
        $this->billing_state = $client->billing_state;
        $this->billing_zip_code = $client->billing_zip_code;
        $this->billing_country = $client->billing_country;
        $this->payment_terms = $client->payment_terms;
        $this->tax_id = $client->tax_id;
        $this->status = $client->status;
        $this->notes = $client->notes;
        $this->default_hourly_rate = $client->default_hourly_rate;
        $this->hosting_provider = $client->hosting_provider;
        $this->hosting_managed_by = $client->hosting_managed_by;
        $this->domain_registrar = $client->domain_registrar;
        $this->domain_registrar_other = $client->domain_registrar_other;
        $this->dns_managed_elsewhere = $client->dns_managed_elsewhere;
        $this->dns_provider = $client->dns_provider;
        
        $this->showEditModal = true;
    }

    public function openDeleteModal($id)
    {
        $this->clientId = $id;
        $this->showDeleteModal = true;
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'company_name' => $this->company_name,
                'trading_name' => $this->trading_name,
                'website' => $this->website,
                'email' => $this->email,
                'phone' => $this->phone,
                'mobile' => $this->mobile,
                'address_line_1' => $this->address_line_1,
                'address_line_2' => $this->address_line_2,
                'city' => $this->city,
                'state' => $this->state,
                'zip_code' => $this->zip_code,
                'country' => $this->country,
                'billing_address_same' => $this->billing_address_same,
                'billing_address_line_1' => $this->billing_address_line_1,
                'billing_address_line_2' => $this->billing_address_line_2,
                'billing_city' => $this->billing_city,
                'billing_state' => $this->billing_state,
                'billing_zip_code' => $this->billing_zip_code,
                'billing_country' => $this->billing_country,
                'payment_terms' => $this->payment_terms,
                'tax_id' => $this->tax_id,
                'status' => $this->status,
                'notes' => $this->notes,
                'default_hourly_rate' => $this->default_hourly_rate,
                'hosting_provider' => $this->hosting_provider,
                'hosting_managed_by' => $this->hosting_managed_by,
                'domain_registrar' => $this->domain_registrar,
                'domain_registrar_other' => $this->domain_registrar_other,
                'dns_managed_elsewhere' => $this->dns_managed_elsewhere,
                'dns_provider' => $this->dns_provider,
            ];

            if ($this->clientId) {
                // Update existing client
                $client = Client::findOrFail($this->clientId);
                $data['updated_by_id'] = Auth::id();
                $client->update($data);
                
                session()->flash('message', 'Client updated successfully.');
            } else {
                // Create new client
                $data['account_number'] = Client::generateAccountNumber($this->company_name);
                $data['created_by_id'] = Auth::id();
                Client::create($data);
                
                session()->flash('message', 'Client created successfully.');
            }

            $this->closeModals();
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving client: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        try {
            $client = Client::findOrFail($this->clientId);
            $client->delete();
            
            session()->flash('message', 'Client deleted successfully.');
            $this->closeModals();
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting client: ' . $e->getMessage());
        }
    }

    public function openImportModal()
    {
        $this->resetImportState();
        $this->showImportModal = true;
    }

    // CSV processing properties
    public $csvProcessingBatch = false;
    
    public function previewCsv()
    {
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        if (!$this->csvFile) {
            session()->flash('error', 'Please select a CSV file to upload.');
            return;
        }

        try {
            set_time_limit(300);
            
            $this->isProcessing = true;
            $this->progressCurrent = 0;
            $this->progressTotal = 0;
            $this->progressMessage = 'Reading file...';
            
            $path = $this->csvFile->getRealPath();
            
            if (!file_exists($path) || !is_readable($path)) {
                throw new \Exception('Unable to read uploaded file');
            }
            
            // Read and validate file
            $file = fopen($path, 'r');
            if ($file === false) {
                throw new \Exception('Failed to open CSV file');
            }
            
            $header = fgetcsv($file);
            if (!$header || !in_array('company_name', $header)) {
                fclose($file);
                session()->flash('error', 'Invalid CSV format. Required column: company_name');
                $this->isProcessing = false;
                return;
            }

            // Count total rows
            $totalRows = 0;
            while (fgets($file) !== false) {
                $totalRows++;
            }
            
            if ($totalRows === 0) {
                fclose($file);
                session()->flash('error', 'CSV file is empty');
                $this->isProcessing = false;
                return;
            }
            
            rewind($file);
            fgetcsv($file); // Skip header
            
            $this->progressTotal = $totalRows;
            $this->progressMessage = "Processing {$totalRows} rows...";
            
            // Pre-fetch existing clients
            $existingClients = Client::pluck('account_number', 'company_name')->toArray();
            $existingAccountNumbers = array_values($existingClients);
            
            $allPreviewData = [];
            $allErrors = [];
            $createCount = 0;
            $updateCount = 0;
            $generatedAccountNumbers = [];
            $currentRow = 0;
            
            // Process all rows
            while (($row = fgetcsv($file)) !== false) {
                $currentRow++;
                $this->progressCurrent = $currentRow;
                
                // Update progress every 25 rows
                if ($currentRow % 25 === 0) {
                    $this->progressMessage = "Processing row {$currentRow} of {$totalRows}...";
                }
                
                try {
                    // Combine with header, handling missing columns
                    $rowData = [];
                    foreach ($header as $index => $columnName) {
                        $rowData[$columnName] = $row[$index] ?? '';
                    }
                    
                    // Validate company_name
                    if (empty($rowData['company_name'])) {
                        $allErrors[] = "Row {$currentRow}: Missing required field 'company_name'";
                        continue;
                    }
                    
                    // Check if exists by account_number first
                    if (!empty($rowData['account_number']) && in_array($rowData['account_number'], $existingAccountNumbers)) {
                        $rowData['_action'] = 'update';
                        $rowData['_existing_account'] = $rowData['account_number'];
                        $updateCount++;
                    }
                    // Check by company_name (case-sensitive)
                    else if (isset($existingClients[$rowData['company_name']])) {
                        $rowData['_action'] = 'update';
                        $rowData['_existing_account'] = $existingClients[$rowData['company_name']];
                        $updateCount++;
                    }
                    else {
                        // Generate account number
                        $accountNumber = $this->generateUniqueAccountNumber(
                            $rowData['company_name'],
                            array_merge($existingAccountNumbers, $generatedAccountNumbers)
                        );
                        
                        $rowData['_action'] = 'create';
                        $rowData['_preview_account'] = $accountNumber;
                        $generatedAccountNumbers[] = $accountNumber;
                        $createCount++;
                    }
                    
                    $allPreviewData[] = $rowData;
                    
                } catch (\Exception $e) {
                    $allErrors[] = "Row {$currentRow}: " . $e->getMessage();
                }
            }
            
            fclose($file);
            
            $this->csvPreviewData = $allPreviewData;
            $this->csvErrors = $allErrors;
            $this->csvCreateCount = $createCount;
            $this->csvUpdateCount = $updateCount;
            $this->showCsvPreview = true;
            $this->isProcessing = false;
            $this->progressMessage = 'Preview complete!';
            
        } catch (\Exception $e) {
            $this->isProcessing = false;
            $this->progressMessage = 'Error: ' . $e->getMessage();
            session()->flash('error', 'Error parsing CSV: ' . $e->getMessage());
            \Log::error('CSV Preview Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
        }
    }

    /**
     * Generate unique account number checking existing numbers
     * Uses first 4 letters of first word + first 4 letters of second word
     * Example: "Arkansas Man Camp" -> "ARKAMANC"
     */
    private function generateUniqueAccountNumber($companyName, $existingNumbers = [])
    {
        // Remove special characters and convert to uppercase
        $cleanName = preg_replace('/[^A-Za-z0-9\s]/', '', $companyName);
        $cleanName = strtoupper(trim($cleanName));
        
        // Split into words
        $words = preg_split('/\s+/', $cleanName);
        $words = array_filter($words);
        
        $baseNumber = '';
        
        if (count($words) >= 2) {
            // Use first 4 letters of first word + first 4 letters of second word
            $firstWord = substr($words[0], 0, 4);
            $secondWord = substr($words[1], 0, 4);
            $baseNumber = $firstWord . $secondWord;
        } else if (count($words) === 1) {
            // Single word - use first 8 characters
            $baseNumber = substr($words[0], 0, 8);
        } else {
            // Fallback
            $baseNumber = substr(preg_replace('/[^A-Za-z0-9]/', '', $cleanName), 0, 8);
        }
        
        // Pad with zeros if less than 8 characters
        $baseNumber = str_pad($baseNumber, 8, '0', STR_PAD_RIGHT);
        
        // Check for duplicates
        $accountNumber = $baseNumber;
        $suffix = 2;
        
        while (in_array($accountNumber, $existingNumbers)) {
            $accountNumber = $baseNumber . $suffix;
            $suffix++;
        }
        
        return $accountNumber;
    }

    public function confirmImport()
    {
        try {
            // Increase execution time for large imports
            set_time_limit(300); // 5 minutes
            
            $this->isProcessing = true;
            $this->progressCurrent = 0;
            $this->progressTotal = count($this->csvPreviewData);
            $this->progressMessage = 'Starting import...';

            $chunkSize = 25;
            $imported = 0;
            $errors = [];

            foreach ($this->csvPreviewData as $index => $rowData) {
                $imported++;
                $this->progressCurrent = $imported;
                $this->progressMessage = "Importing {$imported} of {$this->progressTotal}...";
                
                // Force UI update every 10 records
                if ($imported % 10 === 0) {
                    usleep(100000); // 100ms delay to allow UI update
                }

                try {
                    $clientData = [
                        'company_name' => $rowData['company_name'] ?? null,
                        'trading_name' => $rowData['trading_name'] ?? null,
                        'website' => $rowData['website'] ?? null,
                        'email' => $rowData['email'] ?? null,
                        'phone' => $rowData['phone'] ?? null,
                        'mobile' => $rowData['mobile'] ?? null,
                        'address_line_1' => $rowData['address_line_1'] ?? null,
                        'address_line_2' => $rowData['address_line_2'] ?? null,
                        'city' => $rowData['city'] ?? null,
                        'state' => $rowData['state'] ?? null,
                        'zip_code' => $rowData['zip_code'] ?? null,
                        'country' => $rowData['country'] ?? 'United States',
                        'billing_address_same' => filter_var($rowData['billing_address_same'] ?? true, FILTER_VALIDATE_BOOLEAN),
                        'billing_address_line_1' => $rowData['billing_address_line_1'] ?? null,
                        'billing_address_line_2' => $rowData['billing_address_line_2'] ?? null,
                        'billing_city' => $rowData['billing_city'] ?? null,
                        'billing_state' => $rowData['billing_state'] ?? null,
                        'billing_zip_code' => $rowData['billing_zip_code'] ?? null,
                        'billing_country' => $rowData['billing_country'] ?? null,
                        'payment_terms' => $rowData['payment_terms'] ?? 'net30',
                        'tax_id' => $rowData['tax_id'] ?? null,
                        'status' => $rowData['status'] ?? 'active',
                        'notes' => $rowData['notes'] ?? null,
                        'default_hourly_rate' => $rowData['default_hourly_rate'] ?? 130.00,
                        'hosting_provider' => $rowData['hosting_provider'] ?? null,
                        'hosting_managed_by' => $rowData['hosting_managed_by'] ?? null,
                        'domain_registrar' => $rowData['domain_registrar'] ?? null,
                        'domain_registrar_other' => $rowData['domain_registrar_other'] ?? null,
                        'dns_managed_elsewhere' => filter_var($rowData['dns_managed_elsewhere'] ?? false, FILTER_VALIDATE_BOOLEAN),
                        'dns_provider' => $rowData['dns_provider'] ?? null,
                    ];

                    if ($rowData['_action'] === 'update') {
                        // Update existing client
                        $client = Client::where('account_number', $rowData['_existing_account'])->first();
                        if ($client) {
                            $clientData['updated_by_id'] = Auth::id();
                            $client->update($clientData);
                        }
                    } else {
                        // Create new client
                        $clientData['account_number'] = $rowData['_preview_account'];
                        $clientData['created_by_id'] = Auth::id();
                        Client::create($clientData);
                    }

                } catch (\Exception $e) {
                    $companyName = $rowData['company_name'] ?? 'Unknown';
                    $errors[] = "Row " . ($index + 1) . " ({$companyName}): " . $e->getMessage();
                }
            }

            // Clean up
            $this->isProcessing = false;
            $this->progressMessage = 'Import complete!';

            if (empty($errors)) {
                session()->flash('message', "CSV imported successfully! Created: {$this->csvCreateCount}, Updated: {$this->csvUpdateCount}");
            } else {
                session()->flash('error', 'Import completed with errors: ' . implode(', ', $errors));
            }

            $this->closeModals();
            
        } catch (\Exception $e) {
            $this->isProcessing = false;
            session()->flash('error', 'Error importing CSV: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'account_number',
            'company_name',
            'trading_name',
            'email',
            'phone',
            'mobile',
            'website',
            'address_line_1',
            'address_line_2',
            'city',
            'state',
            'zip_code',
            'country',
            'billing_address_same',
            'billing_address_line_1',
            'billing_address_line_2',
            'billing_city',
            'billing_state',
            'billing_zip_code',
            'billing_country',
            'payment_terms',
            'tax_id',
            'default_hourly_rate',
            'hosting_provider',
            'hosting_managed_by',
            'domain_registrar',
            'domain_registrar_other',
            'dns_managed_elsewhere',
            'dns_provider',
            'notes',
        ];

        $filename = 'client_import_template.csv';
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $headers);
        
        // Add example row
        $exampleRow = [
            'ACME0001', // account_number (optional - will auto-generate if blank)
            'ACME Corporation', // company_name (required)
            'ACME Co', // trading_name
            'contact@acme.com', // email
            '214-555-1234', // phone
            '214-555-5678', // mobile
            'https://www.acme.com', // website
            '123 Main Street', // address_line_1
            'Suite 100', // address_line_2
            'Dallas', // city
            'Texas', // state (will be abbreviated to TX)
            '75201', // zip_code
            'United States', // country
            'true', // billing_address_same
            '', // billing_address_line_1
            '', // billing_address_line_2
            '', // billing_city
            '', // billing_state
            '', // billing_zip_code
            '', // billing_country
            'net30', // payment_terms (net15, net30, net45, net60, due_on_receipt)
            '12-3456789', // tax_id
            '130.00', // default_hourly_rate
            'cloudways', // hosting_provider
            'lingo', // hosting_managed_by (lingo or client)
            'godaddy', // domain_registrar
            '', // domain_registrar_other
            'false', // dns_managed_elsewhere
            '', // dns_provider
            'Example client record', // notes
        ];
        fputcsv($handle, $exampleRow);
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function resetForm()
    {
        $this->reset([
            'clientId',
            'account_number',
            'company_name',
            'trading_name',
            'website',
            'email',
            'phone',
            'mobile',
            'address_line_1',
            'address_line_2',
            'city',
            'state',
            'zip_code',
            'billing_address_line_1',
            'billing_address_line_2',
            'billing_city',
            'billing_state',
            'billing_zip_code',
            'billing_country',
            'tax_id',
            'notes',
            'hosting_provider',
            'hosting_managed_by',
            'domain_registrar',
            'domain_registrar_other',
            'dns_managed_elsewhere',
            'dns_provider',
        ]);
        
        $this->country = 'United States';
        $this->billing_address_same = true;
        $this->payment_terms = 'net30';
        $this->status = 'active';
        $this->default_hourly_rate = 130.00;
        
        $this->resetErrorBag();
    }

    private function resetImportState()
    {
        $this->reset([
            'csvFile',
            'csvPreviewData',
            'csvErrors',
            'csvCreateCount',
            'csvUpdateCount',
            'showCsvPreview',
            'isProcessing',
            'progressCurrent',
            'progressTotal',
            'progressMessage',
        ]);
    }

    public function getCsvFileUploadedProperty()
    {
        return $this->csvFile !== null;
    }

    private function closeModals()
    {
        $this->showAddModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->showImportModal = false;
        $this->resetForm();
        $this->resetImportState();
    }

    public function render()
    {
        $clients = Client::query()
            ->when($this->search, function ($query) {
                $query->search($this->search);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.client-management', [
            'clients' => $clients,
            'hostingProviders' => Client::$hostingProviders,
            'domainRegistrars' => Client::$domainRegistrars,
        ]);
    }
}
