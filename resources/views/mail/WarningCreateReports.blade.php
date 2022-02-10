При завантаженні відомостей з {{ $ac }} було отримано наступні попередження:
@foreach($warnings as $warning)
    {{ $loop->iteration}}. -> {{ $warning }}
@endforeach