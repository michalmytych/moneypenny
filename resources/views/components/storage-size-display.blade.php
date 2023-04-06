<span>
    @php
        $units = ['B', 'KB', 'MB'];
        $i = 0;
        /** @var int $size */
        while ($size > 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        $formattedSize = round($size, 2) . ' ' . $units[$i];
    @endphp
    {{ $formattedSize }}
</span>
