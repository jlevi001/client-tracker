<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\HasProfilePhoto;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProfileInformationForm extends Component
{
    use WithFileUploads;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * The new avatar for the user.
     *
     * @var \Illuminate\Http\UploadedFile
     */
    public $photo;

    /**
     * Determine if the verification email is being resent.
     *
     * @var bool
     */
    public $verificationLinkSent = false;

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->state = Auth::user()->withoutRelations()->toArray();
    }

    /**
     * Update the user's profile information.
     *
     * @return void
     */
    public function updateProfileInformation()
    {
        $this->resetErrorBag();

        $user = Auth::user();

        $rules = [
            'state.name' => ['required', 'string', 'max:255'],
            'state.email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];

        // Add wage validation rules only for admins
        if ($user->hasRole('Admin')) {
            $rules['state.wage_type'] = ['nullable', 'in:hourly,salary'];
            $rules['state.wage_rate'] = ['nullable', 'required_with:state.wage_type', 'numeric', 'min:0', 'max:99999999.99'];
        }

        $this->validate($rules);

        if (isset($this->photo)) {
            $user->updateProfilePhoto($this->photo);
        }

        if ($this->state['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $this->state);
        } else {
            // Only update wage fields if user is admin
            $updateData = [
                'name' => $this->state['name'],
                'email' => $this->state['email'],
            ];

            if ($user->hasRole('Admin')) {
                $updateData['wage_type'] = $this->state['wage_type'] ?? null;
                $updateData['wage_rate'] = $this->state['wage_rate'] ?? null;
            }

            $user->forceFill($updateData)->save();
        }

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $updateData = [
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ];

        // Only update wage fields if user is admin
        if ($user->hasRole('Admin')) {
            $updateData['wage_type'] = $input['wage_type'] ?? null;
            $updateData['wage_rate'] = $input['wage_rate'] ?? null;
        }

        $user->forceFill($updateData)->save();

        $user->sendEmailVerificationNotification();

        $this->verificationLinkSent = true;
    }

    /**
     * Send an email verification notification to the current user.
     *
     * @return void
     */
    public function sendEmailVerification()
    {
        Auth::user()->sendEmailVerificationNotification();

        $this->verificationLinkSent = true;
    }

    /**
     * Delete the current user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        Auth::user()->deleteProfilePhoto();

        $this->emit('refresh-navigation-menu');
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('profile.update-profile-information-form');
    }
}