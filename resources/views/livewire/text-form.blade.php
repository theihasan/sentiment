<div>
    <div class="h-screen bg-gray-100">
        <div class="h-full px-5 py-40">
            <div class="max-w-2xl p-6 mx-auto bg-white rounded-lg shadow-lg">
                <h1 class="mb-4 text-2xl font-bold text-center">Emoji Analyzer</h1>
                <form wire:submit.prevent="submit">
                    <textarea wire:model="content" class="w-full p-2 mb-4 border border-gray-300 rounded-md" rows="4" placeholder="Enter your text with emojis here..."></textarea>
                    @error('content')
                    <div class="mb-4 text-red-600">{{ $message }}</div>
                    @enderror
                    <button id="analyzeButton" type="submit" class="w-full py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                        Analyze
                    </button>
                </form>
                @if($result)
                <h2 class="mt-4 mb-4 text-xl font-bold text-left">Result:</h2>
                <div id="result" class="p-4 mt-4 border border-gray-300 rounded-md bg-gray-50">
                    {!! $result !!}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
