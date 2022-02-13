<p>{{ $messageToSend }}</p>
<p>При завантаженні відомостей з {{ $ac }} було отримано наступні попередження:</p>
<ol>
    @foreach($warnings as $warning)
        <li>{{ $warning }}</li>
    @endforeach
</ol>
