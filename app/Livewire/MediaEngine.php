<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

/**
 * Media Engine — Lingo's social-media / blog content control panel.
 *
 * Two views: "Set Up" (clients, channels, blog settings) and "Review"
 * (approve/reject queued drafts). Live data comes from the n8n Control Panel
 * webhooks; the shared secret is attached server-side here so it never reaches
 * the browser. Falls back to seed/demo data until live data is loaded.
 */
class MediaEngine extends Component
{
    /** @var string 'settings' | 'review' */
    public $view = 'settings';

    /** @var array<int, array> */
    public $clients = [];

    /** @var array<int, array> */
    public $pending = [];

    public $selectedClient = 'all';
    public $reviewClient = 'all';
    public $reviewSel = null;

    public $liveLoaded = false;

    // Add-client form
    public $showAddForm = false;
    public $newName = '';
    public $newLocation = '';
    public $newGroup = '';
    public $newVoice = '';
    public $newTopics = '';
    public $newRules = '';
    public $newPlatforms = ['Facebook', 'LinkedIn'];
    public $newCadence = 'Weekly';
    public $newTimes = '';
    public $newBlog = false;
    public $newBlogFreq = 'Weekly';
    public $newBlogTarget = 'drafts';

    public const PLATFORMS = ['Facebook', 'Instagram', 'LinkedIn', 'X (Twitter)', 'TikTok', 'YouTube', 'Pinterest', 'Threads', 'Google Business', 'Bluesky'];
    public const CADENCES = ['3 per week', '2 per week', 'Weekly', 'Monthly'];
    public const BLOGFREQ = ['Weekly', 'Bi-Weekly', 'Monthly'];
    public const EMOJI = ['0', '0 to 1', '1 to 2', '2 to 3'];
    public const BLOGTARGETS = [
        'drafts' => 'Drafts (review)',
        'spark' => 'Lingo Spark (manual)',
        'wordpress' => 'WordPress (draft)',
        'joomla' => 'Joomla (unpublished)',
    ];
    public const NEEDS = ['Instagram' => 'needs a photo', 'TikTok' => 'needs a video', 'YouTube' => 'needs a video', 'Pinterest' => 'needs a photo'];

    public function mount()
    {
        $seed = $this->seed();
        $this->clients = $seed['clients'];
        $this->pending = $seed['pending'];
        $this->selectedClient = $this->clients[0]['id'] ?? 'all';
    }

    /* ---------------------------------------------------------------- view */

    public function setView($v)
    {
        $this->view = $v === 'review' ? 'review' : 'settings';
    }

    /* ------------------------------------------------------------- helpers */

    private function clientIndexById($id)
    {
        foreach ($this->clients as $i => $c) {
            if ($c['id'] === $id) {
                return $i;
            }
        }
        return null;
    }

    private function slug($s)
    {
        $s = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $s));
        $s = trim($s, '-');
        return $s ?: 'client';
    }

    /** Stats for the summary bar. */
    private function summary()
    {
        $accts = 0; $on = 0; $blogs = 0;
        foreach ($this->clients as $c) {
            foreach ($c['accounts'] as $a) {
                $accts++;
                if (!empty($a['active'])) $on++;
            }
            if (!empty($c['blog']['active'])) $blogs++;
        }
        return ['clients' => count($this->clients), 'accts' => $accts, 'on' => $on, 'blogs' => $blogs];
    }

    private function pendingCount()
    {
        return count(array_filter($this->pending, fn ($p) => ($p['status'] ?? 'pending') === 'pending'));
    }

    /** Clients grouped by their "group" field for the picker optgroups. */
    private function groupedClients()
    {
        $groups = [];
        foreach ($this->clients as $c) {
            $g = trim($c['group'] ?? '') ?: 'Ungrouped';
            $groups[$g][] = $c;
        }
        uksort($groups, function ($a, $b) {
            if ($a === 'Ungrouped') return 1;
            if ($b === 'Ungrouped') return -1;
            return strcasecmp($a, $b);
        });
        return $groups;
    }

    private function isLive($c)
    {
        foreach ($c['accounts'] as $a) {
            if (!empty($a['active'])) return true;
        }
        return !empty($c['blog']['active']);
    }

    /* ----------------------------------------------------- client editing */

    public function addAccount($clientIndex, $platform)
    {
        if (!isset($this->clients[$clientIndex])) return;
        $this->clients[$clientIndex]['accounts'][] = [
            'platform' => $platform, 'accountId' => '', 'active' => true, 'cadence' => 'Weekly', 'postTimes' => '',
        ];
    }

    public function removeAccount($clientIndex, $accountIndex)
    {
        if (!isset($this->clients[$clientIndex]['accounts'][$accountIndex])) return;
        array_splice($this->clients[$clientIndex]['accounts'], $accountIndex, 1);
    }

    public function removeClient($clientIndex)
    {
        if (!isset($this->clients[$clientIndex])) return;
        $removedId = $this->clients[$clientIndex]['id'];
        array_splice($this->clients, $clientIndex, 1);
        if ($this->selectedClient === $removedId) {
            $this->selectedClient = 'all';
        }
    }

    public function toggleAddForm()
    {
        $this->showAddForm = !$this->showAddForm;
    }

    public function addClient()
    {
        $this->validate([
            'newName' => ['required', 'string', 'max:255'],
        ], [], ['newName' => 'client name']);

        $id = $this->slug($this->newName) . '-' . count($this->clients);

        $accounts = [];
        foreach ($this->newPlatforms as $p) {
            $accounts[] = [
                'platform' => $p, 'accountId' => '', 'active' => true,
                'cadence' => $this->newCadence, 'postTimes' => trim($this->newTimes),
            ];
        }

        $this->clients[] = [
            'id' => $id,
            'name' => trim($this->newName),
            'location' => trim($this->newLocation),
            'group' => trim($this->newGroup),
            'voice' => trim($this->newVoice),
            'topicSeed' => trim($this->newTopics),
            'rules' => trim($this->newRules),
            'imageFolder' => '',
            'hashtags' => 3,
            'emoji' => '0 to 1',
            'blog' => ['active' => (bool) $this->newBlog, 'frequency' => $this->newBlogFreq, 'target' => $this->newBlogTarget, 'siteUrl' => ''],
            'accounts' => $accounts,
        ];

        $this->selectedClient = $id;
        $this->reset(['newName', 'newLocation', 'newGroup', 'newVoice', 'newTopics', 'newRules', 'newTimes', 'newBlog']);
        $this->newPlatforms = ['Facebook', 'LinkedIn'];
        $this->newCadence = 'Weekly';
        $this->showAddForm = false;
    }

    public function resetDemo()
    {
        $seed = $this->seed();
        $this->clients = $seed['clients'];
        $this->pending = $seed['pending'];
        $this->selectedClient = $this->clients[0]['id'] ?? 'all';
        $this->reviewSel = null;
        $this->liveLoaded = false;
        session()->flash('me_status', 'Reset to demo data.');
    }

    /* -------------------------------------------------------- draft logic */

    private function generateFor(&$client)
    {
        $n = 0;
        foreach ($client['accounts'] as $a) {
            if (!empty($a['active'])) {
                $this->pending[] = [
                    'id' => 'g' . uniqid() . '_' . ($n++),
                    'type' => 'social',
                    'client' => $client['name'],
                    'platform' => $a['platform'],
                    'when' => 'Just now',
                    'status' => 'pending',
                    'caption' => 'Sample ' . $a['platform'] . ' draft for ' . $client['name'] . '. Wired to the engine, this is written in their voice from their topic and cadence.',
                ];
            }
        }
        if (!empty($client['blog']['active'])) {
            $this->pending[] = [
                'id' => 'g' . uniqid() . '_b' . ($n++),
                'type' => 'blog',
                'client' => $client['name'],
                'title' => 'Sample blog draft for ' . $client['name'],
                'target' => $client['blog']['target'] ?? 'drafts',
                'when' => 'Just now',
                'status' => 'pending',
                'body' => 'Placeholder article for ' . $client['name'] . '. The live engine writes a full humanized article from their voice and topic, then routes it to the chosen destination.',
            ];
        }
        return $n;
    }

    public function generateForClient($clientIndex)
    {
        if (!isset($this->clients[$clientIndex])) return;
        $n = $this->generateFor($this->clients[$clientIndex]);
        if (!$n) {
            session()->flash('me_error', 'No active channels for ' . $this->clients[$clientIndex]['name'] . '. Toggle an account or the blog on first.');
            return;
        }
        $this->reviewClient = $this->clients[$clientIndex]['id'];
        $this->reviewSel = null;
        $this->setView('review');
    }

    public function generateDrafts()
    {
        $targets = [];
        if ($this->selectedClient === 'all') {
            $targets = array_keys($this->clients);
        } else {
            $i = $this->clientIndexById($this->selectedClient);
            if ($i !== null) $targets = [$i];
        }
        $n = 0;
        foreach ($targets as $i) {
            $n += $this->generateFor($this->clients[$i]);
        }
        if (!$n) {
            session()->flash('me_error', 'No active channels to generate. Toggle an account or blog on first.');
            return;
        }
        $this->reviewClient = $this->selectedClient;
        $this->reviewSel = null;
        $this->setView('review');
    }

    /* ------------------------------------------------------------- review */

    public function selectReview($id)
    {
        $this->reviewSel = $id;
    }

    public function approve($id)
    {
        $this->setStatus($id, 'approved');
    }

    public function reject($id)
    {
        $this->setStatus($id, 'rejected');
    }

    private function setStatus($id, $status)
    {
        foreach ($this->pending as $i => $p) {
            if (($p['id'] ?? null) == $id) {
                $this->pending[$i]['status'] = $status;
                if (($p['type'] ?? 'social') === 'social') {
                    $this->n8n('POST', '/webhook/panel-review', ['key' => $id, 'action' => $status === 'approved' ? 'approve' : 'reject']);
                }
                break;
            }
        }
        $this->reviewSel = null;
    }

    /* --------------------------------------------------------- n8n bridge */

    private function n8n($method, $path, $body = null)
    {
        $base = rtrim((string) config('services.n8n.base'), '/');
        $req = Http::withHeaders(['X-Panel-Secret' => config('services.n8n.panel_secret')])->timeout(30);
        return $method === 'POST' ? $req->post($base . $path, $body ?? []) : $req->get($base . $path);
    }

    public function loadLiveRoster()
    {
        $names = ['facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'x' => 'X (Twitter)', 'twitter' => 'X (Twitter)', 'tiktok' => 'TikTok', 'youtube' => 'YouTube', 'pinterest' => 'Pinterest', 'threads' => 'Threads', 'bluesky' => 'Bluesky'];

        try {
            $res = $this->n8n('GET', '/webhook/panel-roster');
            if (!$res->ok()) {
                throw new \RuntimeException('HTTP ' . $res->status());
            }
            $rows = $res->json() ?? [];

            $clients = [];
            foreach ($rows as $i => $r) {
                $plats = array_filter(array_map('trim', explode(',', (string) ($r['platforms'] ?? ''))));
                $accounts = [];
                foreach ($plats as $p) {
                    $k = strtolower($p);
                    $accounts[] = [
                        'platform' => $names[$k] ?? ucfirst($p),
                        'accountId' => $r['pfm_' . $k] ?? '',
                        'active' => strtolower((string) ($r['active'] ?? '')) === 'yes',
                        'cadence' => $r['cadence'] ?? 'Weekly',
                        'postTimes' => $r['post_times'] ?? '',
                    ];
                }
                $clients[] = [
                    'id' => $this->slug((string) ($r['client'] ?? ('c' . $i))),
                    'name' => $r['client'] ?? '',
                    'location' => $r['location'] ?? '',
                    'group' => $r['group'] ?? '',
                    'voice' => $r['voiceProfile'] ?? '',
                    'topicSeed' => $r['topicSeed'] ?? '',
                    'rules' => $r['rules'] ?? '',
                    'imageFolder' => $r['image_folder'] ?? '',
                    'hashtags' => $r['hashtagCount'] ?? 3,
                    'emoji' => $r['emojiPolicy'] ?? '0 to 1',
                    'blog' => [
                        'active' => strtolower((string) ($r['blog_active'] ?? '')) === 'yes',
                        'frequency' => $r['blog_frequency'] ?? 'Weekly',
                        'target' => $r['blog_target'] ?? 'drafts',
                        'siteUrl' => $r['blog_site_url'] ?? '',
                    ],
                    'accounts' => $accounts,
                ];
            }

            $pRes = $this->n8n('GET', '/webhook/panel-pending');
            if ($pRes->ok()) {
                $pend = $pRes->json() ?? [];
                $this->pending = [];
                foreach ($pend as $p) {
                    if (empty($p['client'])) continue;
                    $this->pending[] = [
                        'id' => (string) ($p['post_key'] ?? $p['id'] ?? ('row' . ($p['row_number'] ?? ''))),
                        'type' => 'social',
                        'client' => $p['client'],
                        'platform' => $names[strtolower((string) ($p['platform'] ?? ''))] ?? ($p['platform'] ?? ''),
                        'caption' => $p['caption'] ?? '',
                        'when' => $p['scheduled_at'] ?? 'Pending',
                        'status' => $p['status'] ?? 'pending',
                    ];
                }
                $this->reviewClient = 'all';
                $this->reviewSel = null;
            }

            $this->clients = $clients;
            $this->selectedClient = $clients[0]['id'] ?? 'all';
            $this->liveLoaded = true;
            session()->flash('me_status', 'Live data loaded — ' . count($clients) . ' clients.');
        } catch (\Throwable $e) {
            session()->flash('me_error', 'Could not reach n8n: ' . $e->getMessage());
        }
    }

    public function saveToSandbox()
    {
        try {
            $res = $this->n8n('POST', '/webhook/panel-save', ['clients' => $this->clients]);
            if (!$res->ok()) {
                throw new \RuntimeException('HTTP ' . $res->status());
            }
            session()->flash('me_status', 'Saved to sandbox.');
        } catch (\Throwable $e) {
            session()->flash('me_error', 'Save to sandbox failed: ' . $e->getMessage());
        }
    }

    public function export()
    {
        $payload = json_encode(['clients' => $this->clients, 'pending' => $this->pending], JSON_PRETTY_PRINT);
        return response()->streamDownload(function () use ($payload) {
            echo $payload;
        }, 'content-roster.json');
    }

    public function render()
    {
        return view('livewire.media-engine', [
            'summary' => $this->summary(),
            'pendingCount' => $this->pendingCount(),
            'groupedClients' => $this->groupedClients(),
        ]);
    }

    /* --------------------------------------------------------- seed data */

    private function seed()
    {
        return [
            'clients' => [
                [
                    'id' => 'employment-solutions', 'name' => 'Employment Solutions', 'location' => 'Mabelvale, Arkansas', 'group' => 'Staffing',
                    'voice' => 'A supportive career-services team. Warm, practical, encouraging. Talks to job seekers like a helpful neighbor, never corporate.',
                    'topicSeed' => '', 'rules' => '', 'imageFolder' => '', 'hashtags' => 3, 'emoji' => '0 to 1',
                    'blog' => ['active' => true, 'frequency' => 'Weekly', 'target' => 'wordpress', 'siteUrl' => 'https://employment-solution.com'],
                    'accounts' => [
                        ['platform' => 'Facebook', 'accountId' => 'spc_DRYRUN_TEST', 'active' => true, 'cadence' => '3 per week', 'postTimes' => '8am, 7pm'],
                        ['platform' => 'LinkedIn', 'accountId' => '', 'active' => true, 'cadence' => 'Weekly', 'postTimes' => '9am'],
                    ],
                ],
                [
                    'id' => 'smart-comfort', 'name' => 'Smart Comfort', 'location' => 'Little Rock, Arkansas', 'group' => 'Home Services',
                    'voice' => 'A trustworthy local HVAC company. Friendly, no-nonsense, helpful. Explains things plainly without scare tactics.',
                    'topicSeed' => '', 'rules' => '', 'imageFolder' => '', 'hashtags' => 3, 'emoji' => '0 to 1',
                    'blog' => ['active' => true, 'frequency' => 'Bi-Weekly', 'target' => 'spark', 'siteUrl' => ''],
                    'accounts' => [
                        ['platform' => 'Facebook', 'accountId' => '', 'active' => true, 'cadence' => '2 per week', 'postTimes' => '7am, 5pm'],
                        ['platform' => 'Instagram', 'accountId' => '', 'active' => true, 'cadence' => 'Weekly', 'postTimes' => '12pm'],
                        ['platform' => 'Google Business', 'accountId' => '', 'active' => true, 'cadence' => 'Weekly', 'postTimes' => '8am'],
                    ],
                ],
                [
                    'id' => 'therapeutic-family-services', 'name' => 'Therapeutic Family Services', 'location' => 'Arkansas', 'group' => 'Healthcare',
                    'voice' => 'A compassionate family-services provider. Calm, reassuring, professional. Centers families and trust.',
                    'topicSeed' => '', 'rules' => '', 'imageFolder' => '', 'hashtags' => 2, 'emoji' => '0',
                    'blog' => ['active' => true, 'frequency' => 'Monthly', 'target' => 'drafts', 'siteUrl' => ''],
                    'accounts' => [
                        ['platform' => 'Facebook', 'accountId' => '', 'active' => true, 'cadence' => 'Weekly', 'postTimes' => '10am'],
                        ['platform' => 'LinkedIn', 'accountId' => '', 'active' => true, 'cadence' => 'Weekly', 'postTimes' => '8am'],
                    ],
                ],
                [
                    'id' => 'fleming-heating-air', 'name' => 'Fleming Heating & Air', 'location' => 'Arkansas', 'group' => 'Home Services',
                    'voice' => 'A family-owned heating and air company. Down-to-earth, dependable, community-minded.',
                    'topicSeed' => '', 'rules' => '', 'imageFolder' => '', 'hashtags' => 3, 'emoji' => '0 to 1',
                    'blog' => ['active' => false, 'frequency' => 'Monthly', 'target' => 'drafts', 'siteUrl' => ''],
                    'accounts' => [
                        ['platform' => 'Facebook', 'accountId' => '', 'active' => true, 'cadence' => 'Weekly', 'postTimes' => '9am'],
                        ['platform' => 'Instagram', 'accountId' => '', 'active' => false, 'cadence' => 'Weekly', 'postTimes' => ''],
                    ],
                ],
                [
                    'id' => 'lingobingo-sandbox', 'name' => 'LingoBingo (sandbox)', 'location' => 'Internal test', 'group' => 'Internal',
                    'voice' => 'Throwaway sandbox brand for testing. No real posting.',
                    'topicSeed' => '', 'rules' => '', 'imageFolder' => '', 'hashtags' => 3, 'emoji' => '1 to 2',
                    'blog' => ['active' => false, 'frequency' => 'Weekly', 'target' => 'wordpress', 'siteUrl' => 'https://lingobingo.example'],
                    'accounts' => [
                        ['platform' => 'Facebook', 'accountId' => '', 'active' => false, 'cadence' => 'Weekly', 'postTimes' => ''],
                        ['platform' => 'X (Twitter)', 'accountId' => '', 'active' => false, 'cadence' => 'Weekly', 'postTimes' => ''],
                    ],
                ],
            ],
            'pending' => [
                ['id' => 'p1', 'type' => 'social', 'client' => 'Employment Solutions', 'platform' => 'Facebook', 'when' => 'Tomorrow, 8:00 AM', 'status' => 'pending',
                 'caption' => "You know that moment when they say \"tell me about yourself\" and your mind goes blank? Here's the trick: don't recite your whole resume. Give them a quick story in three parts. Where you are now, one or two experiences that got you here, and why you're excited about this role. Keep it to 90 seconds. At Employment Solutions we practice this with folks all the time, and it makes a real difference.\n\n#JobInterviewTips #CareerAdvice #ArkansasJobs"],
                ['id' => 'p2', 'type' => 'social', 'client' => 'Smart Comfort', 'platform' => 'Instagram', 'when' => 'Tomorrow, 12:00 PM', 'status' => 'pending',
                 'caption' => "Three signs your AC is quietly begging for a tune-up before the Arkansas heat really hits:\n\n1. It runs longer than it used to\n2. Some rooms never quite cool down\n3. Your last bill made you do a double take\n\nA quick spring check-up beats a July breakdown every time.\n\n#HVAC #LittleRock #StayCool"],
                ['id' => 'p3', 'type' => 'social', 'client' => 'Smart Comfort', 'platform' => 'Facebook', 'when' => 'Tomorrow, 7:00 AM', 'status' => 'pending',
                 'caption' => "Summer's coming, and so are the surprise breakdowns. Here's the one cheap thing most folks skip: changing your air filter every month during heavy-use season. A clogged filter makes your system work harder, runs your bill up, and shortens its life. Five dollars and five minutes. Your future self says thanks.\n\n#HomeComfort #HVACtips #Arkansas"],
                ['id' => 'p4', 'type' => 'social', 'client' => 'Therapeutic Family Services', 'platform' => 'LinkedIn', 'when' => 'Wed, 8:00 AM', 'status' => 'pending',
                 'caption' => "Supporting a family member through a hard season rarely starts with a grand gesture. It starts with small, steady presence. A check-in text. A shared meal. Showing up again the next day. Healing happens in the ordinary moments, and no family has to navigate them alone.\n\n#FamilySupport #MentalHealth #Community"],
                ['id' => 'b1', 'type' => 'blog', 'client' => 'Smart Comfort', 'title' => '5 Spring AC Tune-Up Steps Before the Arkansas Heat Hits', 'target' => 'spark', 'when' => 'Draft ready', 'status' => 'pending',
                 'body' => "Every spring the same thing happens. The first 90-degree day arrives, everyone cranks the AC at once, and the systems that were quietly struggling all winter finally give out.\n\nA little maintenance now saves a miserable call later. Five things worth doing before summer:\n\n1. Replace the air filter. A clogged filter makes the whole system work harder and runs your bill up.\n2. Clear the outdoor unit. Two feet of clearance, no grass clippings packed against the coils.\n3. Check the thermostat. If it is still manual, a programmable one pays for itself fast.\n4. Listen for new sounds. Rattles and hums are the cheap-to-fix stage. Do not wait for the expensive stage.\n5. Book a tune-up. A 30-minute checkup catches the small stuff before it becomes a July breakdown.\n\nWant us to handle it? Smart Comfort runs spring tune-ups across central Arkansas. One visit, and you stop thinking about it."],
            ],
        ];
    }
}
