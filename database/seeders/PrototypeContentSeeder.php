<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Inquiry;
use App\Models\Insider;
use App\Models\LeadDownload;
use App\Models\Package;
use App\Models\PackageItinerary;
use App\Models\Review;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PrototypeContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedAdminUser();
        $this->seedPackagesAndItineraries();
        $this->seedDestinations();
        $this->seedInsiders();
        $this->seedReviews();
        $this->seedInquiries();
        $this->seedLeadDownloads();
        $this->seedSiteSettings();
    }

    private function seedAdminUser(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kiyaraholidays.com'],
            [
                'name' => 'Kiyara Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }

    private function seedPackagesAndItineraries(): void
    {
        $packages = [
            [
                'title' => 'The Heritage & Cloud Highlands Trail',
                'slug' => 'the-heritage-and-cloud-highlands-trail',
                'subtitle' => 'Bestseller • Small Group & Private',
                'duration_days' => 10,
                'difficulty' => 'Moderate',
                'group_size_max' => 10,
                'starting_price_usd' => 2150.00,
                'hero_image' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=1200&q=80',
                'overview' => 'Sunrise at ancient Sigiriya, colonial train through emerald tea gardens, private wildlife tracking in leopard territory, and a serene finish at a Tangalle beach cove.',
                'is_featured' => true,
                'order' => 1,
                'itineraries' => [
                    [
                        'day_number' => 1,
                        'title' => 'Negombo Arrival & Coastal Welcome',
                        'location' => 'Negombo & Cultural Triangle',
                        'morning_desc' => 'Arrive at Bandaranaike International Airport in Katunayake. Meet your dedicated insider driver-guide and receive an Ayubowan floral and king coconut welcome.',
                        'afternoon_desc' => 'Scenic transfer into the Cultural Triangle dry-zone forest. Settle into your eco-luxury villa amidst bird sanctuaries.',
                        'evening_desc' => 'Candlelit welcome dinner with traditional village claypot curries and fresh coconut arrack tasting.',
                        'stay_notes' => 'Water Garden Sigiriya / Aliya Resort & Spa',
                        'image' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 2,
                        'title' => 'Sigiriya Lion Rock Sunrise & Rural Village Hearth',
                        'location' => 'Sigiriya',
                        'morning_desc' => 'Pre-dawn climb of the 5th-century Sigiriya Lion Rock fortress before the heat settles, taking in panoramic jungle vistas and ancient frescoes.',
                        'afternoon_desc' => 'Village walk in Habarana with Amma Lakshmi. Help grind roasted curry powders on ancient granite stones and enjoy an organic claypot feast.',
                        'evening_desc' => 'Unwind with an evening herbal foot bath or a tranquil walk around Kandalama Lake as fruit bats take to the skies.',
                        'stay_notes' => 'Water Garden Sigiriya',
                        'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 3,
                        'title' => 'Dambulla Rock Temples & Matale Spices',
                        'location' => 'Dambulla & Matale',
                        'morning_desc' => 'Ascend to the five UNESCO cave shrines of Dambulla, housing over 150 serene Buddha statues and vibrant mural ceiling paintings.',
                        'afternoon_desc' => 'Stop at a heritage organic spice garden in Matale with a master botanist to observe wild cardamom, vanilla vines, and cinnamon peeling.',
                        'evening_desc' => 'Arrive in the royal hill capital of Kandy. Settle into a restored 18th-century manor house overlooking misty terraced hills.',
                        'stay_notes' => 'The Kandy House',
                        'image' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 4,
                        'title' => 'Sacred Kandy Relics & Royal Botanicals',
                        'location' => 'Kandy',
                        'morning_desc' => 'Join the morning puja drumming ceremony at Sri Dalada Maligawa (Temple of the Sacred Tooth Relic).',
                        'afternoon_desc' => 'Privately guided walk through the Royal Botanical Gardens of Peradeniya among century-old Javanese fig trees and rare orchids.',
                        'evening_desc' => 'Private Kandyan cultural percussion and dance demonstration, followed by dinner overlooking the Mahaweli River.',
                        'stay_notes' => 'The Kandy House',
                        'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 5,
                        'title' => 'The Legendary Blue Train to Ella Highlands',
                        'location' => 'Nuwara Eliya & Ella',
                        'morning_desc' => 'Board the nostalgic colonial train as it climbs slowly past roaring cascades, misty valleys, and tea pickers in vibrant sarees.',
                        'afternoon_desc' => 'Arrive in the cool mountain village of Ella. Walk through the eucalyptus grove to witness the iconic colonial Nine Arch Bridge.',
                        'evening_desc' => 'Cozy dinner in a highland planter’s cottage paired with artisanal Ceylon teas and wood-fired curries.',
                        'stay_notes' => '98 Acres Resort & Spa / Planters Bungalow Ella',
                        'image' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 6,
                        'title' => 'Little Adam’s Peak & Secret Tea Tasting',
                        'location' => 'Ella & Demodara',
                        'morning_desc' => 'Gentle sunrise hike up Little Adam’s Peak, drinking in 360-degree views across the southern gap.',
                        'afternoon_desc' => 'Exclusive visit to a single-estate organic tea factory to pluck "two leaves and a bud" and taste rare silver tip brews.',
                        'evening_desc' => 'Twilight cocktails infused with garden passion fruit and lemongrass on an open timber terrace.',
                        'stay_notes' => '98 Acres Resort & Spa',
                        'image' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 7,
                        'title' => 'Highland Descent to Yala Safari Camp',
                        'location' => 'Ella to Yala',
                        'morning_desc' => 'Descend the breathtaking Ella Gap passing Ravana Falls, transitioning from cool rainforest to dry wilderness scrub.',
                        'afternoon_desc' => 'Check in to luxury glamping tented suites bordering Yala National Park. Meet your dedicated wildlife naturalist.',
                        'evening_desc' => 'Introductory late afternoon game drive tracking wild Asian elephants and mugger crocodiles around scenic waterholes.',
                        'stay_notes' => 'Wild Coast Tented Lodge / Chena Huts',
                        'image' => 'https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 8,
                        'title' => 'Dawn Leopard Tracking & Coastal Dunes',
                        'location' => 'Yala National Park',
                        'morning_desc' => 'First light safari into the heart of Yala Block 1 tracking the elusive Ceylon leopard, sloth bears, and hornbills.',
                        'afternoon_desc' => 'Shaded bush lunch under ancient Palu trees and relaxation by the freeform saltwater pool.',
                        'evening_desc' => 'Sunset dune walk where the jungle meets the untamed Indian Ocean surf, followed by a beachfront BBQ around the bonfire.',
                        'stay_notes' => 'Wild Coast Tented Lodge',
                        'image' => 'https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 9,
                        'title' => 'Tangalle Coastline to Historic Galle Fort',
                        'location' => 'Tangalle & Galle',
                        'morning_desc' => 'Coastal drive past the serene turquoise bays of Tangalle, observing iconic stilt fishermen balanced above the tides.',
                        'afternoon_desc' => 'Enter the 17th-century UNESCO ramparts of Galle Fort. Settle into a colonial boutique residence with vaulted ceilings.',
                        'evening_desc' => 'Leisurely walk along the ocean ramparts at golden hour watching cliff divers, followed by a coastal seafood tasting.',
                        'stay_notes' => 'Amangalla / Fort Bazaar Galle',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 10,
                        'title' => 'Rampart Strolls & Southern Ocean Departure',
                        'location' => 'Galle to Colombo Airport',
                        'morning_desc' => 'Slow breakfast in the shaded courtyard under frangipani trees. Artisan gem, spice, and antique explorations.',
                        'afternoon_desc' => 'Private chauffeur transfer along the Southern Expressway to Bandaranaike International Airport.',
                        'evening_desc' => 'Depart with cherished memories, handcrafted Ceylon gifts, and lasting friendships.',
                        'stay_notes' => 'Departure Flight',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                ],
            ],
            [
                'title' => 'The Connoisseur’s Ceylon: Wild & Slow',
                'slug' => 'the-connoisseurs-ceylon-wild-and-slow',
                'subtitle' => 'Private Chauffeured Journey',
                'duration_days' => 14,
                'difficulty' => 'Easy',
                'group_size_max' => 6,
                'starting_price_usd' => 3200.00,
                'hero_image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=1200&q=80',
                'overview' => 'A leisurely journey tailored for couples and slow travelers. Stay in Geoffrey Bawa architectural treasures, boat safaris with indigenous Vedda elders, and sunset gin & tonics in Galle Fort.',
                'is_featured' => true,
                'order' => 2,
                'itineraries' => [
                    [
                        'day_number' => 1,
                        'title' => 'Colombo Arts & Geoffrey Bawa Heritage',
                        'location' => 'Colombo',
                        'morning_desc' => 'Arrive in Colombo and transfer to a private design retreat. Sip chilled Ceylon toddy cocktails on arrival.',
                        'afternoon_desc' => 'Private access architectural tour of Number 11, master architect Geoffrey Bawa’s legendary townhouse residence.',
                        'evening_desc' => 'Modern Sri Lankan dinner paired with fine wines at the acclaimed Gallery Café.',
                        'stay_notes' => 'Tinto House Colombo / Maniumpathy',
                        'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 2,
                        'title' => 'Lunuganga Country Estate Gardens',
                        'location' => 'Bentota & Lunuganga',
                        'morning_desc' => 'Leisurely breakfast and drive south to Lunuganga, Geoffrey Bawa’s lyrical country retreat on Dedduwa Lake.',
                        'afternoon_desc' => 'Private estate stroll through Italian-inspired water gardens, Roman busts, and tropical cinnamon hills.',
                        'evening_desc' => 'Sunset aperitif on the terrace ringing the garden bells just as Bawa did for his guests.',
                        'stay_notes' => 'Lunuganga Country Estate',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 3,
                        'title' => 'Journey into the Untamed East: Gal Oya',
                        'location' => 'Gal Oya National Park',
                        'morning_desc' => 'Scenic transfer across the central spine into the undisturbed wild valley of Gal Oya.',
                        'afternoon_desc' => 'Check in to an eco-lodge constructed entirely from locally sourced wood and mud-plastered walls.',
                        'evening_desc' => 'Sundowners overlooking the lake as twilight sounds of nightjars and bullfrogs envelop the valley.',
                        'stay_notes' => 'Gal Oya Lodge',
                        'image' => 'https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 4,
                        'title' => 'Lake Boat Safari & Swimming Wild Elephants',
                        'location' => 'Senanayake Samudraya Reservoir',
                        'morning_desc' => 'Early boat excursion across the vast inland sea, the only national park in Sri Lanka offering wildlife viewing from the water.',
                        'afternoon_desc' => 'Witness wild elephant herds swimming between uninhabited islands to graze on fresh reeds.',
                        'evening_desc' => 'Jungle picnic lunch on a secluded island beach, followed by wildlife photography discussions.',
                        'stay_notes' => 'Gal Oya Lodge',
                        'image' => 'https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 5,
                        'title' => 'Sacred Forest Walk with Indigenous Vedda Elders',
                        'location' => 'Gal Oya Forest Sanctuary',
                        'morning_desc' => 'Walk deep into ancient ancestral hunting grounds led by the chief of Sri Lanka’s indigenous Vedda community.',
                        'afternoon_desc' => 'Learn generational secrets of medicinal tree barks, wild bee honey gathering, and sacred rock caves.',
                        'evening_desc' => 'Storytelling around an open timber hearth with traditional folklore and fire-roasted yams.',
                        'stay_notes' => 'Gal Oya Lodge',
                        'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 6,
                        'title' => 'Ascent to High Tea Country: Hatton',
                        'location' => 'Hatton & Bogawantalawa Valley',
                        'morning_desc' => 'Scenic private drive ascending into the Golden Valley of Ceylon tea, blanketed in emerald green velvet slopes.',
                        'afternoon_desc' => 'Check in to an authentic restored colonial planter’s residence situated on the shores of Lake Castlereagh.',
                        'evening_desc' => 'Full silver-service English high tea with warm scones, clotted cream, and strawberry preserves on manicured lawns.',
                        'stay_notes' => 'Ceylon Tea Trails (Relais & Châteaux)',
                        'image' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 7,
                        'title' => 'Slow Bungalow Life & Valley Ridge Walks',
                        'location' => 'Hatton Tea Trails',
                        'morning_desc' => 'Wake to bed tea served by your private butler. Gentle morning walk along misty plantation tracks accompanied by songbirds.',
                        'afternoon_desc' => 'Private masterclass with the resident tea planter explaining the leaf selection process and flavor profiles.',
                        'evening_desc' => 'Four-course wine-paired dinner prepared by your private bungalow chef beside a roaring log fireplace.',
                        'stay_notes' => 'Ceylon Tea Trails',
                        'image' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 8,
                        'title' => 'Lake Castlereagh Kayaking & Waterfalls',
                        'location' => 'Castlereagh Reservoir',
                        'morning_desc' => 'Morning kayak on the still, mirror-like waters of Castlereagh Lake surrounded by peaks.',
                        'afternoon_desc' => 'Private visit to hidden Aberdeen and Laxapana mountain waterfalls with gourmet tiffin carrier lunch.',
                        'evening_desc' => 'Relaxing in-room aromatherapy massage using Ceylon cinnamon and clove essential oils.',
                        'stay_notes' => 'Ceylon Tea Trails',
                        'image' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 9,
                        'title' => 'Descent to South Coast: Weligama Bay',
                        'location' => 'Weligama & Cape Weligama',
                        'morning_desc' => 'Drive down towards the southern coastline through rubber and cinnamon plantations.',
                        'afternoon_desc' => 'Check in to an oceanfront clifftop villa overlooking the vast expanse of the Indian Ocean.',
                        'evening_desc' => 'Sunset dip in the cliff-edge crescent infinity pool followed by fresh crab and reef fish dining.',
                        'stay_notes' => 'Cape Weligama',
                        'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 10,
                        'title' => 'Private Catamaran Sail & Blue Whale Spotting',
                        'location' => 'Mirissa Coast',
                        'morning_desc' => 'Board a private luxury 48-foot sailing catamaran at Mirissa harbor for an ethical, crowd-free ocean safari.',
                        'afternoon_desc' => 'Encounter pygmy blue whales and spinner dolphins in their natural deep-water migration trench.',
                        'evening_desc' => 'Anchor in a quiet cove for paddleboarding, swimming, and chilled champagne on deck.',
                        'stay_notes' => 'Cape Weligama',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 11,
                        'title' => 'Galle Fort Heritage & Colonial Living',
                        'location' => 'Galle Fort',
                        'morning_desc' => 'Transfer into the pedestrianized cobblestone alleys of 17th-century Galle Fort.',
                        'afternoon_desc' => 'Private walking masterclass with a heritage architect examining Dutch gables, British verandas, and underground sewer tunnels.',
                        'evening_desc' => 'Sundowners on the bastion ramparts listening to the Islamic call to prayer mingling with Buddhist temple bells.',
                        'stay_notes' => 'Amangalla',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 12,
                        'title' => 'Artisan Galle Cooking & Antiquing',
                        'location' => 'Galle Fort',
                        'morning_desc' => 'Visit the lively Galle fish market with your chef, followed by an intimate market-to-table culinary workshop.',
                        'afternoon_desc' => 'Curated boutique shopping for antique Dutch furniture, unheated Ceylon blue sapphires, and hand-woven silks.',
                        'evening_desc' => 'Candlelit dinner in the stately columned dining hall of Amangalla accompanied by live classical violin.',
                        'stay_notes' => 'Amangalla',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 13,
                        'title' => 'Slow Beach Day at Thalpe Cove',
                        'location' => 'Thalpe & Unawatuna',
                        'morning_desc' => 'Spend an unhurried morning soaking in natural coral rock pools along the serene Thalpe coastline.',
                        'afternoon_desc' => 'Relax under swaying coconut palms with a good book and fresh young coconuts.',
                        'evening_desc' => 'Private farewell beach bonfire feast with grilled jumbo tiger prawns and passion fruit pavlova.',
                        'stay_notes' => 'Amangalla',
                        'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 14,
                        'title' => 'Frangipani Courtyards & Ocean Departure',
                        'location' => 'Galle to Colombo Airport',
                        'morning_desc' => 'Traditional Ceylon tea and string hopper breakfast under the shade of ancient frangipani trees.',
                        'afternoon_desc' => 'Chauffeured expressway journey to Colombo airport, bidding farewell to your private driver-storyteller.',
                        'evening_desc' => 'Board your return flight home renewed by the calm and authentic spirit of Sri Lanka.',
                        'stay_notes' => 'Departure Flight',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                ],
            ],
            [
                'title' => 'Prana: Forest Ayurveda & Coastal Surf',
                'slug' => 'prana-forest-ayurveda-and-coastal-surf',
                'subtitle' => 'Ayurveda & Soul Retreat',
                'duration_days' => 8,
                'difficulty' => 'Easy',
                'group_size_max' => 8,
                'starting_price_usd' => 1890.00,
                'hero_image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=1200&q=80',
                'overview' => 'Begin in an eco-sanctuary hidden in the Knuckles mountain range with personal Ayurvedic doctor consultations, herbal bath rituals, then move south for gentle surf and sound baths.',
                'is_featured' => true,
                'order' => 3,
                'itineraries' => [
                    [
                        'day_number' => 1,
                        'title' => 'The Knuckles Mountain Sanctuary & Pulse Consultation',
                        'location' => 'Knuckles Mountain Range',
                        'morning_desc' => 'Arrival at CMB airport and scenic transition into the misty foothills of the Knuckles wilderness.',
                        'afternoon_desc' => 'In-depth initial consultation with resident Ayurvedic physician Dr. Nilmini to determine your unique dosha profile (Vata, Pitta, Kapha).',
                        'evening_desc' => 'Introductory herbal foot bath (Pada Abhyanga) followed by an organic dosha-specific farm-to-table dinner.',
                        'stay_notes' => 'Santani Wellness Sanctuary / Forest Eco-Lodge',
                        'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 2,
                        'title' => 'Abhyanga Herbal Oils & Forest Pranayama',
                        'location' => 'Knuckles Wellness Retreat',
                        'morning_desc' => 'Sunrise Hatha yoga and breathwork (pranayama) overlooking cloud-draped mountain peaks.',
                        'afternoon_desc' => 'Two-hour synchronised full-body herbal oil treatment (Abhyanga) followed by herbal steam bath (Swedana).',
                        'evening_desc' => 'Silent walking meditation through bamboo groves and fresh organic dinner.',
                        'stay_notes' => 'Santani Wellness Sanctuary',
                        'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 3,
                        'title' => 'Shirodhara Rhythms & Plant Medicine Workshop',
                        'location' => 'Knuckles Range',
                        'morning_desc' => 'Shirodhara therapy with warm herb-infused medicated oils poured steadily over the third eye to calm the nervous system.',
                        'afternoon_desc' => 'Hands-on plant medicine workshop in the sanctuary herb gardens learning medicinal benefits of Gotu Kola and Ashwagandha.',
                        'evening_desc' => 'Restorative Yin Yoga in the open timber shala as cool highland breezes rustle the forest canopy.',
                        'stay_notes' => 'Santani Wellness Sanctuary',
                        'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 4,
                        'title' => 'Natural Stream Dips & Mindful Forest Walk',
                        'location' => 'Knuckles River Trails',
                        'morning_desc' => 'Mindful guided hike to a secret natural mountain stream for wild river bathing and cold-water hydrotherapy.',
                        'afternoon_desc' => 'Ayurvedic nutrition and cooking masterclass with the sanctuary head chef preparing nutritious claypot curries.',
                        'evening_desc' => 'Tibetan singing bowl sound bath ceremony inducing deep delta-wave sleep.',
                        'stay_notes' => 'Santani Wellness Sanctuary',
                        'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 5,
                        'title' => 'Highland Transfer to Southern Ocean: Hiriketiya',
                        'location' => 'Knuckles to Hiriketiya Bay',
                        'morning_desc' => 'Final morning consultation with Dr. Nilmini with your personalized take-home lifestyle and herbal regimen.',
                        'afternoon_desc' => 'Chauffeured journey to the lush southern coast, arriving at horseshoe-shaped Hiriketiya horseshoe cove.',
                        'evening_desc' => 'Sunset beach walk on powder sands and refreshing wood-fired seafood dinner by the bay.',
                        'stay_notes' => 'Dots Bay House / Verse Collective',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 6,
                        'title' => 'Gentle Longboard Surf & Sound Healing',
                        'location' => 'Hiriketiya Beach',
                        'morning_desc' => 'Beginner-friendly private morning longboard surf coaching on gentle, peel-off waves.',
                        'afternoon_desc' => 'Free afternoon for hammock reading, cold-pressed tropical juices, and ocean swimming.',
                        'evening_desc' => 'Acoustic evening yoga flow followed by oceanfront sound bath beneath palm trees.',
                        'stay_notes' => 'Dots Bay House',
                        'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 7,
                        'title' => 'Ocean Deck Yoga & Sea Salt Therapy',
                        'location' => 'Hiriketiya & Dikwella',
                        'morning_desc' => 'Invigorating Vinyasa flow on the open oceanfront deck with sounds of the ocean tide.',
                        'afternoon_desc' => 'Visit a local coastal salt flat to witness traditional sea-salt harvesting and natural body scrub preparation.',
                        'evening_desc' => 'Farewell community dinner with beach lanterns, grilled mahi-mahi, and fresh coconut water.',
                        'stay_notes' => 'Dots Bay House',
                        'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 8,
                        'title' => 'Coastal Farewell & Departure',
                        'location' => 'Hiriketiya to Colombo Airport',
                        'morning_desc' => 'Final ocean swim and wholesome tropical fruit bowl breakfast with organic curd and treacle.',
                        'afternoon_desc' => 'Chauffeured transfer along the scenic coastal highway to Colombo airport.',
                        'evening_desc' => 'Board your return flight deeply grounded, revitalized, and filled with inner calm.',
                        'stay_notes' => 'Departure Flight',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                ],
            ],
            [
                'title' => 'Sacred Peaks & Hidden Coastlines',
                'slug' => 'sacred-peaks-and-hidden-coastlines',
                'subtitle' => 'Mountain Temples & Secluded Bays',
                'duration_days' => 12,
                'difficulty' => 'Moderate',
                'group_size_max' => 8,
                'starting_price_usd' => 2750.00,
                'hero_image' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=1200&q=80',
                'overview' => 'Traverse the mist-crowned Knuckles mountain peaks, ancient pilgrimage paths, secluded south-coast bays, and secret wilderness lagoons far from tourist footprints.',
                'is_featured' => true,
                'order' => 4,
                'itineraries' => [
                    [
                        'day_number' => 1,
                        'title' => 'Colombo Arrival & Kandy Foothills',
                        'location' => 'Katunayake & Kandy',
                        'morning_desc' => 'Meet your storyteller guide at the airport and journey towards the verdant Kandy foothills.',
                        'afternoon_desc' => 'Check in to a boutique stone lodge overlooking cascading rice terraces.',
                        'evening_desc' => 'Gentle evening stroll through village spice gardens followed by candlelit dinner.',
                        'stay_notes' => 'Madulkelle Tea & Eco Lodge',
                        'image' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 2,
                        'title' => 'Knuckles Mountain Cloud Forest Trek',
                        'location' => 'Knuckles UNESCO Wilderness',
                        'morning_desc' => 'Trek into the UNESCO World Heritage cloud forests of the Knuckles massif with a native tracker.',
                        'afternoon_desc' => 'Encounter rare endemic pygmy lizards, purple-faced langurs, and pristine mountain cascades.',
                        'evening_desc' => 'Mountain hearth dinner featuring slow-cooked wild pepper curry and hot roast paan bread.',
                        'stay_notes' => 'Madulkelle Tea & Eco Lodge',
                        'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 3,
                        'title' => 'Ancient Temples: Gadaladeniya & Embekke',
                        'location' => 'Kandy Outskirts',
                        'morning_desc' => 'Explore the intricate 14th-century wood-carved pillars of Embekke Devalaya temple.',
                        'afternoon_desc' => 'Visit Gadaladeniya rock temple with its South Indian stone Dravidian architectural lines.',
                        'evening_desc' => 'Twilight tea tasting overlooking the tea-carpeted slopes of Madulkelle.',
                        'stay_notes' => 'Madulkelle Tea & Eco Lodge',
                        'image' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 4,
                        'title' => 'High Mountain Ridge Crossing to Nuwara Eliya',
                        'location' => 'Nuwara Eliya',
                        'morning_desc' => 'Drive through hairpin bends past Ramboda Falls into the high cool plateau of Nuwara Eliya.',
                        'afternoon_desc' => 'Walk around Lake Gregory and explore historic colonial mock-Tudor bungalows.',
                        'evening_desc' => 'Log fire dinner and hot spiced mulled wine at the historic Hill Club.',
                        'stay_notes' => 'The Grand Hotel Nuwara Eliya',
                        'image' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 5,
                        'title' => 'Horton Plains Dawn Walk & World’s End',
                        'location' => 'Horton Plains National Park',
                        'morning_desc' => 'Dawn departure to walk the misty plateau of Horton Plains before clouds roll into World’s End.',
                        'afternoon_desc' => 'Marvel at Baker’s Falls and the unique montane grassland biodiversity.',
                        'evening_desc' => 'Afternoon high tea and warm herbal sauna session.',
                        'stay_notes' => 'The Grand Hotel Nuwara Eliya',
                        'image' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 6,
                        'title' => 'Adam’s Peak Sacred Wilderness Pilgrimage',
                        'location' => 'Sri Pada / Nallathanniya',
                        'morning_desc' => 'Scenic transfer into the sacred peak valleys where tea plantations merge with rainforest sanctuaries.',
                        'afternoon_desc' => 'Rest and prepare for the twilight or dawn pilgrimage walk along ancient stone stairways.',
                        'evening_desc' => 'Witness thousands of butter lamps lit along mountain passes as pilgrims chant Buddhist verses.',
                        'stay_notes' => 'Grand Adams Peak Lodge',
                        'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 7,
                        'title' => 'Descent to Sinharaja Virgin Rain Forest',
                        'location' => 'Sinharaja Biosphere Reserve',
                        'morning_desc' => 'Journey southwest into the ancient tropical virgin rainforest of Sinharaja.',
                        'afternoon_desc' => 'Check in to an eco-reserve with cottages perched on stilts above the rainforest canopy.',
                        'evening_desc' => 'Nocturnal wildlife walk with a specialist spotting tree frogs, tarantulas, and fireflies.',
                        'stay_notes' => 'Sinharaja Rainforest Eco Lodge',
                        'image' => 'https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 8,
                        'title' => 'Endemic Bird Watching & Canopy Waterfalls',
                        'location' => 'Sinharaja Forest',
                        'morning_desc' => 'Morning birding tracking the famed mixed-species bird feeding flocks with the rare Sri Lanka Blue Magpie.',
                        'afternoon_desc' => 'Swim in crystal natural waterfall rock pools deep within the emerald forest.',
                        'evening_desc' => 'Quiet evening listening to the symphony of the jungle over an organic plant-based dinner.',
                        'stay_notes' => 'Sinharaja Rainforest Eco Lodge',
                        'image' => 'https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 9,
                        'title' => 'Secluded Tangalle Bay & Secret Rock Pools',
                        'location' => 'Tangalle Coast',
                        'morning_desc' => 'Drive from rainforest canopy directly down to the pristine golden beaches of Tangalle.',
                        'afternoon_desc' => 'Settle into an intimate beach hideaway sheltered by swaying coconut groves.',
                        'evening_desc' => 'Watch the sunset ignite the waves while enjoying grilled lobster and passion fruit cocktails.',
                        'stay_notes' => 'Buckingham Place Tangalle / Amanwella',
                        'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 10,
                        'title' => 'Private Coastal Boat & Snorkeling Cove',
                        'location' => 'Tangalle & Mawella',
                        'morning_desc' => 'Private morning boating expedition to sheltered coral reefs for snorkeling with sea turtles.',
                        'afternoon_desc' => 'Lazy afternoon nap in beach cabanas with chilled fresh king coconut water.',
                        'evening_desc' => 'Beach barbecue dinner under southern stars with ocean breezes.',
                        'stay_notes' => 'Buckingham Place Tangalle',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 11,
                        'title' => 'Organic Spice Farm Feast & Coconut Hearth',
                        'location' => 'Weligama & Galle Hinterland',
                        'morning_desc' => 'Visit a family-owned cinnamon peelers cottage and learn ancient stripping techniques.',
                        'afternoon_desc' => 'Traditional claypot lunch cooked over wood embers with roasted jackfruit and pol sambol.',
                        'evening_desc' => 'Sunset walk on Galle Fort lighthouse ramparts with refreshing craft arrack tonics.',
                        'stay_notes' => 'The Fort Printers Galle',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 12,
                        'title' => 'Coastal Scenic Route & Airport Departure',
                        'location' => 'Galle to Colombo Airport',
                        'morning_desc' => 'Slow breakfast in the sunny colonial courtyard. Final artisan souvenir collections.',
                        'afternoon_desc' => 'Direct highway transfer to Colombo airport for your departure flight.',
                        'evening_desc' => 'Board your flight with peace of mind and cherished Ceylon connections.',
                        'stay_notes' => 'Departure Flight',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                ],
            ],
            [
                'title' => 'Wander Women: Wild & Sacred',
                'slug' => 'wander-women-wild-and-sacred',
                'subtitle' => 'All-Women Guided Soul Journey',
                'duration_days' => 10,
                'difficulty' => 'Easy',
                'group_size_max' => 10,
                'starting_price_usd' => 2350.00,
                'hero_image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=1200&q=80',
                'overview' => 'An empowering women-only travel experience led by female naturalists, tea masters, and Ayurvedic physicians across Sri Lanka’s sanctuary landscapes and boutique eco-villas.',
                'is_featured' => true,
                'order' => 5,
                'itineraries' => [
                    [
                        'day_number' => 1,
                        'title' => 'Colombo Welcome Circle & Coastal Sanctuary',
                        'location' => 'Colombo & Mount Lavinia',
                        'morning_desc' => 'Arrive in Colombo and meet your female tour leader and fellow wanderers.',
                        'afternoon_desc' => 'Opening circle, intention setting, and fresh herbal welcome tea by the coast.',
                        'evening_desc' => 'Welcome dinner under fairy lights with Sri Lankan female culinary entrepreneurs.',
                        'stay_notes' => 'Maniumpathy Colombo',
                        'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 2,
                        'title' => 'Dambulla Cave Sanctuaries & Women Weaver Co-op',
                        'location' => 'Dambulla & Kurunegala',
                        'morning_desc' => 'Visit a women-owned handloom weaving co-op empowering rural artisans.',
                        'afternoon_desc' => 'Explore the ancient Dambulla cave temples, experiencing quiet moments of reflection.',
                        'evening_desc' => 'Check in to a boutique eco-lodge surrounded by dry-zone birds and lotus ponds.',
                        'stay_notes' => 'Aliya Resort & Spa',
                        'image' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 3,
                        'title' => 'Sigiriya Sunrise & Village Hearth with Amma Lakshmi',
                        'location' => 'Sigiriya',
                        'morning_desc' => 'Sunrise climb of Lion Rock together, feeling the historic energy of the ancient citadel.',
                        'afternoon_desc' => 'Cook side-by-side with Amma Lakshmi in her village mud-brick kitchen, learning generational spice blends.',
                        'evening_desc' => 'Herbal foot massages and relaxation around the infinity pool.',
                        'stay_notes' => 'Aliya Resort & Spa',
                        'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 4,
                        'title' => 'Kandy Temple Drumming & Female Botanist Garden Walk',
                        'location' => 'Kandy & Peradeniya',
                        'morning_desc' => 'Morning puja at the Temple of the Tooth with traditional percussion resonance.',
                        'afternoon_desc' => 'Walk the Peradeniya Botanical Gardens led by a pioneering Sri Lankan female botanist.',
                        'evening_desc' => 'Stay at a colonial manor house filled with antique art and courtyard gardens.',
                        'stay_notes' => 'The Kandy House',
                        'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 5,
                        'title' => 'Blue Mountain Train & Ella Ridge Yoga',
                        'location' => 'Highlands to Ella',
                        'morning_desc' => 'Colonial train ride winding through tea hills and roaring waterfalls.',
                        'afternoon_desc' => 'Sunset yoga on a panoramic wooden deck overlooking Ella Gap.',
                        'evening_desc' => 'Highland herbal tea bar and storytelling evening around the wood burner.',
                        'stay_notes' => '98 Acres Resort & Spa',
                        'image' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 6,
                        'title' => 'Tea Pluckers’ Solidarity & Artisan Blending',
                        'location' => 'Ella Tea Country',
                        'morning_desc' => 'Spend the morning with local female estate tea pluckers, learning about their lives and traditions.',
                        'afternoon_desc' => 'Create your own personalized bespoke tea blend with single-estate black teas and wild flowers.',
                        'evening_desc' => 'Scenic dinner with panoramic vistas of the illuminated Nine Arch Bridge.',
                        'stay_notes' => '98 Acres Resort & Spa',
                        'image' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 7,
                        'title' => 'Wildlife Safari with Female Field Naturalist',
                        'location' => 'Yala Buffer Zone',
                        'morning_desc' => 'Descend to the southern wild plains for glamping under starry skies.',
                        'afternoon_desc' => 'Game drive led by one of Sri Lanka’s rare certified female wildlife safari naturalists.',
                        'evening_desc' => 'Campfire discussion on female conservation leadership in South Asia.',
                        'stay_notes' => 'Wild Coast Tented Lodge',
                        'image' => 'https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 8,
                        'title' => 'Mirissa Ocean Meditation & Sound Bath',
                        'location' => 'Mirissa & Hiriketiya',
                        'morning_desc' => 'Gentle ocean sunrise breathwork and meditation on the golden sands of Mirissa.',
                        'afternoon_desc' => 'Ayurvedic consultation and Abhyanga therapy with Dr. Nilmini Senanayake.',
                        'evening_desc' => 'Sunset singing bowl sound healing session in a beachfront pavilion.',
                        'stay_notes' => 'Dots Bay House / Weligama Eco Villa',
                        'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 9,
                        'title' => 'Galle Fort Female Artists & Rampart Sunset',
                        'location' => 'Galle Fort',
                        'morning_desc' => 'Private visits to female painters, jewelry silversmiths, and lace makers inside Galle Fort.',
                        'afternoon_desc' => 'Stroll along the historic ocean walls watching waves crash against ancient stones.',
                        'evening_desc' => 'Celebration farewell dinner with fresh seafood and island storytelling.',
                        'stay_notes' => 'Fort Bazaar Galle',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'day_number' => 10,
                        'title' => 'Closing Circle & Departure',
                        'location' => 'Galle to Colombo Airport',
                        'morning_desc' => 'Closing reflection circle, sharing insights and tokens of gratitude.',
                        'afternoon_desc' => 'Private group transfer to Bandaranaike International Airport.',
                        'evening_desc' => 'Fly home empowered, nourished, and bonded with lifelong friends.',
                        'stay_notes' => 'Departure Flight',
                        'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                    ],
                ],
            ],
        ];

        foreach ($packages as $pkgData) {
            $itineraries = $pkgData['itineraries'];
            unset($pkgData['itineraries']);

            $package = Package::updateOrCreate(
                ['slug' => $pkgData['slug']],
                $pkgData
            );

            foreach ($itineraries as $itData) {
                PackageItinerary::updateOrCreate(
                    [
                        'package_id' => $package->id,
                        'day_number' => $itData['day_number'],
                    ],
                    $itData
                );
            }
        }
    }

    private function seedDestinations(): void
    {
        $destinations = [
            [
                'name' => 'Cultural Triangle',
                'slug' => 'cultural-triangle',
                'hero_image' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'The cradle of ancient Sinhalese civilization featuring UNESCO fortress palaces, monumental stupas, and cave monasteries nestled in dry-zone forest.',
                'best_season' => 'November to April',
            ],
            [
                'name' => 'Knuckles Mountain Range',
                'slug' => 'knuckles-mountain-range',
                'hero_image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'A UNESCO World Heritage wilderness of misty peaks, secluded cloud forest trails, hidden waterfalls, and biodiversity-rich valleys.',
                'best_season' => 'Year-round / December to March',
            ],
            [
                'name' => 'Ella & Central Highlands',
                'slug' => 'ella-central-highlands',
                'hero_image' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'Cascading waterfalls, iconic Nine Arch railway viaducts, emerald tea plantation slopes, and breezy hill country ridges.',
                'best_season' => 'December to April',
            ],
            [
                'name' => 'Yala & Wild South',
                'slug' => 'yala-wild-south',
                'hero_image' => 'https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'Arid coastlines, dense thorny scrub, sacred pilgrimage sites, and the highest leopard density in the world.',
                'best_season' => 'February to July',
            ],
            [
                'name' => 'Galle Fort & Southern Coast',
                'slug' => 'galle-fort-southern-coast',
                'hero_image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
                'short_desc' => '17th-century Dutch colonial bastion streets, turquoise surf coves, artisan jewelry shops, and golden ocean sunsets.',
                'best_season' => 'November to April',
            ],
        ];

        foreach ($destinations as $dest) {
            Destination::updateOrCreate(['slug' => $dest['slug']], $dest);
        }
    }

    private function seedInsiders(): void
    {
        $insiders = [
            [
                'name' => 'Rohan Jayawardena',
                'role' => 'Driver-Storyteller',
                'experience_years' => 14,
                'bio' => 'I grew up in the misty tea villages outside Hatton. I love taking our travelers to my friend’s estate where we can pick wild tea leaves and drink fresh ginger tea together on the ridge.',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
                'languages' => ['English', 'Sinhala', 'Tamil'],
            ],
            [
                'name' => 'Dr. Nilmini Senanayake',
                'role' => 'Ayurvedic Physician & Wellness Curator',
                'experience_years' => 12,
                'bio' => 'Ayurveda in Sri Lanka is rooted in balance and local forest herbs. On our wellness retreats, I help guests identify their doshas and reset through unhurried healing.',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
                'languages' => ['English', 'Sinhala'],
            ],
            [
                'name' => 'Chathura Samarasinghe',
                'role' => 'Senior Naturalist & Wildlife Spotter',
                'experience_years' => 10,
                'bio' => 'Tracking leopards and sloth bears in Yala requires patience, deep listening to bird alarm calls, and understanding the rhythm of the jungle. I share the hidden language of Ceylon’s wild with every guest.',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80',
                'languages' => ['English', 'Sinhala'],
            ],
        ];

        foreach ($insiders as $insider) {
            Insider::updateOrCreate(['name' => $insider['name']], $insider);
        }
    }

    private function seedReviews(): void
    {
        $reviews = [
            [
                'guest_name' => 'Sarah Jenkins',
                'guest_country' => 'Melbourne, Australia',
                'rating' => 5,
                'text' => 'The antithesis of commercial tourism. We joined the 10-day small group trip with 7 other people. It felt like a group of old friends on a road trip. Our guide, Chathura, stopped at a roadside king coconut stall that led to a 2-hour conversation with village fishermen. Pure magic.',
                'tour_name' => 'Small Group Trip',
                'avatar' => null,
                'is_featured' => true,
            ],
            [
                'guest_name' => 'Marcus & Lea Laurent',
                'guest_country' => 'Lyon, France',
                'rating' => 5,
                'text' => 'Flawlessly planned bespoke honeymoon. Kiyara designed our 14-day chauffeured tour. We stayed in tea estate bungalows that felt plucked out of a dream. Our driver Rohan was patient, kind, and knowledgeable. We didn\'t have to stress about a single logistics detail.',
                'tour_name' => 'Private Honeymoon',
                'avatar' => null,
                'is_featured' => true,
            ],
            [
                'guest_name' => 'Astrid Weber',
                'guest_country' => 'Berlin, Germany',
                'rating' => 5,
                'text' => 'Ayurveda that changed my perspective. Traveling solo as a woman, safety was paramount. From the moment I was picked up at CMB airport, I felt cocooned in genuine hospitality. The Knuckles eco-lodge was the most peaceful place I have ever visited on earth.',
                'tour_name' => 'Solo Wellness',
                'avatar' => null,
                'is_featured' => true,
            ],
        ];

        foreach ($reviews as $rev) {
            Review::updateOrCreate(
                ['guest_name' => $rev['guest_name'], 'tour_name' => $rev['tour_name']],
                $rev
            );
        }
    }

    private function seedInquiries(): void
    {
        $inquiries = [
            [
                'name' => 'Eleanor Vance',
                'email' => 'eleanor.vance@example.co.uk',
                'phone' => '+44 7700 900077',
                'country' => 'United Kingdom',
                'travel_type' => 'couple',
                'duration_days' => 14,
                'guests' => 2,
                'preferred_season' => 'February 2025 - April 2025',
                'tier' => 'Heritage Boutique',
                'estimated_cost_usd' => 3800.00,
                'notes' => 'We love tea hill walks, Geoffrey Bawa architecture, boutique hotels, quiet beaches, and want to avoid tourist crowds.',
                'status' => 'new',
            ],
            [
                'name' => 'Dr. Julian Thorne',
                'email' => 'j.thorne@sydney-uni.edu.au',
                'phone' => '+61 412 345 678',
                'country' => 'Australia',
                'travel_type' => 'family',
                'duration_days' => 10,
                'guests' => 4,
                'preferred_season' => 'November 2024 - January 2025',
                'tier' => 'Essential Comfort',
                'estimated_cost_usd' => 4300.00,
                'notes' => 'Traveling with two teenagers. Interested in leopard safari, scenic blue train ride, and ethical elephant experiences.',
                'status' => 'contacted',
            ],
        ];

        foreach ($inquiries as $inq) {
            Inquiry::updateOrCreate(['email' => $inq['email']], $inq);
        }
    }

    private function seedLeadDownloads(): void
    {
        $downloads = [
            [
                'name' => 'Sophie Martin',
                'email' => 'sophie.m@paristravel.fr',
                'guide_slug' => 'secret-ceylon-guide-2025',
            ],
            [
                'name' => 'David Miller',
                'email' => 'david.miller@seattleadventures.com',
                'guide_slug' => 'secret-ceylon-guide-2025',
            ],
        ];

        foreach ($downloads as $dl) {
            LeadDownload::updateOrCreate(['email' => $dl['email']], $dl);
        }
    }

    private function seedSiteSettings(): void
    {
        $settings = [
            [
                'key' => 'company_name',
                'value' => 'Kiyara Holidays (Pvt) Ltd.',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'company_slogan',
                'value' => 'Boutique Ceylon Journeys',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'contact_email',
                'value' => 'hello@kiyaraholidays.com',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+94 (77) 123-4567',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_address',
                'value' => '42/B Lighthouse Street, Galle Fort, Sri Lanka',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '+94771234567',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'whatsapp_widget_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'contact',
            ],
            [
                'key' => 'license_number',
                'value' => 'SLTDA/TDA/02914',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'currency_rates',
                'value' => json_encode([
                    'USD' => ['rate' => 1.0, 'symbol' => '$'],
                    'EUR' => ['rate' => 0.92, 'symbol' => '€'],
                    'GBP' => ['rate' => 0.79, 'symbol' => '£'],
                    'AUD' => ['rate' => 1.52, 'symbol' => 'A$'],
                ]),
                'type' => 'json',
                'group' => 'currency',
            ],
            [
                'key' => 'guide_title',
                'value' => 'The Insider’s Guide to Ceylon: 40 Hidden Corners',
                'type' => 'text',
                'group' => 'marketing',
            ],
            [
                'key' => 'guide_edition',
                'value' => 'Free 2025 Edition',
                'type' => 'text',
                'group' => 'marketing',
            ],
            [
                'key' => 'hero_headline',
                'value' => 'Not just a holiday, but a journey that [lingers in your soul.]',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'hero_subheadline',
                'value' => 'We move away from crowded tourist coaches. Join intimate, thoughtfully guided journeys, stay in colonial heritage bungalows and eco-villas, and connect directly with local islanders.',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'hero_background_image',
                'value' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=2000&q=80',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'hero_badge_1',
                'value' => 'Carbon-Balanced Trips',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'hero_badge_2',
                'value' => 'Max 12 Travelers on Groups',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'hero_badge_3',
                'value' => 'SLTDA Certified Insider Drivers',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'theme_primary_color',
                'value' => '#1a3b32',
                'type' => 'text',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_secondary_color',
                'value' => '#c86d51',
                'type' => 'text',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_background_color',
                'value' => '#f4efe6',
                'type' => 'text',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_text_color',
                'value' => '#1e292b',
                'type' => 'text',
                'group' => 'theme',
            ],
            [
                'key' => 'homepage_sections_order',
                'value' => json_encode([
                    ['id' => 'hero', 'label' => 'Hero & Quick Search', 'enabled' => true, 'order' => 1],
                    ['id' => 'featured_packages', 'label' => 'Signature & Group Journeys', 'enabled' => true, 'order' => 2],
                    ['id' => 'experiences', 'label' => 'Experiential Offerings & Soul', 'enabled' => true, 'order' => 3],
                    ['id' => 'trip_builder', 'label' => 'Custom Trip Builder & Estimator', 'enabled' => true, 'order' => 4],
                    ['id' => 'destinations', 'label' => 'Island Regions & Destinations', 'enabled' => true, 'order' => 5],
                    ['id' => 'insiders', 'label' => 'Local Insiders & Drivers', 'enabled' => true, 'order' => 6],
                    ['id' => 'reviews', 'label' => 'Guest Testimonials', 'enabled' => true, 'order' => 7],
                ]),
                'type' => 'json',
                'group' => 'layout',
            ],
        ];

        foreach ($settings as $st) {
            SiteSetting::updateOrCreate(['key' => $st['key']], $st);
        }
    }
}

