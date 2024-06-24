<!-- resources/views/filament/components/copy-url.blade.php -->
<div class="flex items-center">
    <input type="text" id="url-{{ $getRecord()->code }}" value="{{ url(md5($getRecord()->code)) }}" readonly class="form-input px-4 py-2 w-full">
    <button onclick="copyToClipboard('{{ $getRecord()->id }}')" class="ml-2 btn btn-primary">
        Copy URL
    </button>
</div>

<script>
    function copyToClipboard(id) {
        var copyText = document.getElementById("url-" + id);
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        navigator.clipboard.writeText(copyText.value);

        alert("Copied the URL: " + copyText.value);
    }
</script>