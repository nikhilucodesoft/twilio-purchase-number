@props(['name'])
@error($name)
<span class="text-red-500 mt-1 block text-sm"> {{ $message }}</span>
@enderror
