<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companyName = fake()->company();
        
        return [
            'account_number' => Client::generateAccountNumber($companyName),
            'company_name' => $companyName,
            'trading_name' => fake()->optional(0.2)->company(),
            'website' => fake()->optional(0.6)->url(),
            'email' => fake()->optional(0.8)->companyEmail(),
            'phone' => Client::formatPhoneNumber(fake()->phoneNumber()),
            'mobile' => fake()->optional(0.3)->phoneNumber() ? Client::formatPhoneNumber(fake()->phoneNumber()) : null,
            'address_line_1' => fake()->streetAddress(),
            'address_line_2' => fake()->optional(0.2)->secondaryAddress(),
            'city' => fake()->city(),
            'state' => fake()->stateAbbr(),
            'zip_code' => fake()->postcode(),
            'country' => 'United States',
            'billing_address_same' => true,
            'billing_address_line_1' => null,
            'billing_address_line_2' => null,
            'billing_city' => null,
            'billing_state' => null,
            'billing_zip_code' => null,
            'billing_country' => null,
            'payment_terms' => fake()->randomElement(['net15', 'net30', 'net45', 'net60', 'due_on_receipt']),
            'tax_id' => fake()->optional(0.3)->numerify('##-#######'),
            'status' => 'active',
            'notes' => fake()->optional(0.2)->paragraph(),
            'created_by_id' => User::role('Admin')->first()?->id ?? 1,
            'updated_by_id' => null,
        ];
    }

    /**
     * Indicate that the client is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the client is suspended.
     */
    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'suspended',
        ]);
    }

    /**
     * Indicate that the client has a different billing address.
     */
    public function withDifferentBillingAddress(): static
    {
        return $this->state(fn (array $attributes) => [
            'billing_address_same' => false,
            'billing_address_line_1' => fake()->streetAddress(),
            'billing_address_line_2' => fake()->optional(0.2)->secondaryAddress(),
            'billing_city' => fake()->city(),
            'billing_state' => fake()->stateAbbr(),
            'billing_zip_code' => fake()->postcode(),
            'billing_country' => 'United States',
        ]);
    }

    /**
     * Indicate that the client is Canadian.
     */
    public function canadian(): static
    {
        $provinces = array_values(Client::CA_PROVINCES);
        
        return $this->state(fn (array $attributes) => [
            'state' => fake()->randomElement($provinces),
            'zip_code' => strtoupper(fake()->bothify('?#? #?#')),
            'country' => 'Canada',
        ]);
    }

    /**
     * Indicate that the client has no address.
     */
    public function withoutAddress(): static
    {
        return $this->state(fn (array $attributes) => [
            'address_line_1' => null,
            'address_line_2' => null,
            'city' => null,
            'state' => null,
            'zip_code' => null,
        ]);
    }

    /**
     * Indicate that the client has minimal information.
     */
    public function minimal(): static
    {
        return $this->state(fn (array $attributes) => [
            'trading_name' => null,
            'website' => null,
            'mobile' => null,
            'address_line_1' => null,
            'address_line_2' => null,
            'city' => null,
            'state' => null,
            'zip_code' => null,
            'tax_id' => null,
            'notes' => null,
        ]);
    }
}
