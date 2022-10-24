<div class="d-inline-flex flex-column justify-content-center mr-3">
    <span class="fw-300 fs-xs d-block opacity-50">
        <small>{{ $title }}</small>
    </span>
    <span class="{{ $priceClass }}">
        {{ $price  }}
    </span>
</div>
<span class="sparklines hidden-lg-down" sparkType="bar" sparkBarColor="{{ $sparkColor}}" sparkHeight="32px" sparkBarWidth="5px" values="{{ $values }}"></span>