@php
  use App\Models\PageConfig;
  $config = PageConfig::first();
@endphp

<main>
<section class="banner bg-tertiary position-relative overflow-hidden">
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <div class="block text-center text-lg-start pe-0 pe-xl-5">
          <h1 class="text-capitalize mb-4">{{ $config->title ?? ''}}</h1>
          <p class="mb-4">{{ $config->detail ?? ''}}</p> <a type="button"
            class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#applyLoan">See More<span style="font-size: 14px;" class="ms-2 fas fa-arrow-right"></span></a>
        </div>
      </div>
      <div class="col-lg-6">
    <div class="ps-lg-5 text-center">
        <img 
            loading="lazy" 
            decoding="async"
            src="{{ asset('storage/' . $config->image) }}"
            alt="Banner Image"
            class="img-fluid rounded shadow-lg w-75"
            style="max-height: 400px; object-fit: cover;"
        >
    </div>
</div>

    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="section-title pt-4">
          <p class="text-primary text-uppercase fw-bold mb-3">Our Services</p>
          <h1>Our online services</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipreiscing elit. Lacus penatibus tincidunt</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 service-item">
        <a class="text-black" href="service-details.html">
          <div class="block"> <span class="colored-box text-center h3 mb-4">01</span>
            <h3 class="mb-3 service-title">Digital Marketing</h3>
            <p class="mb-0 service-description">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
              eirmod</p>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-6 service-item">
        <a class="text-black" href="service-details.html">
          <div class="block"> <span class="colored-box text-center h3 mb-4">02</span>
            <h3 class="mb-3 service-title">Web Design</h3>
            <p class="mb-0 service-description">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
              eirmod</p>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-6 service-item">
        <a class="text-black" href="service-details.html">
          <div class="block"> <span class="colored-box text-center h3 mb-4">03</span>
            <h3 class="mb-3 service-title">SEO</h3>
            <p class="mb-0 service-description">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
              eirmod</p>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-6 service-item">
        <a class="text-black" href="service-details.html">
          <div class="block"> <span class="colored-box text-center h3 mb-4">04</span>
            <h3 class="mb-3 service-title">Logo Design</h3>
            <p class="mb-0 service-description">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
              eirmod</p>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-6 service-item">
        <a class="text-black" href="service-details.html">
          <div class="block"> <span class="colored-box text-center h3 mb-4">05</span>
            <h3 class="mb-3 service-title">Graphic Design</h3>
            <p class="mb-0 service-description">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
              eirmod</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

</main>