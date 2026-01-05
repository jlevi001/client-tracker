<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClientManagement extends Component
{
    use WithPagination, WithFileUploads;

    // Event listeners
    protected $listeners = ['process-next-batch' => 'processNextBatch'];

    // Modal states
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showImportModal = false;
    public $showImportPreview = false;

    // Client form fields
    public $clientId;
    public $accountNumber;
    public $companyName;
    public $tradingName;
    public $website;
    public $email;
    public $phone;
    public $mobile;
    public $addressLine1;
    public $addressLine2;
    public $city;
    public $state;
    public $zipCode;
    public $country = 'United States';
    public $billingAddressSame = true;
    public $billingAddressLine1;
    public $billingAddressLine2;
    public $billingCity;
    public $billingState;
    public $billingZipCode;
    public $billingCountry;
    public $paymentTerms = 'net30';
    public $taxId;
    public $defaultHourlyRate = 130.00;
    public $status = 'active';
    public $notes;

    // CSV Import fields
    public $csvFile;
    public $importData = [];
    public $importErrors = [];
    public $importNewCount = 0;
    public $importUpdateCount = 0;
    public $importErrorCount = 0;

    // Batched import progress tracking
    public $isImporting = false;
    public $importProgress = 0;
    public $importTotal = 0;
    public $importProcessed = 0;
    public $importCreated = 0;
    public $importUpdated = 0;
    public $currentBatchIndex = 0;

    // Search, sort, pagination
    public $search = '';
    public $sortField = 'company_name';
    public $sortDirection = 'asc';
    public $perPage = 10;

    // Preview for account number
    public $accountNumberPreview = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'company_name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function mount()
    {
        $this->search = '';
    }

    protected function rules()
    {
        $rules = [
            'companyName' => ['required', 'string', 'max:255'],
            'tradingName' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'mobile' => ['nullable', 'string', 'max:50'],
            'addressLine1' => ['nullable', 'string', 'max:255'],
            'addressLine2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:100'],
            'zipCode' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'billingAddressSame' => ['boolean'],
            'billingAddressLine1' => ['nullable', 'string', 'max:255'],
            'billingAddressLine2' => ['nullable', 'string', 'max:255'],
            'billingCity' => ['nullable', 'string', 'max:255'],
            'billingState' => ['nullable', 'string', 'max:100'],
            'billingZipCode' => ['nullable', 'string', 'max:20'],
            'billingCountry' => ['nullable', 'string', 'max:100'],
            'paymentTerms' => ['required', Rule::in(['net15', 'net30', 'net45', 'net60', 'due_on_receipt'])],
            'taxId' => ['nullable', 'string', 'max:50'],
            'defaultHourlyRate' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
            'notes' => ['nullable', 'string', 'max:5000'],
        ];

        return $rules;
    }

    protected $messages = [
        'companyName.required' => 'Company name is required.',
        'email.email' => 'Please enter a valid email address.',
        'website.url' => 'Please enter a valid URL (include http:// or https://).',
        'defaultHourlyRate.required' => 'Default hourly rate is required.',
        'defaultHourlyRate.numeric' => 'Hourly rate must be a number.',
        'defaultHourlyRate.min' => 'Hourly rate cannot be negative.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedCompanyName($value)
    {
        // Generate preview of account number
        if (!empty($value)) {
            $this->accountNumberPreview = Client::generateAccountNumber($value);
        } else {
            $this->accountNumberPreview = '';
        }
    }

    public function updatedCsvFile()
    {
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt|max:10240', // 10MB max
        ]);

        $this->processImportCsv();
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

    public function openCreateModal()
    {
        $this->resetForm();
        $this->resetValidation();
        $this->showCreateModal = true;
    }

    public function openEditModal($clientId)
    {
        $this->resetValidation();
        $client = Client::findOrFail($clientId);

        $this->clientId = $client->id;
        $this->accountNumber = $client->account_number;
        $this->companyName = $client->company_name;
        $this->tradingName = $client->trading_name;
        $this->website = $client->website;
        $this->email = $client->email;
        $this->phone = $client->phone;
        $this->mobile = $client->mobile;
        $this->addressLine1 = $client->address_line_1;
        $this->addressLine2 = $client->address_line_2;
        $this->city = $client->city;
        $this->state = $client->state;
        $this->zipCode = $client->zip_code;
        $this->country = $client->country ?? 'United States';
        $this->billingAddressSame = $client->billing_address_same;
        $this->billingAddressLine1 = $client->billing_address_line_1;
        $this->billingAddressLine2 = $client->billing_address_line_2;
        $this->billingCity = $client->billing_city;
        $this->billingState = $client->billing_state;
        $this->billingZipCode = $client->billing_zip_code;
        $this->billingCountry = $client->billing_country;
        $this->paymentTerms = $client->payment_terms ?? 'net30';
        $this->taxId = $client->tax_id;
        $this->defaultHourlyRate = $client->default_hourly_rate ?? 130.00;
        $this->status = $client->status ?? 'active';
        $this->notes = $client->notes;

        $this->showEditModal = true;
    }

    public function openDeleteModal($clientId)
    {
        $this->clientId = $clientId;
        $this->showDeleteModal = true;
    }

    public function openImportModal()
    {
        $this->reset(['csvFile', 'importData', 'importErrors', 'importNewCount', 'importUpdateCount', 'importErrorCount']);
        $this->resetImportProgress();
        $this->showImportPreview = false;
        $this->showImportModal = true;
    }

    protected function resetImportProgress()
    {
        $this->isImporting = false;
        $this->importProgress = 0;
        $this->importTotal = 0;
        $this->importProcessed = 0;
        $this->importCreated = 0;
        $this->importUpdated = 0;
        $this->currentBatchIndex = 0;
    }

    public function createClient()
    {
        $this->validate();

        $client = Client::create([
            'company_name' => $this->companyName,
            'trading_name' => $this->tradingName,
            'website' => $this->website,
            'email' => $this->email,
            'phone' => Client::formatPhoneNumber($this->phone),
            'mobile' => Client::formatPhoneNumber($this->mobile),
            'address_line_1' => $this->addressLine1,
            'address_line_2' => $this->addressLine2,
            'city' => $this->city,
            'state' => Client::abbreviateState($this->state, $this->country),
            'zip_code' => $this->zipCode,
            'country' => $this->country,
            'billing_address_same' => $this->billingAddressSame,
            'billing_address_line_1' => $this->billingAddressLine1,
            'billing_address_line_2' => $this->billingAddressLine2,
            'billing_city' => $this->billingCity,
            'billing_state' => Client::abbreviateState($this->billingState, $this->billingCountry ?? $this->country),
            'billing_zip_code' => $this->billingZipCode,
            'billing_country' => $this->billingCountry,
            'payment_terms' => $this->paymentTerms,
            'tax_id' => $this->taxId,
            'default_hourly_rate' => $this->defaultHourlyRate,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_by_id' => Auth::id(),
        ]);

        $this->showCreateModal = false;
        $this->resetForm();
        session()->flash('success', "Client '{$client->company_name}' created successfully.");
    }

    public function updateClient()
    {
        $this->validate();

        $client = Client::findOrFail($this->clientId);

        $client->update([
            'company_name' => $this->companyName,
            'trading_name' => $this->tradingName,
            'website' => $this->website,
            'email' => $this->email,
            'phone' => Client::formatPhoneNumber($this->phone),
            'mobile' => Client::formatPhoneNumber($this->mobile),
            'address_line_1' => $this->addressLine1,
            'address_line_2' => $this->addressLine2,
            'city' => $this->city,
            'state' => Client::abbreviateState($this->state, $this->country),
            'zip_code' => $this->zipCode,
            'country' => $this->country,
            'billing_address_same' => $this->billingAddressSame,
            'billing_address_line_1' => $this->billingAddressLine1,
            'billing_address_line_2' => $this->billingAddressLine2,
            'billing_city' => $this->billingCity,
            'billing_state' => Client::abbreviateState($this->billingState, $this->billingCountry ?? $this->country),
            'billing_zip_code' => $this->billingZipCode,
            'billing_country' => $this->billingCountry,
            'payment_terms' => $this->paymentTerms,
            'tax_id' => $this->taxId,
            'default_hourly_rate' => $this->defaultHourlyRate,
            'status' => $this->status,
            'notes' => $this->notes,
            'updated_by_id' => Auth::id(),
        ]);

        $this->showEditModal = false;
        $this->resetForm();
        session()->flash('success', "Client '{$client->company_name}' updated successfully.");
    }

    public function deleteClient()
    {
        $client = Client::findOrFail($this->clientId);
        $companyName = $client->company_name;

        $client->delete();

        $this->showDeleteModal = false;
        $this->clientId = null;
        session()->flash('success', "Client '{$companyName}' deleted successfully.");
    }

    public function processImportCsv()
    {
        if (!$this->csvFile) {
            return;
        }

        $this->importData = [];
        $this->importErrors = [];
        $this->importNewCount = 0;
        $this->importUpdateCount = 0;
        $this->importErrorCount = 0;

        try {
            $path = $this->csvFile->getRealPath();
            $file = fopen($path, 'r');

            // Get headers
            $headers = fgetcsv($file);
            if (!$headers) {
                $this->addError('csvFile', 'Invalid CSV file: no headers found.');
                return;
            }

            // Normalize headers
            $headers = array_map('trim', $headers);
            $headers = array_map('strtolower', $headers);

            // Required column
            if (!in_array('company_name', $headers)) {
                $this->addError('csvFile', 'CSV must contain a "company_name" column.');
                return;
            }

            $rowNumber = 1; // Start at 1 (header is row 0)
            while (($row = fgetcsv($file)) !== false) {
                $rowNumber++;

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Map row to associative array
                $data = array_combine($headers, $row);

                // Validate required field
                if (empty($data['company_name'])) {
                    $this->importErrors[] = [
                        'row' => $rowNumber,
                        'message' => 'Missing required field: company_name'
                    ];
                    $this->importErrorCount++;
                    continue;
                }

                // Check if this is an update or create
                $isUpdate = false;
                $existingId = null;

                if (!empty($data['account_number'])) {
                    $existing = Client::where('account_number', trim($data['account_number']))->first();
                    if ($existing) {
                        $isUpdate = true;
                        $existingId = $existing->id;
                    }
                }

                // Add to import data
                $this->importData[] = array_merge($data, [
                    'row_number' => $rowNumber,
                    'is_update' => $isUpdate,
                    'existing_id' => $existingId,
                ]);

                if ($isUpdate) {
                    $this->importUpdateCount++;
                } else {
                    $this->importNewCount++;
                }
            }

            fclose($file);

            // Show preview
            $this->showImportPreview = true;

        } catch (\Exception $e) {
            $this->addError('csvFile', 'Error processing CSV: ' . $e->getMessage());
        }
    }

    public function confirmImport()
    {
        if (empty($this->importData)) {
            session()->flash('error', 'No valid data to import.');
            return;
        }

        // Initialize progress tracking
        $this->importTotal = count($this->importData);
        $this->importProcessed = 0;
        $this->importCreated = 0;
        $this->importUpdated = 0;
        $this->currentBatchIndex = 0;
        $this->isImporting = true;
        $this->importProgress = 0;

        // Start processing first batch
        $this->processNextBatch();
    }

    public function processNextBatch()
    {
        if (!$this->isImporting) {
            return;
        }

        $batchSize = 25;
        $startIndex = $this->currentBatchIndex * $batchSize;
        $batch = array_slice($this->importData, $startIndex, $batchSize);

        if (empty($batch)) {
            // All batches processed - complete the import
            $this->completeImport();
            return;
        }

        foreach ($batch as $data) {
            // Prepare the data for database
            $clientData = [
                'company_name' => $data['company_name'],
                'trading_name' => $data['trading_name'] ?? null,
                'email' => $data['email'] ?? null,
                'phone' => !empty($data['phone']) ? Client::formatPhoneNumber($data['phone']) : null,
                'mobile' => !empty($data['mobile']) ? Client::formatPhoneNumber($data['mobile']) : null,
                'website' => $data['website'] ?? null,
                'address_line_1' => $data['address_line_1'] ?? null,
                'address_line_2' => $data['address_line_2'] ?? null,
                'city' => $data['city'] ?? null,
                'state' => !empty($data['state']) ? Client::abbreviateState($data['state'], $data['country'] ?? 'United States') : null,
                'zip_code' => $data['zip_code'] ?? null,
                'country' => $data['country'] ?? 'United States',
                'billing_address_same' => isset($data['billing_address_same']) ? filter_var($data['billing_address_same'], FILTER_VALIDATE_BOOLEAN) : true,
                'billing_address_line_1' => $data['billing_address_line_1'] ?? null,
                'billing_address_line_2' => $data['billing_address_line_2'] ?? null,
                'billing_city' => $data['billing_city'] ?? null,
                'billing_state' => !empty($data['billing_state']) ? Client::abbreviateState($data['billing_state'], $data['billing_country'] ?? $data['country'] ?? 'United States') : null,
                'billing_zip_code' => $data['billing_zip_code'] ?? null,
                'billing_country' => $data['billing_country'] ?? null,
                'payment_terms' => !empty($data['payment_terms']) ? strtolower($data['payment_terms']) : 'net30',
                'tax_id' => $data['tax_id'] ?? null,
                'default_hourly_rate' => !empty($data['default_hourly_rate']) ? (float) $data['default_hourly_rate'] : 130.00,
                'notes' => $data['notes'] ?? null,
            ];

            if ($data['is_update'] && isset($data['existing_id'])) {
                // Update existing client
                $client = Client::find($data['existing_id']);
                if ($client) {
                    $clientData['updated_by_id'] = Auth::id();
                    $client->update($clientData);
                    $this->importUpdated++;
                }
            } else {
                // Create new client
                $clientData['status'] = 'active';
                $clientData['created_by_id'] = Auth::id();
                Client::create($clientData);
                $this->importCreated++;
            }

            $this->importProcessed++;
        }

        // Update progress
        $this->importProgress = round(($this->importProcessed / $this->importTotal) * 100);
        $this->currentBatchIndex++;

        // Check if there are more batches
        if ($this->importProcessed < $this->importTotal) {
            // Dispatch next batch processing (allows UI to update)
            $this->dispatch('process-next-batch');
        } else {
            $this->completeImport();
        }
    }

    protected function completeImport()
    {
        $created = $this->importCreated;
        $updated = $this->importUpdated;

        $this->showImportModal = false;
        $this->showImportPreview = false;
        $this->reset(['csvFile', 'importData', 'importErrors', 'importNewCount', 'importUpdateCount', 'importErrorCount']);
        $this->resetImportProgress();

        session()->flash('success', "Import completed: {$created} clients created, {$updated} clients updated.");
    }

    public function cancelImport()
    {
        $this->isImporting = false;
        $this->showImportPreview = false;
        $this->reset(['csvFile', 'importData', 'importErrors', 'importNewCount', 'importUpdateCount', 'importErrorCount']);
        $this->resetImportProgress();
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
            'notes',
        ];

        $exampleRow = [
            '', // account_number (leave blank for new)
            'Example Company LLC',
            'Example Co',
            'contact@example.com',
            '555-123-4567',
            '555-987-6543',
            'https://example.com',
            '123 Main Street',
            'Suite 100',
            'Dallas',
            'Texas',
            '75201',
            'United States',
            'true',
            '',
            '',
            '',
            '',
            '',
            '',
            'net30',
            '12-3456789',
            '130.00',
            'Example client notes',
        ];

        $callback = function () use ($headers, $exampleRow) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fputcsv($file, $exampleRow);
            fclose($file);
        };

        return response()->streamDownload($callback, 'client_import_template.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    protected function resetForm()
    {
        $this->reset([
            'clientId',
            'accountNumber',
            'companyName',
            'tradingName',
            'website',
            'email',
            'phone',
            'mobile',
            'addressLine1',
            'addressLine2',
            'city',
            'state',
            'zipCode',
            'billingAddressLine1',
            'billingAddressLine2',
            'billingCity',
            'billingState',
            'billingZipCode',
            'billingCountry',
            'taxId',
            'notes',
            'accountNumberPreview',
        ]);

        $this->country = 'United States';
        $this->billingAddressSame = true;
        $this->paymentTerms = 'net30';
        $this->defaultHourlyRate = 130.00;
        $this->status = 'active';
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
        ]);
    }
}