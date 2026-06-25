<div class="space-y-6">
    {{-- Flash messages --}}
    @if (session('me_status'))
        <div class="alert alert-success">
            <span>{{ session('me_status') }}</span>
        </div>
    @endif
    @if (session('me_error'))
        <div class="alert alert-error">
            <span>{{ session('me_error') }}</span>
        </div>
    @endif

    <p class="text-base-content/70 text-sm">
        Two steps: <span class="font-semibold">Set Up</span> your clients and channels, then
        <span class="font-semibold">Review</span> what's queued before anything posts.
    </p>

    {{-- Tabs --}}
    <div class="tabs tabs-boxed bg-base-300 inline-flex">
        <a class="tab {{ $view === 'settings' ? 'tab-active' : '' }}" wire:click="setView('settings')">Set Up</a>
        <a class="tab {{ $view === 'review' ? 'tab-active' : '' }}" wire:click="setView('review')">
            Review
            @if ($pendingCount)
                <span class="badge badge-secondary badge-sm ml-2">{{ $pendingCount }}</span>
            @endif
        </a>
    </div>

    {{-- ============================================================ SET UP --}}
    @if ($view === 'settings')
        {{-- Client picker --}}
        <div class="form-control max-w-md">
            <label class="label"><span class="label-text">Client</span></label>
            <select class="select select-bordered" wire:model.live="selectedClient">
                <option value="all">All clients ({{ count($clients) }})</option>
                @foreach ($groupedClients as $group => $groupClients)
                    <optgroup label="{{ $group }}">
                        @foreach ($groupClients as $gc)
                            <option value="{{ $gc['id'] }}">{{ $gc['name'] }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>

        {{-- Summary --}}
        <div class="flex flex-wrap gap-6 text-sm text-base-content/70">
            <div><span class="block text-2xl font-bold text-base-content">{{ $summary['clients'] }}</span>clients</div>
            <div><span class="block text-2xl font-bold text-base-content">{{ $summary['accts'] }}</span>accounts</div>
            <div><span class="block text-2xl font-bold text-base-content">{{ $summary['on'] }}</span>active</div>
            <div><span class="block text-2xl font-bold text-base-content">{{ $summary['blogs'] }}</span>blogs</div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-wrap gap-2">
            <button class="btn btn-primary btn-sm" wire:click="generateDrafts">Generate drafts</button>
            <button class="btn btn-ghost btn-sm" wire:click="toggleAddForm">+ Add a client</button>
            <button class="btn btn-ghost btn-sm" wire:click="export">Export</button>
            <button class="btn btn-ghost btn-sm" wire:click="resetDemo"
                    wire:confirm="Reset to demo data? This wipes the current edits in this view.">Reset demo</button>
            <button class="btn btn-secondary btn-sm" wire:click="loadLiveRoster" wire:loading.attr="disabled" wire:target="loadLiveRoster">
                <span wire:loading.remove wire:target="loadLiveRoster">Load live roster</span>
                <span wire:loading wire:target="loadLiveRoster"><span class="loading loading-spinner loading-xs"></span> Loading…</span>
            </button>
            <button class="btn btn-outline btn-sm" wire:click="saveToSandbox" wire:loading.attr="disabled" wire:target="saveToSandbox">
                <span wire:loading.remove wire:target="saveToSandbox">Save to sandbox</span>
                <span wire:loading wire:target="saveToSandbox"><span class="loading loading-spinner loading-xs"></span> Saving…</span>
            </button>
        </div>

        {{-- Add-client form --}}
        @if ($showAddForm)
            <div class="card bg-base-100 border-2 border-dashed border-secondary">
                <div class="card-body">
                    <h3 class="card-title text-lg">New client</h3>
                    <p class="text-sm text-base-content/60 -mt-2">Fill the basics — you can fine-tune accounts after saving.</p>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Client name</span></label>
                        <input type="text" class="input input-bordered @error('newName') input-error @enderror"
                               wire:model="newName" placeholder="Business name">
                        @error('newName') <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Location</span></label>
                            <input type="text" class="input input-bordered" wire:model="newLocation" placeholder="City, State">
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Group <span class="opacity-60">(optional)</span></span></label>
                            <input type="text" class="input input-bordered" wire:model="newGroup" placeholder="e.g. HVAC, Q3 campaign">
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Brand voice</span></label>
                        <textarea class="textarea textarea-bordered" rows="2" wire:model="newVoice" placeholder="Who they are and how they sound"></textarea>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">What to post about <span class="opacity-60">(topics)</span></span></label>
                        <textarea class="textarea textarea-bordered" rows="2" wire:model="newTopics" placeholder="Themes the AI draws from — services, seasonal angles, FAQs, promotions"></textarea>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Content guardrails <span class="opacity-60">(optional)</span></span></label>
                        <textarea class="textarea textarea-bordered" rows="2" wire:model="newRules" placeholder="Hard rules: claims to avoid, words to skip, required disclaimers"></textarea>
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Post on</span></label>
                        <div class="flex flex-wrap gap-x-4 gap-y-2">
                            @foreach (\App\Livewire\MediaEngine::PLATFORMS as $p)
                                <label class="label cursor-pointer justify-start gap-2 py-0">
                                    <input type="checkbox" class="checkbox checkbox-sm checkbox-secondary" value="{{ $p }}" wire:model="newPlatforms">
                                    <span class="label-text">{{ $p }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">How often (social)</span></label>
                            <select class="select select-bordered" wire:model="newCadence">
                                @foreach (\App\Livewire\MediaEngine::CADENCES as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Post times</span></label>
                            <input type="text" class="input input-bordered" wire:model="newTimes" placeholder="e.g. 8am, 7pm">
                        </div>
                    </div>

                    <label class="label cursor-pointer justify-start gap-3 mt-2">
                        <input type="checkbox" class="toggle toggle-secondary" wire:model.live="newBlog">
                        <span class="label-text">Also generate blog articles</span>
                    </label>
                    @if ($newBlog)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label"><span class="label-text">Blog frequency</span></label>
                                <select class="select select-bordered" wire:model="newBlogFreq">
                                    @foreach (\App\Livewire\MediaEngine::BLOGFREQ as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text">Publishes to</span></label>
                                <select class="select select-bordered" wire:model="newBlogTarget">
                                    @foreach (\App\Livewire\MediaEngine::BLOGTARGETS as $val => $lbl)
                                        <option value="{{ $val }}">{{ $lbl }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="card-actions mt-4">
                        <button class="btn btn-primary btn-sm" wire:click="addClient">Save</button>
                        <button class="btn btn-ghost btn-sm" wire:click="toggleAddForm">Cancel</button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Client cards --}}
        @forelse ($clients as $ci => $c)
            @if ($selectedClient === 'all' || $selectedClient === $c['id'])
                @php $used = array_column($c['accounts'], 'platform'); $free = array_values(array_diff(\App\Livewire\MediaEngine::PLATFORMS, $used)); @endphp
                <div class="card bg-base-100 shadow-md" wire:key="client-{{ $ci }}">
                    <div class="card-body">
                        <div class="flex justify-between items-start gap-3">
                            <div class="flex-1 space-y-1">
                                <input type="text" class="input input-ghost text-xl font-bold px-0 w-full"
                                       wire:model.blur="clients.{{ $ci }}.name">
                                <input type="text" class="input input-ghost input-sm text-base-content/60 px-0 w-full"
                                       wire:model.blur="clients.{{ $ci }}.location" placeholder="City, State">
                            </div>
                            <button class="btn btn-ghost btn-xs text-base-content/50"
                                    wire:click="removeClient({{ $ci }})"
                                    wire:confirm="Remove {{ $c['name'] }}?">Remove</button>
                        </div>

                        <div class="form-control max-w-sm">
                            <label class="label"><span class="label-text">Group <span class="opacity-60">(organizes the dropdown)</span></span></label>
                            <input type="text" class="input input-bordered input-sm" wire:model.blur="clients.{{ $ci }}.group" placeholder="e.g. HVAC, Q3 campaign">
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Brand voice</span></label>
                            <textarea class="textarea textarea-bordered" rows="2" wire:model.blur="clients.{{ $ci }}.voice"></textarea>
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">What to post about <span class="opacity-60">(topics)</span></span></label>
                            <textarea class="textarea textarea-bordered" rows="2" wire:model.blur="clients.{{ $ci }}.topicSeed"
                                      placeholder="e.g. seasonal HVAC tips, energy savings, maintenance reminders"></textarea>
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text">Content guardrails <span class="opacity-60">(optional)</span></span></label>
                            <textarea class="textarea textarea-bordered" rows="2" wire:model.blur="clients.{{ $ci }}.rules"
                                      placeholder="e.g. Never guarantee results. Avoid medical claims."></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label"><span class="label-text">Hashtags <span class="opacity-60">(per post)</span></span></label>
                                <input type="number" min="0" max="10" class="input input-bordered input-sm w-28" wire:model.blur="clients.{{ $ci }}.hashtags">
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text">Emoji <span class="opacity-60">(per post)</span></span></label>
                                <select class="select select-bordered select-sm w-32" wire:model.blur="clients.{{ $ci }}.emoji">
                                    @foreach (\App\Livewire\MediaEngine::EMOJI as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Images folder <span class="opacity-60">(auto-created)</span></span></label>
                            <input type="text" class="input input-bordered input-sm" wire:model.blur="clients.{{ $ci }}.imageFolder"
                                   placeholder="Auto-filled when the image-folder provisioner runs">
                            @if (!empty($c['imageFolder']) && \Illuminate\Support\Str::startsWith($c['imageFolder'], ['http://', 'https://']))
                                <a href="{{ $c['imageFolder'] }}" target="_blank" rel="noopener" class="link link-secondary text-xs mt-1">Open images folder</a>
                            @endif
                        </div>

                        {{-- Social accounts --}}
                        <div class="divider text-sm font-semibold">Social accounts</div>
                        @foreach ($c['accounts'] as $ai => $a)
                            <div class="rounded-box border border-base-300 p-4 mb-3 {{ empty($a['active']) ? 'opacity-60' : '' }}" wire:key="acct-{{ $ci }}-{{ $ai }}">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="font-semibold flex items-center gap-2 flex-wrap">
                                        {{ $a['platform'] }}
                                        @if (isset(\App\Livewire\MediaEngine::NEEDS[$a['platform']]))
                                            <span class="badge badge-warning badge-sm">{{ \App\Livewire\MediaEngine::NEEDS[$a['platform']] }}</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm {{ empty($a['active']) ? 'text-base-content/50' : 'text-success' }}">{{ empty($a['active']) ? 'Paused' : 'Active' }}</span>
                                        <input type="checkbox" class="toggle toggle-success" wire:model.live="clients.{{ $ci }}.accounts.{{ $ai }}.active">
                                    </div>
                                </div>
                                <div class="form-control mb-2">
                                    <label class="label py-1"><span class="label-text text-xs">Post for Me account ID</span></label>
                                    <input type="text" class="input input-bordered input-sm" wire:model.blur="clients.{{ $ci }}.accounts.{{ $ai }}.accountId" placeholder="spc_...">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="form-control">
                                        <label class="label py-1"><span class="label-text text-xs">How often</span></label>
                                        <select class="select select-bordered select-sm" wire:model.blur="clients.{{ $ci }}.accounts.{{ $ai }}.cadence">
                                            @foreach (\App\Livewire\MediaEngine::CADENCES as $opt)
                                                <option value="{{ $opt }}">{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-control">
                                        <label class="label py-1"><span class="label-text text-xs">Post times</span></label>
                                        <input type="text" class="input input-bordered input-sm" wire:model.blur="clients.{{ $ci }}.accounts.{{ $ai }}.postTimes" placeholder="8am, 7pm">
                                    </div>
                                </div>
                                <div class="text-right mt-2">
                                    <button class="btn btn-ghost btn-xs text-base-content/50" wire:click="removeAccount({{ $ci }}, {{ $ai }})">Remove {{ $a['platform'] }}</button>
                                </div>
                            </div>
                        @endforeach

                        @if (count($free))
                            <div class="flex gap-2 items-center" x-data="{ plat: '{{ $free[0] }}' }" wire:key="addacct-{{ $ci }}">
                                <select class="select select-bordered select-sm w-auto" x-model="plat">
                                    @foreach ($free as $p)
                                        <option value="{{ $p }}">{{ $p }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-ghost btn-sm" x-on:click="$wire.addAccount({{ $ci }}, plat)">+ Add account</button>
                            </div>
                        @endif

                        {{-- Blog --}}
                        <div class="divider text-sm font-semibold">Blog</div>
                        <div class="rounded-box border p-4 {{ empty($c['blog']['active']) ? 'border-base-300 opacity-70' : 'border-info/40' }}">
                            <div class="flex items-center justify-between mb-3">
                                <div class="font-semibold">Blog articles</div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm {{ empty($c['blog']['active']) ? 'text-base-content/50' : 'text-info' }}">{{ empty($c['blog']['active']) ? 'Paused' : 'Active' }}</span>
                                    <input type="checkbox" class="toggle toggle-info" wire:model.live="clients.{{ $ci }}.blog.active">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="form-control">
                                    <label class="label py-1"><span class="label-text text-xs">How often</span></label>
                                    <select class="select select-bordered select-sm" wire:model.blur="clients.{{ $ci }}.blog.frequency">
                                        @foreach (\App\Livewire\MediaEngine::BLOGFREQ as $opt)
                                            <option value="{{ $opt }}">{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-control">
                                    <label class="label py-1"><span class="label-text text-xs">Publishes to</span></label>
                                    <select class="select select-bordered select-sm" wire:model.live="clients.{{ $ci }}.blog.target">
                                        @foreach (\App\Livewire\MediaEngine::BLOGTARGETS as $val => $lbl)
                                            <option value="{{ $val }}">{{ $lbl }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @php $bt = $c['blog']['target'] ?? 'drafts'; @endphp
                            @if ($bt === 'drafts' || $bt === 'spark')
                                <p class="text-xs text-base-content/50 mt-3">
                                    {{ $bt === 'spark' ? 'Articles are prepared for manual upload to the Lingo Spark site.' : 'Articles land in the Drafts tab for a human to post.' }}
                                </p>
                            @else
                                <div class="form-control mt-3">
                                    <label class="label py-1"><span class="label-text text-xs">Site URL</span></label>
                                    <input type="text" class="input input-bordered input-sm" wire:model.blur="clients.{{ $ci }}.blog.siteUrl" placeholder="https://clientsite.com">
                                    <p class="text-xs text-base-content/50 mt-1">Login stored in n8n. Engine creates an <b>unpublished</b> draft — a human still hits publish.</p>
                                </div>
                            @endif
                        </div>

                        <div class="border-t border-base-300 mt-4 pt-4 flex items-center gap-3 flex-wrap">
                            <button class="btn btn-primary btn-sm" wire:click="generateForClient({{ $ci }})">Generate drafts for review</button>
                            <span class="text-xs text-base-content/60 flex-1 min-w-[200px]">Makes draft posts + articles for this client's <b>active</b> channels and sends them to the Review tab.</span>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="card bg-base-100"><div class="card-body items-center text-center text-base-content/60">
                <p class="text-lg font-semibold text-base-content">No clients yet</p>
                <p>Tap <b>+ Add a client</b> to start.</p>
            </div></div>
        @endforelse
    @endif

    {{-- ============================================================ REVIEW --}}
    @if ($view === 'review')
        @php
            $reviewName = null;
            if ($reviewClient !== 'all') {
                foreach ($clients as $rc) { if ($rc['id'] === $reviewClient) { $reviewName = $rc['name']; break; } }
            }
            $queue = array_values(array_filter($pending, function ($p) use ($reviewName) {
                return ($p['status'] ?? 'pending') === 'pending' && (!$reviewName || $p['client'] === $reviewName);
            }));
            $selDraft = null;
            foreach ($queue as $q) { if (($q['id'] ?? null) == $reviewSel) { $selDraft = $q; break; } }
            if (!$selDraft && count($queue)) { $selDraft = $queue[0]; }
        @endphp

        <div class="form-control max-w-md">
            <label class="label"><span class="label-text">Client</span></label>
            <select class="select select-bordered" wire:model.live="reviewClient">
                <option value="all">All clients</option>
                @foreach ($groupedClients as $group => $groupClients)
                    <optgroup label="{{ $group }}">
                        @foreach ($groupClients as $gc)
                            <option value="{{ $gc['id'] }}">{{ $gc['name'] }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>

        @if (!count($queue))
            <div class="card bg-base-100"><div class="card-body items-center text-center text-base-content/60">
                {{ $reviewName ? 'No drafts waiting for ' . $reviewName . '.' : 'All caught up. Nothing waiting for review.' }}
            </div></div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-4 items-start">
                {{-- Queue --}}
                <div class="space-y-2">
                    <div class="text-xs font-bold uppercase tracking-wide text-base-content/50">Queue · {{ count($queue) }}</div>
                    @foreach ($queue as $q)
                        @php
                            $isBlog = ($q['type'] ?? 'social') === 'blog';
                            $head = $isBlog ? $q['client'] . ' · Blog' : $q['client'] . ' · ' . ($q['platform'] ?? '');
                            $snip = $isBlog ? ($q['title'] ?? '') : \Illuminate\Support\Str::limit(str_replace("\n", ' ', $q['caption'] ?? ''), 72);
                            $isSel = $selDraft && ($selDraft['id'] ?? null) == ($q['id'] ?? null);
                        @endphp
                        <div class="card bg-base-100 border cursor-pointer transition {{ $isSel ? 'border-secondary ring-1 ring-secondary' : 'border-base-300' }}"
                             wire:key="q-{{ $q['id'] }}" wire:click="selectReview('{{ $q['id'] }}')">
                            <div class="card-body p-3 gap-1">
                                <div class="font-semibold text-sm">{{ $head }}</div>
                                <div class="text-xs text-base-content/60">{{ $snip }}</div>
                                <div class="text-xs text-base-content/40">{{ $q['when'] ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Preview --}}
                <div>
                    @if ($selDraft)
                        @php $selIndex = null; foreach ($pending as $pi => $pp) { if (($pp['id'] ?? null) == ($selDraft['id'] ?? null)) { $selIndex = $pi; break; } } @endphp
                        <div class="card bg-base-100 shadow-md lg:sticky lg:top-4" wire:key="preview-{{ $selDraft['id'] }}">
                            <div class="card-body">
                                @if (($selDraft['type'] ?? 'social') === 'blog')
                                    <div class="text-xs text-base-content/60">Blog article · {{ $selDraft['when'] ?? '' }}</div>
                                    <div class="font-bold">{{ $selDraft['client'] }}</div>
                                    <input type="text" class="input input-bordered font-bold text-lg" wire:model.blur="pending.{{ $selIndex }}.title">
                                    <textarea class="textarea textarea-bordered min-h-[200px] leading-relaxed" wire:model.blur="pending.{{ $selIndex }}.body"></textarea>
                                    @php $t = $selDraft['target'] ?? 'drafts'; $manual = in_array($t, ['drafts', 'spark']); @endphp
                                    <p class="text-xs text-base-content/60"><b>Publishes to:</b> {{ \App\Livewire\MediaEngine::BLOGTARGETS[$t] ?? $t }}.
                                        {{ $manual ? 'Prepared for manual upload — nothing is auto-published.' : 'Creates an unpublished draft via API — a human reviews and publishes.' }}</p>
                                    <div class="card-actions mt-2">
                                        <button class="btn btn-success btn-sm flex-1" wire:click="approve('{{ $selDraft['id'] }}')">{{ $manual ? 'Approve for upload' : 'Approve draft' }}</button>
                                        <button class="btn btn-outline btn-error btn-sm flex-1" wire:click="reject('{{ $selDraft['id'] }}')">Reject</button>
                                    </div>
                                @else
                                    <div class="text-xs text-base-content/60">Scheduled · {{ $selDraft['when'] ?? '' }}</div>
                                    <div class="font-bold">{{ $selDraft['client'] }} — {{ $selDraft['platform'] ?? '' }}</div>
                                    @if (isset(\App\Livewire\MediaEngine::NEEDS[$selDraft['platform'] ?? '']))
                                        <div class="alert alert-warning py-2 text-sm">Image needed for {{ $selDraft['platform'] }}</div>
                                    @endif
                                    <div class="flex items-center gap-3 mt-1">
                                        <div class="avatar placeholder">
                                            <div class="bg-secondary text-secondary-content rounded-full w-10">
                                                <span>{{ \Illuminate\Support\Str::substr($selDraft['client'], 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <b class="block text-sm">{{ $selDraft['client'] }}</b>
                                            <span class="text-xs text-base-content/60">{{ $selDraft['platform'] ?? '' }}</span>
                                        </div>
                                    </div>
                                    <textarea class="textarea textarea-bordered min-h-[160px] leading-relaxed mt-2" wire:model.blur="pending.{{ $selIndex }}.caption"></textarea>
                                    <p class="text-xs text-base-content/60">Make small fixes right here, then Approve.</p>
                                    <div class="card-actions mt-2">
                                        <button class="btn btn-success btn-sm flex-1" wire:click="approve('{{ $selDraft['id'] }}')">Approve</button>
                                        <button class="btn btn-outline btn-error btn-sm flex-1" wire:click="reject('{{ $selDraft['id'] }}')">Reject</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    @endif
</div>
