@props(['book', 'width' => '100px', 'height' => '138px'])

@php
    $coverClass = match(strtolower($book->genre ?? '')) {
        'fiction'   => 'cover-fiction',
        'fantasy'   => 'cover-fantasy',
        'science'   => 'cover-science',
        'history'   => 'cover-history',
        'romance'   => 'cover-romance',
        'mystery'   => 'cover-mystery',
        'biography' => 'cover-biography',
        'classic'   => 'cover-classic',
        default     => 'cover-default',
    };
@endphp

<div style="width:{{ $width }}; height:{{ $height }}; border-radius:8px; overflow:hidden; background:var(--bg-3); border:1px solid var(--border); flex-shrink:0;">
    @if($book->isbn)
        <img src="https://covers.openlibrary.org/b/isbn/{{ $book->isbn }}-M.jpg"
             alt="{{ $book->title }}"
             style="width:100%; height:100%; object-fit:cover; display:block;"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div class="book-cover-placeholder {{ $coverClass }}"
             style="display:none; width:100%; height:100%; flex-direction:column; align-items:center; justify-content:center; padding:8px; text-align:center; gap:4px;">
            <div style="font-size:1.4rem;">📖</div>
            <div style="font-family:'Syne',sans-serif; font-size:0.62rem; font-weight:700; color:var(--text); line-height:1.3;">{{ Str::limit($book->title, 30) }}</div>
            <div style="font-size:0.55rem; color:var(--text-3);">{{ $book->author }}</div>
        </div>
    @else
        <div class="book-cover-placeholder {{ $coverClass }}"
             style="width:100%; height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:8px; text-align:center; gap:4px;">
            <div style="font-size:1.4rem;">📖</div>
            <div style="font-family:'Syne',sans-serif; font-size:0.62rem; font-weight:700; color:var(--text); line-height:1.3;">{{ Str::limit($book->title, 30) }}</div>
            <div style="font-size:0.55rem; color:var(--text-3);">{{ $book->author }}</div>
        </div>
    @endif
</div>