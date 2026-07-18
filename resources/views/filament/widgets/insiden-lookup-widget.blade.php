<div x-data="{ open: @entangle('isOpen'), detailOpen: @entangle('isDetailOpen') }">
    <!-- List Modal -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/50 backdrop-blur-sm"
         style="display: none;">
         
         <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl border border-gray-100 dark:border-gray-800 w-full max-w-4xl max-h-[85vh] flex flex-col"
              @click.away="$wire.closeLookup()">
              
              <!-- Modal Header -->
              <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
                  <button @click="$wire.closeLookup()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                      <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                  </button>
              </div>
              
              <!-- Modal Body -->
              <div class="p-6 overflow-y-auto flex-1">
                  @if (empty($incidents))
                      <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                          Tidak ada data insiden.
                      </div>
                  @else
                      <div class="overflow-x-auto">
                          <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                              <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                  <tr>
                                      <th class="px-4 py-3">Tanggal</th>
                                      <th class="px-4 py-3">Insiden</th>
                                      <th class="px-4 py-3">Pasien</th>
                                      <th class="px-4 py-3">Unit</th>
                                      <th class="px-4 py-3">Grading</th>
                                      <th class="px-4 py-3 text-right">Aksi</th>
                                  </tr>
                              </thead>
                              <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                  @foreach ($incidents as $inc)
                                      <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                          <td class="px-4 py-3 whitespace-nowrap">
                                              {{ \Carbon\Carbon::parse($inc['tanggal_insiden'])->translatedFormat('d M Y') }}
                                          </td>
                                          <td class="px-4 py-3 font-medium text-gray-900 dark:text-white max-w-[200px] truncate">
                                              {{ $inc['insiden'] }}
                                          </td>
                                          <td class="px-4 py-3">
                                              {{ $inc['pasien']['nm_pasien'] ?? $inc['nm_pasien'] ?? '-' }}
                                          </td>
                                          <td class="px-4 py-3">
                                              {{ $inc['unit']['nama_unit'] ?? '-' }}
                                          </td>
                                          <td class="px-4 py-3">
                                              @if ($inc['grading'])
                                                  <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium 
                                                      {{ match($inc['grading']['grading_risiko']) {
                                                          'Biru' => 'bg-sky-50 text-sky-700 ring-1 ring-inset ring-sky-600/20 dark:bg-sky-500/10 dark:text-sky-400',
                                                          'Hijau' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-400',
                                                          'Kuning' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-400',
                                                          'Merah' => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20 dark:bg-rose-500/10 dark:text-rose-400',
                                                          default => 'bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-500/10'
                                                      } }}">
                                                      {{ $inc['grading']['grading_risiko'] }}
                                                  </span>
                                              @else
                                                  <span class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-500/10 px-2 py-0.5 text-xs font-medium text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-500/10 dark:ring-gray-500/20">Belum</span>
                                              @endif
                                          </td>
                                          <td class="px-4 py-3 text-right">
                                              <button wire:click="showDetail({{ $inc['id'] }})"
                                                      class="inline-flex items-center gap-1 text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline">
                                                  Detail
                                                  <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
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
         class="fixed inset-0 z-[60] overflow-y-auto flex items-center justify-center p-4 bg-gray-950/60 backdrop-blur-sm"
         style="display: none;">
         
         <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl border border-gray-100 dark:border-gray-800 w-full max-w-2xl max-h-[85vh] flex flex-col"
              @click.away="$wire.closeDetail()">
              
              <!-- Modal Header -->
              <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Rangkuman Detail Insiden</h3>
                  <button @click="$wire.closeDetail()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                      <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                  </button>
              </div>
              
              <!-- Modal Body -->
              <div class="p-6 overflow-y-auto flex-1 space-y-4 text-sm text-gray-700 dark:text-gray-300">
                  @if ($selectedIncident)
                      <div class="grid grid-cols-3 gap-2 py-2 border-b border-gray-50 dark:border-gray-800">
                          <span class="font-semibold text-gray-900 dark:text-white">Nama Insiden</span>
                          <span class="col-span-2 text-gray-600 dark:text-gray-400">{{ $selectedIncident['insiden'] }}</span>
                      </div>
                      <div class="grid grid-cols-3 gap-2 py-2 border-b border-gray-50 dark:border-gray-800">
                          <span class="font-semibold text-gray-900 dark:text-white">Tanggal Kejadian</span>
                          <span class="col-span-2 text-gray-600 dark:text-gray-400">
                              {{ \Carbon\Carbon::parse($selectedIncident['tanggal_insiden'])->translatedFormat('d F Y') }} pukul {{ $selectedIncident['waktu_insiden'] }}
                          </span>
                      </div>
                      <div class="grid grid-cols-3 gap-2 py-2 border-b border-gray-50 dark:border-gray-800">
                          <span class="font-semibold text-gray-900 dark:text-white">Pasien</span>
                          <span class="col-span-2 text-gray-600 dark:text-gray-400">
                              {{ $selectedIncident['pasien']['nm_pasien'] ?? $selectedIncident['nm_pasien'] ?? '-' }} 
                              @if(!empty($selectedIncident['pasien_id']))
                                  <span class="text-xs text-gray-400">({{ $selectedIncident['pasien_id'] }})</span>
                              @endif
                          </span>
                      </div>
                      <div class="grid grid-cols-3 gap-2 py-2 border-b border-gray-50 dark:border-gray-800">
                          <span class="font-semibold text-gray-900 dark:text-white">Tempat Kejadian</span>
                          <span class="col-span-2 text-gray-600 dark:text-gray-400">{{ $selectedIncident['tempat_kejadian'] }} (Unit: {{ $selectedIncident['unit']['nama_unit'] ?? '-' }})</span>
                      </div>
                      <div class="grid grid-cols-3 gap-2 py-2 border-b border-gray-50 dark:border-gray-800">
                          <span class="font-semibold text-gray-900 dark:text-white">Dampak Insiden</span>
                          <span class="col-span-2">
                              <span class="capitalize px-2 py-0.5 rounded text-xs font-semibold
                                  {{ match($selectedIncident['dampak_insiden']) {
                                      'tidak signifikan' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
                                      'minor' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                      'moderat' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                      'mayor' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                      'katastropik' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                      default => 'bg-gray-100 text-gray-700'
                                  } }}">
                                  {{ $selectedIncident['dampak_insiden'] }}
                              </span>
                          </span>
                      </div>
                      <div class="py-2 border-b border-gray-50 dark:border-gray-800">
                          <span class="font-semibold text-gray-900 dark:text-white block mb-1">Kronologi</span>
                          <p class="text-gray-600 dark:text-gray-400 leading-relaxed bg-gray-50 dark:bg-gray-800/30 p-3 rounded-lg text-xs">{{ $selectedIncident['kronologi'] }}</p>
                      </div>
                      @if(!empty($selectedIncident['tindakan']))
                          <div class="py-2">
                              <span class="font-semibold text-gray-900 dark:text-white block mb-1">Tindakan Penanganan</span>
                              <p class="text-gray-600 dark:text-gray-400 leading-relaxed bg-gray-50 dark:bg-gray-800/30 p-3 rounded-lg text-xs">{{ $selectedIncident['tindakan']['content'] ?? '-' }}</p>
                          </div>
                      @endif
                  @endif
              </div>
              
              <!-- Modal Footer -->
              <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 flex justify-end">
                  <button @click="$wire.closeDetail()"
                          class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg transition">
                      Tutup Detail
                  </button>
              </div>
         </div>
    </div>
</div>
