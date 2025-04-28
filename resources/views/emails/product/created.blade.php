@component('mail::message')
# নতুন প্রোডাক্ট যুক্ত হয়েছে!

**প্রোডাক্টের নাম:** {{ $product->name }}

**দাম:** ${{ $product->price }}

**বর্ণনা:** {{ $product->description }}

ধন্যবাদ!

@endcomponent
