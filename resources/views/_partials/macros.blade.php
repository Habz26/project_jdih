@php
  $width = $width ?? '180';
  $height = $height ?? '60';
@endphp

<span class="text-primary">
  <img src="{{ asset('assets/img/branding/logo-rskk1.png') }}" 
       alt="Logo" 
       width="{{ $width }}" 
       height="{{ $height }}">
</span>
