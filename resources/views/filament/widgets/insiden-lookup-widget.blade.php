<div x-data="{ open: @entangle('isOpen'), detailOpen: @entangle('isDetailOpen') }">
    <!-- List Modal -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/60 backdrop-blur-sm"
         style="display: none;">
         
         <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-800 w-full max-w-4xl flex flex-col"
              style="max-height: 85vh;"
              @click.away="$wire.closeLookup()">
              
              <!-- Modal Header -->
              <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                  <div class="flex items-center gap-3">
                      <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $title }}</h3>
                      <span class="inline-flex items-center rounded-full bg-indigo-50 dark:bg-indigo-500/10 px-2.5 py-0.5 text-xs font-semibold text-indigo-700 dark:text-indigo-400">
                          {{ count($incidents) }} Data
                      </span>
                  </div>
                  <button @click="$wire.closeLookup()" class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-200 transition duration-150">
                      <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                      </svg>
                  </button>
              </div>
              
              <!-- Modal Body -->
              <div class="p-6 overflow-y-auto flex-1">
                  @if (empty($incidents))
                      <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                          <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-700 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.008 1.24l.885 1.77a2.25 2.25 0 0 0 2.007 1.24h1.98a2.25 2.25 0 0 0 2.007-1.24l.885-1.77a2.25 2.25 0 0 1 2.007-1.24h3.86m-18 0h18" />
                          </svg>
                          Tidak ada data insiden.
                      </div>
                  @else
                      <div class="overflow-hidden rounded-xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900">
                          <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400" style="table-layout: fixed;">
                              <thead class="text-xs uppercase bg-gray-50/75 dark:bg-gray-800/60 text-gray-600 dark:text-gray-300 border-b border-gray-100 dark:border-gray-800">
                                  <tr>
                                      <th class="px-4 py-3.5 font-bold text-left" style="width: 15%;">Tanggal</th>
                                      <th class="px-4 py-3.5 font-bold text-left" style="width: 32%;">Insiden</th>
                                      <th class="px-4 py-3.5 font-bold text-left" style="width: 23%;">Pasien</th>
                                      <th class="px-4 py-3.5 font-bold text-left" style="width: 15%;">Unit</th>
                                      <th class="px-4 py-3.5 font-bold text-left" style="width: 15%;">Grading</th>
                                      <th class="px-4 py-3.5 font-bold text-right" style="width: 10%;">Aksi</th>
                                  </tr>
                              </thead>
                              <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                  @foreach ($incidents as $inc)
                                      <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors duration-150">
                                          <td class="px-4 py-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                              <span class="inline-flex items-center gap-1.5">
                                                  <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                  </svg>
                                                  {{ \Carbon\Carbon::parse($inc['tanggal_insiden'])->translatedFormat('d M Y') }}
                                              </span>
                                          </td>
                                          <td class="px-4 py-4 text-xs font-semibold text-gray-900 dark:text-gray-100 break-words leading-relaxed">
                                              {{ $inc['insiden'] }}
                                          </td>
                                          <td class="px-4 py-4 text-xs text-gray-700 dark:text-gray-300 break-words">
                                              <div class="font-bold text-gray-900 dark:text-white leading-normal">
                                                  {{ $inc['pasien']['nm_pasien'] ?? $inc['nm_pasien'] ?? '-' }}
                                              </div>
                                              @if(!empty($inc['pasien_id']))
                                                  <div class="text-[10px] text-gray-400 dark:text-gray-500 font-mono mt-0.5">RM: {{ $inc['pasien_id'] }}</div>
                                              @endif
                                          </td>
                                          <td class="px-4 py-4 text-xs text-gray-600 dark:text-gray-400 break-words">
                                              <span class="inline-flex items-center gap-1">
                                                  <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                                  </svg>
                                                  {{ $inc['unit']['nama_unit'] ?? '-' }}
                                              </span>
                                          </td>
                                          <td class="px-4 py-4 text-xs whitespace-nowrap">
                                              @if ($inc['grading'])
                                                  <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider
                                                      {{ match($inc['grading']['grading_risiko']) {
                                                          'Biru' => 'bg-sky-50 text-sky-700 border border-sky-200 dark:bg-sky-500/10 dark:text-sky-400 dark:border-sky-500/20',
                                                          'Hijau' => 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20',
                                                          'Kuning' => 'bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
                                                          'Merah' => 'bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/20',
                                                          default => 'bg-gray-50 text-gray-600 border border-gray-200 dark:bg-gray-500/10 dark:text-gray-400 dark:border-gray-500/20'
                                                      } }}">
                                                      <span class="h-1.5 w-1.5 rounded-full 
                                                          {{ match($inc['grading']['grading_risiko']) {
                                                              'Biru' => 'bg-sky-500',
                                                              'Hijau' => 'bg-emerald-500',
                                                              'Kuning' => 'bg-amber-500',
                                                              'Merah' => 'bg-rose-500',
                                                              default => 'bg-gray-400'
                                                          } }}"></span>
                                                      {{ $inc['grading']['grading_risiko'] }}
                                                  </span>
                                              @else
                                                  <span class="inline-flex items-center gap-1 rounded-full bg-gray-50 dark:bg-gray-500/10 px-2.5 py-1 text-[10px] font-bold text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-500/20 uppercase tracking-wider">
                                                      <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                                      Belum
                                                  </span>
                                              @endif
                                          </td>
                                          <td class="px-4 py-4 text-right whitespace-nowrap">
                                              <button wire:click="showDetail({{ $inc['id'] }})"
                                                      class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-600 hover:bg-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-400 dark:hover:bg-indigo-500/20 transition-all duration-150">
                                                  Detail
                                                  <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                                  </svg>
                                              </button>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  @endif
              </div>
         </div>
    </div>

    <!-- Detail Modal -->
    <div x-show="detailOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/65 backdrop-blur-sm"
         style="display: none; z-index: 60;">
         
         <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-800 w-full max-w-2xl flex flex-col"
              style="max-height: 85vh;"
              @click.away="$wire.closeDetail()">
              
              <!-- Modal Header -->
              <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                  <h3 class="text-base font-bold text-gray-900 dark:text-white">Rangkuman Detail Insiden</h3>
                  <button @click="$wire.closeDetail()" class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-200 transition duration-150">
                      <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                      </svg>
                  </button>
              </div>
              
              <!-- Modal Body -->
              <div class="p-6 overflow-y-auto flex-1 space-y-5 text-sm text-gray-700 dark:text-gray-300">
                  @if ($selectedIncident)
                      <div class="space-y-4">
                          <div class="flex flex-wrap items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
                              <span class="inline-flex items-center gap-1 rounded-full bg-primary-50 dark:bg-primary-500/10 px-2.5 py-1 text-xs font-semibold text-primary-700 dark:text-primary-400">
                                  ID: {{ $selectedIncident['id'] }}
                              </span>
                              <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold capitalize
                                  {{ match($selectedIncident['dampak_insiden']) {
                                      'tidak signifikan' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
                                      'minor' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                      'moderat' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                      'mayor' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                      'katastropik' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                      default => 'bg-gray-100 text-gray-700'
                                  } }}">
                                  Dampak: {{ $selectedIncident['dampak_insiden'] }}
                              </span>
                          </div>

                          <div class="bg-gray-50 dark:bg-gray-800/30 border border-gray-100 dark:border-gray-800 rounded-xl p-5 space-y-3.5">
                              <div class="grid grid-cols-3 gap-2">
                                  <span class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Nama Insiden</span>
                                  <span class="col-span-2 text-sm font-semibold text-gray-900 dark:text-white">{{ $selectedIncident['insiden'] }}</span>
                              </div>
                              <div class="grid grid-cols-3 gap-2 border-t border-gray-100 dark:border-gray-800 pt-3">
                                  <span class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Waktu Kejadian</span>
                                  <span class="col-span-2 text-sm text-gray-700 dark:text-gray-300">
                                      {{ \Carbon\Carbon::parse($selectedIncident['tanggal_insiden'])->translatedFormat('d F Y') }} pukul {{ $selectedIncident['waktu_insiden'] }}
                                  </span>
                              </div>
                              <div class="grid grid-cols-3 gap-2 border-t border-gray-100 dark:border-gray-800 pt-3">
                                  <span class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Pasien</span>
                                  <span class="col-span-2 text-sm text-gray-700 dark:text-gray-300">
                                      <span class="font-semibold text-gray-900 dark:text-white">
                                          {{ $selectedIncident['pasien']['nm_pasien'] ?? $selectedIncident['nm_pasien'] ?? '-' }}
                                      </span>
                                      @if(!empty($selectedIncident['pasien_id']))
                                          <span class="text-xs text-gray-400 dark:text-gray-500 font-mono ml-1">(RM: {{ $selectedIncident['pasien_id'] }})</span>
                                      @endif
                                  </span>
                              </div>
                              <div class="grid grid-cols-3 gap-2 border-t border-gray-100 dark:border-gray-800 pt-3">
                                  <span class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Unit / Tempat</span>
                                  <span class="col-span-2 text-sm text-gray-700 dark:text-gray-300">
                                      {{ $selectedIncident['tempat_kejadian'] }} (Unit: {{ $selectedIncident['unit']['nama_unit'] ?? '-' }})
                                  </span>
                              </div>
                          </div>

                          <div class="space-y-1.5">
                              <span class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Kronologi Kejadian</span>
                              <div class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-800/20 border border-gray-100 dark:border-gray-800/50 p-4 rounded-xl whitespace-pre-line">
                                  {{ $selectedIncident['kronologi'] }}
                              </div>
                          </div>

                          @if(!empty($selectedIncident['tindakan']))
                              <div class="space-y-1.5">
                                  <span class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Tindakan Penanganan</span>
                                  <div class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-800/20 border border-gray-100 dark:border-gray-800/50 p-4 rounded-xl whitespace-pre-line">
                                      {{ $selectedIncident['tindakan']['content'] ?? '-' }}
                                  </div>
                              </div>
                          @endif
                      </div>
                  @endif
              </div>
              
              <!-- Modal Footer -->
              <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 flex justify-end">
                  <button @click="$wire.closeDetail()"
                          class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-xl transition duration-150">
                      Tutup
                  </button>
              </div>
         </div>
    </div>
</div>