@props(['imgUrl', 'subTitle'])
<div class="fe-box">
    <img src="{{ asset($imgUrl) }}" alt="" />
    <h6>{{ $subTitle }}</h6>
</div>
