<p>{{ $messageToSend }}</p>
<p>При завантаженні відомостей було отримано наступні попередження:</p>
<ol>
    @foreach($warnings as $warning)
        <li>{{ $warning }}</li>
    @endforeach
</ol>
