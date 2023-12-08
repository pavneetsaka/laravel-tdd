<div class="py-12">
    <div {{ $attributes->merge(['class' => 'mx-auto sm:px-6 lg:px-8']) }}>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</div>