@php
$extraAlpineAttributes = $getExtraAlpineAttributes();
$id = $getId();
$isConcealed = $isConcealed();
$isDisabled = $isDisabled();
$isPrefixInline = $isPrefixInline();
$isSuffixInline = $isSuffixInline();
$prefixActions = $getPrefixActions();
$prefixIcon = $getPrefixIcon();
$prefixLabel = $getPrefixLabel();
$suffixActions = $getSuffixActions();
$suffixIcon = $getSuffixIcon();
$suffixLabel = $getSuffixLabel();
$statePath = $getStatePath();
$displayTemplate = $getDisplayTemplate();
@endphp
<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-load-css="[
            @js(\Filament\Support\Facades\FilamentAsset::getStyleHref('signature-pad-styles', \Coolsam\SignaturePad\Forms\Components\Fields\SignaturePad::PACKAGE_NAME)),
        ]" ax-load
        ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('signature-pad', \Coolsam\SignaturePad\Forms\Components\Fields\SignaturePad::PACKAGE_NAME) }}"
        x-data="signaturePad(
        $wire.{{ $applyStateBindingModifiers(" entangle('{$getStatePath()}')") }}, { disabled : {{$isDisabled ? 'true'
        :'false'}}, dotSize : '{{$getStrokeDotSize()}}' , minWidth: '{{$getStrokeMinWidth()}}' , maxWidth
        : '{{$getStrokeMaxWidth()}}' , minDistance: '{{$getStrokeMinDistance()}}' , penColor: '{{$getPenColor()}}' ,
        backgroundColor: '{{$getBackgroundColor()}}' , id: '{{ $id }}' , })" class="sm:rounded-md">
        @if($displayTemplate)
        <template x-if="state">
            <img class="border mx-auto dark:border-gray-700 rounded-lg w-full max-w-[800px]" alt="current_signature"
                :src="state">
        </template>
        @endif
        @if(!($isReadOnly() || $isDisabled))
        <canvas before="Hello World" {{ \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
            ->merge($extraAlpineAttributes, escape: false)
            ->merge([
            'disabled' => $isDisabled,
            'id' => $id,
            'x-ref' => 'canvas',
            'x-model' => 'state',
            'placeholder' => $getPlaceholder(),
            'readonly' => $isReadOnly(),
            'required' => $isRequired() && (! $isConcealed),
            ], escape: false) }}
            style="max-height: 150px !important; max-width: 800px !important; border-width: initial"
            class="w-full h-full m-2 mx-auto rounded-md dark:border-gray-700 before:content-[attr(before)]">
        </canvas>
        <div class="flex mt-2 justify-end items-center space-x-2">
            {{-- <x-filament::button icon="heroicon-o-arrow-path" color="primary" outlined="true" size="sm"
                @click.prevent="resizeCanvas()"></x-filament::button> --}}
            <template x-if="signaturePad">
                {{-- <x-filament::button icon="heroicon-o-arrow-path" color="primary" outlined="true" size="sm"
                    @click.prevent="clear()"></x-filament::button> --}}
                <button class="flex items-center justify-center px-2 py-1 text-sm font-medium dark:text-gray-200 text-gray-700 bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                    @click.prevent="clear()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 -ml-1" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 12q0-1.848-.138-3.662a4.006 4.006 0 0 0-3.7-3.7a49 49 0 0 0-7.324 0a4.006 4.006 0 0 0-3.7 3.7q-.025.33-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3q0 1.848.138 3.662a4.006 4.006 0 0 0 3.7 3.7a49 49 0 0 0 7.324 0a4.006 4.006 0 0 0 3.7-3.7q.025-.33.046-.662M4.5 12l3 3m-3-3l-3 3" />
                    </svg>
                    Clear
                </button>
            </template>

            @if(!$isDisabledDownload())
                <x-filament::button color="primary" outlined="true" size="sm" icon="heroicon-o-arrow-down-on-square" @click.prevent="downloadSVG()">.svg</x-filament::button>
                <x-filament::button color="primary" outlined="true" size="sm" icon="heroicon-o-arrow-down-on-square" @click.prevent="downloadPNG()">.png</x-filament::button>
                <x-filament::button color="primary" outlined="true" size="sm" icon="heroicon-o-arrow-down-on-square" @click.prevent="downloadJPG()">.jpg</x-filament::button>
            @endif
        </div>
        @endif
    </div>
</x-dynamic-component>