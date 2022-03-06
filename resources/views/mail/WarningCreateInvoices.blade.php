<p>{{ $messageToSend }}</p>
<p>При завантаженні актів звірки було отримано наступні попередження:</p>
<ol>
    @foreach($warnings as $warning)
        <li>{{ $warning }}</li>
    @endforeach
</ol>