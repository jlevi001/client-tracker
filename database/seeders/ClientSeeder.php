<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Imports client data from Wave CSV export.
     */
    public function run(): void
    {
        // Get admin user for created_by_id
        $adminUser = User::role('Admin')->first();
        $createdById = $adminUser?->id ?? 1;

        // Client data from Wave CSV export
        $clients = [
            ['company_name' => 'ABBA Adoption', 'first_name' => 'Kandi', 'last_name' => 'Cox', 'email' => 'kandi@abbaadoption.com', 'phone' => '501-993-6487', 'mobile' => null, 'website' => null, 'address_line_1' => '422 W. Sevier St.', 'address_line_2' => null, 'city' => 'Benton', 'state' => 'Arkansas', 'zip_code' => '72015', 'country' => 'United States'],
            ['company_name' => 'Ace Acres Retrievers', 'first_name' => 'Laura', 'last_name' => 'Pollard', 'email' => 'lpt61488@gmail.com', 'phone' => null, 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'ACTM', 'first_name' => 'Leah', 'last_name' => 'Stinnett', 'email' => 'leah.stinnett@scscoop.org', 'phone' => '870-836-1623', 'mobile' => null, 'website' => 'http://www.actm.net/', 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Acumen Contracting LLC.', 'first_name' => 'Richard', 'last_name' => 'Levisee', 'email' => 'richard@acumenmail.com', 'phone' => '501-612-5651', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Advanced Alarm Technologies', 'first_name' => 'Client', 'last_name' => 'Services', 'email' => 'clientservices@aatsecures.com', 'phone' => '(501) 618-8600', 'mobile' => null, 'website' => null, 'address_line_1' => '5340 Salt Creek Road', 'address_line_2' => null, 'city' => 'Benton', 'state' => 'Arkansas', 'zip_code' => '72019', 'country' => 'United States'],
            ['company_name' => 'Ainger Communications & Security Inc.', 'first_name' => 'Ronald', 'last_name' => 'Ainger', 'email' => 'rainger@ainger.com', 'phone' => '(866) 894-3339', 'mobile' => null, 'website' => 'http://www.ainger.com', 'address_line_1' => '1742 Woodward Drive', 'address_line_2' => null, 'city' => 'Ottawa', 'state' => 'Ontario', 'zip_code' => 'ON K2C 0P8', 'country' => 'Canada'],
            ['company_name' => 'Alan Wilson', 'first_name' => 'Alan', 'last_name' => 'Wilson', 'email' => 'wilsonac58@yahoo.com', 'phone' => '501-554-0130', 'mobile' => null, 'website' => null, 'address_line_1' => '1316 Nature Way', 'address_line_2' => null, 'city' => 'Benton', 'state' => 'Arkansas', 'zip_code' => '72019', 'country' => 'United States'],
            ['company_name' => 'Aligned Family Wellness', 'first_name' => 'Dana', 'last_name' => 'Grenman', 'email' => 'alignedfamilywellness@gmail.com', 'phone' => '501-520-7772', 'mobile' => null, 'website' => null, 'address_line_1' => '620 Central Avenue', 'address_line_2' => 'Suite 2A', 'city' => 'Hot Springs', 'state' => 'Arkansas', 'zip_code' => '71901', 'country' => 'United States'],
            ['company_name' => 'All Drains 70 Plumbing', 'first_name' => 'Angela', 'last_name' => 'Conner', 'email' => 'alldrains70@gmail.com', 'phone' => '(501) 909-9172', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Alliance Recovery', 'first_name' => 'Misti', 'last_name' => 'Montes', 'email' => 'mmontes@alliance-recovery.com', 'phone' => '(806) 860-3013', 'mobile' => null, 'website' => 'https://www.alliance-recovery.com/', 'address_line_1' => '12407 CR 2300', 'address_line_2' => null, 'city' => 'Lubbock', 'state' => 'Texas', 'zip_code' => '79423', 'country' => 'United States'],
            ['company_name' => 'Alternative Energy Solutions LLC', 'first_name' => 'Joe', 'last_name' => 'Ellis', 'email' => 'jellis@aessolar.net', 'phone' => '501-322-2907', 'mobile' => null, 'website' => null, 'address_line_1' => '1717 W Arch Ave', 'address_line_2' => null, 'city' => 'Searcy', 'state' => null, 'zip_code' => '72143', 'country' => 'United States'],
            ['company_name' => 'Amvet Tire & Auto', 'first_name' => 'Shawn', 'last_name' => 'Withers', 'email' => 'shawnwithers0111@gmail.com', 'phone' => '501-412-6930', 'mobile' => null, 'website' => null, 'address_line_1' => '1775 Arkansas 5', 'address_line_2' => null, 'city' => 'Benton', 'state' => 'Arkansas', 'zip_code' => '72019', 'country' => 'United States'],
            ['company_name' => 'Anns Therapeutic Massage Clinic', 'first_name' => 'Melissa Ann', 'last_name' => 'Anderson', 'email' => 'annsmassage@gmail.com', 'phone' => '5019603781', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'A Plus Alarm', 'first_name' => 'Scott', 'last_name' => 'Smith', 'email' => 'scott@k3bpm.com', 'phone' => '501-350-1290', 'mobile' => null, 'website' => null, 'address_line_1' => 'PO Box 242502', 'address_line_2' => null, 'city' => 'Little Rock', 'state' => 'Arkansas', 'zip_code' => '72223', 'country' => 'United States'],
            ['company_name' => 'Apple Rentals', 'first_name' => 'Darrell', 'last_name' => 'Apple', 'email' => 'apple.rentals@yahoo.com', 'phone' => '870-883-0725', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Arkansas Awakening', 'first_name' => 'Sherri', 'last_name' => 'Blunk', 'email' => 'sherriblunk@yahoo.com', 'phone' => '501-749-3537', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Arkansas Investigations', 'first_name' => 'Tasha', 'last_name' => 'Sims', 'email' => 'ts@arkansas-investigations.com', 'phone' => '(501) 372-2202', 'mobile' => null, 'website' => 'https://www.arkansasinvestigations.com', 'address_line_1' => '425 W Capitol Ave', 'address_line_2' => 'Suite 220 Simmons Tower', 'city' => 'Little Rock', 'state' => 'Arkansas', 'zip_code' => '72201', 'country' => 'United States'],
            ['company_name' => 'Arkansas Man Camp', 'first_name' => 'Anthony', 'last_name' => 'Carter', 'email' => 'Ac6501@att.net', 'phone' => '(501) 749-9221', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Arkansas Pro Wash', 'first_name' => 'Chris', 'last_name' => 'Apple', 'email' => 'accounting@prowashservice.net', 'phone' => null, 'mobile' => null, 'website' => null, 'address_line_1' => 'P.O. Box 878', 'address_line_2' => null, 'city' => 'Bryant', 'state' => 'Arkansas', 'zip_code' => '72089', 'country' => 'United States'],
            ['company_name' => "Arthur's Prime Steakhouse & Ocean's", 'first_name' => 'Jerry', 'last_name' => 'Barakat', 'email' => 'barakatjerry@yahoo.com', 'phone' => '501-952-5003', 'mobile' => null, 'website' => null, 'address_line_1' => '16100 Chenal Pkwy', 'address_line_2' => null, 'city' => 'Little Rock', 'state' => null, 'zip_code' => '72223', 'country' => 'United States'],
            ['company_name' => 'Authentic Designs Construction', 'first_name' => 'Jason', 'last_name' => 'McCraw', 'email' => 'authenticdesignsconstruction@gmail.com', 'phone' => '(501) 529-5208', 'mobile' => null, 'website' => null, 'address_line_1' => '912 Missile Base Rd', 'address_line_2' => null, 'city' => 'Judsonia', 'state' => 'Arkansas', 'zip_code' => '72081', 'country' => 'United States'],
            ['company_name' => 'Aviva LLC', 'first_name' => 'Paula', 'last_name' => 'Thompson', 'email' => 'john@aviva1.com', 'phone' => '501-554-2288', 'mobile' => null, 'website' => null, 'address_line_1' => '23510 Hwy 300', 'address_line_2' => null, 'city' => 'Roland', 'state' => 'Arkansas', 'zip_code' => '72135', 'country' => 'United States'],
            ['company_name' => 'Baada Bing Grille 2', 'first_name' => 'Dennis', 'last_name' => 'Dokes', 'email' => 'kingdokes@yahoo.com', 'phone' => null, 'mobile' => null, 'website' => null, 'address_line_1' => '1400 145 Street', 'address_line_2' => null, 'city' => 'Little Rock', 'state' => 'Arkansas', 'zip_code' => '72206', 'country' => 'United States'],
            ['company_name' => 'Benton Fence', 'first_name' => 'Diana', 'last_name' => 'Davis', 'email' => 'diana@titanaccesscontrols.com', 'phone' => '501-315-3738', 'mobile' => null, 'website' => null, 'address_line_1' => '3825 Mount Carmel Road', 'address_line_2' => null, 'city' => 'Bryant', 'state' => 'Arkansas', 'zip_code' => '72022', 'country' => 'United States'],
            ['company_name' => 'Benton Gun Club, Inc.', 'first_name' => 'Cully', 'last_name' => 'Majors', 'email' => 'crm762@yahoo.com', 'phone' => '870-210-6756', 'mobile' => null, 'website' => null, 'address_line_1' => '5522 Mount Olive Cutoff Road', 'address_line_2' => null, 'city' => 'Bauxite', 'state' => 'Arkansas', 'zip_code' => '72011', 'country' => 'United States'],
            ['company_name' => 'Bethany Pike', 'first_name' => 'Bethany', 'last_name' => 'Pike', 'email' => 'Bethany@elrodfirm.com', 'phone' => '501-847-1311', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Big Brothers Big Sisters', 'first_name' => 'Raymond', 'last_name' => 'Long', 'email' => 'rlong@bbbsca.org', 'phone' => null, 'mobile' => '+1 (501) 680-5179', 'website' => null, 'address_line_1' => '1201 West 3rd Street', 'address_line_2' => null, 'city' => 'Little Rock', 'state' => 'Arkansas', 'zip_code' => '72201', 'country' => 'United States'],
            ['company_name' => 'Bill Hearnsberger', 'first_name' => 'Bill', 'last_name' => 'Hearnsberger', 'email' => 'bill@hearnsberger.com', 'phone' => null, 'mobile' => '(501) 690-2606', 'website' => null, 'address_line_1' => '17600 Leatha Lane', 'address_line_2' => null, 'city' => 'Little Rock', 'state' => null, 'zip_code' => '72223-9503', 'country' => 'United States'],
            ['company_name' => 'BizTek Connection, Inc.', 'first_name' => 'Rob', 'last_name' => 'Taylor', 'email' => 'billing@biztekconnection.com', 'phone' => '501-542-4241', 'mobile' => null, 'website' => null, 'address_line_1' => '5323 John F Kennedy Blvd', 'address_line_2' => null, 'city' => 'North Little Rock', 'state' => 'Arkansas', 'zip_code' => '72116', 'country' => 'United States'],
            ['company_name' => 'Bodify Contouring & Coaching', 'first_name' => 'Jacalyn', 'last_name' => 'Poyner', 'email' => 'jacalyn@im2health.com', 'phone' => '5013030943', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => "Brother's Landscaping Supply", 'first_name' => 'Paulo', 'last_name' => 'Rodriguez', 'email' => 'brotherslandscapingsupply@gmail.com', 'phone' => '501-249-7552', 'mobile' => null, 'website' => null, 'address_line_1' => '4702 Hwy', 'address_line_2' => null, 'city' => 'Bauxite', 'state' => 'Arkansas', 'zip_code' => '72011', 'country' => 'United States'],
            ['company_name' => 'Bryant Animal Control', 'first_name' => 'Gordon', 'last_name' => 'Miller', 'email' => 'gmiller@cityofbryant.com', 'phone' => '501-912-4178', 'mobile' => null, 'website' => null, 'address_line_1' => '25700 Interstate 30 Frontage Road', 'address_line_2' => null, 'city' => 'Bryant', 'state' => 'Arkansas', 'zip_code' => '72022', 'country' => 'United States'],
            ['company_name' => 'Bryant Public Works', 'first_name' => 'Gordon', 'last_name' => 'Miller', 'email' => 'gmiller@cityofbryant.com', 'phone' => '501-912-4178', 'mobile' => null, 'website' => null, 'address_line_1' => '1017 SW 2nd St', 'address_line_2' => null, 'city' => 'Bryant', 'state' => 'Arkansas', 'zip_code' => '72022', 'country' => 'United States'],
            ['company_name' => "Burt's Media LLC", 'first_name' => 'Steven T', 'last_name' => 'Carter', 'email' => 'scarter@burtsportraits.com', 'phone' => '607-677-4895', 'mobile' => null, 'website' => null, 'address_line_1' => '400 Jackson Ave', 'address_line_2' => null, 'city' => 'Endicott', 'state' => 'Arkansas', 'zip_code' => '13760', 'country' => 'United States'],
            ['company_name' => 'Called To Love Ministries', 'first_name' => 'Brian', 'last_name' => 'Knoedl', 'email' => 'brian@discipleship.love', 'phone' => null, 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Canyon View Properties', 'first_name' => 'Melody', 'last_name' => 'Delone', 'email' => 'mdelone@canyonviewproperties.com', 'phone' => '501-247-8622', 'mobile' => null, 'website' => null, 'address_line_1' => '100 Commercial Park Ct.', 'address_line_2' => null, 'city' => 'Maumelle', 'state' => 'Arkansas', 'zip_code' => '72113', 'country' => 'United States'],
            ['company_name' => 'Canyon View Capital', 'first_name' => 'Bill', 'last_name' => 'Hagen', 'email' => 'bill@canyonviewproperties.com', 'phone' => '(207) 216-2261', 'mobile' => null, 'website' => 'http://www.canyonviewcapital.com', 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Carl Gann', 'first_name' => 'Carl', 'last_name' => 'Gann', 'email' => 'wcgann56@gmail.com', 'phone' => '501-517-4899', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Central Arkansas Truck Outfitters', 'first_name' => 'Carl', 'last_name' => 'Gann', 'email' => 'carl@centralarkansastruckoutfitters.com', 'phone' => '501-517-4988', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Charedible Chocolates', 'first_name' => 'Lytesa', 'last_name' => 'Harris', 'email' => 'mrsharris4@yahoo.com', 'phone' => '501-804-5246', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Chicken King of Bryant', 'first_name' => 'Bill', 'last_name' => 'Walker', 'email' => 'terry_wallace@hotmail.com', 'phone' => '501-258-1888', 'mobile' => null, 'website' => null, 'address_line_1' => 'PO 1609', 'address_line_2' => null, 'city' => 'Little Rock', 'state' => 'Arkansas', 'zip_code' => '72203', 'country' => 'United States'],
            ['company_name' => 'Choose To Stay Ministries', 'first_name' => 'Ty', 'last_name' => 'Pipkins', 'email' => 'thepipsfive@gmail.com', 'phone' => '501-804-5269', 'mobile' => null, 'website' => null, 'address_line_1' => 'P.O. Box 685', 'address_line_2' => null, 'city' => 'Bryant', 'state' => 'Arkansas', 'zip_code' => '72089', 'country' => 'United States'],
            ['company_name' => 'Chrissy Monterrey', 'first_name' => 'Chrissy', 'last_name' => 'Monterrey', 'email' => 'crissy.monterrey@montterreylaw.net', 'phone' => null, 'mobile' => '+1 (501) 352-9551', 'website' => null, 'address_line_1' => '54 Valley Estates Court', 'address_line_2' => null, 'city' => 'Little Rock', 'state' => 'Arkansas', 'zip_code' => '72212', 'country' => 'United States'],
            ['company_name' => 'Church of Benton', 'first_name' => 'Susan', 'last_name' => 'Pierce', 'email' => 'susanpierce44@gmail.com', 'phone' => '501-8603943', 'mobile' => null, 'website' => null, 'address_line_1' => '6604 Congo Road', 'address_line_2' => null, 'city' => 'Benton', 'state' => 'Arkansas', 'zip_code' => '72019', 'country' => 'United States'],
            ['company_name' => 'Cimarron Industrial Sales', 'first_name' => 'Michelle', 'last_name' => 'Campbell', 'email' => 'mcampbell1118@att.net', 'phone' => '501-680-9120', 'mobile' => null, 'website' => null, 'address_line_1' => '3158 Stonewall', 'address_line_2' => null, 'city' => 'Benton', 'state' => null, 'zip_code' => '72015', 'country' => 'United States'],
            ['company_name' => 'Clarke Financial Group', 'first_name' => 'Naomi', 'last_name' => 'Whitmer', 'email' => 'nwhitmer@cfgroup.com', 'phone' => '949-383-4773', 'mobile' => null, 'website' => null, 'address_line_1' => '2601 Main St', 'address_line_2' => 'Suite 770', 'city' => 'Irvine', 'state' => 'California', 'zip_code' => '92614', 'country' => 'United States'],
            ['company_name' => 'Clinton Airport Commission', 'first_name' => 'Will', 'last_name' => 'Dawson', 'email' => 'will@dawsonaircraft.com', 'phone' => null, 'mobile' => null, 'website' => null, 'address_line_1' => 'PO Box 903', 'address_line_2' => null, 'city' => 'Clinton', 'state' => null, 'zip_code' => '72031', 'country' => 'United States'],
            ['company_name' => 'Cold Creek Landing RV Park', 'first_name' => 'Crystal', 'last_name' => 'Herrmann', 'email' => 'dreamworx1012@gmail.com', 'phone' => null, 'mobile' => '501-707-8092', 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => 'Arkansas', 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Community Park Church', 'first_name' => 'KC', 'last_name' => 'Graves', 'email' => 'pastorkc1@yahoo.com', 'phone' => '501-722-7002', 'mobile' => null, 'website' => null, 'address_line_1' => '105 Valderrama Dr', 'address_line_2' => null, 'city' => 'Benton', 'state' => 'Arkansas', 'zip_code' => '72015', 'country' => 'United States'],
            // Note: There's a second Community Park Church entry - keeping as separate contact
            ['company_name' => 'Confident Young Minds', 'first_name' => 'Joshua', 'last_name' => 'Beesley', 'email' => 'joshua.bumblebeez@gmail.com', 'phone' => '702-292-2990', 'mobile' => null, 'website' => 'http://confidentyoungminds.com', 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Countertop World, LLC', 'first_name' => 'Annette', 'last_name' => 'Vick', 'email' => 'accounting@countertopworldar.com', 'phone' => '870-897-7175', 'mobile' => null, 'website' => null, 'address_line_1' => '26096 Interstate 30', 'address_line_2' => null, 'city' => 'Bryant', 'state' => 'Arkansas', 'zip_code' => '72022', 'country' => 'United States'],
            ['company_name' => 'C & S Roof Cleaning', 'first_name' => 'Charles', 'last_name' => 'Shelton', 'email' => 'clshelton44@gmail.com', 'phone' => null, 'mobile' => null, 'website' => null, 'address_line_1' => '5908 W. 19th', 'address_line_2' => null, 'city' => 'Little Rock', 'state' => null, 'zip_code' => '72204', 'country' => 'United States'],
            ['company_name' => 'Curations Home', 'first_name' => 'Eric', 'last_name' => 'Doud', 'email' => 'Curationshome@gmail.com', 'phone' => '501-416-4951', 'mobile' => null, 'website' => null, 'address_line_1' => '8201 Cantrell Road', 'address_line_2' => 'Suite 130', 'city' => 'Little Rock', 'state' => 'Arkansas', 'zip_code' => '72227', 'country' => 'United States'],
            ['company_name' => 'D Auto Care', 'first_name' => 'Jason', 'last_name' => 'Jordan', 'email' => 'jordanjason831@gmail.com', 'phone' => null, 'mobile' => '214-758-7487', 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'David A. Sims, JD PhD', 'first_name' => 'David A.', 'last_name' => 'Sims', 'email' => 'dsims@davidsimsjdphd.com', 'phone' => '501-442-3585', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Dawson Aircraft, Inc', 'first_name' => 'Trevor', 'last_name' => 'Dawson', 'email' => 'Trevor@dawsonaircraft.com', 'phone' => '501-745-6550', 'mobile' => '501-208-2700', 'website' => 'http://www.dawsonaircraft.com/', 'address_line_1' => 'PO Box 910', 'address_line_2' => null, 'city' => 'Clinton', 'state' => 'Arkansas', 'zip_code' => '72031', 'country' => 'United States'],
            ['company_name' => 'Deb Sefcik', 'first_name' => 'Deb', 'last_name' => 'Sefcik', 'email' => 'Deborah.Sefcik@iberiabank.com', 'phone' => '501-658-5858', 'mobile' => null, 'website' => null, 'address_line_1' => '16809 Pineview Circle', 'address_line_2' => null, 'city' => 'Mabelvale', 'state' => 'Arkansas', 'zip_code' => '72103', 'country' => 'United States'],
            ['company_name' => 'Decks & More Inc.', 'first_name' => 'Mike', 'last_name' => 'Manees', 'email' => 'mmanees_2000@yahoo.com', 'phone' => '5018126233', 'mobile' => '15019935109', 'website' => null, 'address_line_1' => '17100 Crystal Valley Rd', 'address_line_2' => null, 'city' => 'Little Rock', 'state' => 'Arkansas', 'zip_code' => '72210', 'country' => 'United States'],
            ['company_name' => 'Dee Brazil Dale', 'first_name' => 'Dee', 'last_name' => 'Brazil Dale', 'email' => 'dbrazil@aristotle.net', 'phone' => '501-909-9465', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Delvin Hale', 'first_name' => 'Delvin', 'last_name' => 'Hale', 'email' => 'delvin.hale@gmail.com', 'phone' => '213-800-4931', 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => 'Diamond State Heat and Air', 'first_name' => 'Charles', 'last_name' => 'Newth', 'email' => 'charlie@diamondstatehvac.com', 'phone' => '501-837-3130', 'mobile' => null, 'website' => null, 'address_line_1' => '7706 Forest Rd', 'address_line_2' => null, 'city' => 'N. Little Rock', 'state' => 'Arkansas', 'zip_code' => '72218', 'country' => 'United States'],
            ['company_name' => 'Diamond State Limousine', 'first_name' => 'Thomas', 'last_name' => 'Houser', 'email' => 'rmoutfitters@yahoo.com', 'phone' => '501-778-3307', 'mobile' => null, 'website' => null, 'address_line_1' => '3403 Meeting Street', 'address_line_2' => 'Suite 400', 'city' => 'Bryant', 'state' => 'Arkansas', 'zip_code' => '72022', 'country' => 'United States'],
            ['company_name' => 'Dignity Memorial', 'first_name' => 'Feleshia', 'last_name' => 'Levisee', 'email' => 'Feleshia.Levisee@dignitymemorial.com', 'phone' => '501-847-0265', 'mobile' => null, 'website' => null, 'address_line_1' => '7401 Arkansas 5', 'address_line_2' => null, 'city' => 'Alexander', 'state' => 'Arkansas', 'zip_code' => '72002', 'country' => 'United States'],
            ['company_name' => 'Divine Mercy Health Center', 'first_name' => 'Lee', 'last_name' => 'Wilbur & Lanita White', 'email' => 'leegarettwilbur@gmail.com', 'phone' => null, 'mobile' => null, 'website' => null, 'address_line_1' => null, 'address_line_2' => null, 'city' => null, 'state' => null, 'zip_code' => null, 'country' => 'United States'],
            ['company_name' => "Don's Weaponry", 'first_name' => 'Josh', 'last_name' => 'Tipton', 'email' => 'donsweap@gmail.com', 'phone' => '(501) 945-2324', 'mobile' => null, 'website' => null, 'address_line_1' => '4116 E Broadway St', 'address_line_2' => null, 'city' => 'North Little Rock', 'state' => 'Arkansas', 'zip_code' => '72117', 'country' => 'United States'],
        ];

        // Note: This is a sample of the first ~65 records.
        // The complete seeder would include all 255 clients from the CSV.
        // For production, consider using a CSV import command instead.

        $importedCount = 0;
        $skippedCount = 0;

        foreach ($clients as $clientData) {
            try {
                // Format phone numbers
                $phone = Client::formatPhoneNumber($clientData['phone']);
                $mobile = Client::formatPhoneNumber($clientData['mobile']);

                // Abbreviate state
                $state = Client::abbreviateState($clientData['state'], $clientData['country'] ?? 'United States');

                // Format postal code for Canada
                $zipCode = $clientData['zip_code'];
                if (stripos($clientData['country'] ?? '', 'Canada') !== false) {
                    $zipCode = Client::formatCanadianPostalCode($zipCode);
                }

                // Create the client
                $client = Client::create([
                    'company_name' => $clientData['company_name'],
                    'email' => $clientData['email'],
                    'phone' => $phone,
                    'mobile' => $mobile,
                    'website' => $clientData['website'],
                    'address_line_1' => $clientData['address_line_1'],
                    'address_line_2' => $clientData['address_line_2'],
                    'city' => $clientData['city'],
                    'state' => $state,
                    'zip_code' => $zipCode,
                    'country' => $clientData['country'] ?? 'United States',
                    'status' => 'active',
                    'created_by_id' => $createdById,
                ]);

                // Store contact info for future ClientContact seeder
                // First/Last name will be used when we create the client_contacts table
                // For now, we're just importing the client records

                $importedCount++;
                
            } catch (\Exception $e) {
                Log::warning("Failed to import client: {$clientData['company_name']} - {$e->getMessage()}");
                $skippedCount++;
            }
        }

        $this->command->info("Imported {$importedCount} clients. Skipped {$skippedCount} due to errors.");
    }
}
