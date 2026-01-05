@if (session('success'))
    <div class="mb-4 rounded-xl border border-emerald-700/40 bg-emerald-950/40 px-4 py-3 text-emerald-200">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 rounded-xl border border-rose-700/40 bg-rose-950/40 px-4 py-3 text-rose-200">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 rounded-xl border border-amber-700/40 bg-amber-950/40 px-4 py-3 text-amber-200">
        <div class="font-semibold">Periksa input Anda:</div>
        <ul class="mt-2 list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
